<?php
/**
 * <p>All REST API requests for uri of /api/* is rerouted here
 * and the requests will be resolved based on endpoints.php</p>
 *
 * <p>This rerouting is achieved by using the .htaccess file used by Apache servers</p>
 * <p>Example available in dummy_index2.html</p>
 *
 * <h2>Notes </h2>
 * <p>There are many services and 3rd party dependencies that we can install to handle
 * REST API functions seamlessly. I have created this because I do not want to walk my team
 * members through installing and understanding another 3rd party dependency.</p>
 * @author Beng
 */

//TODO: It might prove worthwhile for future coders to contemplate the installation of these services to replace this.</p>

//TODO: Parse through what these mean for security and if we want it or not
//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
//header("Access-Control-Max-Age: 3600");
//header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// The backend bootstrap file
require_once '../../../backend/php/util/bootstrap.php';

use backend\php\util\Container;
use backend\php\api\RequestResolverInterface;


//TODO: I feel like endpoints can potentially be restructured and have the functions be bound using our Container.php
// e.g. bind('/api/articles/get/POST', function(){});
// but I can't wrap my head around how to actually implement it
//Array of endpoints
$endpoints = require PROJECT_ROOT_PATH . '/backend/php/api/endpoints.php';

$container = Container::getInstance();
$resolver = $container->resolve(RequestResolverInterface::class);

// The request method sent by the client e.g. GET, POST, PUT, DELETE, OPTIONS
$request_method = $_SERVER['REQUEST_METHOD'];
// The URL_PATH component of the Request URI e.g. http://localhost/api/articles/get?query1=24&query2=44 is /api/articles/get
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


// from our endpoints array, check if the requested uri has an existing endpoint
foreach($endpoints['endpoints'] as $endpoint => $methods){
    if($request_uri == $endpoint){
        //the requested endpoint exists
        // check if the requested method exists for our endpoint
        foreach ($methods as $method => $function){
            if($request_method == $method){
                //requested method exists
                //resolve the client request using our request resolver class
                $resolver->resolve($function);
                exit;
            }
        }
        //found the endpoint but no valid method exists
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
        exit;
    }
}
//did not find the requested endpoint
http_response_code(404);
echo json_encode(['error' => 'Endpoint not found']);