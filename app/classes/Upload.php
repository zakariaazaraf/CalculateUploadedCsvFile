<?php

    
    class Upload {

        private $db;
        private $calculatedArray = array(); 

        public function __construct() {
            $this->db = new Database;
        }

        /**
         *  @param resource
         * 
         *  @return array 
         *  
         *  Parse CSV file to array
         */
        public function parseCsvFileToArray( $filename ){

            $parsedCsvFileAsArray = array();

            $filePointer = fopen( $filename, 'r');

            if ( $filePointer ) {
                
                while ( $line = fgetcsv( $filePointer, 1000, ',' )) {  

                    if( $this->isValidLineFormat(3, $line)){
                        $parsedCsvFileAsArray[] = array(
                            $line[0] , // Category
                            $line[1] ,  // Price 
                            $line[2]   // Amount
                        );
                        
                    }else{
                        return false;
                    }

                }
                
                fclose( $filePointer );
                
                return $parsedCsvFileAsArray;
            
            }
            
            return false;
        }

        /**
         *  @param int
         *  @param array
         * 
         *  @return bool
         *  
         *  Validate Csv Line Format
         */
        public function isValidLineFormat($columnCount, $row){
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

        /**
         *  @param array
         * 
         *  @return array
         *  
         *  Calculate Parsed CSV Array
         */
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

        /**
         *  @param array
         * 
         *  @return bool
         *  
         *  Check if the category existed and modify the total value
         */
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

        /**
         * 
         *  @return bool
         *  
         *  Truncate File Table, To Make the Progeamme Multiple Time
         */
        public function truncateTable(){

            $this->db->query('TRUNCATE TABLE file');
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        /**
         *  @param array
         * 
         *  @return bool
         *  
         *  Insert All the Lines of the File, 
         */
        public function insertAllRecords($parsedCsvFileAsArray){

            foreach($parsedCsvFileAsArray as $record){
                if(!$this->insertRecord($record)){
                    return false;
                }
            }
            return true;

        }

        /**
         *  @param array
         * 
         *  @return bool
         *  
         *  Insert The Passed Line Of a File
         */
        public function insertRecord($record){

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

        /**
         * 
         *  @return array
         *  
         *  Get the All the Line Of a File From The DB
         */
        public function getAllRecords(){
            
            $this->db->query('SELECT * FROM file');

            $results = $this->db->resultSet();

            return $results;
        }

        /**
         *  @param array
         * 
         *  @return resource
         *  
         *  Download a Report File
         */
        public function downloadFileReport($data){

            $filePointe = fopen('php://output', 'w');

            $filename = "claromentis-" . date('Y-m-d') . ".csv";

            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);

            foreach($data as $line){
                fputcsv($filePointe, $line);
            }
            exit;
        }

    }
