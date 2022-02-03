<?php

namespace PUBS\Admin {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class People extends \PUBS\People implements \JsonSerializable
    {
        public function __construct($person = null)
        {
            if ($person != null) {
                $this->id = $person->id;
                $this->FirstName = $person->FirstName;
                $this->LastName = $person->LastName;
                $this->SuffixName = $person->SuffixName;
            }
        }

        public function Create($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {
                PUBSUTILS::$db->insert('people', array(
                    'id' => $this->id,
                    'FirstName' => $this->FirstName,
                    'LastName' => $this->LastName,
                    'SuffixName' => $this->SuffixName
                ));
                $this->id = PUBSUTILS::$db->insertId();
                $person = People::Get($this->id);
                /*
                if ($person && $request['LibraryId'] && $request['peopleIds']) {
                    $peopleIds = [];
                    $peopleIds = $request['peopleIds'];
                    array_push($peopleIds, $this->id);
                    $authors = Author::updateAuthorsByLibraryId($peopleIds, $request['LibraryId']);
                }
                */
            } catch (\MeekroDBException $e) {
                return new \WP_Error('People_Create_Error', $e->getMessage());
            }
            return [
                'data' => $person
            ];
        }

        public static function populatefromrow($row)
        {
            $person = \PUBS\People::populatefromrow($row);

            $adminPerson = new People($person);

            return $adminPerson;
        }
    }
}
