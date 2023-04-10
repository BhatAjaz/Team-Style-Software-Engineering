<?php

namespace backend\php\api\database;

use backend\php\api\BaseController;
use backend\php\database\DatabaseInterface;
use backend\php\util\Container;
use Error;

class ArticleController extends BaseController implements ArticleControllerInterface
{
    protected mixed $db;

    public function __construct(){
        parent::__construct();
        $this->db = $this->container->resolve(DatabaseInterface::class);
    }

    /**
     * @inheritDoc
     * @return void
     */
    public function callArticlesDatabase($function):void{
        try {
            $this->responseData = $this->db->{$function}($this->request);
        } catch (Error $e) {
            $this->strErrorDesc = $e->getMessage(). $this->setErrorDesc();
        }
        $this->response();
    }
}