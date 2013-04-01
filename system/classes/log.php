<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-21
 * Time: 上午9:07
 * To change this template use File | Settings | File Templates.
 */
class Log
{
    const CLASS_ALIAS_NO_FILE = 105;

    public static function write($type, $message)
    {
        if ($type instanceof Exception)
        {
            echo "ERROR";
        }

    }
}
