<?php
/**
 * 定义应用程序的输入信息组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Input;

use Zen\Core;

/**
 * 应用程序的输入信息组件。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
abstract class Input extends Core\Component implements Core\Application\IInput
{
    /**
     * 输入信息树。
     *
     * @internal
     *
     * @var array[]
     */
    protected $params;

    /**
     * 判断元素是否存在。
     *
     * @internal
     *
     * @param  scalar $offset 键名
     * @return bool
     */
    final public function offsetExists($offset)
    {
        $s_key1 = is_string($offset)
            ? trim($offset)
            : (string) $offset;
        $i_pos = strpos($s_key1, ':');
        if (false === $i_pos) {
            return false;
        }
        $s_key2 = substr($s_key1, 1 + $i_pos);
        $s_key1 = substr($s_key1, 0, $i_pos);

        return array_key_exists($s_key1, $this->params) && array_key_exists($s_key2, $this->params[$s_key1]);
    }

    /**
     * 获取指定元素值。
     *
     * @internal
     *
     * @param  scalar $offset 键名
     * @return mixed
     *
     * @throws ExInvalidKey     当键名不合法时
     * @throws ExNonExistantKey 当元素不存在时
     */
    final public function offsetGet($offset)
    {
        $s_key1 = is_string($offset)
            ? trim($offset)
            : (string) $offset;
        $i_pos = strpos($s_key1, ':');
        if (false === $i_pos) {
            throw new ExInvalidKey($s_key1);
        }
        $s_key2 = substr($s_key1, 1 + $i_pos);
        $s_key1 = substr($s_key1, 0, $i_pos);
        if (!array_key_exists($s_key1, $this->params) || !array_key_exists($s_key2, $this->params[$s_key1])) {
            throw new ExNonExistantKey($s_key1 . ':' . $s_key2);
        }

        return $this->params[$s_key1][$s_key2];
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
    final public function offsetSet($offset, $value)
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
    final public function offsetUnset($offset)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->params = array();
    }

    /**
     * {@inheritdoc}
     *
     * @param  scalar $key      键名
     * @param  mixed  $defaults 默认值
     * @return mixed
     */
    final public function expect($key, $defaults)
    {
        try {
            return $this->offsetGet($key);
        } catch (Exception $ee) {
            return $defaults;
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param  scalar $key      键名
     * @param  string $type     类型
     * @param  mixed  $defaults 可选。默认值
     * @return mixed
     *
     * @throws ExInvalidKey     当键名不合法且无默认值时
     * @throws ExNonExistantKey 当元素不存在且无默认值时
     */
    public function expectType($key, $type, $defaults = null)
    {
        try {
            $m_ret = $this->offsetGet($key);
        } catch (Exception $ee) {
            if (is_null($defaults)) {
                throw $ee;
            }
            $m_ret = $defaults;
        }
        settype($m_ret, $type);

        return $m_ret;
    }

    /**
     * {@inheritdoc}
     *
     * @param  scalar $key      键名
     * @param  string $pattern  模式
     * @param  string $defaults 可选。默认值
     * @return string
     *
     * @throws ExInvalidKey      当键名不合法且无默认值时
     * @throws ExNonExistantKey  当元素不存在且无默认值时
     * @throws ExPatternDismatch 当模式不匹配且无默认值时
     */
    public function expectMatch($key, $pattern, $defaults = null)
    {
        try {
            $m_ret = $this->offsetGet($key);
        } catch (Exception $ee) {
            if (is_null($defaults)) {
                throw $ee;
            }
        }
        if (!preg_match($pattern, $m_ret)) {
            if (is_null($defaults)) {
                throw new ExPatternDismatch($key, $pattern);
            }
            $m_ret = $defaults;
        }

        return $m_ret;
    }
}
