<?php

namespace PUBS {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class Tag extends Pubs_Base implements \JsonSerializable
    {
        private $_id;
        private $_tag;
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
        protected function tag($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_tag = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_tag;
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
                'tag' => $this->tag,
                'records' => $this->records
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
                        tag 
                    Where 
                        id = %i",
                    $id
                );
                $tag = Tag::populatefromRow($row);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Tag_Get_Error', $e->getMessage());
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
                        tag t"
                );
                foreach ($results as $row) {
                    $tag = Tag::populatefromRow($row);
                    $records = \PUBS\Admin\Library_Has_Tag::GetTotalByTagId($tag->id);
                    $tag->records = $records;

                    $tags->add_item($tag);  // Add the author to the collection
                }
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('Tag_GetAll_Error', $e->getMessage());
            }

            return
                [
                    'data' => $tags
                ];
        }

        public static function populatefromrow($row)
        {
            if ($row == null)
                return null;

            $tag = new Tag();

            $tag->id = $row['id'];
            $tag->tag = $row['tag'];
            $tag->record = $row['records'];
            //   $libraryitem->DateCreated = $row['DateCreated'];
            //   $libraryitem->DateModified = $row['DateModified'];

            return $tag;
        }
    }
}
