<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-21
 * Time: 下午3:09
 * To change this template use File | Settings | File Templates.
 */
class Url_Core
{

    public static function base()
    {

    }

    public static function to()
    {

    }

    public static function asset()
    {

    }

    public static function redirect($url)
    {
        $url = (Str::start_with($url, 'http://') || Str::start_with($url, 'https://')) ? $url : 'http://' . $url;
        static::set_header('Location', $url);
    }

    private static function set_header($key, $value)
    {
        header($key . ":" . $value);
    }
}