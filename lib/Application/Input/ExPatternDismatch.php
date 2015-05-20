<?php
/**
 * 定义当元素不匹配模式时抛出地异常。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Input;

/**
 * 当元素不匹配模式时抛出地异常。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 *
 * @method void __construct(string $key, \Exception $prev = null) 构造函数
 */
final class ExPatternDismatch extends Exception
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected static $template = '输入信息“%key$s”未匹配模式“%pattern$s”。';

    /**
     * {@inheritdoc}
     *
     * @internal
     *
     * @var string[]
     */
    protected static $contextSequence = array('key', 'pattern');
}
