<?php
/**
 * 定义辅助路由派发功能的特殊控制器。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Controller;

use Zen\Core\Application;

/**
 * 辅助路由派发功能的特殊控制器。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
class UndefinedController extends Controller
{
    /**
     * {@inheritdoc}
     *
     * @param  Application\IRouterToken $token 路由令牌组件实例
     * @return void
     */
    public function act(Application\IRouterToken $token)
    {
        var_dump($token);
    }
}
