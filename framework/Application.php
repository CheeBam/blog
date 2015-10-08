<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 12.09.15
 * Time: 13:16
 */

namespace Framework;

use Framework\DI\Service;
use Framework\Exception\HttpException;

class Application
{
    /**
     * Container for configs.
     *
     * @var array Config.
     */
    public $config = [];


    /**
     * Initialize.
     *
     * @param array $config Config.
     *
     * @throws HttpException.
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        Service::set('request', new \Framework\Http\Request);
        Service::set('router', (new \Framework\Router())->add($config['routes']));
        Service::set('response', new \Framework\Http\Response);
        Service::set('pdo', new \PDO($config['pdo']['dns'], $config['pdo']['user'], $config['pdo']['password']));
        Service::set('session', new \Framework\Http\Session);
        Service::set('security', new \Framework\Security\Security);
        Service::set('flash', new \Framework\Http\Flash);
        Service::set('csrf', new \Framework\Security\Csrf);
        Service::set('location', new \Framework\Location(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)));
    }

    /**
     * Execute MVC application.
     *
     * @return \Framework\Http\Response object.
     * @throws HttpException
     * @throws \Framework\Exception\DIException
     */
    public function run()
    {
        try{
            $tmp = Service::get('router')->execute();
            //var_dump($tmp);
            Service::set('sub_view', new \Framework\View());
            Service::set('view', new \Framework\View());
            if (class_exists($tmp['controller'])) {
                $controller = new $tmp['controller'];
                $tmp['action'] .= 'Action';
                if (method_exists($controller, $tmp['action'])) {
                    $action = $tmp['action'];
                    unset($tmp['controller'], $tmp['action']);
                    $response = $controller->{$action}($tmp);
                    if (is_string($response)) {
                        return Service::get('response')->setContent($response);
                    } elseif (null === $response) {
                        return Service::get('response');
                    } else {
                        throw new \Exception('All is bad', 404);
                    }
                } else {
                    throw new HttpException('Action isn\'t found!', 404);
                }
            } else {
                throw new HttpException('Controller isn\'t found!', 404);
            }
        } catch(\Exception $e){
            return Service::get('response')->setContent(
                Service::get('view')->set(
                    'content',
                    Service::get('sub_view')->render(
                        $this->config['error_500'],
                        array('code' => $e->getCode(), 'message' => $e->getMessage())
                    )
                )->set('flush', array())->render(
                    Service::get('application')->config['main_layout']
                )
            );
        }
    }
}