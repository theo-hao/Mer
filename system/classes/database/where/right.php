<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-2
 * Time: 上午12:25
 * To change this template use File | Settings | File Templates.
 */
class Database_Where_Right
{
    public function and_where()
    {
        return new Database_Execute();
    }

    public function or_where()
    {
        return new Database_Execute();
    }

    public function close_where()
    {
        return new Database_Execute();
    }
}
