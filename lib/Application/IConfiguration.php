<?php
/**
 * 声明应用程序的配置信息组件规范。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

use ArrayAccess;

/**
 * 应用程序的配置信息组件规范。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
interface IConfiguration extends ArrayAccess
{
    /**
     * 构造函数
     *
     * @param mixed[]|string $config 配置表
     */
    public function __construct($config);
}
