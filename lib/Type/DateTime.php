<?php
/**
 * 定义可做类型转换的日期时间组件。
 */

namespace Zen\Core\Type;

use DateTime as PHPDateTime;

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
     * 获取日期时间字符串。
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('Y-m-d H:i:s');
    }
}
