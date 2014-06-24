<?php
/**
 * 定义当键名不合法时抛出地异常。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Input;

/**
 * 当键名不合法时抛出地异常。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 *
 * @method void __construct(string $key, \Exception $prev = null) 构造函数
 */
final class ExNonExistantKey extends Exception
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected static $template = '输入信息“%key$s”不存在。';

    /**
     * {@inheritdoc}
     *
     * @internal
     *
     * @var string[]
     */
    protected static $contextSequence = array('key');
}
