<?php

namespace backend\php\database\mongodb;

use backend\php\database\DatabaseInterface;
use backend\php\util\Container;
use MongoDB\Client;


class MongoDB implements DatabaseInterface
{
    protected Client $mongoClient;
    protected string $connectionString;
    protected ?Container $container = null;

    public function __construct()
    {
        $this->container = Container::getInstance();

        // Set the mongodb Atlas connection string
        $this->connectionString = "mongodb+srv://SoftEngineerUBDJan2023Student:5rpMmgLIDCbaSdWR@lithubcluster0.kxu4yzq.mongodb.net/?retryWrites=true&w=majority";

        // Create a mongodb client with the connection string
        $this->mongoClient = new Client($this->connectionString);
    }

    /**
     * @inheritDoc
     */
    public static function setConfig(string $config): MongoDB
    {
        $instance = new self();
        $config = json_decode($config, false);
        $instance->connectionString = $config->connectionString;

        // Create a mongodb client with the updated connection string
        $instance->mongoClient = new Client($instance->connectionString);

        return $instance;
    }

    public function addArticles(string $json): string
    {
        // Decode the input JSON string to an array of documents
        $documents = json_decode($json, true);

        // Insert the documents into the mongodb collection
        $result = $this->mongoClient->selectCollection('your_collection_name')->insertMany($documents);

        // Return the inserted document IDs as a JSON string
        return json_encode($result->getInsertedIds());
    }

    public function getArticle(string $articles, string $document): array
    {
        // Query the mongodb collection to get a single document by its ID
        $result = $this->mongoClient->selectCollection('your_collection_name')->findOne(['_id' => $document]);

        // Return the result as an array
        return json_decode(json_encode($result), true);
    }

    public function updateArticles(string $json): string
    {
        // Decode the input JSON string to an array of documents
        $documents = json_decode($json, true);

        // Loop through the documents and update them in the mongodb collection
        foreach ($documents as $document) {
            $filter = ['_id' => $document['_id']];
            $update = ['$set' => $document];
            $this->mongoClient->selectCollection('your_collection_name')->updateOne($filter, $update);
        }

        // Return a success message
        return json_encode(['message' => 'Articles updated successfully']);
    }

    public function deleteArticles(): string
    {
        // Delete all documents in the mongodb collection
        $result = $this->mongoClient->selectCollection('your_collection_name')->deleteMany([]);

        // Return the number of documents deleted as a JSON string
        return json_encode(['count' => $result->getDeletedCount()]);
    }

    public function getConfig(): string
    {
        // TODO: Implement getConfig() method.
    }

    public function getArticles(string $json): string
    {
        // TODO: Implement getArticles() method.
    }

    public function getArticlesByID(string $json): string
    {
        // TODO: Implement getArticlesByID() method.
    }

    public function moveArticles(string $json): string
    {
        // TODO: Implement moveArticles() method.
    }
}

