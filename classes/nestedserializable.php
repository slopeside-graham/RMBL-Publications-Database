<?php

namespace PUBS {
    class NestedSerializable  implements \JsonSerializable
    {
        private $elements;

        function __construct() { 
            $this->elements = array();
         }

        public function jsonSerialize()
        {
            return $this->elements;
        }

        public function add_item($value)
        {
            $this->elements[] = $value;
            return $this->elements;
        }
        public function count()
        {
            return count($this->elements);
        }
        
    }
}