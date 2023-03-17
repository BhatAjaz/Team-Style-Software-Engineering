<?php


namespace backend\php\firestore;

    interface FirestoreInterface
    {
        public function getArticle(string $articles, string $document): array;
    }