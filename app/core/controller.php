<?php


    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $validateFile = new ValidateFile( $_FILES );

        if( $validateFile->isFileUploaded() ){

            $isValidSize = $validateFile->isValidSize(5);
            $isValidType = $validateFile->isValidType( array('csv') );

            if( $isValidSize && $isValidType ){
                
                $upload = new Upload();
                $filename = $_FILES['csv_file']['tmp_name'];

                // Check File Format
                $parsedCsvFile = $upload->parseCsvFileToArray($filename);
                if( $parsedCsvFile ){
                    
                    $calculatedResult = $upload->calculateCsvArray($parsedCsvFile);

                    $response = [
                        'success' => true,
                        'content' => $calculatedResult
                    ];
                }else{
                    echo 'File Format Inccoredt';
                }

            }else{
                echo 'Check file type and size';
            }

        }else{
            echo 'Please Select A File';
        }
        

        /* if ( isset( $_FILES['csv_file'] ) ) {
        
            if( $_FILES['csv_file']['error'] > 0){
                
                $response = [
                    'success' => false,
                    'content' => 'Failed, Try Uploading File ' . $_FILES['csv_file']['error']
                ];
            }else{

                // instaniate validateFile object
                $fileValidation = new ValidateFile( $_FILES['csv_file'] );
                
                $size = 5;
                $supportedFileTypes = array('csv');
                
                if( $fileValidation->validateFile($size, $supportedFileTypes ) ){
                    
                    // instaniate upload object
                    $upload = new Upload( $_FILES['csv_file'] );

                    if ( ! $upload->fileExists() ) {
                        
                        if( $upload->uploadFile() ) {

                            $data = $upload->parseCsvFileToArray();

                            if($data){

                                // Genrate Downloadable file
                                $upload->createDownloadableFile();

                                $response = [
                                    'success' => true,
                                    'content' => $data,
                                    'filename' => $upload->getFileName()
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
                                'content' => 'Failed uploading file'
                            ];
                        }
                    }else {

                        $response = [
                            'success' => false,
                            'content' => $_FILES['csv_file']['name'] . ' File already exists.'
                        ];
                    }
                }else{

                    $response = [
                        'success' => false,
                        'content' => 'Try csv File type and less then 5 mb'
                    ];
                }     
            }
            echo '<pre>';
            var_dump($_FILES);
            echo '</pre>';
            
        } else {
            $response = [
                'success' => false,
                'content' => 'No File Selected'
            ];
        } */
    }
    
    
    $upload = new Upload();

    $data = array(
        'zakaria',
        6.1,
        85665
    );

    /* $upload->insertAllRecords($data);

    if( $upload->insertAllRecords($data) ){
        echo '<h3>Inserted</h3>';
    }else{
        echo '<h3>FFFFFFFFFFFFF</h3>';
    } */

    //$result = $upload->getAllRecords();

    /* if( $result ){
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    } */

    //$calculated = $upload->calculatedArray($result);

    /* if( $calculated ){
        echo '<pre>';
        print_r($calculated);
        echo '</pre>';
    } */

    //$upload->downloadFileReport($calculated);