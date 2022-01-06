<?php

namespace PUBS {

    use PUBS\Utils as PUBSUTILS;

    class Pubs extends Pubs_Base implements \JsonSerializable
    {
        private $_id;
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

        public static function GetAll()
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $pubs = new NestedSerializable();

            try {
                $results = PUBSUTILS::$db->query("select * from rmbl_pubs");

                foreach ($results as $row) {
                    $pub = Pubs::populatefromRow($row);
                    $pubs->add_item($pub);  // Add the lesson to the collection

                }
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Sample_GetAll_Error', $e->getMessage());
            }
            return $pubs;
        }

        public static function populatefromrow($row): ?Pubs
        {
            if ($row == null)
                return null;

            $Pub = new Pubs();

            $Pub->id = $row['id'];
            $Pub->DateCreated = $row['DateCreated'];
            $Pub->DateModified = $row['DateModified'];

            return $Pub;
        }
    }
}
