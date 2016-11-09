<?php
/**
 * 定义框架内派生异常的基础抽象。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2016 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core;

use Exception as PHPException;

/**
 * 框架内派生异常的基础抽象。
 *
 * @version 0.1.0
 *
 * @since   0.1.0
 *
 * @method void __construct(mixed $..., \Exception $prev = null) 构造函数
 */
abstract class Exception extends PHPException
{
    /**
     * 异常编号。
     *
     * @var int
     */
    const CODE = 1;

    /**
     * 异常描述模板。
     *
     * @var string
     */
    protected static $template = '未知错误';

    /**
     * 环境信息名称序列。
     *
     * @var string[]
     */
    protected static $contextSequence = array();

    /**
     * 环境信息集合。
     *
     * @internal
     *
     * @var scalar[]
     */
    protected $context;

    /**
     * 构造函数.
     *
     * @internal
     */
    final public function __construct()
    {
        $a_args = func_get_args();
        $i_args = count($a_args);
        $i_keys = count(static::$contextSequence);
        $e_prev = null;
        if ($i_args) {
            if (1 + $i_keys < $i_args) {
                $i_args = 1 + $i_keys;
                array_splice($a_args, $i_args);
            }
            if ($a_args[$i_args - 1] instanceof PHPException) {
                $e_prev = array_pop($a_args);
                --$i_args;
            }
        }
        $a_keys = static::$contextSequence;
        if ($i_keys > $i_args) {
            array_splice($a_keys, $i_args);
        } elseif ($i_keys < $i_args) {
            array_splice($a_args, $i_keys);
        }
        $this->context = array_combine($a_keys, $a_args);
        parent::__construct($this->semanticize(), static::CODE, $e_prev);
    }

    /**
     * 根据环境信息生成合适的描述。
     *
     * @internal
     *
     * @return string
     */
    final protected function semanticize()
    {
        if (!preg_match_all('@%([^\$]+)\$@', static::$template, $a_matches, PREG_SET_ORDER)) {
            return static::$template;
        }
        $a_context = $this->format();
        $i_counter = 0;
        $a_src = $a_dst = $a_val = array();
        foreach ($a_matches as $ii) {
            if (isset($a_src[$ii[0]])) {
                continue;
            }
            $a_src[$ii[0]] = 1;
            $a_dst[] = '%'.(++$i_counter).'$';
            $a_val[] = isset($a_context[$ii[1]]) ? $a_context[$ii[1]] : '';
        }
        $a_src = array_keys($a_src);

        return vsprintf(str_replace($a_src, $a_dst, static::$template), $a_val);
    }

    /**
     * 格式化环境信息。
     *
     * @return mixed[]
     */
    protected function format()
    {
        return $this->context;
    }

    /**
     * 获取环境信息集合。
     *
     * @return mixed[]
     */
    final public function getContext()
    {
        return $this->context;
    }

    /**
     * 获取描述。
     *
     * @return string
     */
    final public function __toString()
    {
        return $this->getMessage();
    }
}
