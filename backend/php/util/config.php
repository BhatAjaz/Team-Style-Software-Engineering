<?php
/**
 *
 * @author Beng
 */
    return [
        'interfaces' => [
                \backend\php\database\DatabaseInterface::class => \backend\php\database\firestore\Firestore::class,
                \backend\php\authentication\AuthenticatorInterface::class => function(){return \backend\php\authentication\Authenticator_dummy::getInstance();}
        ],
    ];