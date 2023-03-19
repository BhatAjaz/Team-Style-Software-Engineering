<?php

 namespace backend\php\database\firestore;

 use backend\php\database\DatabaseInterface;
 use Google\Cloud\Firestore\FirestoreClient;

 class Firestore implements DatabaseInterface
 {
    private FirestoreClient $firestoreClient;
    private string $keyPath = __DIR__ . "/keys/zz-2204websiteproject-cbac90c118c2.json";

    public function __construct()
    {
            $this->firestoreClient = new FirestoreClient([
                "keyFilePath" => $this->keyPath,
                "projectId" => "zz-2204websiteproject",
            ]);

    }

    public function getArticle(string $articles, string $document): array
    {
        return $this->firestoreClient->collection($articles)->document($document)->snapshot()->data();
    }

 }