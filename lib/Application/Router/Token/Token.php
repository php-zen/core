<?php
/**
 * 定义应用程序的路由令牌组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Router\Token;

use Zen\Core;

/**
 * 应用程序的路由令牌组件。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
final class Token extends Core\Component implements Core\Application\IRouterToken
{
    /**
     * 目标控制器类。
     *
     * @var string
     */
    protected $goal;

    /**
     * 控制器调用参数。
     *
     * @var mixed[]
     */
    protected $options;

    /**
     * 判断元素是否存在。
     *
     * @internal
     *
     * @param  scalar $offset 键名
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->options);
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
        return @$this->options[$offset];
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
     * @param  string $offset 键名
     * @return void
     */
    public function offsetUnset($offset)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @param string $goal    目标控制器类名
     * @param array  $options 控制器调用参数
     */
    public function __construct($goal, $options)
    {
        $this->goal = $goal;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     *
     * @param  Core\Application\IApplication $app 应用程序实例
     * @return void
     */
    public function dispatch(Core\Application\IApplication $app)
    {
        $s_class = $this->goal;
        if (!class_exists($s_class)) {
            $o_ctrl = $this->newUndefinedController($app);
        } else {
            if (!is_subclass_of($s_class, 'Zen\Core\Application\IController')) {
                throw new ExIllegalGoalType($s_class);
            }
            $o_ctrl = new $s_class($app);
        }
        $o_ctrl->act($this);
    }

    /**
     * 创建辅助路由派发功能的特殊控制器实例。
     *
     * @param  Core\Application\IApplication                   $app 应用程序实例
     * @return Core\Application\Controller\UndefinedController
     */
    protected function newUndefinedController(Core\Application\IApplication $app)
    {
        return new Core\Application\Controller\UndefinedController($app);
    }
}
