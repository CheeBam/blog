<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 12.09.15
 * Time: 17:20
 */

namespace Framework\Security\Model;

/**
 * This interface must be implemented in classes which using user roles.
 */
interface UserInterface
{
    /**
     * Method which returns user role.
     *
     * @return mixed User role.
     */
    public function getRole();
}