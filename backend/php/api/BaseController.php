<?php

namespace backend\php\api;

class BaseController
{
    /**
     * the sendOutput method,
     * which is used to send the API response.
     * We’ll call this method when we want to send the API response to the user.
     *
     * @param mixed $data
     * @param string $httpHeader
     */
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }
}