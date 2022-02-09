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

        public function jsonSerialize()
        {
            return [
                'RefType' => $this->RefType,
                'Total' => $this->Total,
                'Student' => $this->Student
            ];
        }

        public static function Get($request)
        {
            PUBSUTILS::$db->error_handler = false; // since we're catching errors, don't need error handler
            PUBSUTILS::$db->throw_exception_on_error = true;

            $reports = new \PUBS\NestedSerializable();

            try {

                $results = PUBSUTILS::$db->query(
                    "SELECT 
                        rt.name AS RefType,
                    COUNT(l.id) AS Total,
                    COUNT(CASE WHEN l.student = 'T' Then 1 End) as Student
                    FROM library l
                        INNER JOIN reftype rt ON l.reftypeId = rt.id
                    GROUP BY 
                        rt.name"
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

            return $report;
        }
    }
}
