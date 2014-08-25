<?php
/**
 * 定义可做类型转换的日期时间组件。
 */

namespace Zen\Core\Type;

use DateTime as PHPDateTime;
use DateTimeZone;

/**
 * 可做类型转换的日期时间组件。
 *
 * @package    Zen\Core
 * @subpackage Type
 * @version    0.1.0
 * @since      0.1.0
 */
class DateTime extends PHPDateTime
{
    /**
     * 构造函数
     *
     * @param string       $time 可选。时间描述
     * @param DateTimeZone $zone 可选。时区
     */
    public function __construct($time = 'now', DateTimeZone $zone = null)
    {
        if ('epoch' == $time || '0' == $time) {
            $time = '1970-01-01 00:00:00';
        }
        parent::__construct($time, $zone);
    }

    /**
     * 获取日期时间字符串。
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('Y-m-d H:i:s');
    }
}
