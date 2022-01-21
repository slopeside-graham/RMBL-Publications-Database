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
                $this->name = $library->name;
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
                    foreach ($authors->jsonSerialize() as $author) { // Loop through authors and pull People names into People array.
                        $person = \PUBS\People::Get($author->peopleId);
                        array_push($peopleArray, $person->LastName . " " . $person->FirstName);
                    }
                    $authors = implode(", ", $peopleArray); // Convert People array to String.
                    $libraryitem->authors = $authors; // Assign People Names to Authors in the Library item.

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

        public function Update()
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            try {
                $result = PUBSUTILS::$db->query(
                    "UPDATE library 
                    SET
                        year=%i, 
                    WHERE 
                        id=%i",
                    $this->year,
                    $this->id
                );

                $counter = PUBSUTILS::$db->affectedRows();

                $library = Library::Get($this->id);
            } catch (\MeekroDBException $e) {
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
        /*
        public static function populatefromrow($row): ?Library
        {
            $library = \PUBS\Library::populatefromrow($row);

            $adminLibrary = new Library($library);


            return $adminLibrary;
        }
        */
    }
}
