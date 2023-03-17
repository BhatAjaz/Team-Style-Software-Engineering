<?php

namespace php\firestore;


use backend\php\firestore\Firestore;
use backend\php\firestore\interfaces\Firestore_interface;
use PHPUnit\Framework\TestCase;
use backend\php\util\Container;

class FirestoreTest extends TestCase
{
    private Firestore_interface $firestore;

    protected function setUp(): void
    {
        $container = Container::getInstance();
        $this->firestore = $container->resolve(Firestore_interface::class);
    }
    public function testGetArticle()
    {
        $article = $this->firestore->getArticle("Articles","nRcGBJdO5l1KU");
        //$article = $this->firestore->cries();
        $this->assertNotEmpty($article);
    }

    public function test__construct()
    {
        $this->assertInstanceOf(Firestore::class, $this->firestore);
    }
}
