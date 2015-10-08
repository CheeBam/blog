<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 10.09.15
 * Time: 15:58
 */

namespace Framework\Http\Response;

use Framework\Http\Response;

class ResponseRedirect extends Response
{
    /**
     * @param     $url    Redirect url.
     * @param int $status Status code.
     */
    public function __construct($url, $status = 302)
    {
        $this->redirect($url, $status);
    }
}