<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 15.09.15
 * Time: 15:14
 */

namespace Framework\Validation\Filter;

class Length implements FilterInterface
{
    /**
     * @var int. Minimum length for checked line.
     */
    protected $minLength;

    /**
     * @var int. Maximum length for checked line.
     */
    protected $maxLength;

    /**
     * Initialize filter parameters.
     *
     * @param int $min . Minimum length for checked line.
     * @param int $max . Maximum length for checked line.
     */
    public function __construct($min, $max)
    {
        $this->minLength = $min;
        $this->maxLength = $max;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($data, $validatorObj, $field)
    {
        if (strlen($data) > $this->minLength && strlen($data) < $this->maxLength) {
            return true;
        } else {
            $validatorObj->addMessage(
                $field,
                '[ERROR] The count of characters of this field must be between '.
                $this->minLength.' and '.$this->maxLength.' !'
            );
            return false;
        }
    }
}