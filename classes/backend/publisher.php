<?php

namespace PUBS\Admin {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class Publisher extends \PUBS\Publisher implements \JsonSerializable
    {
        public function __construct($publisher = null)
        {
            if ($publisher != null) {
                $this->id = $publisher->id;
                $this->name = $publisher->name;
                $this->city_state = $publisher->city_state;
            }
        }

        public function Create()
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {
                PUBSUTILS::$db->insert('publisher', array(
                    'id' => $this->id,
                    'name' => $this->name,
                    'city_state' => $this->city_state
                ));
                $this->id = PUBSUTILS::$db->insertId();
                $publisher = Publisher::Get($this->id);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Publisher_Create_Error', $e->getMessage());
            }
            return $publisher;
        }

        public function Update()
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {
                PUBSUTILS::$db->update(
                    'publisher',
                    array(
                        'name' => $this->name,
                        'city_state' => $this->city_state
                    ),
                    'id=%i',
                    $this->id
                );
                $publisher = Publisher::Get($this->id);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Publisher_Update_Error', $e->getMessage());
            }
            return $publisher;
        }

        public static function populatefromrow($row)
        {
            $publisher = \PUBS\Publisher::populatefromrow($row);

            $adminPublisher = new Publisher($publisher);

            return $adminPublisher;
        }
    }
}
