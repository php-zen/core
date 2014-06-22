<?php
/**
 * 声明应用程序的路由令牌组件规范。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

use ArrayAccess;

/**
 * 应用程序的路由令牌组件规范。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
interface IRouterToken extends ArrayAccess
{
    /**
     * 构造函数
     *
     * @param string $target  目标控制器类名
     * @param array  $options 控制器调用参数
     */
    public function __construct($target, $options);

    /**
     * 派发至结果控制器。
     *
     * @param  IApplication $app 应用程序实例
     * @return void
     */
    public function dispatch(IApplication $app);
}
