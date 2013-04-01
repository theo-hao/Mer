<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-21
 * Time: 下午4:03
 * To change this template use File | Settings | File Templates.
 */
class Common_String
{
    public static function remove($haystack, $char, $direction = 1)
    {
        if ($direction >= 0)
        {
            return ltrim($haystack, $char);
        }else
        {
           return rtrim($haystack, $char);
        }
    }

    public static function start_with($haystack, $char)
    {
        return strpos($haystack, $char) === 0;
    }

    /**
     * 以特定字符结尾
     * @static
     * @param $haystack
     * @param $char
     * @return bool
     */
    public static function end_with($haystack, $char)
    {
        return strrpos($haystack, $char) === (strlen($haystack) - strlen($char));
    }

    public static function dir_join($base, $dir, $connector = DIR_SEPARATOR)
    {
        return static::end_with($base, $connector) ? $base . $dir : $base . $connector . $dir;
    }

    public static function gb_substr($string, $start, $length) {
        if(strlen($string)>$length){      //strlen得到字符串的长度
            $str=null;
            $len=$start+$length;
            for($i=$start;$i<$len;$i++){
                if(ord(substr($string,$i,1)) > 0xa0){
                    $str.=substr($string,$i,2);
                    $i++;
                }else{
                    $str.=substr($string,$i,1);
                }
            }
            return $str.'...';
        }else{
            return $string;
        }
    }
}
