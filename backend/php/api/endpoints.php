<?php

return [
    'endpoints' => [
        '/api/articles/get' => [
            //Our function has the option to do lengthy requests
            //which would clutter the url if we use GET, so our "GET" request is converted
            //to a POST instead.
            'POST' => 'getArticles'
        ],
        '/api/articles' => [
            'POST' => 'addArticles'
        ],
        '/api/articles/id/get' =>[
            //Same here
            'POST' => 'getArticlesByID'
        ],
        '/api/articles/id' => [
            'PUT' => 'updateArticles',
            'DELETE' => 'deleteArticles'
        ]
    ]
];