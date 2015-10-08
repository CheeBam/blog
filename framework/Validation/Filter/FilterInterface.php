<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 15.09.15
 * Time: 21:37
 */

namespace Framework\Validation\Filter;

use \Framework\Validation\Validator;

/**
 * This interface must be implemented in filter classes.
 */
interface FilterInterface
{
    /**
     * Method for validation of different objects.
     *
     * @param string    $data         Checking string.
     * @param Validator $validatorObj Validator object.
     * @param string    $field        Current field.
     *
     * @return bool.
     */
    public function validate($data, $validatorObj, $field);
}