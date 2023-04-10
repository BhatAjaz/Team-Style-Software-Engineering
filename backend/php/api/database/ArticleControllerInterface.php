<?php

namespace backend\php\api\database;

/**
 * All database api calls should be rerouted here
 */
interface ArticleControllerInterface
{
    public function callArticlesDatabase($function):void;
}