<?php

namespace php\database;

use backend\php\database\DatabaseInterface;
use backend\php\database\firestore\Firestore;
use backend\php\util\Container;
use Google\Cloud\Firestore\FirestoreClient;
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

//        if($this->db instanceof Firestore){
//            $this->db = new Firestore($this->firebaseMocking());
//        }


    }

    /**
     * Mocking FirestoreClient returns is tedious and time-consuming. Use the emulator suite for Firebase.
     * TODO: Refactor the test class to use Firebase Emulator
     * @return void
     */
//    protected function firebaseMocking()
//    {
//        $databaseClientMock = $this->createMock(FirestoreClient::class);
//        return $databaseClientMock;
//    }

    public function testGetStatus(): void
    {
        $return = $this->db->getStatus();
        $this->assertJson($return);
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
                "YhC9FJUY03km13UWybCJ" => array(
                    "id" => "YhC9FJUY03km13UWybCJ",
                    "title" => "Crimereads Title 1",
                    "img_url" => "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
                    "author" => "Beng",
                    "publish_date" => "2023-04-07T09:58:23.687000Z",
                    "content" => "Crimereads"
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
                "YhC9FJUY03km13UWybCJ" => array(
                    "id" => "YhC9FJUY03km13UWybCJ",
                    "title" => "Crimereads Title 1",
                    "img_url" => "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
                    "author" => "Beng",
                    "publish_date" => "2023-04-07T09:58:23.687000Z",
                    "content" => "Crimereads"
                ),
                "vG7GatbnFqHds1SiTtnB" => array(
                    "id" => "vG7GatbnFqHds1SiTtnB",
                    "title" => "Crimereads Title 2",
                    "img_url" => "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
                    "author" => "Beng",
                    "publish_date" => "2023-04-07T09:59:18.789000Z",
                    "content" => "Crimereads"
                )
            )
        ));

        $return = $this->db->getArticles($get);
        $this->assertJsonStringEqualsJsonString($expected, $return);
    }
    public function testNoLimitGetArticles()
    {
        $get = json_encode(array(
            "from" => "Crimereads"
        ));

        $return = $this->db->getArticles($get);
        $this->assertJson($return);
    }
    public function testGetNoArticlesByID()
    {
        $expected = json_encode(array("articles" => array()));

        $get = json_encode(array(
            "articles" => array()
        ));
        $return = $this->db->getArticlesbyID($get);

        $this->assertJsonStringEqualsJsonString($expected, $return);
    }
    public function testGetOneArticlesByID()
    {
        $get = json_encode(array(
            "articles" => array(
                array(
                    "from" => "Crimereads",
                    "id" => "vG7GatbnFqHds1SiTtnB"
                )
            )
        ));

        $expected = json_encode(array(
            "articles" => array(
                "vG7GatbnFqHds1SiTtnB" => array(
                    "id" => "vG7GatbnFqHds1SiTtnB",
                    "title" => "Crimereads Title 2",
                    "img_url" => "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
                    "author" => "Beng",
                    "publish_date" => "2023-04-07T09:59:18.789000Z",
                    "content" => "Crimereads"
                )
            )
        ));

        $return = $this->db->getArticlesbyID($get);
        $this->assertJsonStringEqualsJsonString($expected, $return);
    }
    public function testGetMultipleArticlesByID()
    {
        $get = json_encode(array(
            "articles" => array(
                array(
                    "from" => "Crimereads",
                    "id" => "vG7GatbnFqHds1SiTtnB"
                ),
                array(
                    "from" => "Fiction and Poetry",
                    "id" => "ex7UanwL6Pf5dWUKTw90"
                )
            )
        ));

        $expected = json_encode(array(
            "articles" => array(
                "vG7GatbnFqHds1SiTtnB" => array(
                    "id" => "vG7GatbnFqHds1SiTtnB",
                    "title" => "Crimereads Title 2",
                    "img_url" => "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
                    "author" => "Beng",
                    "publish_date" => "2023-04-07T09:59:18.789000Z",
                    "content" => "Crimereads"
                ),
                "ex7UanwL6Pf5dWUKTw90" => array(
                    "id" => "ex7UanwL6Pf5dWUKTw90",
                    "title" => "Fiction and Poetry Title 1",
                    "img_url" => "https://pediaa.com/wp-content/uploads/2021/08/Books-old-books-novels-vintage-reading-library.jpg",
                    "author" => "Beng",
                    "content" => "Fiction and Poetry"
                )
            )
        ));

        $return = $this->db->getArticlesbyID($get);
        $this->assertJsonStringEqualsJsonString($expected, $return);
    }

    public function testAddNoArticles()
    {
        $add = json_encode(array(
            "articles" => array()
        ));
        $return = $this->db->addArticles($add);
        $this->assertStringContainsString("added 0 article(s)", $return);
    }

    public function testAddOneArticles()
    {
        $add = json_encode(array(
            "articles" => array(
                array(
                    "from" => "TestCollection",
                    "id" => "testDocument",
                    "title" => "test title",
                    "content" => "test content"
                )
            )
        ));

        $return = $this->db->addArticles($add);
        $this->assertStringContainsString("added 1 article(s)", $return);
    }

    public function testAddMultipleArticles()
    {
        $add = json_encode(array(
           "articles" => array(
               array(
                   "from" => "TestCollection",
                   "title" => "test title",
                   "content" => "test content"
               ),
               array(
                   "from" => "TestCollection",
                   "id" => "testDocument 2",
               ),
               array(
                   "from" => "TestCollection 2",
                   "id" => "testDocument 2",
                   "title" => "test title",
                   "content" => "test content"
               )
           )
        ));
        $return = $this->db->addArticles($add);
        $this->assertStringContainsString("added 3 article(s)", $return);
    }

    public function testUpdateNoArticles()
    {
        $update = json_encode(array(
            "articles" => array()
        ));
        $return = $this->db->updateArticles($update);
        $this->assertStringContainsString("updated 0 article(s)", $return);

    }

    public function testUpdateOneArticles()
    {
        $update = json_encode(array(
            "articles" => array(
                array(
                    "from" => "TestCollection",
                    "id" => "testDocument",
                    "content" => "updated test content"
                )
            )
        ));
        $return = $this->db->updateArticles($update);
        $this->assertStringContainsString("updated 1 article(s)", $return);

    }

    public function testUpdateMultipleArticles()
    {
        $update = json_encode(array(
            "articles" => array(
                array(
                    "from" => "TestCollection",
                    "id" => "testDocument",
                    "title" => "updated test title"
                ),
                array(
                    "from" => "TestCollection 2",
                    "id" => "testDocument 2",
                    "title" => "updated test title",
                    "content" => "updated test content"
                )
            )
        ));
        $return = $this->db->updateArticles($update);
        $this->assertStringContainsString("updated 2 article(s)", $return);

    }

    public function testDeleteNoArticles()
    {
        $delete = json_encode(array(
            "articles" => array()
        ));
        $return = $this->db->deleteArticles($delete);
        $this->assertStringContainsString("deleted 0 article(s)", $return);


    }

    public function testDeleteOneArticles()
    {
        $delete = json_encode(array(
            "articles" => array(
                array(
                    "from" => "TestCollection",
                    "id" => "testDocument"
                )
            )
        ));
        $return = $this->db->deleteArticles($delete);
        $this->assertStringContainsString("deleted 1 article(s)", $return);


    }

    public function testDeleteMultipleArticles()
    {
        $delete = json_encode(array(
            "articles" => array(
                array(
                    "from" => "TestCollection",
                    "id" => "testDocument 2"
                ),
                array(
                    "from" => "TestCollection 2",
                    "id" => "testDocument 2"
                )
            )
        ));
        $return = $this->db->deleteArticles($delete);
        $this->assertStringContainsString("deleted 2 article(s)", $return);


    }

    public function testMoveArticles()
    {
        $return = $this->db->moveArticles("");
        $this->assertStringContainsString("articles", $return);

    }
}