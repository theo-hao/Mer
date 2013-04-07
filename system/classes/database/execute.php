<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-2
 * Time: 上午12:11
 * To change this template use File | Settings | File Templates.
 */
class Database_Execute extends Database_Base
{
    protected $results;

    public function execute($driver = 'default')
    {
        $conn = $this->connect($driver);
        $result = mysql_query(static::$sql, $conn);
        $this->close($driver);
        return new Database_Results($result);
    }
}
