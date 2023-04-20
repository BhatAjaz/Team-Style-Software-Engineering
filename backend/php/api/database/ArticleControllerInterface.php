<?php

namespace backend\php\api\database;

/**
 * All articles database API functions should be implemented here
 * @author Beng
 */
interface ArticleControllerInterface
{
    /**
     * The function used to complete the REST API client for the Articles Database
     * Talks to the appropriate database class functions and sends the return to the client
     *
     * @param $function string database class' function to be called
     * @return void
     */
    public function callArticlesDatabase(string $function):void;
}