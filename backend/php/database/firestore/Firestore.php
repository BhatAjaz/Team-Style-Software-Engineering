<?php

 namespace backend\php\database\firestore;

 use backend\php\database\DatabaseInterface;
 use Google\Cloud\Core\Exception\GoogleException;
 use Google\Cloud\Firestore\FirestoreClient;

 class Firestore implements DatabaseInterface
 {
    protected FirestoreClient $firestoreClient;
    protected string $keyPath = __DIR__ . "/keys/zz-2204websiteproject-cbac90c118c2.json";
    protected string $projectID = "zz-2204websiteproject";

     /**
      * @throws GoogleException
      */
     public function __construct()
    {
            $this->firestoreClient = new FirestoreClient([
                "keyFilePath" => $this->keyPath,
                "projectId" => $this->projectID,
            ]);

    }

     /**
      * @param array $config
      * @return Firestore
      * @throws GoogleException
      */
     public static function setConfig(array $config): Firestore
    {
         $instance = new self();

         $instance->keyPath = $config[0];
         $instance->projectID = $config[1];

         $instance->firestoreClient = new FirestoreClient([
             "keyFilePath" => $instance->keyPath,
             "projectId" => $instance->projectID,
         ]);

         return $instance;
    }

     /**
      * @return array
      */
     public function getConfig(): array
     {
         return [$this->keyPath,$this->projectID];
     }

     /**
      * @param string $articles
      * @param string $document
      * @return array
      */
     public function getArticle(string $articles, string $document): array
    {
        return $this->firestoreClient->collection($articles)->document($document)->snapshot()->data();
    }

 }
