<?php

namespace backend\php\api\database;

use backend\php\api\BaseController;
use backend\php\database\DatabaseInterface;
use backend\php\util\Container;
use Error;

class ArticleController extends BaseController implements ArticleControllerInterface
{
    private Container $ioc;
    private mixed $db;
    public function __construct(){
        $this->ioc = Container::getInstance();
        $this->db = $this->ioc->resolve(DatabaseInterface::class);
    }

    protected function response($responseData,$strErrorHeader,$strErrorDesc){
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    /**
     * @inheritDoc
     * @return void
     */
    public function getArticlesAction(): void
    {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $responseData = '';
        //This is our raw json POST data
        $data = file_get_contents("php://input");
        try {
            $responseData = $this->db->getArticles($data);
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        $this->response($responseData,$strErrorHeader,$strErrorDesc);
    }
    public function getArticlesActionDummy(): void
    {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $responseData = '';
        //This is our raw json POST data
        $data = file_get_contents("php://input");
        try {
            $responseData = json_encode(array(
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
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        $this->response($responseData,$strErrorHeader,$strErrorDesc);
    }

    /**
     * @inheritDoc
     */
    public function addArticlesAction()
    {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $responseData = '';
        //This is our raw json POST data
        $articles = file_get_contents("php://input");
        try {
            $responseData = $this->db->addArticles($articles);
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        $this->response($responseData,$strErrorHeader,$strErrorDesc);
    }

    /**
     * @inheritDoc
     */
    public function getArticlesByIDAction()
    {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $responseData = '';
        //This is our raw json POST data
        $data = file_get_contents("php://input");
        try {
            $responseData = $this->db->getArticlesByID($data);
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        $this->response($responseData,$strErrorHeader,$strErrorDesc);
    }

    /**
     * @inheritDoc
     */
    public function updateArticlesByIDAction()
    {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $responseData = '';
        //This is our raw json POST data
        $updates = file_get_contents("php://input");
        try {
            $responseData = $this->db->updateArticles($updates);
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        $this->response($responseData,$strErrorHeader,$strErrorDesc);
    }

    /**
     * @inheritDoc
     */
    public function deleteArticlesByIDAction()
    {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $responseData = '';
        //This is our raw json POST data
        $articles = file_get_contents("php://input");
        try {
            $responseData = $this->db->deleteArticles($articles);
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
        $this->response($responseData,$strErrorHeader,$strErrorDesc);
    }
}