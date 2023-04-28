<?php

/**
 * Returns an array linking endpoints to their appropriate function calls
 *
 * Each endpoint will have REST API methods associated with it
 * Each of the REST API method will have a function associated with it.
 *
 * Some of our functions that should've been linked to GET requests according to best practices
 * are instead linked to POST requests
 *
 * This is because our functions has the option to do lengthy requests
 * which would clutter the url if we use GET,
 * so our "GET" request is converted to a POST request instead.
 *
 * The controllers array will list out all the available controllers
 * @author Beng
 */
return [
    'endpoints' => [
        '/api/articles/get' => [
            'POST' => 'ArticleControllerInterface/getArticles'
        ],
        '/api/articles' => [
            'POST' => 'ArticleControllerInterface/addArticles'
        ],
        '/api/articles/id/get' =>[
            'POST' => 'ArticleControllerInterface/getArticlesByID'
        ],
        '/api/articles/id' => [
            'PUT' => 'ArticleControllerInterface/updateArticles',
            'DELETE' => 'ArticleControllerInterface/deleteArticles'
        ]
    ],

    'controllers' => [
        'ArticleControllerInterface'
    ]
];