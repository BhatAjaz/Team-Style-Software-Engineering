<?php

 namespace backend\php\firestore;

 use Google\Cloud\Core\Exception\GoogleException;
 use Google\Cloud\Firestore\FirestoreClient;
 use Google\Cloud\Firestore\DocumentReference;
 use Google\Cloud\Firestore\CollectionReference;

 class Firestore
 {
    private FirestoreClient $firestoreClient;

    public function __construct()
    {
            $this->firestoreClient = new FirestoreClient([
                "keyFilePath" => __DIR__ . "/keys/zz-2204websiteproject-cbac90c118c2.json",
                "projectId" => "zz-2204websiteproject",
            ]);

    }

    public function getArticle(string $articles, string $document): array
    {
        return $this->firestoreClient->collection($articles)->document($document)->snapshot()->data();
    }

 }
