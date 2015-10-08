<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 20.09.15
 * Time: 16:27
 */

namespace Framework\Security;

use Framework\DI\Service;

class Security
{

    const SESSION_USER_NAME = 'user_name';

    /**
     * Set session for this user.
     *
     * @param object $user User object.
     *
     * @throws \Framework\Exception\DIException
     */
    public function setUser($user)
    {
        Service::get('session')->set(self::SESSION_USER_NAME, serialize($user));
    }

    /**
     * Get session for this user.
     *
     * @return object $ser User object.
     * @throws \Framework\Exception\DIException
     */
    public function getUser()
    {
        return $this->isAuthenticated()?unserialize(Service::get('session')->get(self::SESSION_USER_NAME)):null;
    }

    /**
     * Check user for authentication.
     *
     * @return bool
     * @throws \Framework\Exception\DIException
     */
    public function isAuthenticated()
    {
        return Service::get('session')->has(self::SESSION_USER_NAME);
    }

    /**
     * Delete session for this user.
     *
     * @throws \Framework\Exception\DIException
     */
    public function clear()
    {
        Service::get('session')->remove(self::SESSION_USER_NAME);
    }
}