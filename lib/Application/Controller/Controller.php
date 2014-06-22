<?php
/**
 * 定义应用程序的控制器组件。
 *
 * @author    Snakevil Zen <zsnakevil@gmail.com>
 * @copyright © 2014 SZen.in
 * @license   LGPL-3.0+
 */

namespace Zen\Core\Application\Controller;

use Zen\Core;

/**
 * 应用程序的控制器组件。
 *
 * @package    Zen\Core
 * @subpackage Application
 * @version    0.1.0
 * @since      0.1.0
 */
abstract class Controller extends Core\Component implements Core\Application\IController
{
    /**
     * 隶属应用程序实例。
     *
     * @var Core\Application\IApplication
     */
    protected $appliance;

    /**
     * 关联地配置信息组件实例。
     *
     * @var Core\Application\IConfiguration
     */
    protected $config;

    /**
     * 关联地输入信息组件实例。
     *
     * @var Core\Application\IInput
     */
    protected $input;

    /**
     * 关联地输出流组件实例。
     *
     * @var Core\Application\IOutput
     */
    protected $output;

    /**
     * {@inheritdoc}
     *
     * @param Core\Application\IApplication $app 应用程序组件实例
     */
    public function __construct(Core\Application\IApplication $app)
    {
        $this->appliance = $app;
        $this->config = $app->getConfig();
        $this->input = $app->getInput();
        $this->output = $app->getOutput();
    }
}
