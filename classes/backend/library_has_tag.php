<?php

namespace PUBS {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class Library_Has_Tag extends Pubs_Base implements \JsonSerializable
    {
        private $_id;
        private $_library_id;
        private $_tag_id;
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
        protected function library_id($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_library_id = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_library_id;
            }
        }
        protected function tag_id($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_tag_id = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_tag_id;
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
                'library_id' => $this->library_id,
                'tag_id' => $this->tag_id
                //  'DateCreated' => $this->DateCreated,
                //  'DateModified' => $this->DateModified
            ];
        }

        public function Create()
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {
                PUBSUTILS::$db->insert('library_has_tag', array(
                    'id' => $this->id,
                    'library_id' => $this->library_id,
                    'tag_id' => $this->tag_id
                ));
                $this->id = PUBSUTILS::$db->insertId();
                $library_has_tag = Library_Has_Tag::Get($this->id);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Library_has_Tag_Create_Error', $e->getMessage());
            }
            return [
                'data' => $library_has_tag
            ];
        }

        public function Delete()
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {

                PUBSUTILS::$db->query("Delete from library_has_tag WHERE id=%i", $this->id);
                $counter = PUBSUTILS::$db->affectedRows();
            } catch (\MeekroDBException $e) {
                $message = $e->getMessage();
                $query = $e->getQuery();
                return new \WP_Error('Library_has_Tag_Delete_Error', $e->getMessage());
            }
            return true;
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
                        library_has_tag 
                    Where 
                        id = %i",
                    $id
                );
                $tag = Tag::populatefromRow($row);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Library_Has_Tag_Get_Error', $e->getMessage());
            }
            return
                [
                    'data' => $tag
                ];
        }

        public static function GetAll($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $tags = new NestedSerializable();

            try {
                $results = PUBSUTILS::$db->query(
                    "SELECT 
                        *
                    FROM 
                        library_has_tag t"
                );
                foreach ($results as $row) {
                    $tag = Tag::populatefromRow($row);
                    $tags->add_item($tag);  // Add the author to the collection
                }
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('Library_has_Tag_GetAll_Error', $e->getMessage());
            }

            return
                [
                    'data' => $tags
                ];
        }

        public static function GetAllByLibraryId($libraryid)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $library_has_tags = new NestedSerializable();

            try {
                $results = PUBSUTILS::$db->query(
                    "SELECT 
                        *
                    FROM 
                        library_has_tag t
                    WHERE library_id = %i",
                    $libraryid
                );
                foreach ($results as $row) {
                    $library_has_tag = Library_Has_Tag::populatefromRow($row);
                    $library_has_tags->add_item($library_has_tag);  // Add the author to the collection
                }
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('Library_has_Tag_GetAll_Error', $e->getMessage());
            }

            return
                [
                    'data' => $library_has_tags
                ];
        }

        public static function updateLibraryHasTagByLibraryId($tagIds, $libraryid)
        {
            $library_has_tags = Library_Has_Tag::GetAllByLibraryId($libraryid);
            foreach ($library_has_tags['data']->jsonSerialize() as $library_has_tag) {
                $library_has_tag->Delete();
            };

            foreach ($tagIds as $tagId) {
                $library_has_tag = new Library_Has_Tag;
                $library_has_tag->library_id = $libraryid;
                $library_has_tag->tag_id = $tagId;

                $library_has_tag->Create();
            };
        }

        public static function populatefromrow($row)
        {
            if ($row == null)
                return null;

            $library_has_tag = new Library_Has_Tag();

            $library_has_tag->id = $row['id'];
            $library_has_tag->library_id = $row['library_id'];
            $library_has_tag->tag_id = $row['tag_id'];
            //   $libraryitem->DateCreated = $row['DateCreated'];
            //   $libraryitem->DateModified = $row['DateModified'];

            return $library_has_tag;
        }
    }
}
