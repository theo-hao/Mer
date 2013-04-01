<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 3/17/13
 * Time: 5:25 PM
 * To change this template use File | Settings | File Templates.
 */


//
//Router::common('</directory>/</controller>/</action>.(?:suffix)');
//
Router::action('/', 'welcome@index');
Router::controller('welcome/(?:any).(?:suffix)', 'welcome');
//Router::action('user/(:num)', 'user@info');
Router::action('user/(:num)/(?:any)/(?:num)', 'user@info');
Router::action('login', 'user@login');
Router::action('logout', 'user@logout');

Router::controller('user/(?:any).(?:suffix)', 'user');
//
//Router::group('admin', function(){
//
//});