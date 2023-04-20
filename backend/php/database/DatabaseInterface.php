<?php


namespace backend\php\database;

/**
 * The database class will accept json strings and returns the results in json
 * @author Beng
 */
    interface DatabaseInterface
    {
        /**
         * @return string Json response that details the status of the database
         * @author Beng
         */
        public function getStatus(): string;

        //TODO: Refactor the function so that users can specify the slice of the articles they want
        // e.g. I want articles 1-10 based on publish date,
        // user clicked page2 so I want to get the next 10 articles based on publish date,
        // For firebase: https://cloud.google.com/firestore/docs/query-data/query-cursors#add_a_simple_cursor_to_a_query
        // could be a separate function
        //
        //TODO: We could contemplate if there should be a way to only return specific fields such as title/author/etc
        // this reduces the strain on the network strain of sending out and receiving large amounts of data
        // could be a separate function
        /**
         * Returns articles from a section based on a given query
         *
         * Query fields:
         * from: the Article Section requested
         * (optional) noOfArticles: the number of articles to be returned
         *      default: 5
         * (optional) sortBy: the field used to sort the articles
         *      default: "title"
         * (optional) order: the order in which the articles are sorted
         *      default: "ascending"
         *
         * Returns:
         * Json array of Article arrays,
         * Each article array will have a key associated with it based on the article's ID
         * Article Array will contain the Article ID as its first field,
         * subsequent fields will depend on the fields that exists in that article
         *
         * e.g.
         * Request JSON:
         *  {
         *      from: "Crimereads",
         *      noOfArticles: 2,
         *      sortBy: "publish_date",
         *      order: "ascending"
         *  }
         *
         * Return JSON:
         *  {
         *      articles: {
         *          YhC9FJUY03km13UWybCJ:{
         *              id: "YhC9FJUY03km13UWybCJ",
         *              title: "Crimereads Title 1"
         *              img_url: "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
         *              author: "Beng",
         *              publish_date: "2023-04-07T09:58:23.687000Z",
         *              content: "Crimereads"
         *          },
         *          vG7GatbnFqHds1SiTtnB:{
         *              id:  "vG7GatbnFqHds1SiTtnB",
         *              title:  "Crimereads Title 2",
         *              img_url:  "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
         *              author:  "Beng",
         *              publish_date:  "2023-04-07T09:59:18.789000Z",
         *              content:  "Crimereads"
         *          }
         *      }
         *  }
         *
         * @param string $json query to get the articles
         * @return string json containing all the requested articles
         * @author Beng
         */
        public function getArticles(string $json): string;

        /**
         * Returns articles based on article IDs given
         *
         * Query Fields:
         * from: The article section of the article
         * id: The ID of the article
         *
         * Returns:
         * Json array of Article arrays,
         * Each article array will have a key associated with it based on the article's ID
         * Article Array will contain the Article ID as its first field,
         * subsequent fields will depend on the fields that exists in that article
         *
         * e.g.
         * Request JSON:
         *  {
         *      articles: {
         *          {
         *              from: "Crimereads",
         *              id: "vG7GatbnFqHds1SiTtnB"
         *          },
         *          {
         *              from: "Fiction and Poetry",
         *              id: "ex7UanwL6Pf5dWUKTw90"
         *          }
         *      }
         *  }
         *
         * Return JSON:
         *  {
         *      articles: {
         *          vG7GatbnFqHds1SiTtnB:{
         *              id:  "vG7GatbnFqHds1SiTtnB",
         *              title:  "Crimereads Title 2",
         *              img_url:  "https://pbs.twimg.com/media/DXtHp7zXcAIlO_n?format=jpg&name=4096x4096",
         *              author:  "Beng",
         *              publish_date:  "2023-04-07T09:59:18.789000Z",
         *              content:  "Crimereads"
         *          },
         *          ex7UanwL6Pf5dWUKTw90:{
         *              id:  "ex7UanwL6Pf5dWUKTw90",
         *              title:  "Fiction and Poetry Title 1",
         *              img_url: "https://pediaa.com/wp-content/uploads/2021/08/Books-old-books-novels-vintage-reading-library.jpg",
         *              author:  "Beng",
         *              content:  "Fiction and Poetry"
         *          }
         *      }
         *  }
         *
         * @param string $json query to get the articles
         * @return string json containing all the requested articles
         * @author Beng
         */
        public function getArticlesByID(string $json): string;

        /**
         * Add articles based on JSON given
         *
         * Add Articles JSON:
         * from: The article section that the article will be added to
         * (optional) id: The id of the new article
         *      (not recommended because it could generate user errors if id match a pre-existing id)
         *      default: random id generated by the database
         * (optional others): other fields that the article will contain
         *
         * Return:
         * Json array with a simple array stating the number of articles added
         * TODO: rework or remove the return
         *
         * e.g.
         * Add Articles JSON:
         *  {
         *      articles: {
         *          {
         *              from: "Crimereads",
         *              title: "New Crimereads",
         *              content: "Newly added article"
         *          },
         *          {
         *              from: "Fiction and Poetry",
         *              title: "New Fiction and Poetry",
         *              content: "Newly added article"
         *          },
         *          {
         *              from: "Fiction and Poetry",
         *              id: "FictionAndPoetryArticle2"
         *              title: "New Fiction and Poetry 2",
         *              content: "Newly added article"
         *              author: "Beng"
         *          }
         *      }
         *  }
         *
         * Return JSON:
         *  {
         *      result message: "added 3 articles"
         *  }
         *
         * @param string $json Add Articles Instructions
         * @return string json containing the result message
         * @author Beng
         */
        public function addArticles(string $json): string;
        /**
         * moving articles around firestore collections is not natively supported,
         * Firestore has no way to easily move articles,
         *
         * From some research,
         * we should probably try to work around this
         * rather than forcefully create a function to do this
         *
         * A possible way to implement this would be to:
         * 1. copy the contents of the whole document,
         * 2. create a new document at intended location with the content of the previous document,
         * 3. delete the old document
         *
         * note: metadata etc. would probably be lost in the process
         *
         * @param string $json
         * @return string
         * @author Beng
         */
        public function moveArticles(string $json): string;

        /**
         * Update articles based on JSON given
         *
         * Update Articles JSON:
         * from: The article section that the article is located in
         * id: The ID of the article to be updated
         * (optional others): other fields that will be added/changed in the article
         *
         * Return:
         * Json array with a simple array stating the number of articles updated
         * TODO: rework or remove the return
         *
         * e.g.
         * Updated Articles JSON:
         *  {
         *      articles: {
         *          {
         *              from: "Crimereads",
         *              id: "vG7GatbnFqHds1SiTtnB",
         *              content: "Updated content"
         *          },
         *          {
         *              from: "Fiction and Poetry",
         *              id: "ex7UanwL6Pf5dWUKTw90",
         *              title: "Updated title",
         *              note: "newly added 'note' field"
         *          }
         *      }
         *  }
         *
         * Return JSON:
         *  {
         *      result message: "updated 3 articles"
         *  }
         *
         * @param string $json Update Articles Instructions
         * @return string json containing the result message
         * @author Beng
         */
        public function updateArticles(string $json): string;

        //TODO: To prevent accidental deletes, instead of actually deleting our documents,
        // we can use the updateArticles() function to flip a boolean variable "deleted" from false to true
        // then maybe if we're keen, we can create a function that periodically
        // permanently delete documents that has been set to "deleted" for a while
        // pseudocode:
        //      if (current_date - delete_date)>(20days):
        //      $db->delete($document)

        /**
         * Deletes articles based on JSON given
         *
         * Delete Articles JSON:
         * from: The article section that the article is located in
         * id: The ID of the article to be deleted
         *
         * Return:
         * Json array with a simple array stating the number of articles deleted
         * TODO: rework or remove the return
         *
         * e.g.
         * Updated Articles JSON:
         *  {
         *      articles: {
         *          {
         *              from: "Crimereads",
         *              id: "vG7GatbnFqHds1SiTtnB",
         *          },
         *          {
         *              from: "Fiction and Poetry",
         *              id: "ex7UanwL6Pf5dWUKTw90",
         *          }
         *      }
         *  }
         *
         * Return JSON:
         *  {
         *      result message: "deleted 2 articles"
         *  }
         *
         * <b>Notes</b>
         * <p></p>
         * For Firestore:
         *      Deleting a document won't remove subcollections and subdocuments from firestore
         *      Read for more:
         *          https://firebase.google.com/docs/firestore/solutions/delete-collections#solution_delete_data_with_a_callable_cloud_function
         *
         * @param string $json Delete Articles Instructions
         * @return string json containing the result message
         * @author Beng
         */
        public function deleteArticles(string $json): string;
    }