<?php

namespace Slimvc;

use \Slim\Slim;

/**
* Controller abstract class
*/
abstract class Controller
{
    protected $app;
    protected $config = [];

    public function __construct(Slim $app = null)
    {
        $this->app = ($app instanceof Slim) ? $app : Slim::getInstance();
    }

    public function config(array $config)
    {
        $this->config = $this->getApp()->container['settings'];
        if (!empty($config) && is_array($config)) {
            $this->config = array_merge($config, $this->config);
        }
        return $this;
    }

    protected function getConfig()
    {
        return $this->config;
    }

    protected function getApp()
    {
        return $this->app;
    }

    protected function render($template, $data = array(), $status = null)
    {
        $this->getApp()->render($template, $data, $status);
    }

    protected function translate($data)
    {
        return  $this->getConfig()['tr']->translate($data);
    }

    protected function stop()
    {
        $this->getApp()->stop();
    }
}
