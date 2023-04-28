<?php

namespace backend\php\database\mongodb;

use backend\php\database\DatabaseInterface;
use backend\php\util\Container;
use MongoDB\Client;

class MongoDBHandler implements DatabaseInterface
{
    protected Client $mongoClient;
    protected string $connectionString;
    protected ?Container $container = null;
//    protected $db;
    protected string $databaseName = 'Articles';

    public function __construct()
    {
        $this->container = Container::getInstance();

        // Set the mongodb Atlas connection string
        $this->connectionString = "mongodb+srv://SoftEngineerUBDJan2023Student:5rpMmgLIDCbaSdWR@lithubcluster0.kxu4yzq.mongodb.net/?retryWrites=true&w=majority";

        // Create a mongodb client with the connection string
        $this->mongoClient = new Client($this->connectionString);

        // Get the database
        //$this->db = $this->mongoClient->selectDatabase('Articles');

    }

    /**
     * @inheritDoc
     */
    public function addArticles(string $json): string
    {
        // Decode the JSON input
        $articles = json_decode($json, true);

        // Initialize the count of added articles
        $count = 0;

        // Loop through each article and add it to the database
        foreach ($articles['articles'] as $article) {
            $collection = $this->mongoClient->selectCollection($this->databaseName, $article['from']);
            unset($article['from']);

            if(array_key_exists('id', $article)){
                $article['_id'] = $article['id'];
                unset($article['id']);
            }

            $result = $collection->insertOne($article);
            if ($result->getInsertedCount() > 0) {
                $count++;
            }
        }

        // Return the result as a JSON string
        return json_encode(['message' => "added $count article(s)"]);
    }

    public function updateArticles(string $json): string
    {
        $articles = json_decode($json, true)['articles'];
        $updatedCount = 0;

        if(!empty($articles)){
            foreach ($articles as $article) {
                $collection = $this->mongoClient->selectCollection($this->databaseName, $article['from']);
                $id = $article['id'];
                unset($article['from']);
                unset($article['id']);

                $updates = array();
                foreach ($article as $path => $value){
                    $updates[$path] = $value;
                }

                $collection->updateOne(
                    ['_id' => $id],
                    ['$set' => $updates],
                    ["upsert" => true]
                );

                $updatedCount = $updatedCount + 1;
            }
        }

        return json_encode(array("result message" => "updated " . $updatedCount . " article(s)"));
    }


    public function deleteArticles($json): string
    {
        $data = json_decode($json, true);

        $deletedCount = 0;

        if (! empty($data['articles'])){
            foreach ($data['articles'] as $article) {
                $collection = $this->mongoClient->selectCollection($this->databaseName, $article['from']);
                $collection->deleteOne(['_id' => $article['id']]);
                $deletedCount = $deletedCount+1;
            }
        }

        return json_encode(array("result message" => "deleted " . $deletedCount . " article(s)"));

    }

    public function getArticles(string $json): string
    {
        // Parse the JSON request
        $requestData = json_decode($json, true);

        // Get the "from" field from the request
        $from = $requestData["from"];

        // Get the "noOfArticles" field from the request
        $noOfArticles = isset($requestData["noOfArticles"]) ? $requestData["noOfArticles"] : 5;

        // Get the "sortBy" field from the request
        $sortBy = isset($requestData["sortBy"]) ? $requestData["sortBy"] : "title";

        // Get the "order" field from the request
        $order = isset($requestData["order"]) ? $requestData["order"] : "ascending";

        // Check if the number of articles is greater than 0
        if ($noOfArticles <= 0) {
            // Return an empty array
            return json_encode(array("articles" => array()));
        }

        // Query the database to get the article
        $collection = $this->mongoClient->selectCollection($this->databaseName, $from);
        $query = $collection->find([], [
            'limit' => $noOfArticles,
            'sort' => [$sortBy => ($order === 'ascending' ? 1 : -1)]
        ]);

        $query = json_encode(iterator_to_array($query));
        $queryArr = json_decode($query,true);
        // Create an array to store the results
        $results = array();

        // Loop through the articles and add them to the result array
        foreach ($queryArr as $article) {
            $result = array(
                "id" => $article["_id"],
            );
            unset($article['_id']);
            $result = array_merge($result, $article);
            $results[$result['id']] = $result;
        }
        // Encode the result array as JSON and return it
        return json_encode(array("articles" => $results));
    }

    public function getArticlesByID(string $json): string
    {
        $requests = json_decode($json, true);
        $articles = array();


        foreach ($requests['articles'] as $request){
            $collection = $this->mongoClient->selectCollection($this->databaseName, $request['from']);
            $query = $collection->findOne(['_id' => $request['id']]);

            //Change to array
            $query = json_encode(iterator_to_array($query));
            $query = json_decode($query,true);

            $article = array();
            $article['id'] = $query['_id'];
            unset($query['_id']);
            $article = array_merge($article,$query);
            $articles[$article['id']] = $article;
        }

        return json_encode(array("articles" => $articles));

    }

    public function moveArticles(string $json): string
    {
        return json_encode(array("result message" => "moved articles not implemented"));
    }

    public function getStatus(): string
    {
        // Check the status of the MongoDB client connection
        try {
            $status = $this->mongoClient->getManager()->selectServer(new \MongoDB\Driver\ReadPreference(\MongoDB\Driver\ReadPreference::RP_PRIMARY))->isPrimary() ? 'OK' : 'ERROR';
        } catch (\MongoDB\Driver\Exception\Exception $e) {
            $status = 'ERROR';
        }

        // Return the status as a JSON string
        return json_encode(['status' => $status]);
    }



}

