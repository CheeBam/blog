<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 07.09.15
 * Time: 13:41
 */

namespace Framework\DI;

use Framework\Exception\DIException;

class Service
{

    /**
     * Objects container.
     *
     * @var array
     */
    public static $storage = array();


    /**
     * Add object to container.
     *
     * @param string $name  Object name.
     * @param $value Object value.
     */
    public static function set($name, $value)
    {
        self::$storage[$name] = $value;
    }

    /**
     * Return object from container.
     *
     * @param string $name Object name.
     *
     * @return Object, if it exists.
     * @throws Exception
     */
    public static function get($name)
    {
        if (array_key_exists($name, self::$storage)) {
            if (is_string(self::$storage[$name]) && class_exists(self::$storage[$name])) {
                $obj = new self::$storage[$name];
            } else if (is_object(self::$storage[$name])) {
                $obj = self::$storage[$name];
            } else {
                throw new Exception('Illegal definition type!');
            }
        } else {
            throw new DIException('Service "'.$name.'" isn`t found!');
        }
        return $obj;
    }

}