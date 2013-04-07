<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-4-7
 * Time: 上午10:46
 * To change this template use File | Settings | File Templates.
 */
interface Database_IConnect
{
    /**
     * @abstract
     * @param  array $config
     * @return resource
     */
    public function connect($config);

    public function close($handler);
}
