<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-2
 * Time: 上午12:13
 * To change this template use File | Settings | File Templates.
 */
abstract class Database_Base
{
    protected static $sql;
    protected $flag;
    protected $sentences;
    protected $driver = NULL;
    protected static $connect_handlers = array();

    protected function connect($driver = 'default')
    {
        $this->driver = $driver ?: 'default';
        if ( ! array_key_exists($this->driver, static::$connect_handlers))
        {
            $drivers = Config::get('database');

            if ( ! array_key_exists($this->driver, $drivers))
            {
                Event::fire('System.Error.Database.Config.Error', $this->driver);
            }
            $config = $drivers[$driver];
            $connection = $config['connection'];
            //TODO 暂时只考虑Mysql，后续继续做扩展到多数据库
            $conn = $this->_connection($config);
            if (is_resource($conn))
            {
                 static::$connect_handlers[$driver] = $conn;
                return $conn;
            }
        }
        return NULL;
    }

    private function _connection($config)
    {
        $type = $config['type'];
        $class_name = ucfirst($type) . '_Connect' ;
        /**
         * @var Database_IConnect
         */
        $class_handler = new $class_name();
        if (is_object($class_handler))
        {
            $conn = $class_handler->connect($config);
            return $conn;
        }
        return NULL;
    }

    protected function close($driver = 'default')
    {
        mysql_close(static::$connect_handlers[$driver]);
        unset(static::$connect_handlers[$driver]);
    }

    public function __toString()
    {
        return static::$sql;
    }
}
