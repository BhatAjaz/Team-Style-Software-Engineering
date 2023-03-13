<?php

require_once './backend/bootstrapping.php';

use backend\php\firestore\Firestore;

$db = new Firestore();

print_r($db->getArticle("Articles","nRcGBJdO5l1KU"));