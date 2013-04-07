<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 3/14/13
 * Time: 4:16 PM
 * To change this template use File | Settings | File Templates.
 */
//if( !defined('DIR_SEPARATOR'))
//{
    error_reporting(E_ALL);
    define('DIR_SEPARATOR', DIRECTORY_SEPARATOR);
    define('EXT', '.php');
    define('URL_BASE', '/Mer/');

    $base_dir = realpath(dirname(__FILE__)) . DIR_SEPARATOR;
    $module_path = $base_dir . "module" . DIR_SEPARATOR;
    $application_path = $base_dir . "application" . DIR_SEPARATOR;
    $system_path = $base_dir . "system" . DIR_SEPARATOR;
    $config_path = $application_path . 'config' . DIR_SEPARATOR;

    define('BASE_DIR', $base_dir);
    define('MODULE_PATH', $module_path);
    define('APPLICATION_PATH', $application_path);
    define('SYSTEM_PATH', $system_path);
    define('CONFIG_PATH', $config_path);


    include SYSTEM_PATH . "classes" . DIR_SEPARATOR . 'event' . DIR_SEPARATOR . 'core'.EXT;
    include SYSTEM_PATH . "classes" . DIR_SEPARATOR . 'event' . EXT;

    Event::listen('System.Error.Router.No.Action', function($param){
        echo "Action";
//    var_dump($param);
        exit;
    });

    Event::listen('System.Error.404', function(){
        echo "404";
        exit;
    });

    Event::listen('System.Error.Router.No.Controller', function($controller){
        echo "Controller";
//    var_dump($controller);
        $view = View::factory(SYSTEM_PATH . 'base'. DIR_SEPARATOR . 'error' . DIR_SEPARATOR . '400' . EXT);
        $view->with('error', $controller);
        echo $view->render();
        exit;
    });

    Event::listen('System.Error.Route.No.Match.Route', function($route_name){
        $view = View::factory(SYSTEM_PATH . 'base'. DIR_SEPARATOR . 'error' . DIR_SEPARATOR . '400');
        $view->with('error', implode('', $route_name));
        echo $view->render();
        exit;
    });

    Event::listen('System.Error.Config.Error', function($config_error){
        $view = View::factory(SYSTEM_PATH . 'base' . DIR_SEPARATOR . 'error'. DIR_SEPARATOR . 'config');
        $view->with('error','没有' . implode( $config_error));
        echo $view->render();
        exit;
    });

    Event::listen('System.Error.Alias.No.Class', function($class_name){
        echo $class_name;
    });

    Event::listen('System.Error.No.Found.Class', function($class_name){
//    var_dump($class_name);
        var_dump($class_name);
        exit;
    });

    Event::listen('System.Error.No.View', function($view){
        var_dump($view);
        exit;
    });

    Event::listen('System.Error', function($param){
        echo is_array($param) ? implode(',', $param) : $param;
        exit;
    });

    include SYSTEM_PATH . "classes" . DIR_SEPARATOR . "core" . DIR_SEPARATOR . 'mer' . EXT ;
    include SYSTEM_PATH . "classes" . DIR_SEPARATOR ."core" . EXT;


    $result = spl_autoload_register(array('core', 'auto_load'));

    $class_alias = array(
//    'Router' => SYSTEM_PATH . 'classes' . DIR_SEPARATOR . 'router' . EXT,
    );

    $class_loader_directory = array(
        APPLICATION_PATH . 'classes' . DIR_SEPARATOR,
        SYSTEM_PATH . 'classes' . DIR_SEPARATOR,
        MODULE_PATH,
    );

    Core_Mer::loader($class_alias, $class_loader_directory);

    /**
     * 模块添加和使用
     * 当不再使用某模块，可以注释或者删除，将会不启用模块
     */
    $modules = array(
        'orm' => MODULE_PATH . 'orm',
        'mysql' => MODULE_PATH . 'mysql',
        'cli' => MODULE_PATH . 'cli',
    );



    /***
     * URL后缀链接使用
     * 如
     * http://192.168.1.100/dairy/list.do
     * public function do_list()
     *
     * http://192.168.1.100/dairy/create.action
     * public function action_create()
     *
     * http://192.168.1.100/dairy/index.html
     * public function html_index()
     *
     * http://192.168.1.100/dairy/index.jsp
     * public function jsp_index()
     *
     * 增加后缀，使外部查看，产生误解
     *
     * 优先级按照此处配置的顺序
     */
    $url_suffix = array(
        'action' => '.action',
        'do' => '.do',
        'html' => '.html',
        'php' => '.php',
        'dao' => '.jsp'
    );

//Router::action('user/list/(:num)/(?:num)', 'user@list');
//
//Router::controller('user/(:any)', 'user@info');
//var_dump($_SERVER);

    include_once APPLICATION_PATH . 'routes' . EXT;
    Request::instance()->execute();
//}

