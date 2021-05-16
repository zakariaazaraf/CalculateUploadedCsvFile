<?php

    use PHPUnit\Framework\TestCase;

    class ValidateTest extends TestCase{

        public function testisValidSize(){
            $file['csv_file'] = [
                'name' => 'test.csv',
                'size' => 1024 * 1024 * 4,
                'error' => 0
            ];

            $validateFile = new ValidateFile($file);

            $allowedSize = 5;
            $isValidSize = $validateFile->isValidSize($allowedSize);

            $this->assertEquals(true, $isValidSize);
        }

        public function testisValidType(){
            $file['csv_file'] = [
                'name' => 'test.csv',
                'size' => 1024 * 1024 * 4,
                'error' => 0
            ];

            $validateFile = new ValidateFile($file);
            
            $allowedTypes = array('csv');

            $isValidType = $validateFile->isValidType($allowedTypes);

            $this->assertEquals(true, $isValidType);
        }

        public function testisFileUploaded(){

            $file['csv_file'] = [
                'name' => 'test.csv',
                'size' => 1024 * 1024 * 4,
                'error' => 0
            ];

            $validateFile = new ValidateFile($file);
            

            $isFileUploaded = $validateFile->isFileUploaded();

            $this->assertEquals(true, $isFileUploaded);
        }
    }