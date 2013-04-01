<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 3/14/13
 * Time: 5:59 PM
 * To change this template use File | Settings | File Templates.
 */
interface Controller_IBase
{
    public function before($request);

    public function after();
}
