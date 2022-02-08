<?php

namespace PUBS\Admin {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class Library extends \PUBS\Library implements \JsonSerializable
    {

        public function __construct($library = null)
        {
            if ($library != null) {

                $this->id = $library->id;
                $this->reftypeId = $library->reftypeId;
                $this->reftypename = $library->reftypename;
                $this->year = $library->year;
                $this->title = $library->title;
                $this->volume = $library->volume;
                $this->edition = $library->edition;
                $this->publisherId = $library->publisherId;
                $this->pages = $library->pages;
                $this->restofreference = $library->restofreference;
                $this->journalname = $library->journalname;
                $this->journalissue = $library->journalissue;
                $this->catalognumber = $library->catalognumber;
                $this->donatedby = $library->donatedby;
                $this->chaptertitle = $library->chaptertitle;
                $this->bookeditors = $library->bookeditors;
                $this->degree = $library->degree;
                $this->institution = $library->institution;
                $this->keywords = $library->keywords;
                $this->comments = $library->comments;
                $this->bn_url = $library->bn_url;
                $this->abstract_url = $library->abstract_url;
                $this->fulltext_url = $library->fulltext_url;
                $this->pdf_url = $library->pdf_url;
                $this->copyinlibrary = $library->copyinlibrary;
                $this->RMBL = $library->RMBL;
                $this->pending = $library->pending;
                $this->email = $library->email;
                $this->student = $library->student;
                $this->authors = $library->authors;
                $this->authorIds = $library->authorIds;
                //   $this->DateCreated = $library->DateCreated;
                //   $this->DateModified = $library->DateModified;
            }
        }

        public static function GetAll($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            // Only run if there is a filter sent in the request.
            $filtersLogic = 'AND';
            $searchfilterwhere = new WhereClause($filtersLogic); // Set the base where caluse for returning records with filter
            //$searchfilterwhere->add('RMBL <> %s', 'F');

            $searchwhere = new WhereClause($filtersLogic); // Set the base where clause for returning totals without filter.
            //$searchwhere->add('RMBL <> %s', 'F');

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

                        if ($field == 'rt.name') {
                            $searchfilterwhere->add($field .  " " . $operator . " " . $searchType, $value);
                        } else {
                            $searchfilterwhere->add($field .  " " . $operator . " " . $searchType, $value);
                            $searchwhere->add($field .  " " . $operator . " " . $searchType, $value);
                        }
                    }
                }
            }

            $sqlSort = " ORDER BY l.year desc, reftypename asc, l.authors asc "; // Set the default sort

            if ($request['sort']) {
                $sqlSortArray = array();
                $sorts = $request['sort'];

                foreach ($sorts as $sort) {
                    $sortField = $sort['field'];
                    $sortDir = $sort['dir'];

                    array_push($sqlSortArray, $sortField . " " . $sortDir);
                }
                $sqlSort = " ORDER BY " . implode(", ", $sqlSortArray) . " ";
            }

            $limit = ($request['take']) ? intval($request['take']) : 10; // Amount of results to display
            $offset = ($request['skip']) ? intval($request['skip']) : 0; // Amount of results to skip.

            $libraryitems = new \PUBS\NestedSerializable();

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
                    $searchfilterwhere,
                    $offset,
                    $limit
                );
                foreach ($results as $row) {
                    $libraryitem = Library::populatefromRow($row);

                    //TODO: Should the below be done in SQL?
                    // Add People Names to the Library item from the authors table link. 
                    $authors = \Pubs\Author::GetAllByLibraryId($row['id']); // Get the authors for the library item.
                    $peopleArray = []; // Create an array to put in the people (authors).
                    $peopleIdsArray = []; // Create an array to hold the People Ids
                    foreach ($authors->jsonSerialize() as $author) { // Loop through authors and pull People names into People array.
                        $person = \PUBS\People::Get($author->peopleId);
                        array_push($peopleArray, $person['data']->LastName . " " . $person['data']->FirstName);
                        array_push($peopleIdsArray, $person['data']->id);
                    }
                    $authors = implode(", ", $peopleArray); // Convert People array to String.
                    $libraryitem->authors = $authors; // Assign People Names to Authors in the Library item.
                    $libraryitem->authorIds = $peopleIdsArray; // Assing the poepl ids array to the library object

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
                    $searchfilterwhere
                );

                $totalTypes = PUBSUTILS::$db->query(
                    "SELECT rt.name AS Type,
                        COUNT(l.id) AS Total
                    FROM 
                        library l
                    INNER JOIN 
                        reftype rt ON l.reftypeId = rt.id
                    WHERE %l
                    GROUP BY rt.name",
                    $searchwhere
                );
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('Library_GetAll_Error', $e->getMessage());
            }

            return [
                'total' => $total[0]['COUNT(*)'],
                'totalTypes' => $totalTypes,
                'data' => $libraryitems
            ];
        }

        
        public function Create($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {
                $tableName = 'library';
                $setArray = [
                    'reftypeId' => $this->reftypeId,
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
                    'student' => $this->student
                    // 'authors' => $this->authors,
                    // 'authorIds' => $this->authorIds
                    // 'DateCreated' => $this->DateCreatedm
                    // 'DateModified' => $this->DateModified\
                ];
                
                PUBSUTILS::$db->insert(
                    $tableName,
                    $setArray
                );
                $counter = PUBSUTILS::$db->affectedRows();
                $this->id = PUBSUTILS::$db->insertId();
                $library = Library::Get($this->id);

                 // Update the Authors Table
                 Author::updateAuthorsByLibraryId($this->authorIds, $this->id);

            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('Library_Update_Error', $e->getMessage());
            }
            return [
                'data' => $library
            ];
        }


        public function Update()
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {
                $tableName = 'library';
                $setArray = [
                    'reftypeId' => $this->reftypeId,
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
                    'student' => $this->student
                    // 'authors' => $this->authors,
                    // 'authorIds' => $this->authorIds
                    // 'DateCreated' => $this->DateCreatedm
                    // 'DateModified' => $this->DateModified\
                ];

                // Update the Authors Table
                Author::updateAuthorsByLibraryId($this->authorIds, $this->id);
                
                PUBSUTILS::$db->update(
                    $tableName,
                    $setArray,
                    'id = %i',
                    $this->id
                );
                $counter = PUBSUTILS::$db->affectedRows();

                $library = Library::Get($this->id);
            } catch (\MeekroDBException $e) {
                $query = $e->getQuery();
                return new \WP_Error('Library_Update_Error', $e->getMessage());
            }
            return [
                'data' => $library
            ];
        }

        /*
        public static function Get($row): ?Library
        {
            $library = \PUBS\Library::Get($row);

            $adminLibrary = new Library($library);

            return $adminLibrary;
        }
*/

        public static function populatefromrow($row)
        {
            $library = \PUBS\Library::populatefromrow($row);

            $adminLibrary = new Library($library);

            $adminLibrary->authorIds = $row['authorIds'];

            return $adminLibrary;
        }
    }
}
