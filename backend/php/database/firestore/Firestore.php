<?php

 namespace backend\php\database\firestore;

 use backend\php\database\DatabaseInterface;
 use Google\Cloud\Firestore\FirestoreClient;

 const ARTICLE_ROOT = "Articles";
 const ARTICLE_SUB_COLLECTION = "Articles";

 /**
  * Firestore implementation of the DatabaseInterface
  * @author Beng
  */
 class Firestore implements DatabaseInterface
 {

     /**
      * @param FirestoreClient $firestoreClient the firestore instance used to communicate with our database
      * @author Beng
      */
     public function __construct(protected FirestoreClient $firestoreClient){
     }

     /**
      * @return string Json response that details the status of the Firestore database
      * @author Beng
      */
     public function getStatus(): string
     {
         return json_encode(array("message" => "I am a Firestore database :>"));
     }

     /**
      * @inheritDoc
      * @author Beng
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
      * @inheritDoc
      * @author Beng
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
      * @inheritDoc
      * @author Beng
      */
     public function addArticles(string $json): string
     {
         $jsonArr = json_decode($json,true);
         $batch = $this->firestoreClient->bulkWriter();

         //variable here is only used for testing
         // TODO: Remove when we have better unit tests
         $added = 0;

         if (! empty($jsonArr['articles'])){
             //unsets 'from' and 'id' after using it, so it won't be saved to the articles we're creating
             foreach ($jsonArr['articles'] as $article){
                 $ref = $this->firestoreClient->collection(ARTICLE_ROOT."/".$article['from']."/".ARTICLE_SUB_COLLECTION);
                 unset($article['from']);

                 //it's expected for the most common requests to not have id, so it goes first.
                 //will maybe improve performance by 0.000001% for most users
                 if(!array_key_exists('id', $article)){
                     $ref = $ref->newDocument();
                 }else{
                     $id = $article['id'];
                     unset($article['id']);
                     $ref = $ref->document($id);
                 }
                 //TODO: could set merge true,
                 // so it won't replace the whole document
                 // if an old document with same ID exists
                 // e.g.    $cityRef->set('capital' => true], ['merge' => true]);
                 $batch->set($ref, $article);
                 $added = $added + 1;
             }
             $batch->commit();
         }
         return json_encode(array("result message" =>"added " . $added . " article(s)"));
     }

     /**
      * @inheritDoc
      */
     public function moveArticles(string $json): string
     {
            // TODO: Implement moveArticles() method.
             return json_encode(array("result message" => "moved articles not implemented"));
     }

     /**
      * @inheritDoc
      * @author Beng
      */
     public function updateArticles(string $json): string
     {
         $jsonArr = json_decode($json,true);
         $batch = $this->firestoreClient->bulkWriter();

         //variable here is only used for testing
         // TODO: Remove when we have better unit tests
         $updated = 0;

         if (! empty($jsonArr['articles'])){
             //unsets 'from' and 'id' after using it,
             // so it won't be saved to the articles we're updating
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
         return json_encode(array("result message" => "updated " . $updated . " article(s)"));
     }

     /**
      * @inheritDoc
      * @author Beng
      */
     public function deleteArticles(string $json): string
     {
         $jsonArr = json_decode($json,true);
         $batch = $this->firestoreClient->bulkWriter();

         //variable here is only used for testing
         // TODO: Remove when we have better unit tests
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
         return json_encode(array("result message" => "deleted " . $deleted . " article(s)"));
     }
 }
