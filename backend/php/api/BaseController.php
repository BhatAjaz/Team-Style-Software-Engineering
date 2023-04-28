<?php

namespace backend\php\api;

use backend\php\util\Container;
use JetBrains\PhpStorm\NoReturn;

/**
 * Base Controller class that is expected to be inherited by all future Controller classes
 *
 * Controller classes are classes that will take the REST API request by the client and
 * will resolve said request by calling the functions of the interface associated with the Controller class
 *
 * @author Beng
 */
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

    /**
     * This function constructs the API response to send to the client
     *
     * It first checks if the strErrorDesc variable is set
     * If not, we'll send out the response data
     * If it is, then we'll send out the error response
     * @return void
     * @author Beng
     */
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

    /**
     * controllers will use this function to set the strErrorDesc variable
     *
     * currently it just returns a simple string.
     * @return string error message
     * @author Beng
     */
    protected function setErrorDesc(): string
    {
        return 'Something went wrong! Please contact support.';
    }

    /**
     * This function is used to send the API response.
     * response() will call this method when it wants to send the API response to the user.
     *
     * @author Beng
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