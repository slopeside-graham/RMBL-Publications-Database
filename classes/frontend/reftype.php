<?php

namespace PUBS {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class RefType extends Pubs_Base implements \JsonSerializable
    {
        private $_id;
        private $_name;
        private $_template;
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
        protected function template($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_template = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_template;
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
                'template' => $this->template
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
                        reftype 
                    Where 
                        id = %i",
                    $id
                );
                $reftype = RefType::populatefromRow($row);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('RefType_Get_Error', $e->getMessage());
            }
            return [
                'data' => $reftype
            ];
        }

        public static function GetAll($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $reftypes = new NestedSerializable();

            try {
                $results = PUBSUTILS::$db->query(
                    "SELECT 
                        *
                    FROM 
                        reftype rt"
                );
                foreach ($results as $row) {
                    $reftype = RefType::populatefromRow($row);
                    $reftypes->add_item($reftype);  // Add the reftype to the collection
                }
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('RefType_GetAll_Error', $e->getMessage());
            }

            return [
                'data' => $reftypes
            ];
        }

        public static function populatefromrow($row): ?RefType
        {
            if ($row == null)
                return null;

            $reftype = new RefType();

            $reftype->id = $row['id'];
            $reftype->name = $row['name'];
            $reftype->template = $row['template'];
            //   $libraryitem->DateCreated = $row['DateCreated'];
            //   $libraryitem->DateModified = $row['DateModified'];

            return $reftype;
        }
    }
}
