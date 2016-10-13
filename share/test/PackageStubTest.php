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
                'empty' => array(
                    'lib' => array(),
                ),
                'one' => array(
                    'lib' => array(
                        'stub.php' => '<?php ZenTest\Core\PackageStubTest::record(1);',
                    ),
                ),
                'more' => array(
                    'lib' => array(),
                    'lib64' => array(
                        'stub.php' => '<?php ZenTest\Core\PackageStubTest::record(2);',
                    ),
                    'extra' => array(
                        'stub.php' => '<?php ZenTest\Core\PackageStubTest::record(4);',
                    ),
                ),
            )
        );
        $this->stub = $this->createMock('Composer\Autoload\ClassLoader');
    }

    public function testAllStubsRunOnBinding()
    {
        $this->stub->expects($this->once())
            ->method('getPrefixesPsr4')
            ->willReturn(array(
                    'Foo\\Bar\\' => array(
                        $this->vfs->url().'/one/lib',
                    ),
                )
            );
        Unit::bind($this->stub, true);
        $this->assertEquals(1, self::$counter);
    }

    public function testFirstStubWorkInEachPackage()
    {
        $this->stub->expects($this->once())
            ->method('getPrefixesPsr4')
            ->willReturn(array(
                    'Foo\\Bar\\' => array(
                        $this->vfs->url().'/more/extra',
                        $this->vfs->url().'/one/lib',
                    ),
                )
            );
        Unit::bind($this->stub, true);
        $this->assertEquals(4, self::$counter);
    }

    public function testEachStubRunOnlyOnce()
    {
        $this->stub->expects($this->once())
            ->method('getPrefixesPsr4')
            ->willReturn(array(
                    'Foo\\Bar\\' => array(
                        $this->vfs->url().'/more/extra',
                    ),
                    'Foo\\Blah\\' => array(
                        $this->vfs->url().'/more/extra',
                    ),
                )
            );
        Unit::bind($this->stub, true);
        $this->assertEquals(4, self::$counter);
    }

    public function testStubIsOptional()
    {
        $this->stub->expects($this->once())
            ->method('getPrefixesPsr4')
            ->willReturn(array(
                    'Foo\\Bar\\' => array(
                        $this->vfs->url().'/empty/lib',
                    ),
                )
            );
        Unit::bind($this->stub, true);
        $this->assertEquals(0, self::$counter);
    }

    /**
     * @expectedException Zen\Core\ExStubAlreadyDone
     */
    public function testStubSingleton()
    {
        $this->stub->expects($this->once())
            ->method('getPrefixesPsr4')
            ->willReturn(array());
        Unit::bind($this->stub);
        Unit::bind($this->stub);
    }
}
