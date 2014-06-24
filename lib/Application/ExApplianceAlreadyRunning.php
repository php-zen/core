<?php
/**
 * 定义当多应用程序同时运行时抛出地异常。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

/**
 * 当多应用程序同时运行时抛出地异常。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 *
 * @method void __construct(string $class, \Exception $prev = null) 构造函数
 */
final class ExApplianceAlreadyRunning extends Exception
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected static $template = '应用程序“%class$s”已运行。';

    /**
     * {@inheritdoc}
     *
     * @internal
     *
     * @var string[]
     */
    protected static $contextSequence = array('class');
}
