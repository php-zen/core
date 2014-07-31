<?php
/**
 * 定义框架内派生组件的基础抽象。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core;

use ReflectionClass;

/**
 * 框架内派生组件的基础抽象。
 *
 * @package Zen\Core
 * @version 0.1.0
 * @since   0.1.0
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
        $i_mode = $this->zenDetectProp($property);
        if (4 & $i_mode) {
            $s_xetter = 'get' . $property;

            return $this->$s_xetter();
        }
        if (1 & $i_mode) {
            return $this->zenGet($property);
        }
    }

    /**
     * 获取非公开属性值。
     *
     * @param  string $property 属性名
     * @return mixed
     */
    protected function zenGet($property)
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
        $i_mode = $this->zenDetectProp($property);
        if (2 & $i_mode) {
            $s_xetter = 'set' . $property;

            return $this->s_xetter($value);
        }
        if (1 & $i_mode) {
            return $this->zenSet($property, $value);
        }
    }

    /**
     * 设置非公开属性值。
     *
     * @param  string $property 属性名
     * @param  mixed  $value    新值
     * @return void
     */
    protected function zenSet($property, $value)
    {
    }

    /**
     * 重载 PHP 原生 `__isset()` 魔法方法。
     *
     * @param  string $property 属性名
     * @return bool
     */
    final public function __isset($property)
    {
        $i_mode = $this->zenDetectProp($property);
        if (!$i_mode) {
            return false;
        }

        return $this->zenIsset($property);
    }

    /**
     * 判断非公开属性是否设有值。
     *
     * @param  string $property 属性名
     * @return bool
     */
    protected function zenIsset($property)
    {
        return true;
    }

    /**
     * 重载 PHP 原生 `__unset()` 魔法方法。
     *
     * @param  string $property 属性名
     * @return bool
     */
    final public function __unset($property)
    {
        $this->__set($property, null);
    }

    /**
     * 度量非公共属性的可读写性。
     *
     * @internal
     *
     * @param  string $name 属性名
     * @return int
     */
    final protected function zenDetectProp($name)
    {
        $s_class = get_class($this);
        if (null === self::$zenPropsTable) {
            self::$zenPropsTable = array();
        }
        if (!isset(self::$zenPropsTable[$s_class])) {
            $a_table = array();
            $o_rclass = new ReflectionClass($this);
            foreach ($o_rclass->getProperties() as $ii) {
                if ($ii->isStatic() || $ii->isPublic()) {
                    continue;
                }
                $s_prop = $ii->getName();
                if ('zen' == substr($ii, 0, 3)) {
                    $a_table[$s_prop] = 0;
                    continue;
                }
                $i_mode = 1;
                if (method_exists($this, 'set' . $s_prop)) {
                    $i_mode += 2;
                }
                if (method_exists($this, 'get' . $s_prop)) {
                    $i_mode += 4;
                }
                $a_table[$s_prop] = $i_mode;
            }
            self::$zenPropsTable[$s_class] = $a_table;
        }

        return isset(self::$zenPropsTable[$s_class][$name])
            ? self::$zenPropsTable[$s_class][$name]
            : 0;
    }
}
