<?php
/**
 * 定义当目标控制器类未实现标准接口时抛出地异常。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Router\Token;

/**
 * 当目标控制器类未实现标准接口时抛出地异常。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 *
 * @method void __construct(string $class, \Exception $prev = null) 构造函数
 */
final class ExIllegalGoalType extends Exception
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected static $template = '控制器类“%class$s”未实现标准接口，无法执行派发。';

    /**
     * {@inheritdoc}
     *
     * @internal
     *
     * @var string[]
     */
    protected static $contextSequence = array('class');
}
