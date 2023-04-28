<?php
/**
 * Contains information linking interface files to their corresponding classes
 *
 * This linking can also include information on how the class instance is to be constructed
 * as seen by the Firestore linking
 * @author Beng
 */

use Google\Cloud\Firestore\FirestoreClient;

$firestoreClient = null;

//Loops until we successfully get a FirestoreClient instance
while(!$firestoreClient instanceof FirestoreClient){
    try {
        $firestoreClient = new FirestoreClient([
            "keyFilePath" => FIRESTORE_KEY,
            "projectId" => FIRESTORE_PROJECT_ID
        ]);
    } catch (\Google\Cloud\Core\Exception\GoogleException $e) {}

    //Wait 1 sec and try again if it fails
    if(!$firestoreClient instanceof FirestoreClient){
        sleep(1);
    }
}

return [
    'interfaces' => [
//        \backend\php\database\DatabaseInterface::class => function() use($firestoreClient) {return new \backend\php\database\firestore\Firestore($firestoreClient);},
//        \backend\php\database\DatabaseInterface::class => \backend\php\database\mongodb\MongoDB::class,
        \backend\php\database\DatabaseInterface::class => \backend\php\database\dummy\Dummy::class,
        \backend\php\api\RequestResolverInterface::class => \backend\php\api\RequestResolver::class,
        \backend\php\api\database\ArticleControllerInterface::class => \backend\php\api\database\ArticleController::class
   ]
];