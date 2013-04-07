<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-7
 * Time: 下午5:37
 * To change this template use File | Settings | File Templates.
 */
class Database_Where extends Database_Execute
{
    public function where($column, $value, $condition = '=')
    {
        static::$sql .= ' WHERE ' . $column . ' ' . $condition . ' ' . $value;
        return $this;
    }

    public function and_where($column, $value, $condition = '=')
    {
        static::$sql .= ' AND ' .  $column . ' ' . $condition . ' ' . $value;
        return $this;
    }

    public function or_where($column, $value, $condition = '=')
    {
        static::$sql .= ' OR WHERE ' . $column . ' ' . $condition . ' ' . $value ;
        return $this;
    }

    public function open_where()
    {
        static::$sql .= 'WHERE (';
        return $this;
    }

    public function and_open_where()
    {
        static::$sql .= ' AND ( ';
    }

    public function and_close_where()
    {
        static::$sql .= ')';
    }
    public function close_where()
    {
        static::$sql .= ')';
        return $this;
    }

    public function open_or_where()
    {
        static::$sql .= ' OR (';
        return $this;
    }

    public function close_or_where()
    {
        static::$sql .= ')';
        return $this;
    }

    public function join($tablename, $type = 'inner')
    {
        switch(strtolower($type))
        {
            case 'left':{
                static::$sql .= ' LEFT JOIN '. $tablename . ' ';
            }break;
            case 'right' :{
                static::$sql .= ' RIGHT JOIN '. $tablename . ' ';
            } break;
            default:{
                static::$sql .= ' JOIN ' . $tablename;
            }break;
        }
        return $this;
    }

    public function on($column1, $column2, $condition = '=')
    {
        static::$sql .= ' ON ' . $column1 . ' ' . $condition . ' ' . $column2 ;
        return $this;
    }
}
