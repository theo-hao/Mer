<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-21
 * Time: 下午1:52
 * To change this template use File | Settings | File Templates.
 */
class Http_Request_Core
{
    /**
     * @var Http_Request_Core
     */
    protected static $handler;

    /**
     * @var 完整的Url
     */
    protected $full_url;
    /**
     * index.php 后面的地址
     * 如 http://localhost/index.php/user/list
     * @var
     */
    protected $url;
    /**
     * @var Controller名称
     */
    protected $controller;
    /**
     * @var action名称
     */
    protected $action;
    /**
     * @var 后缀
     */
    protected $suffix;

    protected static $server;

    private function __construct()
    {
        static::$server = $_SERVER;
        $this->full_url = '';
    }

    public static function instance()
    {
        if (empty(static::$handler))
        {
            static::$handler = new Http_Request_Core();
        }
        return static::$handler;
    }

    public function execute()
    {
        $url =  $this->router();
        $route = Router::execute($url);
        if ( !$route)
        {
            Event::fire('System.Error.404');
        }
        $controller = $route->controller();
        $action = $route->action();
        if( ! $controller || ! class_exists($controller))
        {
            Event::fire('System.Error.Router.No.Controller', $controller);
        }

        $controller_handler = new $controller();

        if ($controller_handler)
        {
            if( !method_exists($controller_handler, $action))
            {
                Event::fire("System.Error.Router.No.Action", array($controller, $action));
            }
            call_user_func(array($controller_handler, 'before'), Request::instance());
            call_user_func_array(array($controller_handler, $action), $route->get_param());
            call_user_func(array($controller_handler, 'after'));
        }
    }

    protected function router()
    {
        if (isset(static::$server['PATH_INFO']))
        {
            $url = static::$server['PATH_INFO'];
            $url = Str::remove($url, '/');
        }
        else
        {
            $url = static::$server['REQUEST_URI'];
            $url = Str::remove($url, URL_BASE);
        }
        return $url == 'index.php' ? '' : $url;
    }

    public function file($file)
    {

    }
}
