<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-25
 * Time: 下午7:59
 * To change this template use File | Settings | File Templates.
 */
class Route_Model
{
    private  $controller;
    private  $action;
    private  $params = array();

    public function __construct($controller, $action, $params)
    {
        $this->controller = 'Controller_' . $controller;
        $this->action = $action;

        $this->params = $params;
    }

    protected function action_params()
    {

    }

    public function action($action_name = NULL)
    {
        if ( ! empty($action_name))
        {
            $this->action = $action_name;
            return NULL;
        }
        else
        {
            return $this->action;
        }
    }

    public function controller($controller_name = NULL)
    {
        if ( ! empty($controller_name))
        {
            $this->controller = 'Controller_' . $controller_name;
            return NULL;
        }
        else
        {
            return $this->controller;
        }
    }

    public function get_param($key = NULL)
    {
        if (empty($key))
        {
            return $this->params;
        }
        else
        {
            return $this->params[$key];
        }
    }

    public function set_param($key_or_params, $value)
    {
        if ( is_array($key_or_params))
        {
            $this->params = $key_or_params;
        }
        else if ($value && is_string($key_or_params))
        {
            $this->params[$key_or_params] = $value;
        }
    }

}
