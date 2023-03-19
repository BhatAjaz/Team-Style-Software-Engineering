<?php
    return [
        'interfaces' => [
                \backend\php\database\DatabaseInterface::class => \backend\php\database\firestore\Firestore::class,
        ],
    ];