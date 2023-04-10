<?php
/**
 * <p>The bootsrapping file which should be run using:</p>
 * <p>require once './backend/php/util/bootstrap.php';</p>
 * <p>before other backend code is run to ensure that our code is
 * properly instantiated and configured before other codes starts using it.</p>
 * <p></p>
 * <h2>Notes</h2>
 *
 * <p>Current setup of the server requires the bootstrap.php to be specified
 * whenever a webpage is run that requires it to ensure that it would be loaded
 * when a user requests that webpage</p>
 *
 * <p>using require once './backend/php/util/bootstrap.php';</p>
 *
 * <p>There might be other alternatives to ensure that bootstrapping is run
 * whenever something is requested by the server</p>
 *
 * <p>One possible solution would be to redirect all urls to a php file
 * before directing them to the correct webpage</p>
 *
 * <p>e.g. All requests for http://localhost:80/api such as http://localhost:80/api/database
 * would be redirected through the api.php file, where that php file would contain
 * require_once './backend/php/util/bootstrap.php';
 * before redirecting the request to the databaseAPI.php file. </p>
 *
 * @author Beng
 */
if(!defined('PROJECT_ROOT_PATH')){
    define("PROJECT_ROOT_PATH", __DIR__ . '/../../../');
}

// TODO: Contemplate whether the security benefits of encapsulating this key in a class
//  and setting them to private is worth the refactor hassle.
//  Using containers and microservices is another way of passing the (secret) key securely
if(!defined('FIRESTORE_KEY')){
    define("FIRESTORE_KEY", PROJECT_ROOT_PATH . "/backend/php/database/firestore/keys/zz-2204websiteproject-cbac90c118c2.json");
}
if(!defined('FIRESTORE_PROJECT_ID')){
    define("FIRESTORE_PROJECT_ID", "zz-2204websiteproject");
}

require_once PROJECT_ROOT_PATH . '/vendor/autoload.php';
$config = require PROJECT_ROOT_PATH . '/backend/php/util/config.php';

use backend\php\util\Container;
$container = Container::getInstance();
foreach ($config['interfaces'] as $interface => $concrete){
    $container->bind($interface, $concrete);
}