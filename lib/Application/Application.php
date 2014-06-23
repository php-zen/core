<?php
/**
 * 定义应用程序组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

use Zen\Core;

/**
 * 应用程序组件。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 *
 * @property-read IConfiguration $config 配置组件实例。
 * @property-read IInput         $input  输入信息组件实例。
 * @property-read IOutput        $output 输出流组件实例。
 */
abstract class Application extends Core\Component implements IApplication
{
    /**
     * 配置组件实例。
     *
     * @internal
     *
     * @var IConfiguration
     */
    protected $config;

    /**
     * 获取配置组件。
     *
     * @internal
     *
     * @return IConfiguration
     */
    protected function zenGetConfig()
    {
        return $this->config;
    }

    /**
     * 输入信息组件实例。
     *
     * @internal
     *
     * @var IInput
     */
    protected $input;

    /**
     * 获取输入信息组件实例。
     *
     * @internal
     *
     * @return IInput
     */
    protected function zenGetInput()
    {
        return $this->input;
    }

    /**
     * 输出流组件实例。
     *
     * @internal
     *
     * @var IOutput
     */
    protected $output;

    /**
     * 获取输出流组件实例。
     *
     * @internal
     *
     * @return IOutput
     */
    protected function zenGetOutput()
    {
        return $this->output;
    }

    /**
     * 组件实例集合。
     *
     * @var Application
     */
    protected static $instance;

    /**
     * {@inheritdoc}
     *
     * @param  IConfiguration|array|string $configs 可选。配置表
     * @param  IRouter|array|string        $routes  可选。路由表
     * @return void
     *
     * @throws ExApplianceAlreadyRunning 当多应用程序同时运行时
     */
    final public static function run($configs = null, $routes = null)
    {
        if (self::$instance) {
            throw new ExApplianceAlreadyRunning(get_called_class());
        }
        $o_app = self::$instance = new static;
        $o_app->config = $configs instanceof IConfiguration
            ? $configs
            : $o_app->newDefaultConfiguration($configs);
        $o_app->onInit();
        if (!$o_app->input) {
            $o_app->input =
                isset($o_app->config['appliance.input']) &&
                $o_app->isValidInputType($o_app->config['appliance.input'])
                    ? new $o_app->config['appliance.input']
                    : $o_app->newDefaultInput();
        }
        if (!$o_app->output) {
            $o_app->output =
                isset($o_app->config['appliance.output']) &&
                $o_app->isValidOutputType($o_app->config['appliance.output'])
                    ? new $o_app->config['appliance.output']
                    : $o_app->newDefaultOutput();
        }
        $o_app->zenExtend();
        if ($routes instanceof IRouter) {
            $o_router = $routes;
        } else {
            $o_router = isset($o_app->config['appliance.router']) &&
                is_subclass_of($o_app->config['appliance.output'], __NAMESPACE__ . 'IRouter')
                    ? new $o_app->config['appliance.router']($routes)
                    : $o_app->newDefaultRouter($routes);
        }
        $o_router->route($o_app->input)->dispatch($o_app);
    }

    /**
     * 构造函数
     */
    final protected function __construct()
    {
    }

    /**
     * 创建默认的配置组件的实例。
     *
     * @param  array|string                $configs 配置表
     * @return Configuration\Configuration
     */
    protected function newDefaultConfiguration($configs)
    {
        return new Configuration\Configuration($configs);
    }

    /**
     * 初始化事件。
     *
     * @return void
     */
    protected function onInit()
    {
    }

    /**
     * 判断指定类是否为有效的输入信息组件。
     *
     * @internal
     *
     * @param  string $class 类名
     * @return bool
     */
    protected function isValidInputType($class)
    {
        return is_subclass_of($class, __NAMESPACE__ . '\IInput');
    }

    /**
     * 创建默认的输入信息组件的实例。
     *
     * @return IInput
     */
    abstract protected function newDefaultInput();

    /**
     * 判断指定类是否为有效的输出流组件。
     *
     * @internal
     *
     * @param  string $class 类名
     * @return bool
     */
    protected function isValidOutputType($class)
    {
        return is_subclass_of($class, __NAMESPACE__ . '\IOutput');
    }

    /**
     * 创建默认的输出流组件的实例。
     *
     * @return IOutput
     */
    abstract protected function newDefaultOutput();

    /**
     * 运行时扩展应用程序功能。
     *
     * @internal
     *
     * @return void
     */
    abstract protected function zenExtend();

    /**
     * 创建默认的路由组件的实例。
     *
     * @param  array|string  $routes 路由表
     * @return Router\Router
     */
    protected function newDefaultRouter($routes)
    {
        return new Router\Router($routes);
    }

    /**
     * {@inheritdoc}
     *
     * @return Configuration\Configuration
     */
    final public function getConfig()
    {
        return $this->zenGetConfig();
    }

    /**
     * {@inheritdoc}
     *
     * @return Input\Input
     */
    final public function getInput()
    {
        return $this->zenGetInput();
    }

    /**
     * {@inheritdoc}
     *
     * @return Output\Output
     */
    final public function getOutput()
    {
        return $this->zenGetOutput();
    }
}
