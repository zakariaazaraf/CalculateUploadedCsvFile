<?php 
    
    require_once './app/config/config.php';
    require_once './app/core/database.php';
    require_once './app/classes/upload.class.php';
    require_once './app/classes/validate.class.php';
    require_once './app/core/controller.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculate Uploaded CSV File</title>
    <link rel="stylesheet" href="./assets/css/libs/dataTables.css">
    <!-- main css file -->
    <link rel="stylesheet" href="./assets/css/custom/style.css">
</head>
<body>
    
    <h1>Calculate CSV file data</h1>

    <form action="" method='POST' id="upload_csv" class='upload-file' enctype='multipart/form-data'>
        <h4> <label for="csv_file">Upload CSV file</label></h4>
        <input type="file" name='csv_file' id='csv_file'>
        <input type="submit" value='upload & calculate' name="upload" id="upload">
    </form>

    <div id="message">
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

    <table class='content-table'>
        <thead>
            <tr>
                <th>Category</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody class='body-content'>
            <?php 
                if(isset($response) && !empty($response) ){
                    if($response['success']){
                        foreach($response['content'] as $tableRow){
                            echo '<tr>';
                                echo '<td>' . $tableRow[0] . '</td>';
                                echo '<td>' . $tableRow[1] . '</td>';
                            echo '</tr>';
                        }
                    }
                }
            ?>
        </tbody>

    </table>

    <div class="downloadFile">
        <?php 
            if(isset($response) && !empty($response)){
                if($response['success']){
                    
                    echo '<a href="" >Download Report</a>';
                    
                }
            }
        ?>
    </div>
    
    <script src='./assets/js/libs/jquery.js'></script>
    <script src='./assets/js/custom/main.js'></script>
</body>
</html>