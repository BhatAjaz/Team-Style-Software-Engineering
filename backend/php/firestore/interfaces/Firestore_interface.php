<?php


namespace backend\php\firestore\interfaces;

    interface Firestore_interface
    {
        public function getArticle(string $articles, string $document): array;
    }