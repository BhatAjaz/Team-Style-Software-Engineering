<?php

namespace backend\php\database\dummy;

class Dummy implements \backend\php\database\DatabaseInterface
{

    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        // TODO: Implement getStatus() method.
    }

    /**
     * @inheritDoc
     */
    public function getArticles(string $json): string{
        return json_encode(array(
            "articles" => array(
                "dummy" => array(
                    "id" => "dummy",
                    "title" => "Dummy Title",
                    "img_url" => "DummyUrl",
                    "author" => "DummyAuthor",
                    "publish_date" => "DummyDate",
                    "content" => "DummyContent"
                )
            )
        ));
    }

    /**
     * @inheritDoc
     */
    public function getArticlesByID(string $json): string
    {return json_encode(array(
        "articles" => array(
            "dummy" => array(
                "id" => "dummy",
                "title" => "Dummy Title Get By ID",
                "img_url" => "DummyUrl",
                "author" => "DummyAuthor",
                "publish_date" => "DummyDate",
                "content" => "DummyContent"
            )
        )
    ));   // TODO: Implement getArticlesByID() method.
    }

    /**
     * @inheritDoc
     */
    public function addArticles(string $json): string
    {
        // TODO: Implement addArticles() method.

        return json_encode(array("result message" =>"add articles dummy called!"));
    }

    /**
     * @inheritDoc
     */
    public function moveArticles(string $json): string
    {
        // TODO: Implement moveArticles() method.

        return json_encode(array("result message" =>"move articles dummy called!"));
    }

    /**
     * @inheritDoc
     */
    public function updateArticles(string $json): string
    {
        // TODO: Implement updateArticles() method.
        return json_encode(array("result message" =>"update articles dummy called!"));
    }

    /**
     * @inheritDoc
     */
    public function deleteArticles(string $json): string
    {
        // TODO: Implement deleteArticles() method.

        return json_encode(array("result message" =>"delete articles dummy called!"));
    }
}