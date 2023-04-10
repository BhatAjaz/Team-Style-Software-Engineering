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
    public function resolve($function);
}