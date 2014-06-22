<?php
/**
 * 声明应用程序的路由规则原型规范。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

use Zen\Core;

/**
 * 应用程序的路由规则原型规范。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
interface IRouterRoutine extends Core\ISingleton
{
    /**
     * 根据指定模式和处理逻辑生成规则。
     *
     * @param  string            $pattern  路由模式
     * @param  string            $approach 对应地处理逻辑
     * @return IRouterRule|false
     */
    public function generate($pattern, $approach);
}
