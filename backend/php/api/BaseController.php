<?php

namespace backend\php\api;

use backend\php\util\Container;
use JetBrains\PhpStorm\NoReturn;

class BaseController
{
    protected Container $container;
    protected string $request = '';
    protected string $responseData = '';
    protected string $strContentType = 'Content-Type: application/json';
    protected string $strSuccessHeader = 'HTTP/1.1 200 OK';
    protected string $strErrorDesc = '';
    protected string $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';

    public function __construct(){
        $this->container = Container::getInstance();

        //This is our raw json data from client
        $this->request = file_get_contents("php://input");
    }
    #[NoReturn] protected function response():void{
        // send output
        if (!$this->strErrorDesc) {
            $this->sendOutput(
                $this->responseData,
                array($this->strContentType, $this->strSuccessHeader)
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $this->strErrorDesc)),
                array($this->strContentType, $this->strErrorHeader)
            );
        }
    }

    protected function setErrorDesc(): string
    {
        return 'Something went wrong! Please contact support.';
    }

    /**
     * the sendOutput method,
     * which is used to send the API response.
     * We’ll call this method when we want to send the API response to the user.
     *
     */
    #[NoReturn] protected function sendOutput($data, $httpHeaders=array()): void
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