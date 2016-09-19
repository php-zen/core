<?php
/*
 * 定义配合 Composer 类加载器的包引导程序调用组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2016 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core;

/**
 * 配合 Composer 类加载器的包引导程序调用组件。
 *
 * @since 0.2.0
 */
class PackageStub extends Component
{
    /**
     * Composer 类加载器实例。
     *
     * @var \Composer\Autoload\ClassLoader
     */
    protected $loader;

    /**
     * 来自于 Composer 的 PS4 包信息。
     *
     * @var string[][][]
     */
    protected $packages;

    /**
     * 包引导程序调用状态。
     *
     * @var bool[]
     */
    protected $stubbed;

    /**
     * 构造函数。
     *
     * @param \Composer\Autoload\ClassLoader $loader
     */
    protected function __construct($loader)
    {
        $this->loader = $loader;
        $this->packages = array();
        $a_packages = $loader->getPrefixesPsr4();
        krsort($a_packages);
        foreach ($a_packages as $s_namespace => $a_dirs) {
            $s_key = $s_namespace[0];
            if (!isset($this->packages[$s_key])) {
                $this->packages[$s_key] = array();
            }
            $this->packages[$s_key][$s_namespace] = $a_dirs;
        }
        $this->stubbed = array();
    }

    /**
     * 加载指定类。
     *
     * @param string $class
     *
     * @return null|bool
     */
    public function loadClass($class)
    {
        if ('\\' == $class[0]) {
            $class = substr($class, 1);
        }
        if (!$this->loader->loadClass($class)) {
            return;
        }
        foreach ($this->packages[$class[0]] as $s_namespace => $a_dirs) {
            if (0 !== strpos($class, $s_namespace)) {
                continue;
            }
            if (isset($this->stubbed[$s_namespace])) {
                return true;
            }
            foreach ($a_dirs as $p_dir) {
                $p_stub = $p_dir.'/stub.php';
                if (is_file($p_stub)) {
                    $this->stubbed[$s_namespace] = true;
                    include $p_stub;

                    return true;
                }
            }
        }
    }

    /**
     * 绑定 Composer 类加载器实例。
     *
     * @param \Composer\Autoload\ClassLoader $loader
     * @param bool                           $dryRun 此参数仅用于单元测试！
     *
     * @return self
     */
    public static function bind($loader, $dryRun = false)
    {
        $loader->unregister();
        $o_self = new static($loader);
        if (!$dryRun) {
            spl_autoload_register(array($o_self, 'loadClass'), true, true);
        }

        return $o_self;
    }
}
