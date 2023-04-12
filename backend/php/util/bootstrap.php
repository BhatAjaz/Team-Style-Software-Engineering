<?php
/**
 * <p>The bootsrapping file which should be specified using:</p>
 * <p>require once './backend/php/util/bootstrap.php';</p>
 * <p>at the beginning of entry point files to ensure that our
 * environment is properly initialized before other codes is executed.</p>
 * <p> such as: api.php and index.php</p>
 *
 * <h2>Notes</h2>
 * <p>There might be other alternatives to ensure that bootstrapping is run when needed</p>
 *
 * <p>One possible solution would be to redirect all urls to a central php file
 * before directing them to the correct webpages. This cuts down our entry points to only one.
 *  But performance could be an issue</p>
 *
 * @author Beng
 */

if(!defined('PROJECT_ROOT_PATH')){
    define("PROJECT_ROOT_PATH", __DIR__ . '/../../../');
}

//TODO: This is probably very insecure, as the secret key should be a secret
// the key could be potentially linked to payment and admin access to the database
// security of this key should be handled more seriously before putting our website out to the public
// Using containers and microservices is another way of passing the (secret) key securely
//Firestore database secret key
if(!defined('FIRESTORE_KEY')){
    define("FIRESTORE_KEY", PROJECT_ROOT_PATH . "/backend/php/database/firestore/keys/zz-2204websiteproject-cbac90c118c2.json");
}
//Firestore database project ID
if(!defined('FIRESTORE_PROJECT_ID')){
    define("FIRESTORE_PROJECT_ID", "zz-2204websiteproject");
}

//Composer autoloader
require_once PROJECT_ROOT_PATH . '/vendor/autoload.php';
//Configuration array, currently only used by Dependency Injection Container.php
$config = require PROJECT_ROOT_PATH . '/backend/php/util/config.php';

use backend\php\util\Container;

//Binding all the interfaces to the classes based on $config
$container = Container::getInstance();
foreach ($config['interfaces'] as $interface => $concrete){
    $container->bind($interface, $concrete);
}