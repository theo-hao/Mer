<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-31
 * Time: 上午7:41
 * To change this template use File | Settings | File Templates.
 */
class Database_Core
{
    protected $sql;
    protected $flag;
    protected $sentence;

    private function __construct($database = NULL)
    {

    }



    public function __toString()
    {
        if ($this->flag)
        {
            return $this->flag;
        }
        return null;
    }
}
