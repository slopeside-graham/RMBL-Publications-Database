<?php

namespace PUBS\Admin {

    use MeekroDB;
    use PUBS\Utils as PUBSUTILS;
    use WhereClause;

    class Report extends \PUBS\Pubs_Base implements \JsonSerializable
    {
        private $_RefType;
        private $_Total;
        private $_Student;
        private $_year;

        protected function RefType($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_RefType = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_RefType;
            }
        }
        protected function Total($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_Total = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_Total;
            }
        }
        protected function Student($value = null)
        {
            // If value was provided, set the value
            if ($value) {
                $this->_Student = $value;
            }
            // If no value was provided return the existing value
            else {
                return $this->_Student;
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

        public function jsonSerialize()
        {
            return [
                'RefType' => $this->RefType,
                'Total' => $this->Total,
                'Student' => $this->Student,
                'year' => $this->year
            ];
        }

        public static function Get($request)
        {

            if ($request['type'] == 'year') {
                $reports = Report::GetYears($request);
            } else {

                PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
                PUBSUTILS::$db->throw_exception_on_error = true;

                $filtersLogic = 'AND';
                $searchfilterwhere = new WhereClause($filtersLogic);

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
                            $searchfilterwhere->add($field .  " " . $operator . " " . $searchType, $value);
                        }
                    }
                }

                $reports = new \PUBS\NestedSerializable();

                try {

                    $results = PUBSUTILS::$db->query(
                        "SELECT 
                        rt.name AS RefType,
                    COUNT(l.id) AS Total,
                    COUNT(CASE WHEN l.student = 'T' Then 1 End) as Student
                    FROM library l
                        INNER JOIN reftype rt ON l.reftypeId = rt.id
                    WHERE %l
                    GROUP BY 
                        rt.name",
                        $searchfilterwhere
                    );
                    foreach ($results as $row) {
                        $report = Report::populatefromRow($row);
                        $reports->add_item($report);  // Add the publisher to the collection
                    }
                } catch (\MeekroDBException $e) {
                    return new \WP_Error('Report_Get_Error', $e->getMessage());
                }
                return [
                    'data' => $reports
                ];
            }
            return $reports;
        }

        public static function GetYears()
        {

            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $reports = new \PUBS\NestedSerializable();

            try {

                $results = PUBSUTILS::$db->query(
                    "SELECT distinct year
                    FROM library l
                    order by year desc"
                );
                foreach ($results as $row) {
                    $report = Report::populatefromRow($row);
                    $reports->add_item($report);  // Add the publisher to the collection
                }
            } catch (\MeekroDBException $e) {
                return new \WP_Error('Report_Get_Error', $e->getMessage());
            }
            return [
                'data' => $reports
            ];
        }

        public static function populatefromrow($row): ?Report
        {
            if ($row == null)
                return null;

            $report = new Report();

            $report->RefType = $row['RefType'];
            $report->Total = $row['Total'];
            $report->Student = $row['Student'];
            $report->year = $row['year'];

            return $report;
        }
    }
}
