<?php

namespace PUBS\Admin {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class Author extends \PUBS\Author implements \JsonSerializable
    {
        public function __construct($author = null)
        {
            if ($author != null) {
                $this->id = $author->id;
                $this->peopleId = $author->peopleId;
                $this->authornumber = $author->authornumber;
                $this->libraryId = $author->libraryId;
            }
        }

        public static function updateAuthorsByLibraryId($peopleIds, $libraryid)
        {
            $authors = \PUBS\Author::GetAllByLibraryId($libraryid);
            //TODO: Does this actually need to delete entry individually or just do a DeleteAllByLibraryId()?
            foreach ($authors->jsonSerialize() as $author) {
                // Get the admin version of the Author and delete it
                $adminAuthor = new Author($author);
                $adminAuthor->Delete();
            };

            $authorNumber = 0;
            foreach ($peopleIds as $personId) {
                $authorNumber++;
                $adminAuthor = new Author;
                $adminAuthor->peopleId = $personId;
                $adminAuthor->authornumber = $authorNumber;
                $adminAuthor->libraryId = $libraryid;

                $adminAuthor->Create();
            };
        }

        public function Create()
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {
                PUBSUTILS::$db->insert('author', array(
                    'id' => $this->id,
                    'peopleId' => $this->peopleId,
                    'authornumber' => $this->authornumber,
                    'libraryId' => $this->libraryId
                ));
                $this->id = PUBSUTILS::$db->insertId();
                $author = Author::Get($this->id);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Author_Create_Error', $e->getMessage());
            }
            return $author;
        }
        public function Delete()
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {

                PUBSUTILS::$db->query("Delete from author WHERE id=%i", $this->id);
                $counter = PUBSUTILS::$db->affectedRows();
            } catch (\MeekroDBException $e) {
                $message = $e->getMessage();
                $query = $e->getQuery();
                return new \WP_Error('Author_Delete_Error', $e->getMessage());
            }
            return true;
        }

        public static function populatefromrow($row)
        {
            $author = \PUBS\author::populatefromrow($row);

            $adminAuthor = new Author($author);

            return $adminAuthor;
        }
    }
}
