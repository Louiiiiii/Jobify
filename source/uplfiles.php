<?php
    //this file is just for Julian because i implement the fileupload

    $file = $_FILES["fileToUpload"];
    $user_id = 8;

    if(uploadFile($file, $user_id)) {
        echo "<script>alert('File was uploaded succysesyfully');</script>";
    }

    function uploadFile($file, $user_id) {
        print_r($file);

        $FileFormat = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
        $allowedFileFormats = ["jpg","png","jpeg","pdf","docx","xlsx","txt"];
        
        $folderName = $user_id;
        $uplFilesDir = $_SERVER['DOCUMENT_ROOT'] . "/source/uplfiles/";
        $folderPath = $uplFilesDir . $folderName;

        $targetFilePath = $folderPath . "/" . $file["name"];


        //check file format
        foreach ($allowedFileFormats as $type) {
            if ($type == $FileFormat) {
                break;
            } else {
                echo "<script>alert('Sorry, wrong file format! (allowed formats: jpg, png, jpeg, pdf, docx, xlsx, txt)');</script>";
                return false;
            }
        }

        //check size
        if ($file["size"] > 3000000) {
            echo "<script>alert('Sorry, your file is to big! (max 3 MB)');</script>";
            return false;
        }

        // Check if folder already exists
        if (!is_dir($folderPath)) {
            mkdir($folderPath);
        }

        // Check if file already exists
        if (file_exists($targetFilePath)) {
            echo "<script>alert('Sorry, a file with this name is allready exsisting!');</script>";
            return false;
        }

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return true;
        } else {
            return false;
        }
    }
    
?>

