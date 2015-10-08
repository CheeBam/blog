<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 17.09.15
 * Time: 21:46
 */

namespace Framework;

use Framework\DI\Service;

class View
{
    /**
     * Container for variables.
     *
     * @var array Variables.
     */
    public $vars = [];

    /**
     * Path to file.
     *
     * @var string Path.
     */
    public $path;

    /**
     * Initialize.
     *
     * @param string $path Path to file.
     *
     * @throws Exception\DIException
     */
    public function __construct($path = '')
    {
        $this->path = ROOT.'src/Blog/views/'.$path;
        $this->set('route', Service::get('router')->getCurrentRoute());
        $this->set(
            'getRoute',
            function ($key) {
                return Service::get('router')->generateUri($key);
            }
        );
        $this->set('user', Service::get('security')->getUser());
        $this->set(
            'include',
            function ($controller, $action, $params) {
                $ctrl = new $controller;
                $action .= 'Action';
                return call_user_func_array(array($ctrl, $action), $params);
            }
        );
        $this->set(
            'generateToken',
            function () {
                return Service::get('csrf')->generateToken();
            }
        );
        $this->set(
            '_',
            function ($word) {
                return Service::get('location')->getWord($word);
            }
        );
    }

    /**
     * Sets variables.
     *
     * @param string $name Name of variable.
     * @param mixed  $var  Value of variable
     *
     * @return $this
     */
    public function set($name, $var)
    {
        $this->vars[$name] = $var;
        return $this;
    }

    /**
     * Making pages.
     *
     * @param string $path File path.
     * @param array  $var  Variables.
     *
     * @return string Rendered page.
     * @throws Exception\DIException
     */
    public function render($path, $var = array())
    {
        if ($path === Service::get('application')->config['main_layout']) {
            $this->path = $path;
        } elseif ($path === Service::get('application')->config['error_500']) {
            $this->path = $path;
        } else {
            $this->path = __DIR__.'/../src/Blog/views/'.$path.'.php';
        }
        $this->vars = array_merge($this->vars, $var);
        ob_start();
        extract($this->vars);
        include $this->path;
        return ob_get_clean();
    }

}
