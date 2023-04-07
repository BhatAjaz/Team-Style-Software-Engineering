<?php
/**
 *
 * @author Beng
 */
    return [
        'interfaces' => [
                \backend\php\database\DatabaseInterface::class => \backend\php\database\firestore\Firestore::class,
                \backend\javascript\authentication\AuthenticatorInterface::class => function(){return \backend\javascript\authentication\Authenticator_dummy::getInstance();}
        ],
    ];