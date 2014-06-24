<?php
/**
 * 定义应用程序的配置信息组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Configuration;

use Zen\Core;

/**
 * 应用程序的配置信息组件。
 *
 * 数据读取方式，参见 {@link http://php.net/arrayaccess PHP 的 ArrayAccess 接口}。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
final class Configuration extends Core\Component implements Core\Application\IConfiguration
{
    /**
     * 配置信息树。
     *
     * @internal
     *
     * @var Array
     */
    protected $tree;

    /**
     * 判断指定元素是否存在。
     *
     * @internal
     *
     * @param  scalar $offset 键名
     * @return bool
     */
    public function offsetExists($offset)
    {
        $s_key = is_string($offset)
            ? trim($offset, ". \t\n\r\0\x0B")
            : (string) $offset;
        $a_nodes = explode('.', $s_key);
        if (1 == count($a_nodes)) {
            return array_key_exists($s_key, $this->tree);
        }
        $s_key = array_pop($a_nodes);
        $s_var = '$this->tree[\'' . implode('\'][\'', $a_nodes) . '\']';
        eval('$b_ret = isset(' . $s_var . ') && array_key_exists(\'' . $s_key . '\', ' . $s_var . ');');

        return $b_ret;
    }

    /**
     * 获取指定元素值。
     *
     * @internal
     *
     * @param  scalar $offset 键名
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $s_key = is_string($offset)
            ? trim($offset, ". \t\n\r\0\x0B")
            : (string) $offset;
        $s_var = '$this->tree[\'' . str_replace('.', '\'][\'', $s_key) . '\']';
        eval('$m_ret = @' . $s_var . ';');

        return $m_ret;
    }

    /**
     * 设置指定元素值。
     *
     * @internal
     *
     * @param  scalar $offset 键名
     * @param  mixed  $value  新值
     * @return void
     */
    public function offsetSet($offset, $value)
    {
    }

    /**
     * 删除指定元素。
     *
     * @internal
     *
     * @param  scalar $offset 键名
     * @return void
     */
    public function offsetUnset($offset)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @param array|string $config 配置表
     */
    public function __construct($config)
    {
        if (is_array($config)) {
            $a_conf = $config;
        } elseif (is_string($config) && is_file($config)) {
            $a_conf = require $config;
        } else {
            $a_conf = array();
        }
        $this->tree = $this->arrange($a_conf);
    }

    /**
     * 整理指定配置表数组。
     *
     * @internal
     *
     * @param  array $raw 原始配置表
     * @return array
     */
    protected function arrange($raw)
    {
        $a_ret = array();
        foreach ($raw as $kk => $vv) {
            $kk = is_string($kk)
                ? trim($kk, ". \t\n\r\0\x0B")
                : (string) $kk;
            $a_nodes = explode('.', $kk);
            $a_ref =& $a_ret;
            for ($ii = 0, $jj = count($a_nodes) - 1; $ii < $jj; $ii++) {
                if (!isset($a_ref[$a_nodes[$ii]])) {
                    $a_ref[$a_nodes[$ii]] = array();
                }
                $a_ref =& $a_ref[$a_nodes[$ii]];
            }
            if (!is_array($vv) || !isset($a_ref[$a_nodes[$ii]])) {
                $a_ref[$a_nodes[$ii]] = $vv;
            } else {
                $a_ref[$a_nodes[$ii]] = array_merge_recursive($a_ref[$a_nodes[$ii]], $vv);
            }
        }

        return $a_ret;
    }
}
