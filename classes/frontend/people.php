<?php

namespace PUBS {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class People extends Pubs_Base implements \JsonSerializable
    {
        private $_id;
        private $_FirstName;
        private $_LastName;
        private $_SuffixName;
        // private $_Student;
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
        protected function FirstName($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_FirstName = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_FirstName;
            }
        }
        protected function LastName($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_LastName = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_LastName;
            }
        }
        protected function SuffixName($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_SuffixName = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_SuffixName;
            }
        }
        // protected function Student($value = null)
        // {
        //     // If value was provided, set the value
        //     if ($value) {
        //         $this->_Student = $value;
        //     }
        //     // If no value was provided return the existing value
        //     else {
        //         return $this->_Student;
        //     }
        // }

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
                'FirstName' => $this->FirstName,
                'LastName' => $this->LastName,
                'SuffixName' => $this->SuffixName,
                // 'Student' => $this->Student
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
                        people 
                    Where 
                        id = %i",
                    $id
                );
                $person = People::populatefromRow($row);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('People_Get_Error', $e->getMessage());
            }
            return
                [
                    'data' => $person
                ];
        }

        public static function GetAll($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $people = new NestedSerializable();

            try {
                $results = PUBSUTILS::$db->query(
                    "SELECT 
                        *
                    FROM 
                        people p"
                );
                foreach ($results as $row) {
                    $person = People::populatefromRow($row);
                    $people->add_item($person);  // Add the author to the collection
                }
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('People_GetAll_Error', $e->getMessage());
            }

            return
                [
                    'data' => $people
                ];
        }

        public static function populatefromrow($row)
        {
            if ($row == null)
                return null;

            $person = new People();

            $person->id = $row['id'];
            $person->FirstName = $row['FirstName'];
            $person->LastName = $row['LastName'];
            $person->SuffixName = $row['SuffixName'];
            // if ($row['Student'] === 'true' || $row['Student'] === 'on') {
            //     $person->Student = 1;
            // } else if ($row['Student'] === 'false' || $row['Student'] === '') {
            //     $person->Student = 0;
            // } else {
            //     $person->Student = $row['Student'];
            // }

            //   $libraryitem->DateCreated = $row['DateCreated'];
            //   $libraryitem->DateModified = $row['DateModified'];

            return $person;
        }
    }
}
