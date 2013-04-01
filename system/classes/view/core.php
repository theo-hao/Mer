<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-25
 * Time: 下午9:21
 * To change this template use File | Settings | File Templates.
 */
class View_Core
{
    /**
     * template 的文件
     * @var null|string
     */
    protected $template;
    /**
     * 参数
     * @var array
     */
    protected $params = array();
    /**
     * 自动渲染
     * @var bool
     */
    protected $auto_render = true;

    private function __construct(){}

    /**
     * 创建View
     * @static
     * @param $view
     * @return View_Core
     */
    public static function factory($view = NULL)
    {
        $view_handler = new View_Core();
        if ($view)
            $view_handler->set($view);
        return $view_handler;
    }


    public function set($view_name)
    {
        $view_name = str_replace('.', DIR_SEPARATOR, $view_name);
        $view_file =  Str::dir_join(APPLICATION_PATH . 'view' . DIR_SEPARATOR, $view_name . EXT, DIR_SEPARATOR);
        $view_file = file_exists($view_file) ? $view_file: $view_name . EXT;

        if ( ! file_exists($view_file))
        {
            Event::fire('System.Error.No.View', $view_name);
        }
        $this->template = $view_file;
    }
    /**
     * 传递参数
     * @param $key
     * @param $value
     */
    public function with($key, $value)
    {
        if (is_array($key) && is_array($value) && (count($key) == count($value)))
        {
            $param = array_combine($key, $value);
            $this->params = array_merge($this->params, $param);
            return $this;
        }
        else
        {
            $this->params[$key] = $value;
            return $this;
        }
    }

    public function render($view = NULL)
    {
        if ($view)
            $this->set($view);

        if ( !$this->template || ! file_exists($this->template))
        {
            Event::fire('System.Error.No.Found.View');
        }
        ob_start();
        try{
            extract($this->params);
            include $this->template;
        }
        catch(Exception $ex)
        {
            ob_end_clean();
            throw $ex;
        }
        return ob_get_clean();
    }
}
