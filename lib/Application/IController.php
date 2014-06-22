<?php
/**
 * 声明应用程序的控制器组件规范。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

/**
 * 应用程序的控制器组件规范。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
interface IController
{
    /**
     * 构造函数
     *
     * @param IApplication $app 应用程序组件实例
     */
    public function __construct(IApplication $app);

    /**
     * 执行该控制逻辑。
     *
     * @param  IRouterToken $token 应用程序的路由令牌组件实例
     * @return void
     */
    public function act(IRouterToken $token);
}
