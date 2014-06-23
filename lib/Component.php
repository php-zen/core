<?php
/**
 * 定义框架内派生组件的基础抽象。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core;

/**
 * 框架内派生组件的基础抽象。
 *
 * @package Zen\Core
 * @version    0.1.0
 * @since      0.1.0
 */
abstract class Component
{
    /**
     * 非公共属性的读写性记录表。
     *
     * @internal
     *
     * @var array[]
     */
    protected static $zenPropsTable;

    /**
     * 重载 PHP 原生 `__get()` 魔法方法。
     *
     * @param  string $property 属性名
     * @return mixed
     */
    final public function __get($property)
    {
        if (2 & $this->zenMeasureProperty($property)) {
            $s_xetter = 'zenGet' . $property;

            return $this->$s_xetter();
        }
        if (1 & $this->zenMeasureProperty($property)) {
            return $this->onGetProperty($property);
        }
    }

    /**
     * 读取非公开属性的事件。
     *
     * @param  string $property 属性名
     * @return mixed
     */
    protected function onGetProperty($property)
    {
    }

    /**
     * 重载 PHP 原生 `__set()` 魔法方法。
     *
     * @param  string $property 属性名
     * @param  mixed  $value    新值
     * @return void
     */
    final public function __set($property, $value)
    {
        if (4 & $this->zenMeasureProperty($property)) {
            $s_xetter = 'zenSet' . $property;

            return $this->s_xetter($value);
        }
        if (1 & $this->zenMeasureProperty($property)) {
            return $this->onSetProperty($property, $value);
        }
    }

    /**
     * 设置非公开属性的事件。
     *
     * @param  string $property 属性名
     * @param  mixed  $value    新值
     * @return void
     */
    protected function onSetProperty($property, $value)
    {
    }

    /**
     * 度量非公共属性的可读写性。
     *
     * @internal
     *
     * @param  string $name 属性名
     * @return int
     */
    final protected function zenMeasureProperty($name)
    {
        if (!is_array(self::$zenPropsTable)) {
            self::$zenPropsTable = array();
        }
        $s_class = get_class($this);
        if (!isset(self::$zenPropsTable[$s_class][$name])) {
            self::$zenPropsTable[$s_class] = array();
            foreach (array_keys(get_class_vars($s_class)) as $ii) {
                if ('zen' != substr($ii, 0, 3)) {
                    self::$zenPropsTable[$s_class][$ii] = 1;
                }
            }
            $s_xetter = 'zenGet' . $name;
            if (method_exists($s_class, $s_xetter)) {
                self::$zenPropsTable[$s_class][$name] += 2;
            }
            $s_xetter = 'zenSet' . $name;
            if (method_exists($s_class, $s_xetter)) {
                self::$zenPropsTable[$s_class][$name] += 4;
            }
        }

        return self::$zenPropsTable[$s_class][$name];
    }
}
