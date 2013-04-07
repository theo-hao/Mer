<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 3/14/13
 * Time: 6:26 PM
 * To change this template use File | Settings | File Templates.
 */

return array(
    'default' => array(
        'type' => 'mysql',
        'connection' => array(
            'hostname' => 'localhost',
            'user' => 'root',
            'password' => '123456',
            'database' => 'blogs',
        ),
        'charset' => 'utf8',
        'table_prefix' => '',
        'profiling' => TRUE,
        'caching' => false,
    ),
);