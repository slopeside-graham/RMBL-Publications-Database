<?php

namespace PUBS {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class Library extends Pubs_Base implements \JsonSerializable
    {
        private $_id;
        private $_reftypeId;
        private $_year;
        private $_title;
        private $_volume;
        private $_edition;
        private $_publisherId;
        private $_pages;
        private $_restofreference;
        private $_journalname;
        private $_journalissue;
        private $_catalognumber;
        private $_donatedby;
        private $_chaptertitle;
        private $_bookeditors;
        private $_degree;
        private $_institution;
        private $_keywords;
        private $_comments;
        private $_bn_url;
        private $_abstract_url;
        private $_fulltext_url;
        private $_pdf_url;
        private $_copyinlibrary;
        private $_RMBL;
        private $_pending;
        private $_email;
        private $_student;
        private $_authors;
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
        protected function reftypeId($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_reftypeId = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_reftypeId;
            }
        }
        protected function year($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_year = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_year;
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
        protected function volume($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_volume = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_volume;
            }
        }
        protected function edition($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_edition = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_edition;
            }
        }
        protected function publisherId($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_publisherId = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_publisherId;
            }
        }
        protected function pages($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_pages = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_pages;
            }
        }
        protected function restofreference($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_restofreference = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_restofreference;
            }
        }
        protected function journalname($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_journalname = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_journalname;
            }
        }
        protected function journalissue($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_journalissue = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_journalissue;
            }
        }
        protected function catalognumber($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_catalognumber = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_catalognumber;
            }
        }
        protected function donatedby($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_donatedby = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_donatedby;
            }
        }
        protected function chaptertitle($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_chaptertitle = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_chaptertitle;
            }
        }
        protected function bookeditors($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_bookeditors = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_bookeditors;
            }
        }
        protected function degree($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_degree = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_degree;
            }
        }
        protected function institution($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_institution = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_institution;
            }
        }
        protected function keywords($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_keywords = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_keywords;
            }
        }
        protected function comments($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_comments = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_comments;
            }
        }
        protected function bn_url($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_bn_url = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_bn_url;
            }
        }
        protected function abstract_url($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_abstract_url = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_abstract_url;
            }
        }
        protected function fulltext_url($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_fulltext_url = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_fulltext_url;
            }
        }
        protected function pdf_url($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_pdf_url = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_pdf_url;
            }
        }
        protected function copyinlibrary($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_copyinlibrary = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_copyinlibrary;
            }
        }
        protected function RMBL($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_RMBL = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_RMBL;
            }
        }
        protected function pending($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_pending = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_pending;
            }
        }
        protected function email($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_email = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_email;
            }
        }
        protected function student($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_student = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_student;
            }
        }
        protected function authors($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_authors = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_authors;
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
                'reftypeId' => $this->reftypeId,
                'reftypename' => $this->reftypename,
                'year' => $this->year,
                'title' => $this->title,
                'volume' => $this->volume,
                'edition' => $this->edition,
                'publisherId' => $this->publisherId,
                'pages' => $this->pages,
                'restofreference' => $this->restofreference,
                'journalname' => $this->journalname,
                'journalissue' => $this->journalissue,
                'catalognumber' => $this->catalognumber,
                'donatedby' => $this->donatedby,
                'chaptertitle' => $this->chaptertitle,
                'bookeditors' => $this->bookeditors,
                'degree' => $this->degree,
                'institution' => $this->institution,
                'keywords' => $this->keywords,
                'comments' => $this->comments,
                'bn_url' => $this->bn_url,
                'abstract_url' => $this->abstract_url,
                'fulltext_url' => $this->fulltext_url,
                'pdf_url' => $this->pdf_url,
                'copyinlibrary' => $this->copyinlibrary,
                'RMBL' => $this->RMBL,
                'pending' => $this->pending,
                'email' => $this->email,
                'student' => $this->student,
                'authors' => $this->authors,
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
                        library 
                    Where 
                        id = %i",
                    $id
                );
                $libraryitem = Library::populatefromRow($row);
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Library_Get_Error', $e->getMessage());
            }
            return $libraryitem;
        }

        public static function GetAll($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            // Only run if there is a filter sent inthe request.
            $filtersLogic = 'AND';
            $where = new WhereClause($filtersLogic);

            if ($request['filter']) {
                $filters = $request['filter']['filters'];
                $filtersLogic = $request['filter']['logic'];
                // Build the sql statemont for the where clause.

                foreach ($filters as $filter) {
                    $field = $filter['field'];
                    $value = $filter['value'];
                    $operator = $filter['operator'];
                    $searchType = '%ss'; // Search String set as default
                    // Only continue if the filter has any value, filters can exist with no value.
                    if ($value) {
                        // Convert operators to SQL
                        if ($operator == 'contains' || $operator == 'LIKE') {
                            $operator = 'LIKE';
                            $searchType = '%ss';
                        } else if ($operator == 'eq') {
                            $operator = '=';
                            $searchType = '%s';
                        } else if ($operator == 'gte') {
                            $operator = '>=';
                            $searchType = '%s';
                        } else if ($operator == 'lte') {
                            $operator = '<=';
                            $searchType = '%s';
                        } else {
                            $operator = $operator;
                            $searchType = '%s';
                        }
                        $where->add($field .  " " . $operator . " " . $searchType, $value);
                    }
                }
                if (empty($where->clauses)) {
                    $where->add('title LIKE %ss', ''); // Set a default Where clause whenthere are filter, but no values. Only happens if the search button is pressed with no input.
                };
            } else {
                $where->add('title LIKE %ss', ''); // Use this to set a default Where caluse when there are no filters.
            }

            $sqlSort = " ORDER BY l.year desc, reftypename asc, l.authors asc "; // Set the default sort

            if ($request['sort']) {
                $sqlSortArray = array();
                $sorts = $request['sort'];

                foreach ($sorts as $sort) {
                    $sortField = $sort['field'];
                    $sortDir = $sort['dir'];

                    array_push($sqlSortArray, "l." . $sortField . " " . $sortDir);
                }
                $sqlSort = " ORDER BY " . implode(", ", $sqlSortArray) . " ";
            }

            $limit = ($request['take']) ? intval($request['take']) : 10; // Amount of results to display
            $offset = ($request['skip']) ? intval($request['skip']) : 0; // Amount of results to skip.

            $libraryitems = new NestedSerializable();

            try {
                $results = PUBSUTILS::$db->query(
                    "SELECT 
                        l.*,
                        rt.name as reftypename
                    FROM 
                        library l
                    INNER JOIN 
                        reftype rt ON l.reftypeId = rt.id
                    WHERE %l"
                        .
                        $sqlSort // Sort Clause
                        .
                        "LIMIT %i, %i",
                    $where,
                    $offset,
                    $limit
                );
                foreach ($results as $row) {
                    $libraryitem = Library::populatefromRow($row);
                    $libraryitems->add_item($libraryitem);  // Add the publication to the collection
                }

                $total = PUBSUTILS::$db->query(
                    "SELECT 
                        COUNT(*)
                    FROM 
                        library l
                    INNER JOIN 
                        reftype rt ON l.reftypeId = rt.id
                    WHERE %l",
                    $where
                );
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('Library_GetAll_Error', $e->getMessage());
            }

            return [
                'total' => $total[0]['COUNT(*)'],
                'data' => $libraryitems
            ];
        }

        public static function populatefromrow($row): ?Library
        {
            if ($row == null)
                return null;

            $libraryitem = new Library();

            $libraryitem->id = $row['id'];
            $libraryitem->reftypeId = $row['reftypeId'];
            $libraryitem->reftypename = $row['reftypename'];
            $libraryitem->year = $row['year'];
            $libraryitem->title = $row['title'];
            $libraryitem->volume = $row['volume'];
            $libraryitem->edition = $row['edition'];
            $libraryitem->publisherId = $row['publisherId'];
            $libraryitem->pages = $row['pages'];
            $libraryitem->restofreference = $row['restofreference'];
            $libraryitem->journalname = $row['journalname'];
            $libraryitem->journalissue = $row['journalissue'];
            $libraryitem->catalognumber = $row['catalognumber'];
            $libraryitem->donatedby = $row['donatedby'];
            $libraryitem->chaptertitle = $row['chaptertitle'];
            $libraryitem->bookeditors = $row['bookeditors'];
            $libraryitem->degree = $row['degree'];
            $libraryitem->institution = $row['institution'];
            $libraryitem->keywords = $row['keywords'];
            $libraryitem->comments = $row['comments'];
            $libraryitem->bn_url = $row['bn_url'];
            $libraryitem->abstract_url = $row['abstract_url'];
            $libraryitem->fulltext_url = $row['fulltext_url'];
            $libraryitem->pdf_url = $row['pdf_url'];
            $libraryitem->copyinlibrary = $row['copyinlibrary'];
            $libraryitem->RMBL = $row['RMBL'];
            $libraryitem->pending = $row['pending'];
            $libraryitem->email = $row['email'];
            $libraryitem->student = $row['student'];
            $libraryitem->authors = $row['authors'];
            //   $libraryitem->DateCreated = $row['DateCreated'];
            //   $libraryitem->DateModified = $row['DateModified'];

            return $libraryitem;
        }
    }
}
