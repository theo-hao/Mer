<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 3/14/13
 * Time: 5:11 PM
 * To change this template use File | Settings | File Templates.
 */
class Core_Mer
{
    protected static $class_alias = array();
    protected static $class_directory = array();

    public static function loader($alias, $directory)
    {
        static::$class_alias = $alias;
        static::$class_directory = $directory;
    }


    public static function auto_load($class_name)
    {
        if(array_key_exists($class_name, static::$class_alias))
        {
            $file_dir =  static::$class_alias[$class_name];
            if( file_exists($file_dir))
            {
                include_once $file_dir;
                return;
            }
            else
            {
                Event::fire('System.Error.Alias.No.Class', $file_dir);
            }
        }
        $class_path = str_replace("_", DIR_SEPARATOR, strtolower($class_name));

        foreach(static::$class_directory  as $dir)
        {
            $class_dir = strpos($dir, DIR_SEPARATOR, (strlen($dir) - 1)) ? $dir . $class_path . EXT : $dir . DIR_SEPARATOR . $class_path . EXT;
            if ( file_exists($class_dir))
            {
                include_once $class_dir;
                return;
            }
        }
        Event::fire('System.Error.No.Found.Class', $class_name);
    }
}
