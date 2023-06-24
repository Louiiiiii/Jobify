<?php 

    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/website/classes/getClasses.php';

    $current_user_email = $_SESSION["current_user_email"];
    $current_user_pwhash = $_SESSION["current_user_pwhash"];
    $current_user_id = $_SESSION["current_user_id"];

    //Submit Form
        if (isset($_POST["file_submit_btn"])) {
            

            
        }

    //File upload
        if (isset($_POST["file_submit_btn"])) {

            $filetype_name = $_POST["filetype_name"];

            File::uploadFile($_FILES["fileToUpload"], $filetype_name, $current_user_id, $current_user_email);

            //Unset and delete file from server
            unset($_POST);
            
            $fileToUpload = $_FILES['fileToUpload']['tmp_name'];
            
            unset($_FILES);
            
        }

    //Delete File
        if (isset($_POST["delete-file-btn"])) {

            $del_file_id = $_POST["delete-file-btn"];
            $del_file_nema = FILE::getFileName($del_file_id);

            $spawn_delete_file_modal = '
                <div class="modal is-active">
                    <div class="modal-background is-active"></div>
                    <div class="modal-content modal-content-delete-file">
                        <div class="box">
                            <form action="./company_profile.php" method="post">
                                <h1>Wollen Sie das Dokument "' . $del_file_nema . '" wirklick löschen?</h1>
                                <input type="number" name="del-file-id" value="'.$del_file_id.'" style="display: none;" readonly>
                                <br> 
                                <div class="columns">
                                    <div class="column">
                                        <button class="button is-dark" type="submit" name="now-delete-file-btn">Delete</button>
                                    </div>                              
                                    <div class="column">
                                        <button class="button is-danger" type="submit" name="reset-delete-file-btn">Cancel</button>
                                    </div>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            ';
            
        } else {

            $spawn_delete_file_modal = "";

        }
        
        if (isset($_POST["now-delete-file-btn"])) {
            $spawn_delete_file_modal = "";

            $file_deleted = FILE::delFile($_POST["del-file-id"], $current_user_id);

            if($file_deleted) {
                echo "<script>alert('Your File was deleted!');</script>";
            } else {
                echo "<script>alert('Ahhhh shit something went wrong!');</script>";
            }
        }

        if (isset($_POST["reset-delete-file-btn"])) {
            $spawn_delete_file_modal = "";
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/website/source/css/bulma.css">
    <link rel="stylesheet" href="/website/source/css/profile.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body>

    <?php 

        require_once '../parts/company_profile_navbar.php'; 

        echo $spawn_delete_file_modal;

    ?>

    <form class="form" action="./company_profile.php" >
        <div class="row">
            <div class="field">
                <figure class="image is-128x128">
                    <?php 
                        $profile_pic = File::getFile($current_user_id, "Profile Picture");
                        
                        if (is_null($profile_pic)) {
                            $profile_pic_path = "/website/source/img/user-icon.png";
                        } else {                            
                            $profile_pic_path = "/website/uplfiles/" . $current_user_id . "/" . $profile_pic["name"];
                        }
                    ?>
                    <img class="is-rounded" src="<?php echo $profile_pic_path ?>">
                </figure>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Company Name</label>
                <div class="control">
                    <input name="country" class="input disabling" type="text" placeholder="Company Name" disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Slogan</label>
                <div class="control">
                    <input name="state" class="input disabling" type="text" placeholder="Company Slogan" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <div class="field">
                    <label class="label">Description</label>
                    <div class="control">
                        <textarea  name="description" class="textarea input disabling" placeholder="Description of the Company" disabled></textarea>
                    </div>
                </div>
            </div>
            <div class="field"></div>
        </div>
        <hr class="solid">
        <div class="row">
            <div class="field">
                <label class="label" for="email">Email</label>
                <div class="control">
                    <input name="email" id="email" class="input disabling" type="text" placeholder="$user->email" disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Password</label>
                <button type="button" class="button js-modal-trigger" data-target="modal-js-example">Change Password</button>
            </div>
        </div>
        <hr class="solid">
        <div class="row">
            <div class="field">
                <label class="label">Country</label>
                <div class="control">
                    <input name="country" class="input disabling" type="text" placeholder="Country" disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">State</label>
                <div class="control">
                    <input name="state" class="input disabling" type="text" placeholder="State" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Postal Code</label>
                <div class="control">
                    <input name="postalcode" class="input disabling" type="text" placeholder="Postal Code" disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">City</label>
                <div class="control">
                    <input name="city" class="input disabling" type="text" placeholder="City" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Street</label>
                <div class="control">
                    <input name="street" class="input disabling" type="text" placeholder="Street" disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Street Num.</label>
                <div class="control">
                    <input name="streetnumber" class="input disabling" type="text" placeholder="Street Number" disabled>
                </div>
            </div>
        </div>        
        <hr class="solid">
        <diV class="row edit">
            <button type="button" class="button is-link" onclick="edit()">Edit Profile</button>
        </diV>
        <div class="row cancel hide">
            <button type="button" class="button" onclick="cancel()">Cancel</button>
            <button class="button is-link">Change</button>
        </div>
    </div>
    </form>

    <?php
        $files = File::getAllFilesByUser($current_user_id);

        if (count($files) > 0) {

    ?>

    <div class="row">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Extension</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <form action="./company_profile.php" method="post">
                        <?php 

                            foreach($files as $file) {
                                $filepath = $_SERVER['DOCUMENT_ROOT'] . "/website/uplfiles/" . $current_user_id . "/" . $file["name"];
                                
                                $name = pathinfo($filepath, PATHINFO_FILENAME);
                                $extension = '.' . pathinfo($filepath, PATHINFO_EXTENSION);

                                echo "<tr>";
                                echo "<th>" . $file["file_id"] . "</th>";
                                echo "<td>" . $name . "</td>";
                                echo "<td>" . $extension . "</td>";
                                echo "<td>" . $file["type"] . "</td>";
                                echo '
                                    <td>
                                        <button class="button is-danger is-outlined is-rounded" type="submit" name="delete-file-btn" value="' . $file["file_id"] . '" type="button">
                                            <span class="icon is-small">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                ';
                                echo "</tr>";
                            }
                        ?>
                    </form>
                </tbody>
            </table>
        </div>
    </div>

    <?php 
        } else {
            echo "<br>";
            echo "<hr>";
            echo "<h1>Sie haben keine Files hochgeladen</h1>";
            echo "<br>";
        }
    ?>

    <form action="./company_profile.php" method="post" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <label class="label">Choose upload files</label>
                <div id="file-js-example" class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="fileToUpload">
                        <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">Choose a file…</span>
                        </span>
                        <span class="file-name">Nothing selected</span>
                    </label>
                </div>
            </div>
            <div class="column">
                <label class="label">File Type:</label>
                <div class="select">
                    <select name="filetype_name" required>
                        <?php
                        $allFileTypes = File::getAllFileTypes();

                        foreach ($allFileTypes as $row) {
                            echo '<option value="' . $row["type"] . '">' . $row["type"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <button class="button" type="submit" name="file_submit">Upload File</button>
    </form>

    <div id="modal-js-example" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <form class="form">
                    <div class="row">
                        <div class="field">
                            <label class="label">Current Password</label>
                            <div class="control">
                                <input id="currentpassword" name="currentpassword" class="input" type="password" placeholder="Current Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input id="password" name="password" class="input" type="password" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Repeat Password</label>
                            <div class="control">
                                <input id="repeatpassword" name="repeatpassword" class="input" type="password" placeholder="Repeat Password" oninput="checkpw()" required> 
                            </div>
                        </div>
                    </div>
                    <div class="row checkpasswordtext">
                        <div class="field">
                            <label class="label"></label>
                            <div class="checkpasswordtext" id="checkpasswordtext"></div>
                        </div>
                    </div>
                    <div class="row">
                        <button class="button is-link">Change</button>
                    </div>
                </form>
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close"></button>
    </div>
</body>
</html>

<script>
    const fileInput = document.querySelector('#file-js-example input[type=file]');
    fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
            const fileName = document.querySelector('#file-js-example .file-name');
            fileName.textContent = fileInput.files[0].name;
        }
    }
</script>

<script src="../../source/js/hideButton.js"></script>
<script src="../../source/js/modal.js"></script>
<script src="../../source/js/checkpassword.js"></script>
<script src="../../source/js/navbar.js"></script>