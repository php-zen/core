<?php
/**
 * 声明应用程序的路由规则规范。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

/**
 * 应用程序的路由规则规范。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
interface IRouterRule
{
    /**
     * 构造函数
     *
     * @param string   $pattern 路由模式
     * @param string[] $params  初始参数
     */
    public function __construct($pattern, $params);

    /**
     * 尝试匹配指定输入信息摘要。
     *
     * @param  string $summary 输入信息摘要
     * @return bool
     */
    public function match($summary);

    /**
     * 获取匹配地目标控制器名称。
     *
     * @return string
     */
    public function getGoal();

    /**
     * 获取匹配地参数。
     *
     * @return string[]
     */
    public function getOptions();
}
