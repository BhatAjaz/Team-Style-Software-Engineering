<?php

 namespace backend\php\database\firestore;

 use backend\php\database\DatabaseInterface;
 use backend\php\util\Container;
 use Google\Cloud\Core\Exception\GoogleException;
 use Google\Cloud\Firestore\FirestoreClient;
 use Google\Cloud\Firestore\DocumentSnapshot;

 const ARTICLE_ROOT = "Articles";
 const ARTICLE_SUB_COLLECTION = "Articles";

 /**
  *
  * @author Beng
  */
 class Firestore implements DatabaseInterface
 {

     /**
      * @throws GoogleException
      * @author Beng
      */
     public function __construct(protected FirestoreClient $firestoreClient){

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

         $ref = $this->firestoreClient->collection(ARTICLE_ROOT."/".$jsonArr['from']."/".ARTICLE_SUB_COLLECTION);

         if(array_key_exists('noOfArticles',$jsonArr)){
             $noArticles = $jsonArr['noOfArticles'];}else{$noArticles = 5;}

         if(array_key_exists('sortBy',$jsonArr)){
             $sortBy = $jsonArr['sortBy'];}else{$sortBy = "title";}

         if(array_key_exists('order',$jsonArr) && $jsonArr['order'] == "descending"){
             $order = 'DESC';}else{$order = 'ASC';}

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
                 $articles[$article['id']] = $article;
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
         $jsonArr = json_decode($json,true);
         $articles = array();

         foreach ($jsonArr['articles'] as $request){
             $docRef = $this->firestoreClient->collection(ARTICLE_ROOT."/".$request['from']."/".ARTICLE_SUB_COLLECTION)->document($request['id']);
             $snapshot = $docRef-> snapshot();

             if ($snapshot->exists()){
                 $article = array();
                 $article['id'] = $snapshot->id();
                 $article = array_merge($article,$snapshot->data());
                 $articles[$article['id']] = $article;
             }
         }

         return json_encode(array("articles" => $articles));
     }

     /**
      *
      * @inheritDoc
      * @param string $json
      * @return string
      */
     public function addArticles(string $json): string
     {
         $jsonArr = json_decode($json,true);
         $batch = $this->firestoreClient->bulkWriter();

         //variable here is only used for testing TODO: Remove when we have better unit tests
         $added = 0;

         if (! empty($jsonArr['articles'])){
             //unsets 'from' and 'id' after using it so it won't be saved to the articles we're creating
             foreach ($jsonArr['articles'] as $article){
                 $ref = $this->firestoreClient->collection(ARTICLE_ROOT."/".$article['from']."/".ARTICLE_SUB_COLLECTION);
                 unset($article['from']);

                 //it's expected for the most common requests to not have id so it goes first. will maybe improve performance by 0.000001% for most uses
                 if(!array_key_exists('id', $article)){
                     $ref = $ref->newDocument();
                 }else{
                     $id = $article['id'];
                     unset($article['id']);
                     $ref = $ref->document($id);
                 }
                 $batch->set($ref, $article);
                 $added = $added + 1;
//       could set merge true so it won't replace the whole document if an old document with same ID exists
//       $cityRef->set('capital' => true], ['merge' => true]);
             }

             $batch->commit();
         }
         return "added " . $added . " article(s)";
     }

     /**
      *
      * moving articles around firestore collections is not natively supported, the workaround is kind-of unwieldy, so let's not code for this unless really needed
      *
      * @param string $json
      * @return string
      */
     public function moveArticles(string $json): string
     {
            // TODO: Implement moveArticles() method.
             return "moved articles";
     }

     /**
      * @param string $json
      * @return string
      */
     public function updateArticles(string $json): string
     {
         $jsonArr = json_decode($json,true);
         $batch = $this->firestoreClient->bulkWriter();

         //variable here is only used for testing TODO: Remove when we have better unit tests
         $updated = 0;

         if (! empty($jsonArr['articles'])){
             //unsets 'from' and 'id' after using it so it won't be saved to the articles we're creating
             foreach ($jsonArr['articles'] as $article){
                 $ref = $this->firestoreClient
                     ->collection(ARTICLE_ROOT."/".$article['from']."/".ARTICLE_SUB_COLLECTION)
                     ->document($article['id']);
                 unset($article['from']);
                 unset($article['id']);

                 $updates = array();
                 foreach ($article as $path => $value){
                     $updates[] = array(
                         'path' => $path,
                         'value' => $value
                     );
                 }
                 $batch->update($ref, $updates);
                 $updated = $updated + 1;
             }
             $batch->commit();
         }
         return "updated " . $updated . " article(s)";
     }

     /**
      * @return string
      */
     public function deleteArticles(string $json): string
     {
         $jsonArr = json_decode($json,true);
         $batch = $this->firestoreClient->bulkWriter();

         //variable here is only used for testing TODO: Remove when we have better unit tests
         $deleted = 0;

         if (! empty($jsonArr['articles'])){
             foreach ($jsonArr['articles'] as $article){
                 $ref = $this->firestoreClient
                     ->collection(ARTICLE_ROOT."/".$article['from']."/".ARTICLE_SUB_COLLECTION)
                     ->document($article['id']);

                 $batch->delete($ref);
                 $deleted = $deleted + 1;
             }
             $batch->commit();
         }
         return "deleted " . $deleted . " article(s)";
     }
 }
