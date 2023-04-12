<?php

namespace backend\php\api;

use backend\php\api\database\ArticleControllerInterface;
use backend\php\util\Container;

/**
 * Resolver for API requests
 *
 * This class is the middleman that will link all valid endpoints to all the different controller classes
 *
 * Valid endpoints and methods will be directed to this class by api.php
 * This class will call the appropriate controller class to carry out the API request
 *
 * Functions that will be passed here can be referred to in endpoints.php
 *
 * Functions will have two parts separated by "/":
 *      the Class to be used,
 *      and the function of that class to be called
 *
 * e.g. "ArticleControllerInterface/getArticles"
 * Means that from the class ArticleControllerInterface, Call getArticles()
 * @author Beng
 */
class RequestResolver implements RequestResolverInterface
{
    protected Container $container;
    protected array $controllers;


    public function __construct(){
        $this->container = Container::getInstance();
        $endpoints = require PROJECT_ROOT_PATH . '/backend/php/api/endpoints.php';
        $this->controllers = $endpoints['controllers'];
    }

    /**
     * @inheritDoc
     * @author Beng
     */
    public function resolve($function){
        $functionArr = explode("/", $function);
        if ($functionArr[0] == $this->controllers[0]){
            //ArticleControllerInterface is requested
            $controller = $this->container->resolve(ArticleControllerInterface::class);
            $controller->callArticlesDatabase($functionArr[1]);
        }
    }
}