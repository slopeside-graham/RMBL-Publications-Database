<?php

namespace PUBS {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class Publisher extends Pubs_Base implements \JsonSerializable
    {
        private $_id;
        private $_name;
        private $_city_state;
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
        protected function name($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_name = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_name;
            }
        }
        protected function city_state($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_city_state = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_city_state;
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
                'name' => $this->name,
                'city_state' => $this->city_state
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
                        publisher 
                    Where 
                        id = %i",
                    $id
                );
                $publisher = Publisher::populatefromRow($row);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Publisher_Get_Error', $e->getMessage());
            }
            return [
                'data' => $publisher
            ];
        }

        public static function GetAll($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $publishers = new NestedSerializable();

            try {
                $results = PUBSUTILS::$db->query(
                    "SELECT 
                        *
                    FROM 
                        publisher p"
                );
                foreach ($results as $row) {
                    $publisher = Publisher::populatefromRow($row);
                    $publishers->add_item($publisher);  // Add the publisher to the collection
                }
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('Publisher_GetAll_Error', $e->getMessage());
            }

            return [
                'data' => $publishers
            ];
        }

        public static function populatefromrow($row)
        {
            if ($row == null)
                return null;

            $publisher = new Publisher();

            $publisher->id = $row['id'];
            $publisher->name = $row['name'];
            $publisher->city_state = $row['city_state'];
            //   $libraryitem->DateCreated = $row['DateCreated'];
            //   $libraryitem->DateModified = $row['DateModified'];

            return $publisher;
        }
    }
}
