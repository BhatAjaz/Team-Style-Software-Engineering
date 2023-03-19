<?php

namespace php\firestore;


use backend\php\database\firestore\Firestore;
use backend\php\database\DatabaseInterface;
use backend\php\util\Container;
use PHPUnit\Framework\TestCase;

class FirestoreTest extends TestCase
{
    private DatabaseInterface $db;

    protected function setUp(): void
    {
        $container = Container::getInstance();
        $this->db = $container->resolve(DatabaseInterface::class);
    }
    public function testGetArticle()
    {
        $article = $this->db->getArticle("Articles","nRcGBJdO5l1KU");
        //$article = $this->firestore->cries();
        $this->assertNotEmpty($article);
    }

    public function test__construct()
    {
        $this->assertInstanceOf(Firestore::class, $this->db);
    }
}
