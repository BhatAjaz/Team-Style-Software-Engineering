<?php


namespace backend\php\database;

/**
 * We'll be passing info using JSON so that it is more modular, hopefully
 *
 * To make this work with user authentication, maybe we can enclose the functions with an if statement to check for user privileges
 * @author Beng
 */
    interface DatabaseInterface
    {
        /**
         * Will seldom be used but if we want to use non-default keys or projectIDs, it can be specified using this.
         * Can also include other config info needed for the database
         *
         * @param string $config JSON array containing config info
         * @return mixed return the Database Instance
         * @author Beng
         */
        public static function setConfig(string $config): mixed;

        /**
         * @return string JSON String which contains info on config
         * @author Beng
         */
        public function getConfig(): string;

        /**
         * @deprecated Only created to test if the firestore is working, DO NOT USE THIS FOR OTHER CODES
         *
         * @param string $articles
         * @param string $document
         * @return array
         * @author Beng
         */
        public function getArticle(string $articles, string $document): array;

        /**
         * https://firebase.google.com/docs/firestore/query-data/get-data
         * $json contains info on where to read the articles from
         *  such as category: news
         *
         * there should be a way to only return specific fields such as title/author/etc
         * read the documentation for more
         * this is important to improve performance, we don't want to return everything when we only want to get titles for e.g.
         *
         * returns an array of JSON strings, each string will represent an article including its contents
         *
         *
         * Doing a for-loop to check for published articles will probably be time-consuming
         *
         * We should save the info of the published/unpublished articles in a separate collection
         * Info should contain stuff like:
         *      DocumentID, Address to document
         *
         * So we can use this list to retrieve the articles
         *
         * @param string $json
         * @return array
         * @author Beng
         */
        public function getArticles(string $json): array;
        /**
         * https://firebase.google.com/docs/firestore/query-data/get-data
         * json contains list of documentID and collection name to get articles from
         *
         * @param string $json
         * @return string
         * @author Beng
         */
        public function getArticlesByID(string $json): array;
        /**
         * Use this to help with coding:
         * https://firebase.google.com/docs/firestore/manage-data/transactions#batched-writes
         * https://www.w3schools.com/php/php_arrays_associative.asp
         *
         * Use the pseudocode in phpDoc of updateArticles() for reference
         *
         * Use $batch->set(); for this function
         *
         * @param string $json
         * @return string
         * @author Beng
         */
        public function addArticles(string $json): string;
        /**
         * Firestore has no way to easily move articles,
         * From some research, we should probably try to work around this rather than forcefully create a function to do this
         *
         * A possible way to implement this would be to:
         * 1. copy the contents of the whole document,
         * 2. create a new document at intended location with the content of the previous document,
         * 3. delete the old document
         *
         * note: metadata etc. would probably be lost in the process
         * @param string $json
         * @return string
         * @author Beng
         */
        public function moveArticles(string $json): string;

        /**
         * Use this to help with coding:
         * https://firebase.google.com/docs/firestore/manage-data/transactions#batched-writes
         * https://www.w3schools.com/php/php_arrays_associative.asp
         *
         * Updates the articles based on the json info.
         * Example JSONS:
         *  {
         *      [
         *          {
         *          "category":"news",
         *          "articleID":"2345",
         *          "updates": {
         *                "Title": "new Title",
         *                "content": "new content"
         *          }
         *      ],
         *      [
         *          {
         *          "category":"opinions",
         *          "articleID":"5521253",
         *          "updates": {
         *                "Title": "new Title2",
         *                "content": "new content 2"
         *          }
         *      ]
         * }
         *
         * pseudocode:
         * $batch = $db->batch();
         *
         * $jsonsArray = json_decode($jsons)
         * for i in $jsonsArray:
         *  {
         *      $arr = $jsons[i];
         *      $address = (string) 'articles/' + $arr['category'];
         *      $ref = $db->collection($address)->collection($arr['ArticleID']);
         *      $batch->update($ref, [
         *          $arr['updates']
         *      ]);
         * }
         *
         * $batch->commit();
         *
         * IMPORTANT: Test to see if your code can update nested objects
         *
         * @param string $jsons
         * @return string pass or fail message
         * @author Beng
         */
        public function updateArticles(string $jsons): string;


        /**
         * To prevent accidental deletes, instead of actually deleting our documents,
         * we can use the updateArticles() function to flip a boolean variable "deleted" from false to true
         * then maybe if we're keen,
         * we can run this function periodically
         * to permanently delete documents that has been set to "deleted" for a while
         *
         * Doing a for-loop to check for deleted articles will be time consuming
         *
         * As such, I believe when we "delete" an article,
         * We should save the info of the "deleted" article in a separate collection
         * Info should contain stuff like:
         *      DocumentID, Address to document, "deletion" date, and other interesting info like user who deleted the article
         *
         *
         * pseudocode:
         * if (current_date - delete_date)>(20days):
         *      $db->delete($document)
         *
         * @return string pass or fail message including info on documents deleted
         * @author Beng
         */
        public function deleteArticles(): string;
    }