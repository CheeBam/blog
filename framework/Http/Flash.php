<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 21.09.15
 * Time: 1:59
 */

namespace Framework\Http;

class Flash
{

    /**
     * Sets flash messages.
     *
     * @param string $type
     * @param string $value
     */
    public function set($type, $value)
    {
        $_SESSION['flush'][$type][] = $value;
    }

    /**
     * Gets flash messages.
     *
     * @return array
     */
    public function get()
    {
        if (array_key_exists('flush', $_SESSION)) {
            $tmp = $_SESSION['flush'];
            unset($_SESSION['flush']);
            return $tmp;
        } else {
            return array();
        }
    }
}