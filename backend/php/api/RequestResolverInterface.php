<?php

namespace backend\php\api;

/**
 * Resolver for API requests
 * This class is the middleman that will link all valid endpoints to all the different controller classes
 * @author Beng
 */
interface RequestResolverInterface
{

    /**
     *
     * The function responsible for choosing the correct class.
     * @param $function string The function to be called
     */
    public function resolve(string $function);
}