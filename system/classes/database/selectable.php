<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-2
 * Time: 上午12:13
 * To change this template use File | Settings | File Templates.
 */
class Database_Selectable extends Database_Base
{
    /**
     * @static
     * @param string $columns
     * @return Database_From
     */
    public static function select($columns = '*')
    {
        return new Database_From();
    }
}
