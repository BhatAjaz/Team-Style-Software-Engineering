<?php

namespace php\firestore;


use backend\php\firestore\Firestore;
use backend\php\firestore\FirestoreInterface;
use backend\php\util\Container;
use PHPUnit\Framework\TestCase;

class FirestoreTest extends TestCase
{
    private FirestoreInterface $firestore;

    protected function setUp(): void
    {
        $container = Container::getInstance();
        $this->firestore = $container->resolve(FirestoreInterface::class);
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
