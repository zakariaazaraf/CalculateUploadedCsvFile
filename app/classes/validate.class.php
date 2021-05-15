<?php

    class ValidateFile {

        private $filename;
        private $size;
        private $error;
    
        public function __construct( $file ){
            $this->filename = $file['csv_file']['name'];
            $this->size = $file['csv_file']['size'];
            $this->error = $file['csv_file']['error'];
        }
    
        public function isValidSize( $allowedSize ){

            $allowedSize = 1024 * 1024 * $allowedSize; // Convert MB to Bytes
            if( $this->size < $allowedSize){
                return true;
            }
            return false;
        }
    
        public function isValidType( $allowedTypes ){
    
            $type = pathinfo( $this->filename, PATHINFO_EXTENSION );

            if( in_array( $type, $allowedTypes ) ){
                return true;
            }
    
            return false;
        }

        public function isFileUploaded(){
            
            if( isset($file['csv_file']) ){
                return false;
            }
            if( $this->error === UPLOAD_ERR_OK ){
                return true;
            }
            return false;
        }

    }