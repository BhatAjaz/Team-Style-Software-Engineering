<?php
/**
 *
 * @author Beng
 */

use Google\Cloud\Firestore\FirestoreClient;

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
        \backend\php\api\RequestResolverInterface::class => \backend\php\api\RequestResolver::class,
        \backend\php\api\database\ArticleControllerInterface::class => \backend\php\api\database\ArticleController::class
   ]
];