<?php 
    // Call Required Files
    require_once './app/config/config.php';
    require_once './app/core/database.php';
    require_once './app/classes/Upload.php';
    require_once './app/classes/Validate.php';
    require_once './app/core/controller.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculate Uploaded CSV File</title>
    <!-- CSS Files -->
    
    <!-- Bootstrap Css File - Version 5 -->
    <link rel="stylesheet" href="./assets/css/libs/bootstrap.css">
    <!-- Main Css File -->
    <link rel="stylesheet" href="./assets/css/custom/style.css">
</head>
<body>
    

    <div class="container">
            <div class="row justify-content-center">

                <h1 class='text-center text-capitalize mt-3 py-3'>Calculate CSV file data</h1>

                <!-- Start Response Message -->
                <div id="message" class='col-sm-12 col-md-8 p-0'>
                    <?php 
                        
                        if(isset($response) && !empty($response)){
                            if($response['success']){
                                if(is_array($response['content'])){
                                    echo "<p class='message success'>File Uploaded And Calculated Successfully !<p>";
                                }else{
                                    echo "<p class='message success'>". $response['content'] ."!<p>";
                                }
                            }else{
                                echo "<p class='message failed'>". $response['content'] ."!<p>";
                            }
                        }
                    ?>
                </div>
                <!-- End Response Message -->

                <!-- Start Submit Uploaded File Form -->
                <form action="" method='POST' id="upload_csv" class='upload-file col-sm-12 col-md-8 p-0' enctype='multipart/form-data'>
                    <h4> <label for="csv_file">Upload CSV file</label></h4>
                    <input class='csv_file my-2' type="file" name='csv_file' id='csv_file'>
                    <input class='btn my-2 text-capitalize' type="submit" value='upload & calculate' name="upload" id="upload">
                </form>
                <!-- End Submit Uploaded File Form -->
        
                <!-- Start Table -->
                <table class='content-table col-sm-12 col-md-8'>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class='body-content'>
                        <!-- Start Table Body -->
                        <?php 

                            // Handle Response
                            if(isset($response) && !empty($response) ){
                                if($response['success']){

                                    // Display Calculated Resualt
                                    foreach($response['content'] as $tableRow){
                                        echo '<tr>';
                                            echo '<td>' . $tableRow[0] . '</td>';
                                            echo '<td>' . $tableRow[1] . '</td>';
                                        echo '</tr>';
                                    }

                                }
                            }
                        ?>
                        <!-- End Table Body -->
                    </tbody>

                </table>
                <!-- End Table  -->

                <!-- Start Download Divesion -->
                <div class="downloadFile col-sm-12 col-md-8 p-0 text-capitalize">
                    <?php 
                        // Display Download Link If The Response True
                        if(isset($response) && !empty($response)){
                            if($response['success']){                         
                                ?>
                                    <form action="" method='POST'>
                                        <input class='btn success' type="submit" value='Download Report' name='download'>
                                    </form>
                                <?php
                            }
                        }
                    ?>
                </div>
                <!-- End Download Divesion -->

            </div>
    </div>

    <!-- Javascript Files -->
    <!-- <script src='./assets/js/libs/jquery.js'></script> -->
    <script src='./assets/js/custom/main.js'></script>
</body>
</html>