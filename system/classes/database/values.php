<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-7
 * Time: 下午5:41
 * To change this template use File | Settings | File Templates.
 */
class Database_Values extends Database_Execute
{
    protected $_columns;
    protected $_values;

    public function columns($columns)
    {
        $this->_columns = $columns;
        if (is_array($columns))
        {
            $sql = '(' ;
            $columns = array_values($columns);
            for($i = 0; $i < count($columns); $i++)
            {
                if ($i < count($columns) - 1)
                    $sql .= '`'. $columns[$i] . '`,';
                else
                    $sql .= $columns[$i] . ')';
            }
            static::$sql .= ' ' . $sql;
        }
        return $this;
    }

    public function values($pair)
    {
        if ( ! $this->_columns && ! array_key_exists('0', array_keys($pair)))
        {
            $this->columns(array_keys($pair));
        }
        $this->_values = array_values($pair);
        if (is_array($pair))
        {
            $values = array_values($pair);
            $sql = ' VALUES (';
            for($i = 0; $i < count($values); $i++)
            {
                if ( $i < count($values) - 1)
                {
                    $sql .= '\'' . $values[$i] . '\',';
                }
                else
                {
                    $sql .= '\'' . $values[$i] . '\')';
                }
            }
            static::$sql = ' ' . $sql;
        }
        return $this;
    }
}
