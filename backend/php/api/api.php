<?php
/**
 * <p>This file parses the uri calls to http://localhost/api/
 * and will resolve the requests based on endpoints.php</p>
 *
 * <h2>Notes </h2>
 * <p>There are many services and 3rd party dependencies that we can install to handle
 * RESTful API functions seamlessly. I have created this because I do not want to walk my team
 * members through installing and understanding another 3rd party dependency.</p>
 *
 * <p>TODO: It might prove worthwhile for future coders to contemplate the installation of these services to replace this.</p>
 */

//TODO: Parse through what these mean for security and if we want it or not
//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../../backend/php/util/bootstrap.php';

$endpoints = require PROJECT_ROOT_PATH . '/backend/php/api/endpoints.php';

use backend\php\util\Container;
use backend\php\api\RequestResolverInterface;

$request_method = $_SERVER['REQUEST_METHOD'];
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$container = Container::getInstance();
$resolver = $container->resolve(RequestResolverInterface::class);
foreach($endpoints['endpoints'] as $endpoint => $methods){
    if($request_uri == $endpoint){
        //the requested endpoint exists
        foreach ($methods as $method => $function){
            if($request_method == $method){
                //requested method exists
                $resolver->{$function}();
                break;
            }
        }
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);;
        break;
    }
}

// If the endpoint and/or request method is not supported, return an error response
http_response_code(404);
echo json_encode(['error' => 'Endpoint not found']);