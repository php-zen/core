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
     * 是否已执行。
     *
     * @var bool
     */
    protected static $done = false;

    /**
     * 实际执行的包引导程序列表。
     *
     * @var string[]
     */
    protected $stubs;

    /**
     * 包引导程序执行时间列表。
     *
     * @var float[]
     */
    protected $profiler;

    /**
     * 构造函数。
     *
     * @param \Composer\Autoload\ClassLoader $loader
     */
    protected function __construct($loader)
    {
        $this->stubs = array();
        $a_packages = $loader->getPrefixesPsr4();
        ksort($a_packages);
        foreach ($a_packages as $s_namespace => $a_dirs) {
            if (isset($this->stubs[$s_namespace])) {
                continue;
            }
            $a_result = $this->seek($a_dirs);
            if ($a_result) {
                $this->stubs[$s_namespace] = $a_result[0];
                $this->profiler[$s_namespace] = $a_result[1];
            }
        }
    }

    /**
     * 检索第一个引导程序并执行。
     *
     * @param string[] $dirs
     *
     * @return [string, float]|false
     */
    protected function seek($dirs)
    {
        $f_ts = microtime(true);
        foreach ($dirs as $p_dir) {
            $p_stub = $p_dir.'/stub.php';
            if (is_file($p_stub) && is_readable($p_stub)) {
                $this->exec($p_stub);

                return array($p_stub, microtime(true) - $f_ts);
            }
        }

        return false;
    }

    /**
     * 执行引导程序。
     *
     * @param string $stub
     */
    protected function exec($stub)
    {
        if (!in_array($stub, $this->stubs)) {
            require $stub;
        }
    }

    /**
     * 绑定 Composer 类加载器实例。
     *
     * @param \Composer\Autoload\ClassLoader $loader
     * @param bool                           $test   Optional.
     *
     * @return self
     */
    public static function bind($loader, $test = false)
    {
        if (!$test) {
            if (self::$done) {
                throw new ExStubAlreadyDone();
            }
            self::$done = true;
        }

        return new static($loader);
    }
}
