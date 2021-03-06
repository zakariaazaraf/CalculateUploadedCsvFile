<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $upload = new Upload();
        
        // Check if The File Uploaded
        if( isset($_FILES['csv_file']) ){
            
            $validateFile = new ValidateFile( $_FILES );
            
            if( $validateFile->isFileUploaded() ){
    
                $isValidSize = $validateFile->isValidSize(5);
                $isValidType = $validateFile->isValidType( array('csv') );
    
                if( $isValidSize && $isValidType ){
                    
                    $filename = $_FILES['csv_file']['tmp_name'];    
                    
                    $parsedCsvFile = $upload->parseCsvFileToArray($filename);
                    
                    if( $parsedCsvFile ){
                        /*
                            Truncate Table Before Each Upload
                            => To be able to upload multiple time
                        */
                        $upload->truncateTable();

                        $upload->insertAllRecords($parsedCsvFile);
    
                        $calculatedResult = $upload->calculateCsvArray($parsedCsvFile);
    
                        $response = [
                            'success' => true,
                            'content' => $calculatedResult
                        ];
    
                    }else{
                        $response = [
                            'success' => false,
                            'content' => 'Invalid File Format'
                        ];
                    }
    
                }else{
                    $response = [
                        'success' => false,
                        'content' => 'Try csv File type and less then 5 mb'
                    ];
                }
    
            }else{
                $response = [
                    'success' => false,
                    'content' => 'File Uploaed Failed'
                ];
            }
        }else{
            $response = [
                'success' => false,
                'content' => 'No File Selected'
            ];
        }

        // Check if The Request Came From The Download Link
        if( isset($_POST['download']) ){

            $records = $upload->getAllRecords();

            $calculated = $upload->calculateCsvArray($records);

            $upload->downloadFileReport($calculated);
        }
            
    }