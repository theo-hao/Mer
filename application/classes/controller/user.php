<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-21
 * Time: 下午12:33
 * To change this template use File | Settings | File Templates.
 */
class Controller_User extends Controller
{
    public function action_info($id, $name, $age)
    {
        echo $id . "<br>";
        echo $name . "<br>";
        echo $age . "<br>";
    }

    public function action_index()
    {
        echo "User index";
//        Config::load('application');
        Config::load();
        var_dump(Config::get());
    }

    public function xxx_index()
    {
        echo "xxx";
    }

    public function do_index()
    {
        $d = DB::select()->from('users')->execute()->to_array();
        var_dump($d);
        $db = DB::query('SHOW COLUMNS FROM users')->to_array();
        var_dump($db);
        echo DB::last_query();
    }

    public function html_index()
    {
        $template = View::factory('user');
        $user = new Model_User();
        $user->name = 'Kevin';
        $user->age = 18;
        $template->with('user', $user);
        $this->template = $template;
    }

    public function action_list()
    {
        echo "List";
    }

    public function action_add()
    {
        echo 'add';
    }

    public function action_create()
    {
        echo 'create';
    }

    public function action_login()
    {
        echo 'login';
    }

    public function action_logout()
    {
        echo 'logout';
    }
}
