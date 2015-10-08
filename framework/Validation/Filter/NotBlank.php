<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 15.09.15
 * Time: 15:14
 */

namespace Framework\Validation\Filter;

class NotBlank implements FilterInterface
{
    /**
     * {@inheritDoc}
     */
    public function validate($data, $validatorObj, $field)
    {
        if (trim($data, ' ') !== '') {
            return true;
        } else {
            $validatorObj->addMessage(
                $field,
                '[ERROR] The field can\'t be empty!'
            );
            return false;
        }
    }
}