<?php
/**
 * 定义应用程序的输出流组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Output;

use Zen\Core;

/**
 * 应用程序的输出流组件。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
abstract class Output extends Core\Component implements Core\Application\IOutput
{
    /**
     * 输出流缓冲区。
     *
     * @internal
     *
     * @var string
     */
    protected $buffer;

    /**
     * 关闭状态标志位。
     *
     * @var bool
     */
    protected $closed;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->buffer = '';
        $this->closed = false;
        ob_start();
    }

    /**
     * {@inheritdoc}
     *
     * @param  string $binary 待输出内容片段
     * @return self
     */
    public function write($binary)
    {
        if (!$this->closed) {
            $this->buffer .= $binary;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return self
     */
    public function close()
    {
        if (!$this->closed) {
            $this->closed = true;
            print($this->buffer . ob_get_clean());
            $this->buffer = '';
            ob_start();
        }

        return $this;
    }
}
