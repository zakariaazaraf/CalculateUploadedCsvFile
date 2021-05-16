<?php

    
    class Upload {

        private $db;
        private $parsedCsvFileAsArray = array();
        private $calculatedArray = array();

        public function __construct() {
            $this->db = new Database;
        }

        public function getAllRecords(){
            $this->db->query('SELECT * FROM file');

            $results = $this->db->resultSet();

            return $results;
        }

        public function downloadFileReport($data){

            $filePointe = fopen('php://output', 'w');

            $filename = "claromentis" . date('Y-m-d') . ".csv";

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);

            foreach($data as $line){
                fputcsv($filePointe, $line);
            }
            exit;
        }

        public function calculateCsvArray($data){

            foreach($data as $line){

                if( ! $this->isCategoryExisted($line)){
                    $this->calculatedArray[] = array(
                        $line[0], // Category
                        $line[1] * $line[2] // Total = Price * Amount
                    );
                }
            };
            return $this->calculatedArray;
        }

        public function insertAllRecords(){

            foreach($this->parsedCsvFileAsArray as $record){
                if(!$this->insertRecord($record)){
                    return false;
                }
            }
            return true;
        }

        public function parseCsvFileToArray( $filename ){

            $filePointer = fopen( $filename, 'r');

            if ( $filePointer ) {
                
                while ( $line = fgetcsv( $filePointer, 1000, ',' )) {  

                    if( $this->isValidLineFormat(3, $line)){
                        
                        $this->parsedCsvFileAsArray[] = array(
                            $line[0] , // Category
                            $line[1] ,  // Price 
                            $line[2]   // Amount
                        );
                    }else{
                        return false;
                    }

                }
                
                fclose( $filePointer );
                
                return $this->parsedCsvFileAsArray;
            }
            
            return false;
        }

        private function isCategoryExisted($row){

            for($i = 0 ; $i < count( $this->calculatedArray ); $i++){
                // check if the category already exists in the parsed csv array
                if( $this->calculatedArray[$i][0] === $row[0] ) {
                    $this->calculatedArray[$i][1] += $row[1] * $row[2]; // Update the category's total value
                    return true;
                }
            }

            return false;
        }

        private function isValidLineFormat($columnCount, $row){
            if(count($row) !== $columnCount){
                return false;
            }
            if(! is_string($row[0])){
                return false;
            }
            if(! is_numeric($row[1])){
                return false;
            }
            if(! is_numeric($row[2])){
                return false;
            }
            return true;
        }

        private function insertRecord($record){

            $this->db->query('INSERT INTO file (category, price, amount) VALUES (:category, :price, :amount)');

            $this->db->bind(':category', $record[0]);
            $this->db->bind(':price', $record[1]);
            $this->db->bind(':amount', $record[2]);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function truncateTable(){

            $this->db->query('TRUNCATE TABLE file');
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

    }
