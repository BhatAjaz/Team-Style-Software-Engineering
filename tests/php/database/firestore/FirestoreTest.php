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

    /**
     * @return void
     * @author Beng
     */
    public function testGetArticle()
    {
        $article = $this->db->getArticle("Articles", "nRcGBJdO5l1KU");
        //$article = $this->firestore->cries();
        $this->assertNotEmpty($article);
    }

    public function testGetConfig()
    {
        $jsonobj = $this->db->getConfig();
        $arr = json_decode($jsonobj, true);

        $this->assertStringContainsString("/keys/zz-2204websiteproject-cbac90c118c2.json", $arr["keyPath"], );
        $this->assertStringContainsString("zz-2204websiteproject", $arr["projectID"]);
    }

    public function testSetConfig()
    {
        //TODO: write test for setConfig()
    }

    public function testGetArticles()
    {
        $return = $this->db->getArticles("");
        $this->assertStringContainsString("articles", $return[0]);
    }

    public function testGetArticlesByID()
    {
        $return = $this->db->getArticlesbyID("");
        $this->assertStringContainsString("articles", $return[0]);
    }

    public function testAddArticles()
    {

        $return = $this->db->addArticles("");
        $this->assertStringContainsString("articles", $return);
    }

    public function testUpdateArticles()
    {
        $return = $this->db->updateArticles("");
        $this->assertStringContainsString("articles", $return);

    }

    public function testDeleteArticles()
    {
        $return = $this->db->deleteArticles("");
        $this->assertStringContainsString("articles", $return);


    }


    public function testMoveArticles()
    {
        $return = $this->db->moveArticles("");
        $this->assertStringContainsString("articles", $return);

    }
}