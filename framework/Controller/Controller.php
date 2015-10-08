<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 17.09.15
 * Time: 15:01
 */

namespace Framework\Controller;

use Framework\DI\Service;

class Controller
{
    /**
     * @param string $uri
     * @param string $message
     * @param string $type
     *
     * @return mixed
     * @throws \Framework\Exception\DIException
     */
    public function redirect($uri, $message = null, $type = 'success')
    {
        !$message?:Service::get('flash')->set($type, $message);
        return Service::get('response')->redirect($uri);
    }

    /**
     * @param $method
     * @param $args
     *
     * @return null|string
     * @throws \Framework\Exception\DIException
     */
    public function __call($method, $args)
    {
        $method = strtolower(substr($method, 3));
        return !$method?:Service::get($method);
    }

    /**
     * @param $route
     *
     * @return mixed
     * @throws \Framework\Exception\DIException
     */
    public function generateRoute($route)
    {
        return Service::get('router')->generateUri($route);
    }

    /**
     * @param string $path
     * @param array  $vars
     *
     * @return mixed
     * @throws \Framework\Exception\DIException
     */
    public function render($path, array $vars = [])
    {
        return Service::get('view')->set('flush', Service::get('flash')->get())->set(
            'content',
            Service::get('sub_view')->render(
                $path,
                $vars
            )
        )->render(
            Service::get('application')->config['main_layout']
        );
    }
}