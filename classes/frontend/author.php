<?php

namespace PUBS {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class Author extends Pubs_Base implements \JsonSerializable
    {
        private $_id;
        private $_peopleId;
        private $_authornumber;
        private $_libraryId;
        // private $_DateCreated;
        // private $_DateModified;

        protected function id($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_id = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_id;
            }
        }
        protected function peopleId($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_peopleId = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_peopleId;
            }
        }
        protected function authornumber($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_authornumber = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_authornumber;
            }
        }
        protected function libraryId($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_libraryId = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_libraryId;
            }
        }

        /*
        protected function DateCreated($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_DateCreated = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_DateCreated;
            }
        }
        protected function DateModified($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_DateModified = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_DateModified;
            }
        }
        */
        public function jsonSerialize()
        {
            return [
                'id' => $this->id,
                'peopleId' => $this->peopleId,
                'authornumber' => $this->authornumber,
                'libraryId' => $this->libraryId
                //  'DateCreated' => $this->DateCreated,
                //  'DateModified' => $this->DateModified
            ];
        }

        public static function Get($id)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {

                $row = PUBSUTILS::$db->queryFirstRow(
                    "SELECT
                        * 
                    From 
                        author 
                    Where 
                        id = %i",
                    $id
                );
                $author = Author::populatefromRow($row);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Author_Get_Error', $e->getMessage());
            }
            return $author;
        }

        public static function GetAll($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $authors = new NestedSerializable();

            try {
                $results = PUBSUTILS::$db->query(
                    "SELECT 
                        *
                    FROM 
                        author a"
                );
                foreach ($results as $row) {
                    $author = Author::populatefromRow($row);
                    $authors->add_item($author);  // Add the author to the collection
                }
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('Author_GetAll_Error', $e->getMessage());
            }

            return $authors;
        }

        public static function GetAllByLibraryId($id)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $authors = new NestedSerializable();

            try {
                $results = PUBSUTILS::$db->query(
                    "SELECT 
                        *
                    FROM 
                        author a
                    WHERE
                        libraryId = %i
                    ORDER BY authornumber asc",
                    $id
                );
                foreach ($results as $row) {
                    $author = Author::populatefromRow($row);
                    $authors->add_item($author);  // Add the author to the collection
                }
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('Author_GetAll_Error', $e->getMessage());
            }

            return $authors;
        }

        public static function populatefromrow($row)
        {
            if ($row == null)
                return null;

            $author = new Author();

            $author->id = $row['id'];
            $author->peopleId = $row['peopleId'];
            $author->authornumber = $row['authornumber'];
            $author->libraryId = $row['libraryId'];
            //   $libraryitem->DateCreated = $row['DateCreated'];
            //   $libraryitem->DateModified = $row['DateModified'];

            return $author;
        }
    }
}
