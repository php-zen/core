<?php
/**
 * 定义可做类型转换的日期时间组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2016 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Type;

use DateTime as PHPDateTime;
use DateTimeZone;

class DateTime extends PHPDateTime
{
    /**
     * 构造函数.
     *
     * @param string|int   $time 可选。时间描述
     * @param DateTimeZone $zone 可选。时区
     */
    public function __construct($time = 'now', DateTimeZone $zone = null)
    {
        if ('epoch' == $time || '0' == $time || '0000-00-00 00:00:00' == $time) {
            $time = '1970-01-01 00:00:00';
        }
        if (is_numeric($time) && 2038 < $time) {
            parent::__construct('now', $zone);
            $this->setTimestamp($time);
        } else {
            parent::__construct($time, $zone);
        }
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
