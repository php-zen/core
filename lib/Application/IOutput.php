<?php
/**
 * 声明应用程序的输出流组件规范。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application;

/**
 * 应用程序的输出流组件规范。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
interface IOutput
{
    /**
     * 构造函数
     */
    public function __construct();

    /**
     * 输出指定数据。
     *
     * @param  string $binary 待输出内容片段
     * @return self
     */
    public function write($binary);

    /**
     * 关闭输出流。
     *
     * @return self
     */
    public function close();
}
