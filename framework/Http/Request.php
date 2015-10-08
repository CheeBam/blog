<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 08.09.15
 * Time: 1:20
 */

namespace Framework\Http;

class Request
{

    /**
     * Array for data from $_POST or $_GET.
     *
     * @var array
     */
    protected $global = array();

    /**
     * Remove the backslashes from $_POST or $_GET.
     */
    public function __construct()
    {
        if ($this->isPost()) {
            $this->global = array_map('stripslashes', $_POST);
        } else {
            $this->global = array_map('stripslashes', $_GET);
        }
    }

    /**
     * Checking POST method.
     *
     * @return bool
     */
    public function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST');
    }

    /**
     * Checking GET method.
     *
     * @return bool
     */
    public function isGet()
    {
        return ($_SERVER['REQUEST_METHOD'] == 'GET');
    }

    /**
     * Returns request method.
     *
     * @return string
     */
    public function getMethod()
    {
        return ($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Returns content of $_POST or $_GET.
     *
     * @param string /null $key Search key.
     *
     * @return array|null|string If successfully returns content of $_POST or $_GET, if unsuccessfully - null.
     */
    public function get($key = null)
    {
        if (null !== $key && !array_key_exists($key, $this->global)) {
            return null;
        }
        return $key?$this->global[$key]:$this->global;
    }

    /**
     * Returns header.
     *
     * @param $header Header name.
     *
     * @return mixed If exist, returns user header, if no search results - null.
     */
    public function getHeader($header)
    {
        $header = strtoupper(strtr($header, "-", "_"));
        if (array_key_exists($header, $_SERVER)) {
            return $_SERVER[$header];
        } elseif (array_key_exists('HTTP'.$header, $_SERVER)) {
            return $_SERVER['HTTP'.$header];
        } else {
            return null;
        }
    }

    /**
     * Returns uri.
     *
     * @return string Request uri.
     */
    public function getUri()
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

}