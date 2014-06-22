<?php
/**
 * 定义应用程序的路由规则原型组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Router\Routine;

use Zen\Core;

/**
 * 应用程序的路由规则原型组件。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
abstract class Routine extends Core\Component implements Core\Application\IRouterRoutine
{
    /**
     * 组件实例池。
     *
     * @var Routine[]
     */
    protected static $instances = array();

    /**
     * {@inheritdoc}
     *
     * @return self
     */
    final public static function singleton()
    {
        $s_class = get_called_class();
        if (!isset(self::$instances[$s_class])) {
            self::$instances[$s_class] = new static;
        }

        return self::$instances[$s_class];
    }

    /**
     * 路由规则待处理逻辑的匹配模式。
     */
    const PATTERN = '';

    /**
     * 路由规则待处理逻辑对应的规则组件类名。
     */
    const RULE_CLASS = '';

    /**
     * {@inheritdoc}
     *
     * @param  string            $pattern  路由模式
     * @param  string            $approach 对应地处理逻辑
     * @return IRouterRule|false
     */
    final public function generate($pattern, $approach)
    {
        $s_class = static::RULE_CLASS;
        if (!is_subclass_of($s_class, 'Zen\Core\Application\IRouterRule') ||
            !preg_match('#^' . static::PATTERN . '$#', $approach, $a_matches)
        ) {
            return;
        }

        return new $s_class($pattern, $a_matches);
    }
}
