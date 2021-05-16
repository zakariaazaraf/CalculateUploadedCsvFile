<?php

    class ValidateFile {

        /** 
         *  Class Properties
         */
        private $filename;
        private $size;
        private $error;
        
        /**
         *  @param array
         *  
         *  Initiate Properties
         */
        public function __construct( $file ){
            $this->filename = $file['csv_file']['name'];
            $this->size = $file['csv_file']['size'];
            $this->error = $file['csv_file']['error'];
        }
        
        /**
         *  @param int
         * 
         *  @return bool
         *  
         *  Validate File Size
         */
        public function isValidSize( $allowedSize ){

            $allowedSize = 1024 * 1024 * $allowedSize; // Convert MB to Bytes
            if( $this->size < $allowedSize){
                return true;
            }
            return false;
        }
        
        /**
         *  @param array
         * 
         *  @return bool
         *  
         *  Validate File Type
         */
        public function isValidType( $allowedTypes ){
    
            $type = pathinfo( $this->filename, PATHINFO_EXTENSION );

            if( in_array( $type, $allowedTypes ) ){
                return true;
            }
    
            return false;
        }

        /**
         *  
         *  @return bool
         *  
         *  Check If The File Uploaded Successfully
         */
        public function isFileUploaded(){
            
            if( $this->error === UPLOAD_ERR_OK ){
                return true;
            }
            return false;
        }

    }