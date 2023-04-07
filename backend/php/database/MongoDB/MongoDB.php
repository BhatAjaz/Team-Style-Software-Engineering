<?php

namespace backend\php\database\MongoDB;

use backend\php\database\DatabaseInterface;
use backend\php\util\Container;

class MongoDB implements DatabaseInterface
{
    protected Client $mongoClient;
    protected string $connectionString;
    protected ?Container $container = null;

    public function __construct()
    {
        $this->container = Container::getInstance();

        //Set the MongoDB Atlas connection string
        $this->connectionString = "mongodb+srv://SoftEngineerUBDJan2023Student:5rpMmgLIDCbaSdWR@lithubcluster0.kxu4yzq.mongodb.net/?retryWrites=true&w=majority";

        // Create a MongoDB client with the connection string
        $this->mongoClient = new Client($this->connectionString);
    }

    /**
     * @inheritDoc
     */
    public static function setConfig(string $config): MongoDB
    {
        // TODO: Implement setConfig() method.
        $instance = new self();
        $config = json_decode($config, false);
        $instance->connectionString = $config->connectionString;

        //Create a MongoDB client with the updated connection string
        $instance->mongoClient = new Client($instance->connectionString);

        return $instance;
    }

    public function addArticles(string $json): string
    {
        // TODO: Implement addArticles() method.
    }

    public function getConfig(): string
    {
        // TODO: Implement getConfig() method.
    }

    public function getArticle(string $articles, string $document): array
    {
        // TODO: Implement getArticle() method.
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

    public function updateArticles(string $jsons): string
    {
        // TODO: Implement updateArticles() method.
    }

    public function deleteArticles(): string
    {
        // TODO: Implement deleteArticles() method.
    }
}
