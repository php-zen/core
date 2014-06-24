<?php
/**
 * 定义当无法匹配合适的路由规则时抛出地异常。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Router;

/**
 * 当无法匹配合适的路由规则时抛出地异常。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 *
 * @method void __construct(string $summary, \Exception $prev = null) 构造函数
 */
final class ExUnknownRouteSolution extends Exception
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected static $template = '无法找到适合请求“%summary$s”的路由规则。';

    /**
     * {@inheritdoc}
     *
     * @internal
     *
     * @var string[]
     */
    protected static $contextSequence = array('summary');
}
