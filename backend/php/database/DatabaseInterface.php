<?php


namespace backend\php\database;

    interface DatabaseInterface
    {
        public function getArticle(string $articles, string $document): array;
    }