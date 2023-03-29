<?php


namespace backend\php\database;

    interface DatabaseInterface
    {
        /**
         * @param array $config
         * @return mixed
         */
        public static function setConfig(array $config);

        /**
         * @return array
         */
        public function getConfig(): array;

        /**
         * @param string $articles
         * @param string $document
         * @return array
         */
        public function getArticle(string $articles, string $document): array;
    }