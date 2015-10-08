<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 11.09.15
 * Time: 22:44
 */

namespace Framework\Http\Response;

use Framework\Http\Response;

class Json extends Response
{
    /**
     * @param $content Json content.
     */
    public function __construct($content)
    {
        $this->setJson($content);
    }
}