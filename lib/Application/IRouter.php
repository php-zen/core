<?php
/**
 * 声明应用程序的路由组件规范。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

/**
 * 应用程序的路由组件规范。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
interface IRouter
{
    /**
     * 构造函数
     *
     * @param array|string $routes 路由表
     */
    public function __construct($routes);

    /**
     * 根据输入信息摘要寻找首条合适地路由。
     *
     * @param  IInput       $input 输入信息组件实例
     * @return IRouterToken
     */
    public function route(IInput $input);
}
