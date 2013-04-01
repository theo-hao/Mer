<?php
/**
 * User: Kevin Hao
 * Date: 13-3-17
 * Time: 下午6:42
 * To change this template use File | Settings | File Templates.
 */

/***
 * 路由定义：
 *      :num 数字
 *      ？ 可选择
 *      :any 字符串
 *      :suffix 后缀
 *
 *      </directory>
 *      </controller>
 *      </action>
 *
 *
 * Controller   对Controller总体的配置
 *  例如：
 *      1 . Router::controller("user/(?:any)(?:suffix)", "base.user");
 *          此路径表示 user后可以跟字符串再加后缀，对应到 base.user的 controller下
 *          例如
 *              1) http://localhost/user 对应base.user的 action_default
 *              2) http://localhost/user/list   对应base.user的 action_list
 *              3）http://localhost/user/create.do 对应base.user 的 do_create
 *              4）http://localhost/user/create.action 对应 base.user 的action_create
 *
 *      2 . Router::controller("user/(?:any)(?:suffix)", function(Route $route){
 *              $route->suffix = array("action", "do", "list");
 *              $router->default_action = "index";
 *              $router->default_suffix = "action";
 *              $route->controller = "base.user";
 *          })
 *
 *      TODO BBS加前缀类型，暂不考虑
 *      3 . Router::controller("user/(?:any)(?:suffix)", "BBS::base.user");
 *
 * Action       对Action的配置
 * 例如：
 *      1 . Router::action("login", "base.user@login");
 *      2 . Router::action("login(?:suffix)", function(Route $route)
 *          {
 *              $route->suffix = "action";
 *              $route->suffix = array("action", "do");
 *              $route->action = "base.user@login";
 *          });
 * 例如：
 *      1) http://localhost/login  对应base.user的action_login
 *      2）http://localhost/login.do 对应base.user 的 do_login
 *
 * Group        对组配置
 * 例如:
 *      1 . Router::group("admin/(?:any)" , function(Route $route)
 *          {
 *              if ( ! User::is_login())
 *              {
 *                  return Router::redirect("login", "base.user@login.action");
 *              }
 *
 *              Router::controller("admin/user/(:?any)", "admin.base.user");
 *              Router::controller("admin/article/(:?any)", "admin.base.article");
 *          }
 *
 * Common       通用配置
 *
 *
 */
class Route_Router
{
    /**
     * 可配置，在回调内配置,如
     * Router::controller("user/(?action)", function($router){
     *      $router->before("user.author");//路由前的
     *      $router->default_action = 'login';
     *      $router->suffix(array('action', 'do', 'html'));
     *      $router->controller = 'base.user';
     *      $router->after("");
     * });
     * @var string
     */
    //protected $default_action = 'default';

    protected static $actions = NULL;

    protected static $controller = NULL;

    protected static $rules = array();

    protected static $default_suffix = 'action';

    protected static $default_method = 'index';

    protected static $accessible_suffix = array(
        'action', 'do', 'html', 'jsp'
    );

    protected static $default_controller = 'welcome';

    /**
     * @static
     * http://localhost/login
     * Router::action('login', 'base.user@login');
     * 一旦使用了这样的action,那么http://localhost/base/user/login将失效，不能正常访问
     *
     * http://localhost/user
     * http://localhost/user/login
     * Router::controller('user/(?action)', 'base.user'， array('action', 'do', 'html'));
     * (?action)表示可选的action，如果，没有则默认为action_default,do_default, html_default
     * TODO default可以根据用户需求配置，比如 default使用index等
     * http://localhost/user/default 配置为login ，则 http://localhost/user表示 http://user/login
     *
     */
    public static function controller($pattern, $controller)
    {
        $rule = static::analysis($pattern);
        static::$rules[$rule] = array(
            'controller' => $controller
        );
    }

    public static function action($pattern, $action)
    {
        $rule = static::analysis($pattern);
        static::$rules[$rule] = array(
            'action' => $action
        );
    }

    /***
     * @static
     * Router::common("(?directory/(?controller/(?action))", function($router){
     *          $router->
     * });
     */
    public static function common($common_rule)
    {
        $rule = static::analysis($common_rule);
        static::$rules[$rule] = array(
            'common' => $rule
        );
    }

    public static function execute($url)
    {
        //默认路径
        $url = $url ?: '/';

        foreach (static::$rules as $rule => $value) {
            $match = static::match($rule, $url);
            if ( !is_null($match))
            {
                $encapsulation = static::encapsulation($match, $value, $rule) ?:
                    (new Route_Model(static::$default_controller,
                        ucfirst(static::$default_suffix) . '_' . ucfirst(static::$default_method), NULL));
                return $encapsulation;
            }
        }
        return Event::fire('System.Error.Route.No.Match.Route');
    }

    private static function encapsulation($matches, $value, $rule)
    {
        $controller = '';
        $action = '';
        $suffix = '';
        $params = $matches;
        if (array_key_exists('controller', $value))
        {
            $controller = $value['controller'];
            if (array_key_exists('alter_any_0', $matches))
            {
                $action = $matches['alter_any_0'];
                Arr::remove($params, 'alter_any_0');
            }
            else if (array_key_exists('any_0', $matches))
            {
                $action = $matches['any_0'];
                Arr::remove($params, 'any_0');
            }
        }
        else if (array_key_exists('action', $value))
        {
            $action_string = $value['action'];
            if ( !substr_count($action_string, '@'))
            {
                throw new Exception("路由action配置错误");
            }
            $reg = "/^(?'controller'[\\w\.^@]*)@(?'action'[\\w\\W\.]*)$/i";
            if (preg_match($reg, $action_string, $matches))
            {
                $controller = $matches['controller'];
                $action = $matches['action'];
            }
            else
            {
//                throw new Exception("没找到匹配信息");
                //Event::fire('System.Error.No.Action');
                Event::fire('System.Error.404');
            }
        }

        if (array_key_exists('alter_suffix_0', $matches))
        {
            $suffix = $matches['alter_suffix_0'];
            Arr::remove($params, 'alter_suffix_0');
        }
        else if (array_key_exists('suffix_0', $matches))
        {
            $suffix = $matches['suffix_0'];
            Arr::remove($params, 'suffix_0');
        }

        if ( ! in_array($suffix, static::$accessible_suffix))
        {
            Log::write('WARNING', $suffix .  '后缀不支持');
            $suffix = static::$default_suffix;
        }
        if ( empty($controller))
        {
            $controller = static::$default_controller;
        }

        if ($controller)
        {
            $controller = str_replace('.', ' ', $controller);
            $controller = ucwords($controller);
            $controller = str_replace(' ', '_', $controller);
        }
        $action = ( $suffix ?: static::$default_suffix) . '_' .  ($action ?: static::$default_method);

        return new Route_Model($controller, $action, $params);
    }
    public static function group()
    {

    }

    public static function get()
    {
        return static::$rules;
    }

    public static function factory()
    {

    }


    protected static function analysis($pattern)
    {
//        echo $pattern . "<br>";
        //$pattern = str_replace('.', '\.', $pattern);
        $pattern = '/^' . str_replace('/', '[\/]?', $pattern) . '$/i' ;
        $alternative_number_count = substr_count($pattern, '(?:num)');
        $number_count = substr_count($pattern, '(:num)');
        $alternative_any_count = substr_count($pattern, '(?:any)');
        $any_count = substr_count($pattern, '(:any)');

        $alternative_controller_count = substr_count($pattern, '(?:controller)');
        $alternative_action_count = substr_count($pattern, '(?:action)');
        $controller_count = substr_count($pattern, '(:controller)');
        $action_count = substr_count($pattern, '(:action)');

        $alternative_suffix_count = substr_count($pattern, '(?:suffix)');
        $suffix_count = substr_count($pattern, '(:suffix)');
//        echo $alternative_number_count . "<br>";
//        echo $number_count . "<br>";
//        echo $alternative_any_count . "<br>";
//        echo $any_count . "<br>";
//        echo $pattern . "<br>";

        if ($alternative_suffix_count)
        {
            $pattern = str_replace('.', '[\.]?', $pattern);
            $pattern_array = explode('(?:suffix)', $pattern);
            $pattern = '';
            for($i = 0; $i < $alternative_suffix_count; $i++)
            {
                $pattern .= $pattern_array[$i] . "(?'alter_suffix_" . $i . "'[\\w]*)";
            }
            $pattern .= $pattern_array[$alternative_suffix_count];
        }

        if ($suffix_count)
        {
            $pattern = str_replace('.', '[\.]', $pattern);
            $pattern_array = explode('(:suffix)', $pattern);
            $pattern = '';
            for($i = 0; $i < $suffix_count; $i++)
            {
                $pattern .= $pattern_array[$i] . "(?'suffix_" . $i . "'[\\w]+)";
            }
            $pattern .= $pattern_array[$suffix_count];
        }

        if ($alternative_number_count)
        {
            $pattern_array = explode('(?:num)', $pattern);
            $pattern = '';
            for($i = 0; $i < $alternative_number_count; $i ++)
            {
                $pattern .= $pattern_array[$i] . "(?'alert_number_" . $i . "'[\\d]*)";
            }
            $pattern .= $pattern_array[$alternative_number_count];
        }

        if ($number_count)
        {
            $pattern_array = explode('(:num)', $pattern);
            $pattern = '';
            for($i = 0; $i < $number_count; $i++)
            {
                $pattern .= $pattern_array[$i] . "(?'number_" . $i ."'[\\d]+)";
            }
            $pattern .= $pattern_array[$number_count];
        }

        if ($alternative_any_count)
        {
            $pattern_array = explode('(?:any)', $pattern);
            $pattern = '';
            for( $i = 0; $i < $alternative_any_count; $i++)
            {
                $pattern .= $pattern_array[$i] . "(?'alter_any_" . $i . "'[\\w]*)";;
            }
            $pattern .= $pattern_array[$alternative_any_count];
        }

        if ($any_count)
        {
            $pattern_array = explode('(:any)', $pattern);
            $pattern = '';
            for( $i = 0; $i < $any_count; $i++)
            {
                $pattern .= $pattern_array[$i] . "(?'any_" . $i . "'[\\w]+)";;
            }
            $pattern .= $pattern_array[$any_count];
        }

        return $pattern;
    }

    protected static function match($rule, $url)
    {
        if (preg_match($rule, $url, $matches))
        {
            $router = array();
            foreach($matches as $key => $value)
            {
                if (is_string($key))
                {
                    $router = array_merge($router, array( $key => $value));
                }
            }
            return $router;
        }
        return null;
    }
}
