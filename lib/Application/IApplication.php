<?php
/**
 * 声明应用程序组件规范。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

/**
 * 应用程序组件规范。
 *
 * 警告：此规范仅用于内部接口规约，请勿作开发使用！
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
interface IApplication
{
    /**
     * 按照指定配置运行应用程序。
     *
     * @param  IConfiguration|array|string $configs 可选。配置表
     * @param  IRouter|array|string        $routes  可选。路由表
     * @return void
     */
    public static function run($configs = null, $routes = null);

    /**
     * 获取配置信息组件实例。
     *
     * @return IConfiguration
     */
    public function getConfig();

    /**
     * 获取输入信息组件实例。
     *
     * @return IInput
     */
    public function getInput();

    /**
     * 获取输出流组件实例。
     *
     * @return IOutput
     */
    public function getOutput();
}
