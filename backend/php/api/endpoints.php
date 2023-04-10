<?php

return [
    'endpoints' => [
        '/api/gettest' => [
          'GET' => 'getArticlesActionDummy'
        ],
        '/api/articles/get' => [
            //Our function has the option to do lengthy requests
            //which would clutter the url if we use GET, so our "GET" request is converted
            //to a POST instead.
            'POST' => 'getArticlesAction'
        ],
        '/api/articles' => [
            'POST' => 'addArticlesAction'
        ],
        '/api/articles/id/get' =>[
            //Same here
            'POST' => 'getArticlesByIDAction'
        ],
        '/api/articles/id' => [
            'PUT' => 'updateArticlesByIDAction',
            'DELETE' => 'deleteArticlesByIDAction'
        ]
    ]
];