<?php

namespace PUBS {

    use PUBS\Utils as PUBSUTILS;

    class Pubs extends Pubs_Base implements \JsonSerializable
    {
        private $_id;
        private $_title;
        private $_DateCreated;
        private $_DateModified;

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
        protected function title($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_title = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_title;
            }
        }
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

        public function jsonSerialize()
        {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'DateCreated' => $this->DateCreated,
                'DateModified' => $this->DateModified
            ];
        }

        public static function Get($id)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {

                $row = PUBSUTILS::$db->queryFirstRow("select * from rmbl_pubs where id = %i", $id);
                $pub = Pubs::populatefromRow($row);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Pub_Get_Error', $e->getMessage());
            }
            return $pub;
        }

        public static function GetAll($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $pubs = new NestedSerializable();

            try {
                $results = PUBSUTILS::$db->query(
                    "SELECT 
                        * 
                    FROM 
                        library
                    LIMIT %i, %i",
                    $request['skip'],
                    $request['take']
                );

                $total = PUBSUTILS::$db->query(
                    "SELECT 
                        COUNT(*)
                    FROM 
                        library"
                );

                foreach ($results as $row) {
                    $pub = Pubs::populatefromRow($row);
                    $pubs->add_item($pub);  // Add the publication to the collection
                }

            } catch (\MeekroDBException $e) {
                return new \WP_Error('Pubs_GetAll_Error', $e->getMessage());
            }

            return [
                'total' => $total[0]['COUNT(*)'],
                'data' => $pubs
            ];
        }

        public static function populatefromrow($row): ?Pubs
        {
            if ($row == null)
                return null;

            $Pub = new Pubs();

            $Pub->id = $row['id'];
            $Pub->title = $row['title'];
            $Pub->DateCreated = $row['DateCreated'];
            $Pub->DateModified = $row['DateModified'];

            return $Pub;
        }
    }
}
