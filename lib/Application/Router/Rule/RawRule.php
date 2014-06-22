<?php
/**
 * 定义处理逻辑即为控制器名称地规则组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Router\Rule;

/**
 * 处理逻辑即为控制器名称地规则组件。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
final class RawRule extends Rule
{
    /**
     * {@inheritdoc}
     *
     * @internal
     *
     * @return string
     */
    protected function aim()
    {
        return $this->params[0];
    }
}
