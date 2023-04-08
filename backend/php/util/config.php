<?php
/**
 *
 * @author Beng
 */

use Google\Cloud\Firestore\FirestoreClient;

//TODO: Contemplate whether the security benefits by encapsulating these variables in a class and setting them to private is worth the refactor hassle

const FIRESTORE_KEY = __DIR__ . "/../database/firestore/keys/zz-2204websiteproject-cbac90c118c2.json";
const FIRESTORE_PROJECT_ID = "zz-2204websiteproject";

//Loops until we successfully get a FirestoreClient
$firestoreClient = null;
while(!$firestoreClient instanceof FirestoreClient){
    try {
        $firestoreClient = new FirestoreClient([
            "keyFilePath" => FIRESTORE_KEY,
            "projectId" => FIRESTORE_PROJECT_ID
        ]);
    } catch (\Google\Cloud\Core\Exception\GoogleException $e) {}

    //Wait 1 sec and try again
    if(!$firestoreClient instanceof FirestoreClient){
        sleep(1);
    }
}

return [
    'interfaces' => [
            \backend\php\database\DatabaseInterface::class => function() use($firestoreClient) {return new \backend\php\database\firestore\Firestore($firestoreClient);},
            \backend\javascript\authentication\AuthenticatorInterface::class => function(){return \backend\javascript\authentication\Authenticator_dummy::getInstance();}
    ],
];