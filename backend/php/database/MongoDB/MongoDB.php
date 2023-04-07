<?php

namespace backend\php\database\MongoDB;

class MongoDB implements \backend\php\database\DatabaseInterface
{

    /**
     * @inheritDoc
     */
    public static function setConfig(string $config): mixed
    {
        // TODO: Implement setConfig() method.
    }

    /**
     * @inheritDoc
     */
    public function getConfig(): string
    {
        // TODO: Implement getConfig() method.
    }

    /**
     * @deprecated
     * @inheritDoc
     */
    public function getArticle(string $articles, string $document): array
    {
        // TODO: Implement getArticle() method.
    }

    /**
     * @inheritDoc
     */
    public function getArticles(string $json): array
    {
        // TODO: Implement getArticles() method.
    }

    /**
     * @inheritDoc
     */
    public function getArticlesByID(string $json): string
    {
        // TODO: Implement getArticlesByID() method.
    }

    /**
     * @inheritDoc
     */
    public function addArticles(string $json): string
    {
        // TODO: Implement addArticles() method.
    }

    /**
     * @inheritDoc
     */
    public function moveArticles(string $json): string
    {
        // TODO: Implement moveArticles() method.
    }

    /**
     * @inheritDoc
     */
    public function updateArticles(string $jsons): string
    {
        // TODO: Implement updateArticles() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteArticles(): string
    {
        // TODO: Implement deleteArticles() method.
    }
}