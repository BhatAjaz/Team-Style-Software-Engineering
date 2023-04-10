<?php

namespace backend\php\api\database;

/**
 * All database api calls should be rerouted here
 */
interface ArticleControllerInterface
{
    /**
     * "/articles" GET Endpoint - Get articles in a section
     */
    public function getArticlesAction();
    public function getArticlesActionDummy();

    /**
     * "/articles" POST Endpoint - Add articles
     */
    public function addArticlesAction();

    /**
     * "/articles/id" - GET Endpoint get articles by IDs
     */
    public function getArticlesByIDAction();

    /**
     * "/articles/id" PUT Endpoint - Update articles by IDs
     */
    public function updateArticlesByIDAction();

    /**
     * "/articles/id" DELETE Endpoint - Delete articles by IDs
     */
    public function deleteArticlesByIDAction();

}