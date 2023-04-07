<?php

 namespace backend\php\database\firestore;

 use backend\php\database\DatabaseInterface;
 use backend\php\util\Container;
 use Google\Cloud\Core\Exception\GoogleException;
 use Google\Cloud\Firestore\FirestoreClient;
 use Google\Cloud\Firestore\DocumentSnapshot;

 /**
  *
  * @author Beng
  */
 class Firestore implements DatabaseInterface
 {
    protected FirestoreClient $firestoreClient;
    protected string $keyPath = "/keys/zz-2204websiteproject-cbac90c118c2.json";
    protected string $projectID = "zz-2204websiteproject";

    protected ?Container $container = null;


    protected string $rootCollection = "Articles";
    protected string $articleSubCollection = "Articles";


     /**
      * @throws GoogleException
      * @author Beng
      */
     public function __construct()
    {
            $this->container = Container::getInstance();

            $this->firestoreClient = new FirestoreClient([
                "keyFilePath" => __DIR__ . $this->keyPath,
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
             "db" => "firestore",
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
     public function getArticles(string $json): string
     {
         $jsonArr = json_decode($json,true);

         $ref = $this->firestoreClient->collection($this->rootCollection)->document($jsonArr['from'])->collection($this->articleSubCollection);

         if(array_key_exists('noOfArticles',$jsonArr))
         {
             $noArticles = $jsonArr['noOfArticles'];
         }
         else
         {
             $noArticles = 5;
         }

         if(array_key_exists('sortBy',$jsonArr))
         {
             $sortBy = $jsonArr['sortBy'];
         }
         else
         {
             $sortBy = "title";
         }
         if(array_key_exists('order',$jsonArr) && $jsonArr['order'] == "descending")
         {
             $order = 'DESC';
         }
         else
         {
             $order = 'ASC';
         }

         $query = $ref
             ->orderBy($sortBy, $order)
             ->limit($noArticles);

         $documents = $query->documents();

         $articles = array();

         foreach ($documents as $document) {
             if ($document->exists()) {
                 $article = array();
                 $article['id'] = $document->id();
                 $article = array_merge($article,$document->data());

                 $articles[] = $article;
             } else {
                 printf('Document %s does not exist!' . PHP_EOL, $document->id());
             }
         }


         return json_encode(array("articles" => $articles));
     }

     /**
      * @param string $json
      * @return string
      */
     public function getArticlesByID(string $json): string
     {
         // TODO: Implement getArticlesByID() method.
         return "articles by ID";
     }

     /**
      * @param string $json
      * @return string
      */
     public function addArticles(string $json): string
     {
             // TODO: Implement addArticles() method.
             return "added articles";

     }

     /**
      * @param string $json
      * @return string
      */
     public function moveArticles(string $json): string
     {
            // TODO: Implement moveArticles() method.
             return "moved articles";
     }

     /**
      * @param string $jsons
      * @return string
      */
     public function updateArticles(string $jsons): string
     {
            // TODO: Implement updateArticles() method.
             return "updated articles";
     }

     /**
      * @return string
      */
     public function deleteArticles(): string
     {
         // TODO: Implement deleteArticles() method.
             return "deleted articles";
     }
 }
