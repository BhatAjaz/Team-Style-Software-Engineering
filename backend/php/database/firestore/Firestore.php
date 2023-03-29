<?php

 namespace backend\php\database\firestore;

 use backend\php\database\DatabaseInterface;
 use Google\Cloud\Core\Exception\GoogleException;
 use Google\Cloud\Firestore\FirestoreClient;

 /**
  *
  * @author Beng
  */
 class Firestore implements DatabaseInterface
 {
    protected FirestoreClient $firestoreClient;
    protected string $keyPath = __DIR__ . "/keys/zz-2204websiteproject-cbac90c118c2.json";
    protected string $projectID = "zz-2204websiteproject";

     /**
      * @throws GoogleException
      * @author Beng
      */
     public function __construct()
    {
            $this->firestoreClient = new FirestoreClient([
                "keyFilePath" => $this->keyPath,
                "projectId" => $this->projectID,
            ]);

    }

     /**
      * @param string $config
      * @return Firestore
      * @throws GoogleException
      * @author Beng
      */
     public static function setConfig(string $config): Firestore
    {
        $instance = new self();

        $config = json_decode($config, false);
        $instance->keyPath = $config->keyPath;
        $instance->projectID = $config->projectID;

        $instance->firestoreClient = new FirestoreClient([
            "keyFilePath" => $instance->keyPath,
            "projectId" => $instance->projectID,
        ]);

        return $instance;
    }

     /**
      * @return string
      * @author Beng
      */
     public function getConfig(): string
     {
         $config = array(
             "keyPath" => $this->keyPath,
             "projectID" => $this->projectID
         );
         return json_encode($config);
     }

     /**
      * @deprecated Only created to test if the firestore is working, DO NOT USE THIS FOR OTHER CODES
      *
      * @param string $articles
      * @param string $document
      * @return array
      * @author Beng
      */
     public function getArticle(string $articles, string $document): array
    {
        return $this->firestoreClient->collection($articles)->document($document)->snapshot()->data();
    }

     /**
      * @param string $json
      * @return array
      */
     public function getArticles(string $json): array
     {
         // TODO: Implement getArticles() method.
     }

     /**
      * @param string $json
      * @return string
      */
     public function getArticlesByID(string $json): string
     {
         // TODO: Implement getArticlesByID() method.
     }

     /**
      * @param string $json
      * @return string
      */
     public function addArticles(string $json): string
     {
         // TODO: Implement addArticles() method.
     }

     /**
      * @param string $json
      * @return string
      */
     public function moveArticles(string $json): string
     {
         // TODO: Implement moveArticles() method.
     }

     /**
      * @param string $jsons
      * @return string
      */
     public function updateArticles(string $jsons): string
     {
         // TODO: Implement updateArticles() method.
     }

     /**
      * @return string
      */
     public function deleteArticles(): string
     {
         // TODO: Implement deleteArticles() method.
     }
 }
