<?php
/**
 * 定义应用程序的路由规则组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Router\Rule;

use Zen\Core;

/**
 * 应用程序的路由规则组件。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
abstract class Rule extends Core\Component implements Core\Application\IRouterRule
{
    /**
     * 路由模式。
     *
     * @internal
     *
     * @var string
     */
    protected $pattern;

    /**
     * 规则初始参数。
     *
     * @internal
     *
     * @var string[]
     */
    protected $params;

    /**
     * 目标控制器类名。
     *
     * @internal
     *
     * @var string
     */
    protected $goal;

    /**
     * 目标控制器调用参数。
     *
     * @internal
     *
     * @var string[]
     */
    protected $options;

    /**
     * {@inheritdoc}
     *
     * @param string   $pattern 路由模式
     * @param string[] $params  初始参数
     */
    final public function __construct($pattern, $params)
    {
        $this->pattern = $pattern;
        $this->params = $params;
        $this->goal = '';
        $this->options = array();
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $summary 输入信息摘要
     * @return bool
     */
    final public function match($summary)
    {
        if (!preg_match($this->pattern, $summary, $a_matches)) {
            return false;
        }
        $this->options = array_merge($this->params, $a_matches);
        $this->goal = $this->aim();

        return true;
    }

    /**
     * 分析获取目标控制器类名。
     *
     * @return string
     */
    abstract protected function aim();

    /**
     * {@internal}
     *
     * @return string
     */
    final public function getGoal()
    {
        return $this->goal;
    }

    /**
     * {@internal}
     *
     * @return string[]
     */
    final public function getOptions()
    {
        return $this->options;
    }
}
