<?php

namespace php\database\firestore;

use backend\php\database\firestore\Firestore;
use backend\php\database\DatabaseInterface;
use backend\php\util\Container;
use PHPUnit\Framework\TestCase;

class FirestoreTest extends TestCase
{
    private DatabaseInterface $db;

    /**
     * @return void
     *
     * @author Beng
     */
    protected function setUp(): void
    {
        $container = Container::getInstance();
        $this->db = $container->resolve(DatabaseInterface::class);
    }

    public function testGetConfig()
    {

    }

    /**
     * @return void
     * @author Beng
     */
    public function testGetArticle()
    {
        $article = $this->db->getArticle("Articles","nRcGBJdO5l1KU");
        //$article = $this->firestore->cries();
        $this->assertNotEmpty($article);
    }

    public function testSetConfig()
    {

    }
}
