<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 20.09.15
 * Time: 16:26
 */

namespace Framework\Http;

class Session
{
    /**
     * @var string $returnUrl .
     */
    public $returnUrl;

    /**
     * Creating a session.
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Set a session variable.
     *
     * @param string $name  name of session variable.
     * @param int    $value value of session variable.
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Get a session variable.
     *
     * @param string $name name of session variable.
     *
     * @return mixed value of session variable.
     */
    public function get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * Check a session variable.
     *
     * @param string $name name of session variable.
     *
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $_SESSION)?true:false;
    }

    /**
     * Delete a session variable.
     *
     * @param string $name name of session variable.
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

}