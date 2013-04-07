<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-2
 * Time: 上午12:20
 * To change this template use File | Settings | File Templates.
 */
class Database_From extends Database_Execute
{
    public function from($tablename)
    {
        static::$sql .= ' FROM ' . $tablename . ' ';
        return new Database_Where();
    }
}
