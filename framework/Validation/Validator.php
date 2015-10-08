<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 15.09.15
 * Time: 15:14
 */

namespace Framework\Validation;

class Validator
{
    /**
     * @var $object . Object
     */
    protected $object;

    /**
     * @var array. Object fields.
     */
    protected $objFields = [];

    /**
     * @var array. Error messages.
     */
    public $messages = [];

    /**
     * Initialize object.
     *
     * @param object . Object.
     */
    public function __construct($object)
    {
        $this->object = $object;
        foreach ($this->object as $k => $v) {
            $this->objFields[$k] = $v;
        }
    }

    /**
     * Object validation.
     *
     * @return bool. True if it's valid, False - id it's isn't valid.
     */
    public function isValid()
    {
        $rules = $this->object->getRules();
        foreach ($rules as $field => $value) {
            foreach ($rules[$field] as $obj) {
                $obj->validate($this->objFields[$field], $this, $field);
            }
        }

        if ($this->messages) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Add messages to messages array.
     *
     * @param string $message . Error message.
     */
    public function addMessage($field, $message)
    {
        $this->messages[$field] = $message;
    }

    /**
     * Returns array of error messages.
     *
     * @return array.
     */
    public function getErrors()
    {
        return $this->messages;
    }


}