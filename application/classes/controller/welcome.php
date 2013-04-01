<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 3/14/13
 * Time: 6:27 PM
 * To change this template use File | Settings | File Templates.
 */
class Controller_Welcome extends Controller
{
    public $template = 'index';

    public function action_index()
    {
        echo 'welcome index';
    }

    public function do_index()
    {
        echo "welcome_do_index";
    }

    public function html_index()
    {
        $this->template->with('MyName', 'HaoTingyou');

    }

    public function php_index()
    {

    }

    /**
     * protected 方法 使用 一根下划线 _
     * private 方法 推荐使用 两个下划线 __
     * 避免外部的访问
     */
}
