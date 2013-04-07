<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-7
 * Time: 上午10:45
 * To change this template use File | Settings | File Templates.
 */
class Mysql_Connect implements  Database_IConnect
{
    /**
     * @param $connection
     * @return mixed
     */
    public function connect($config)
    {
        if ( !$config)
        {
            Event::fire('Config_Not_Empty');
        }
        $connection = $config['connection'];
        $hostname = $connection['hostname'];
        $user = $connection['user'];
        $password = $connection['password'];
        $database = $connection['database'];
        $charset = $config['charset'];


        $handler = mysql_connect($hostname, $user, $password) or die(Event::fire('System.Error.Database.Config.Error'));
        if (is_resource($handler))
        {
            try{
                mysql_select_db($database);
                mysql_set_charset($charset, $handler);
            }catch (Exception $ex)
            {
                throw $ex;
            }
        }

        return $handler;
    }

    public function close($handler)
    {
        try{
            if ($handler && is_resource($handler))
            {
                mysql_close($handler);
            }
            else
            {
                throw new  Exception("不是连接资源");
            }
        }catch (Exception   $ex)
        {
            throw new $ex;
        }
    }
}
