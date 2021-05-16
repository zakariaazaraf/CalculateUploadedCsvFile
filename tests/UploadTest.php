<?php

    use PHPUnit\Framework\TestCase;

    define('DB_HOST', 'localhost'); //Add your db host
    define('DB_USER', 'root'); // Add your DB root
    define('DB_PASS', ''); //Add your DB pass
    define('DB_NAME', 'uploadcsv'); //Add your DB Name

    $upload = new Upload();

    class UploadTest extends TestCase{
        
        /* public function testparseCsvFileToArray(){
            
            $upload = new Upload();
            $filename = "assets/test.csv";

            $parseCsvFile = $upload->parseCsvFileToArray($filename);
            print_r($parseCsvFile);

            //$this->assertIsArray($parseCsvFile);

        } */
       
        public function testisValidLineFormat(){

            $upload = new Upload();

            $isValidLineFormat = $upload->isValidLineFormat(3, array('category', 1.6, 3));

            $this->assertEquals(true, $isValidLineFormat);

        }

        /* public function testcalculateCsvArray(){
            $data = array(
                array('Hotel', 10, 2),
                array('Fuel', 1.21, 24),
                array('Food', 31, 6),
                array('Hotel', 10, 2),
                array('Fuel', 1.21, 24)
            )
            $upload->calculateCsvArray($data);
            
        } */

        public function testinsertRecord(){

            $upload = new Upload();

            $record = array('Hotel', 1.7, 23);

            $isInserted = $upload->insertRecord($record);

            $this->assertEquals(true, $isInserted);
        }

        public function testinsertAllRecords(){

            $upload = new Upload();

            $parsedCsvFileAsArray = array(
                array('cat1', 10, 2),
                array('cat2', 1.21, 24),
                array('cat3', 31, 6),
                array('cat4', 10, 2),
                array('cat4', 1.21, 24)
            );
            $isRecorsInserted = $upload->insertAllRecords($parsedCsvFileAsArray);

            $this->assertEquals(true, $isRecorsInserted);

        }

        public function testgetAllRecords(){

            $upload = new Upload();

            $result = $upload->getAllRecords();

            $this->assertIsArray($result);
        }

        public function testtruncateTable(){
            $upload = new Upload();

            $isTableTruncated = $upload->truncateTable();

            $this->assertEquals(true, $isTableTruncated);
        }

    }