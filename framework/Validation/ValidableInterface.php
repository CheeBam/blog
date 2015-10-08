<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 15.09.15
 * Time: 22:18
 */

namespace Framework\Validation;

/**
 * This interface must be implemented in classes which must be validated.
 */
interface ValidableInterface
{
    /**
     * Method which returns filter rules.
     *
     * @return mixed. Filtering rules.
     */
    public function getRules();
}