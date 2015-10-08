<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 08.09.15
 * Time: 1:16
 */

namespace Framework;

use Framework\DI\Service;

class Router
{

    /**
     * Container for routes.
     *
     * @var array
     */
    protected $routes = array();


    protected $currentRoute;

    /**
     * Merge the current array routes with an incoming array.
     *
     * @param array $arr Incoming routes array.
     *
     * @return Object.
     */
    public function add(array $arr = array())
    {
        $this->routes = array_merge($this->routes, $arr);
        return $this;
    }

    /**
     * Divide uri and call the appropriate controllers, methods and params.
     *
     * @param string $uri Uri.
     *
     * @return array An array which contains the required controllers, methods and params.
     * @throws \Framework\Exception\DIException
     */
    public function execute($uri = null)
    {
        if ($uri === null) {
            $uri = Service::get('request')->getUri();
        }
        $uri = '/'.trim(trim($uri), '/');
        foreach ($this->routes as $name => $route) {
            $pattern = str_replace(array('{', '}'), array('(?P<', '>)'), $route['pattern']);
            if (array_key_exists('_requirements', $route)) {
                if (array_key_exists(
                        '_method',
                        $route['_requirements']
                    ) && $route['_requirements']['_method'] != Service::get('request')->getMethod()
                ) {
                    continue;
                }
                if (0 !== count($route['_requirements'])) {
                    $search = $replace = array();
                    foreach ($route['_requirements'] as $key => $value) {
                        $search[]  = '<'.$key.'>';
                        $replace[] = '<'.$key.'>'.$value;
                    }
                    $pattern = str_replace($search, $replace, $pattern);
                }
            }
            if (!preg_match('&^'.$pattern.'$&', $uri, $params)) {
                continue;
            }
            $params = array_merge(array('controller' => $route['controller'], 'action' => $route['action']), $params);
            foreach ($params as $key => $value) {
                if (is_int($key)) {
                    unset($params[$key]);
                }
            }
            $this->currentRoute = array_merge($route, array('_name' => $name));
            return $params;
        }
    }

    /**
     * Returns needs uri.
     *
     * @param string $key Array key.
     *
     * @return string Uri.
     */
    public function generateUri($key)
    {
        return !$key?:$this->routes[$key]['pattern'];
    }

    /**
     * Returns current route.
     *
     * @return mixed Curr route.
     */
    public function getCurrentRoute()
    {
        return $this->currentRoute;
    }


}