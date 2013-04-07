<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-2
 * Time: 上午12:21
 * To change this template use File | Settings | File Templates.
 */
class Database_DB extends Database_Execute
{
    public static function select($columns = '*')
    {
        if ( $columns == '*' ||!$columns)
        {
            static::$sql = 'SELECT *';
        }
        elseif (is_string($columns))
        {
            static::$sql = 'SELECT '. $columns . ' ';
        }
        elseif(is_array($columns))
        {
            $columns = array_values($columns);
            $sql = ' ';
            for($i = 0; $i < count($columns); $i++)
            {
                if ($i < count($columns) - 1)
                {
                    $sql .= '`' . $columns[$i] .'`,';
                }
                else
                {
                    $sql .= '`' . $columns[$i] .'` ';
                }
            }
            static::$sql = ' SELECT ' . $sql;
        }
        return new Database_From();
    }

    public static function update($tablename)
    {
        static::$sql = 'UPDATE ' . $tablename . ' ';
        return new Database_Set();
    }

    public static function delete($tablename)
    {
        static::$sql = 'DELETE FROM ' . $tablename . ' ';
        return new Database_Where();
    }

    public static function insert($tablename)
    {
        static::$sql = 'INSERT INTO ' . $tablename . ' ';
        return new Database_Values();
    }

    public static function query($sql, $driver = 'default')
    {
        static::$sql = $sql;
        $handler =  new Database_Execute();
        return $handler->execute($driver);
    }

    public static function last_query()
    {
        return static::$sql;
    }
}
