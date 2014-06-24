<?php
/**
 * 定义应用程序的路由组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Router;

use Zen\Core;

/**
 * 应用程序的路由组件。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
class Router extends Core\Component implements Core\Application\IRouter
{
    /**
     * 路由规则原型组件实例池。
     *
     * @internal
     *
     * @var Routine\Routine[]
     */
    protected $routines;

    /**
     * 路由规则组件实例池。
     *
     * @internal
     *
     * @var Rule\Rule[]
     */
    protected $rules;

    /**
     * {@inheritdoc}
     *
     * @param array $routes 路由表
     */
    final public function __construct($routes)
    {
        $this->routines = $this->initRoutines();
        if (is_array($routes)) {
            $a_routes = $routes;
        } elseif (is_string($routes) && is_file($routes)) {
            $a_routes = require $routes;
        } else {
            $a_routes = array();
        }
        $a_routes = $this->prefix($a_routes, '');
        $this->rules = array();
        foreach ($a_routes as $kk => $vv) {
            /** @var $o_routine Core\Application\IRouterRoutine **/
            foreach ($this->routines as $o_routine) {
                $o_rule = $o_routine->generate('#^' . $kk . '$#', $vv);
                if ($o_rule instanceof Core\Application\IRouterRule) {
                    $this->rules[] = $o_rule;
                    break;
                }
            }
        }
    }

    /**
     * 初始化路由规则原型组件实例池。
     *
     * @return Routine\Routine[]
     */
    protected function initRoutines()
    {
        return array(
            Routine\RawRoutine::singleton()
        );
    }

    /**
     * 为路由表的路由模式增加前缀。
     *
     * @internal
     *
     * @param  array  $routes 路由表
     * @param  string $prefix 前缀
     * @return array
     */
    final protected function prefix($routes, $prefix)
    {
        $a_ret = array();
        foreach ($routes as $kk => $vv) {
            if (is_array($vv)) {
                $a_ret = array_merge($this->prefix($vv, $prefix . $kk), $a_ret);
            } else {
                $a_ret[$prefix . $kk] = $vv;
            }
        }

        return $a_ret;
    }

    /**
     * 根据输入信息摘要寻找首条合适地路由。
     *
     * @param  Core\Application\IInput       $input
     * @return Core\Application\IRouterToken
     *
     * @throws ExUnknownRouteSolution 当无法匹配合适的路由规则时
     */
    final public function route(Core\Application\IInput $input)
    {
        $s_summary = $input->summarize();
        /** @var $o_rule Core\Application\IRouterRule **/
        foreach ($this->rules as $o_rule) {
            if ($o_rule->match($s_summary)) {
                return $this->newToken($o_rule->getGoal(), $o_rule->getOptions());
            }
        }
        throw new ExUnknownRouteSolution($s_summary);
    }

    /**
     * 创建路由令牌组件实例。
     *
     * @param  string      $goal    目标控制器类名
     * @param  string[]    $options 目标控制器调用参数
     * @return Token\Token
     */
    protected function newToken($goal, $options)
    {
        return new Token\Token($goal, $options);
    }
}
