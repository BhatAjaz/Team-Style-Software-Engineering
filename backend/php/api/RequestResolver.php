<?php

namespace backend\php\api;
use backend\php\api\database\ArticleControllerInterface;
use backend\php\util\Container;
class RequestResolver implements RequestResolverInterface
{
    protected Container $container;
    protected mixed $articleController;

    public function __construct(){
        $this->container = Container::getInstance();
        $this->articleController = $this->container->resolve(ArticleControllerInterface::class);
    }

    /**
     */
    public function getArticlesAction(): void
    {
        $this->articleController->getArticlesAction();
    }
    public function getArticlesActionDummy(): void
    {
        $this->articleController->getArticlesActionDummy();
    }

    /**
     */
    public function addArticlesAction(): void
    {
        $this->articleController->addArticlesAction();
    }

    /**
     */
    public function getArticlesByIDAction(): void
    {
        $this->articleController->getArticlesByIDAction();
    }

    /**
     */
    public function updateArticlesByIDAction(): void
    {
        $this->articleController->updateArticlesByIDAction();
    }

    /**
     */
    public function deleteArticlesByIDAction(): void
    {
        $this->articleController->deleteArticlesByIDAction();
    }
}