<?php
/**
 * 声明遵循单例模式地组件规范。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core;

/**
 * 遵循单例模式地组件规范。
 *
 * @package Zen\Core
 * @version    0.1.0
 * @since      0.1.0
 */
interface ISingleton
{
    /**
     * 获取组件的唯一实例。
     *
     * @return self
     */
    public static function singleton();
}
