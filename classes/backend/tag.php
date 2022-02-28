<?php

namespace PUBS\Admin {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class Tag extends \PUBS\Tag implements \JsonSerializable
    {
        public function __construct($tag = null)
        {
            if ($tag != null) {
                $this->id = $tag->id;
                $this->tag = $tag->tag;
            }
        }

        public function Create($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {
                PUBSUTILS::$db->insert('tag', array(
                    'id' => $this->id,
                    'tag' => $this->tag
                ));
                $this->id = PUBSUTILS::$db->insertId();
                $tag = Tag::Get($this->id);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Tag_Create_Error', $e->getMessage());
            }
            return [
                'data' => $tag
            ];
        }

        public function Delete()
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {
                PUBSUTILS::$db->query(
                    "DELETE 
                        from tag 
                    WHERE id=%i",
                    $this->id
                );
                $counter = PUBSUTILS::$db->affectedRows();
            } catch (\MeekroDBException $e) {
                $message = $e->getMessage();
                $query = $e->getQuery();
                return new \WP_Error('Tag_Delete_Error', $e->getMessage());
            }
            return true;
        }

        public static function populatefromrow($row)
        {
            $tag = \PUBS\Tag::populatefromrow($row);

            $adminTag = new Tag($tag);

            return $adminTag;
        }
    }
}
