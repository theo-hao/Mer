<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-25
 * Time: 下午9:01
 * To change this template use File | Settings | File Templates.
 */
class Event_Core
{
    protected  static $events = array(
    );

    protected static function init()
    {
        Event_Core::listen('System.Error.No.Event', function(){
            //echo 'No the Event';
            exit;
        });
    }

    public static function fire($name, $params = null)
    {
        if ( !static::exist('System.Error.No.Event'))
        {
            static::init();
        }

        if ( !isset(static::$events[$name]))
        {

            Event::fire('System.Error.No.Event');
            exit;
        }
        return call_user_func(static::$events[$name], array($params));
    }

    protected static function exist($name)
    {
        return array_key_exists($name, static::$events);
    }

    public static function listen($name, $callback)
    {
        if (static::exist($name))
        {
            echo $name . " Event 重复定义";
            exit;
        }
        static::$events[$name] = $callback;
    }
}
