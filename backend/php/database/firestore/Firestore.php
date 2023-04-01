<?php

 namespace backend\php\database\firestore;

 use backend\php\database\DatabaseInterface;
 use Google\Cloud\Core\Exception\GoogleException;
 use Google\Cloud\Firestore\FirestoreClient;
 use backend\php\util\Container;
 use function React\Promise\resolve;
 use backend\php\authentication\AuthenticatorInterface;

 /**
  *
  * @author Beng
  */
 class Firestore implements DatabaseInterface
 {
    protected FirestoreClient $firestoreClient;
    protected string $keyPath = __DIR__ . "/keys/zz-2204websiteproject-cbac90c118c2.json";
    protected string $projectID = "zz-2204websiteproject";

    protected ?Container $container = null;
    protected mixed $authenticator = null;
     /**
      * @throws GoogleException
      * @author Beng
      */
     public function __construct()
    {
            $this->container = Container::getInstance();
            $this->authenticator = $this->container->resolve(AuthenticatorInterface::class);

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
         return ["articles"];
     }

     /**
      * @param string $json
      * @return string
      */
     public function getArticlesByID(string $json): array
     {
         // TODO: Implement getArticlesByID() method.
         return ["articles by ID"];
     }

     /**
      * @param string $json
      * @return string
      */
     public function addArticles(string $json): string
     {
         if ($this->authenticator->userIs('admin'))
         {
             // TODO: Implement addArticles() method.
             return "added articles";
         }
         return "failed";
     }

     /**
      * @param string $json
      * @return string
      */
     public function moveArticles(string $json): string
     {
         if ($this->authenticator->userIs('admin'))
         {
            // TODO: Implement moveArticles() method.
             return "moved articles";
         }
         return "failed";
     }

     /**
      * @param string $jsons
      * @return string
      */
     public function updateArticles(string $jsons): string
     {
         if ($this->authenticator->userIs('admin'))
         {
            // TODO: Implement updateArticles() method.
             return "updated articles";
         }
         return "failed";
     }

     /**
      * @return string
      */
     public function deleteArticles(): string
     {
         if ($this->authenticator->userIs('admin'))
         {
         // TODO: Implement deleteArticles() method.
             return "deleted articles";
         }
         return "failed";
     }
 }
