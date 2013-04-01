<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-26
 * Time: 上午7:13
 * To change this template use File | Settings | File Templates.
 */
class Common_Array
{
    public static function remove(&$haystack, $key)
    {
        if (array_key_exists($key, $haystack))
        {
            unset($haystack[$key]);
        }

    }
}
