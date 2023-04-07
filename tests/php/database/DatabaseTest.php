<?php

namespace php\database;

use backend\php\database\DatabaseInterface;
use backend\php\database\firestore\Firestore;
use backend\php\util\Container;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
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
        $testConfig = json_encode(array());

        if($this->db instanceof Firestore)
        {
            $testConfig = json_encode(array(
                "db" => "firestore",
                "keyPath" => "/keys/zz-2204websiteproject-cbac90c118c2.json",
                "projectID" => "zz-2204websiteproject"
            ));
        }

        $jsonObj = $this->db->getConfig();

        $this->assertJsonStringEqualsJsonString($testConfig, $jsonObj);
    }

    public function testSetConfig()
    {
        //TODO: write test for setConfig()
    }
    public function testGetNoArticles()
    {
        $get = json_encode(array(
            "from" => "Crimereads",
            "noOfArticles" => 0
        ));

        $expected = json_encode(array("articles" => array()));

        $return = $this->db->getArticles($get);
        $this->assertJsonStringEqualsJsonString($expected, $return);
    }

    public function testGetOneArticles()
    {
        $get = json_encode(array(
            "from" => "Crimereads",
            "noOfArticles" => 1
        ));

        $expected = json_encode(array(
            "articles" => array(
                "article1" => array(
                    "id" => "YhC9FJUY03km13UWybCJ",
                    "author" => "Beng",
                    "content" => "Crimereads",
                    "img_url" => "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
                    "publish_date" => mktime(5,58,23,4,7,2023),
                    "title" => "Crimereads Title 1"
                )
            )
        ));

        $return = $this->db->getArticles($get);
        $this->assertJsonStringEqualsJsonString($expected, $return);
    }

    public function testGetMultipleArticles()
    {
        $get = json_encode(array(
            "from" => "Crimereads",
            "noOfArticles" => 2,
            "sortBy" => "publish_date",
            "order" => "ascending"
        ));

        $expected = json_encode(array(
            "articles" => array(
                "article1" => array(
                    "id" => "YhC9FJUY03km13UWybCJ",
                    "author" => "Beng",
                    "content" => "Crimereads",
                    "img_url" => "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
                    "publish_date" => mktime(5,58,23,4,7,2023),
                    "title" => "Crimereads Title 1"
                ),
                "article2" => array(
                    "id" => "vG7GatbnFqHds1SiTtnB",
                    "author" => "Beng",
                    "content" => "Crimereads",
                    "img_url" => "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
                    "publish_date" => mktime(5,59,18,4,7,2023),
                    "title" => "Crimereads Title 2"
                )
            )
        ));

        $return = $this->db->getArticles($get);
        $this->assertJsonStringEqualsJsonString($expected, $return);
    }
    public function testGetNoArticlesByID()
    {
        $return = $this->db->getArticlesbyID("");

        $expected = json_encode(array());

        $this->assertJsonStringEqualsJsonString($expected, $return);
    }
    public function testGetOneArticlesByID()
    {
        $get = json_encode(array(
            array(
                "from" => "Crimereads",
                "id" => "vG7GatbnFqHds1SiTtnB"
            )
        ));

        $expected = json_encode(array(
            array(
                    "id" => "vG7GatbnFqHds1SiTtnB",
                    "author" => "Beng",
                    "content" => "Crimereads",
                    "img_url" => "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
                    "publish_date" => mktime(5,59,18,4,7,2023),
                    "title" => "Crimereads Title 2"
                )
            ));

        $return = $this->db->getArticles($get);
        $this->assertJsonStringEqualsJsonString($expected, $return);
    }
    public function testGetMultipleArticlesByID()
    {
        $get = json_encode(array(
            array(
                "from" => "Crimereads",
                "id" => "vG7GatbnFqHds1SiTtnB"
            ),
            array(
                "from" => "Fiction and Poetry",
                "id" => "ex7UanwL6Pf5dWUKTw90"
            )
        ));

        $expected = json_encode(array(
            array(
                    "id" => "YhC9FJUY03km13UWybCJ",
                    "author" => "Beng",
                    "content" => "Crimereads",
                    "img_url" => "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
                    "publish_date" => mktime(5,58,23,4,7,2023),
                    "title" => "Crimereads Title 1"
            ),
            array(
                "id" => "ex7UanwL6Pf5dWUKTw90",
                "author" => "Beng",
                "content" => "Fiction and Poetry",
                "img_url" => "https://pediaa.com/wp-content/uploads/2021/08/Books-old-books-novels-vintage-reading-library.jpg",
                "title" => "Fiction and Poetry Title 1"
            )
        ));

        $return = $this->db->getArticles($get);
        $this->assertJsonStringEqualsJsonString($expected, $return);
        $return = $this->db->getArticlesbyID("");
        $this->assertStringContainsString("articles", $return[0]);
    }

    public function testAddNoArticles()
    {

        $return = $this->db->addArticles("");
        $this->assertStringContainsString("articles", $return);
    }

    public function testAddOneArticles()
    {

        $return = $this->db->addArticles("");
        $this->assertStringContainsString("articles", $return);
    }

    public function testAddMultipleArticles()
    {

        $return = $this->db->addArticles("");
        $this->assertStringContainsString("articles", $return);
    }

    public function testUpdateNoArticles()
    {
        $return = $this->db->updateArticles("");
        $this->assertStringContainsString("articles", $return);

    }

    public function testUpdateOneArticles()
    {
        $return = $this->db->updateArticles("");
        $this->assertStringContainsString("articles", $return);

    }

    public function testUpdateMultipleArticles()
    {
        $return = $this->db->updateArticles("");
        $this->assertStringContainsString("articles", $return);

    }

    public function testDeleteNoArticles()
    {
        $return = $this->db->deleteArticles("");
        $this->assertStringContainsString("articles", $return);


    }

    public function testDeleteOneArticles()
    {
        $return = $this->db->deleteArticles("");
        $this->assertStringContainsString("articles", $return);


    }

    public function testDeleteMultipleArticles()
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