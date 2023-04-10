<?php

namespace backend\php\api;
use backend\php\api\database\ArticleControllerInterface;
use backend\php\util\Container;

class RequestResolver implements RequestResolverInterface
{
    protected Container $container;
    private string $articlesDatabase = 'Articles';

    public function __construct(){
        $this->container = Container::getInstance();
    }

    public function resolve($function){
        //This means that the Articles Database is requested
        //TODO: I think this code is a bit sketchy because this relies on the fact that only
        // the Articles Database functions would contain 'Articles' in their name
        if (str_contains($function, $this->articlesDatabase)){
            $articleController = $this->container->resolve(ArticleControllerInterface::class);
            $articleController->callArticlesDatabase($function);
        }
    }
}