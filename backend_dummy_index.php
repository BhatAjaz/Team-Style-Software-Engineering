<?php

require_once './backend/php/util/bootstrap.php';

use backend\php\util\Container;

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
print_r($db->getArticle("Articles","nRcGBJdO5l1KU"));