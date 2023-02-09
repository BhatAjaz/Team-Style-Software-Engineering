<?php

namespace backend\tests\php\firestore;


use backend\php\firestore\Firestore;
use PHPUnit\Framework\TestCase;

class FirestoreTest extends TestCase
{
    private Firestore $firestore;
    protected function setUp(): void
    {
        $this->firestore = new Firestore();
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
