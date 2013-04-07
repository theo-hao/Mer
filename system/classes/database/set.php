<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-7
 * Time: 下午6:00
 * To change this template use File | Settings | File Templates.
 */
class Database_Set extends Database_Execute
{
    public function set($pair)
    {
        $columns = array_keys($pair);
        $values = array_values($pair);
        $sql = ' SET ';
        for($i = 0; $i < count($columns) && count($columns) == count($values); $i++)
        {
            if ( $i < count($columns) - 1)
            {
                $sql .= ' ' . $columns[$i] . ' = \'' . $values[$i] . '\' ,';
            }
            else
            {
                $sql .= ' ' . $columns[$i] . ' = \'' . $values[$i] . '\' ';
            }
        }
        return new Database_Where();
    }
}
