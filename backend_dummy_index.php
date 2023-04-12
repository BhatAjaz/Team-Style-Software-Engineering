<?php

require_once './backend/php/util/bootstrap.php';

use backend\php\util\Container;

/**
 *
 * @author Beng
 */

interface DatabaseDriverTest{
    public function connect();

    public function query();
}
class MySQL implements DatabaseDriverTest{
    public function connect(){
        var_dump("connect mysql");
    }
    public function query(){
        var_dump("query mysql");
    }
}
class PostgreSQL implements DatabaseDriverTest{
    public function connect(){
        var_dump("connect PostgreSQL");
    }
    public function query(){
        var_dump("query PostgreSQL");
    }
}
class FacebookLogin{
    public function __construct($apiKey, $apiSecret){
        var_dump("FB Login module is ready");
    }
}
class UserModel{
    public function __construct(DatabaseDriverTest $driver, FacebookLogin $facebookLogin){
        $driver->connect();
        $driver->query();
    }
}

$app = Container::getInstance();
$app->bind(FacebookLogin::class, function(){
    return new FacebookLogin('secrets', 'secrets');
});

$app->bind(DatabaseDriverTest::class,PostgreSQL::class);
$app->resolve(UserModel::class);

$app->bind(DatabaseDriverTest::class,MySQL::class);
$app->resolve(UserModel::class);

use backend\php\database\DatabaseInterface;
$db = $app->resolve(DatabaseInterface::class);


$get = json_encode(array(
    "from" => "Crimereads",
    "noOfArticles" => 2,
    "sortBy" => "publish_date",
    "order" => "ascending"
));
var_dump($db->getArticles($get));


$app->bind("hello",function(){var_dump("Hello world");});
$app->resolve("hello");

$app->bind("double layer",DatabaseInterface::class);
$db = $app->resolve("double layer");

$get = json_encode(array(
    "from" => "Crimereads",
    "noOfArticles" => 2,
    "sortBy" => "publish_date",
    "order" => "ascending"
));
var_dump($db->getArticles($get));

$app->bind("string to int",2);
$app->bind(2,"int to string");
$app->bind("int to string", function(){var_dump("This doesn't work because 2 is not instantiable");});
$app->resolve("string to int");

