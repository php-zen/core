<?php
/**
 * 声明应用程序的输入信息组件规范。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

use ArrayAccess;

/**
 * 应用程序的输入信息组件规范。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
interface IInput extends ArrayAccess
{
    /**
     * 构造函数
     */
    public function __construct();

    /**
     * 获取用于路由派发地特征字符串。
     *
     * @return string
     */
    public function summarize();

    /**
     * 尝试获取指定键值。
     *
     * 如该键不存在，则采用默认值。
     *
     * @param  string $key      输入信息键名
     * @param  mixed  $defaults 默认值
     * @return mixed
     */
    public function expect($key, $defaults);

    /**
     * 尝试以指定类型获取指定键值。
     *
     * 如该键不存在，则采用默认值。
     *
     * 若未指定默认值，会抛出异常。
     *
     * @param  string $key      输入信息键名
     * @param  string $type     期望类型
     * @param  mixed  $defaults 可选。默认值
     * @return mixed
     */
    public function expectType($key, $type, $defaults = null);

    /**
     * 尝试获取指定键值并匹配模式。
     *
     * 如该键不存在，或不匹配指定模式，则采用默认值。
     *
     * 若未指定默认值，会抛出异常。
     *
     * @param  string $key      输入信息键名
     * @param  string $pattern  期望模式
     * @param  string $defaults 可选。默认值
     * @return string
     */
    public function expectMatch($key, $pattern, $defaults = null);
}
