<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-31
 * Time: 上午7:42
 * To change this template use File | Settings | File Templates.
 */

/**
 * 配置文件读取，在index时，将配置都读到内存中，
 */
class Config_Core
{
    protected static $configs = array();

    /**
     * @static
     * @var string 配置文件
     * 加载配置
     */
    public static function load($file = NULL)
    {
        if ($file)
        {
            $file_dir = CONFIG_PATH . $file . EXT;
            if ( ! file_exists($file_dir))
            {
                Event::fire('System.Error.Config.Error', '没有' . $file . "配置");
            }
            static::$configs[strtoupper($file)] = include $file_dir;
        }
        else
        {
            $dir_handler = opendir(CONFIG_PATH);
            if ( ! is_resource($dir_handler))
            {
                Event::fire('System.Error', '未能打开'. CONFIG_PATH);
            }

            while($file = readdir($dir_handler))
            {
                if ( $file == '.' || $file == '..')
                    continue;
                $file_dir = CONFIG_PATH . $file;
                echo $file_dir;
                $file_key = pathinfo($file_dir, PATHINFO_FILENAME);
                static::$configs[strtoupper($file_key)] = include $file_dir;
            }
            closedir($dir_handler);
        }
    }

    public static function get($key = NULL)
    {
        if ( ! $key)
        {
            return static::$configs;
        }

        if (array_key_exists(strtoupper($key), static::$configs))
        {
            return static::$configs[$key];
        }

        return NULL;
    }

    public static function refresh($file = NULL)
    {

    }
}
