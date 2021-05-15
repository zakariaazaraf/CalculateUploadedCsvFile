<?php

    
    class Upload {

        private $db;

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

            $filename = "claromentis.csv";

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);

            foreach($data as $line){
                fputcsv($filePointe, $line);
            }
            exit;
        }

        public function calculatedArray($data){
            $result = array();
            foreach($data as $line){
                $result[] = array(
                    $line->category,
                    $line->price * $line->amount
                );
            };
            return $result;
        }

        public function insertAllRecords($data){

            $this->db->query('INSERT INTO file (category, price, amount) VALUES (:category, :price, :amount)');

            $this->db->bind(':category', $data[0]);
            $this->db->bind(':price', $data[1]);
            $this->db->bind(':amount', $data[2]);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function parseCsvFileToArray(){

            $filePointer = fopen( $this->destination, 'r');

            if ( $filePointer ) {
                
                while ( $row = fgetcsv( $filePointer, '1024', ',' )) {  

                    if( $this->isValidLineFormat(3, $row)){
                        
                        if( ! $this->isCategoryExisted($row) ){
                            $this->parsedCsvData[] = array(
                                strtolower($row[0]) , // Category
                                $row[1] * $row[2]  // Price * Amount => Total                 
                            );
                        }
                    }else{
                        return false;
                    }

                }
                
                fclose( $filePointer );
                
                return $this->parsedCsvData;
            }
            
            return false;
        }

        private function isCategoryExisted($row){

            for($i = 0 ; $i < count( $this->parsedCsvData ); $i++){

                // check if the category already exists in the parsed csv array
                if( $this->parsedCsvData[$i][0] === strtolower($row[0]) ) {
                    $this->parsedCsvData[$i][1] += $row[1] * $row[2]; // Update the category's total value
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

    }
