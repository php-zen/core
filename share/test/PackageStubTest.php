<?php
/**
 * 配置配合 Composer 类加载器的包引导程序调用组件的单元测试。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2016 SZen.in
 * @license   LGPL-3.0+
 */

namespace ZenTest\Core;

use PHPUnit_Framework_TestCase;
use org\bovigo\vfs;
use Zen\Core\PackageStub as Unit;

/**
 * 配合 Composer 类加载器的包引导程序调用组件的单元测试。
 *
 * @runTestsInSeparateProcesses
 */
class PackageStubTest extends PHPUnit_Framework_TestCase
{
    private static $counter = 0;

    public static function record($size)
    {
        self::$counter += $size;
    }

    private $vfs;

    private $stub;

    protected function setUp()
    {
        self::$counter = 0;
        $this->vfs = vfs\vfsStream::setup('PackageStubTest', 0755, array(
                'foo' => array(
                    'lib' => array(
                        'stub.php' => '<?php ZenTest\Core\PackageStubTest::record(1);',
                    ),
                ),
                'empty' => array(
                    'lib' => array(),
                ),
                'bar' => array(
                    'lib' => array(),
                    'lib64' => array(
                        'stub.php' => '<?php ZenTest\Core\PackageStubTest::record(2);',
                    ),
                    'more' => array(
                        'stub.php' => '<?php ZenTest\Core\PackageStubTest::record(4);',
                    ),
                ),
            )
        );
        $this->stub = $this->createMock('Composer\Autoload\ClassLoader');
        $this->stub->expects($this->once())
            ->method('getPrefixesPsr4')
            ->willReturn(array(
                    'Foo\\' => array(
                        $this->vfs->url().'/foo/lib',
                    ),
                    'Empty\\' => array(
                        $this->vfs->url().'/empty/lib',
                    ),
                    'Bar\\' => array(
                        $this->vfs->url().'/bar/lib',
                        $this->vfs->url().'/bar/lib64',
                        $this->vfs->url().'/bar/more',
                    ),
                )
            );
    }

    public function testBindReplaceComposerLoader()
    {
        $this->stub->expects($this->once())
            ->method('unregister');
        $i_count = count(spl_autoload_functions());
        $o_unit = Unit::bind($this->stub);
        $this->assertEquals(1 + $i_count, count(spl_autoload_functions()));
    }

    public function testStubAutoRun()
    {
        $s_class = 'Foo\\Random'.time();
        $this->stub->expects($this->once())
            ->method('loadClass')
            ->with($this->equalTo($s_class))
            ->willReturn(true);
        $this->assertEquals(0, self::$counter);
        $o_unit = Unit::bind($this->stub, true);
        $o_unit->loadClass('\\'.$s_class);
        $this->assertEquals(1, self::$counter);
    }

    public function testStubSkipOnNonexistantClass()
    {
        $s_class = 'Foo\\Random'.time();
        $this->assertEquals(0, self::$counter);
        $o_unit = Unit::bind($this->stub, true);
        $o_unit->loadClass($s_class);
        $this->assertEquals(0, self::$counter);
    }

    public function testSlienceWhileNoStub()
    {
        $s_class = 'Empty\\Random'.time();
        $this->stub->expects($this->once())
            ->method('loadClass')
            ->willReturn(true);
        $this->assertEquals(0, self::$counter);
        $o_unit = Unit::bind($this->stub, true);
        $o_unit->loadClass($s_class);
        $this->assertEquals(0, self::$counter);
    }

    public function testStubSeekFirstOverEachSourceFolder()
    {
        $s_class = 'Bar\\Random'.time();
        $this->stub->expects($this->once())
            ->method('loadClass')
            ->willReturn(true);
        $this->assertEquals(0, self::$counter);
        $o_unit = Unit::bind($this->stub, true);
        $o_unit->loadClass($s_class);
        $this->assertEquals(2, self::$counter);
    }

    public function testStubRunOnce()
    {
        $s_class1 = 'Bar\\Random1'.time();
        $s_class2 = 'Bar\\Random2'.time();
        $this->stub->expects($this->exactly(2))
            ->method('loadClass')
            ->withConsecutive($this->equalTo($s_class1), $this->equalTo($s_class2))
            ->willReturn(true);
        $this->assertEquals(0, self::$counter);
        $o_unit = Unit::bind($this->stub, true);
        $o_unit->loadClass($s_class1);
        $o_unit->loadClass($s_class2);
        $this->assertEquals(2, self::$counter);
    }
}
