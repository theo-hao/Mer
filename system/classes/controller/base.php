<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 3/14/13
 * Time: 5:59 PM
 * To change this template use File | Settings | File Templates.
 */
class Controller_Base implements Controller_IBase
{
    public $template = NULL;
    public $auto_render = true;

    public function before($request)
    {
        // TODO: Implement before() method.
        if ($this->template && is_string($this->template))
        {
            $this->template = View::factory($this->template);
        }
    }

    public function after()
    {
        if ($this->template)
        {
            if (is_string($this->template))
            {
                $this->template = View::factory($this->template);
            }

            if (($this->template instanceof View_Core) && $this->auto_render)
            {
                echo $this->template->render();
            }
        }
        // TODO: Implement after() method.
    }
}
