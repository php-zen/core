<?php
/**
 * 定义当包引导程序调用组件多次运行时抛出地异常。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2016 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core;

/**
 * 当包引导程序调用组件多次运行时抛出地异常。
 */
final class ExStubAlreadyDone extends Exception
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected static $template = '包引导程序已执行。';
}
