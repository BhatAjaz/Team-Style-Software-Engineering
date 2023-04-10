<?php

namespace backend\php\api;

/**
 * Resolves the function calls for the api.php
 *
 * This class is the middleman that will link all the different controllers to the api
 *
 * Must include all the functions found in the endpoints.php
 */
interface RequestResolverInterface
{
    // '/api/articles/get'
    public function getArticlesAction();
    public function getArticlesActionDummy();
    // '/api/articles'
    public function addArticlesAction();

    // '/api/articles/id/get'
    public function getArticlesByIDAction();
    // '/api/articles/id'
    public function updateArticlesByIDAction();
    public function deleteArticlesByIDAction();
}