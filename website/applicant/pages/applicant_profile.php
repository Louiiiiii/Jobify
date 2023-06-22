<?php 

    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/website/classes/getClasses.php';

    $current_user_email = $_SESSION["current_user_email"];
    $current_user_pwhash = $_SESSION["current_user_pwhash"];
    $current_user_id = $_SESSION["current_user_id"];

    if (isset($_POST["changepw"])) {
        $current_pw = $_POST["current_pw"]; 
        $new_pw = $_POST["new_pw"];
        $repeat_new_pw = $_POST["repeat_new_pw"];

        if (hash('sha512', $current_pw) == $current_user_pwhash) {

            if ($new_pw == $repeat_new_pw) {

                $user = new User($current_user_email, $current_pw);
                $user->updatePW($new_pw);

                $_SESSION["current_user_pwhash"] = hash('sha512', $new_pw);
                
                echo "<script>alert('Your new Password is set.');</script>";

            } else {
                echo "<script>alert('Your new Password is unequal.');</script>";
            }

        } else {
            echo "<script>alert('Current Password is wrong.');</script>";
        }


        unset($_POST["changepw"]);
        unset($_POST["current_pw"]);
        unset($_POST["new_pw"]);
        unset($_POST["repeat_new_pw"]);


    }
    
    if (isset($_POST["change_applicant_infos"])) {
        //from Form
        $firstname = $_POST["email"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $birthday = $_POST["birthday"];
        $country = $_POST["country"];
        $state = $_POST["state"];
        $postalcode = $_POST["postalcode"];
        $city = $_POST["city"];
        $street = $_POST["street"];
        $streetnumber = $_POST["streetnumber"];
        $education_id = $_POST["education_id"];        
        $industry_ids = $_POST["industry_ids"];     

        //pleas ignore this it is working and i dont want to change it 😘
        if (isset($_POST["headhunting"])) {
            $headhunting = $_POST["headhunting"];
        } else {
            $headhunting = "off";
        }
        
        //Inserts

        //Address
        $address = new Address($street, $streetnumber, $state, $country, $postalcode, $city);
        $address->addToDB();
        $address_id = $address->address_id;
        
        //Applicant
        if ($headhunting == "on") {
            $allow_headhunting = 1;
        } else {
            $allow_headhunting = 0;
        }

        $applicant = new Applicant(
                $firstname, 
                $lastname, 
                $birthday, 
                null, 
                $allow_headhunting, 
                $current_user_id, 
                $address_id, 
                $education_id, 
                $current_user_email, 
                null
        );

        $applicant->updateDB();
        
        //Industry
        foreach ($industry_ids as $industry_id) {
            $applicant->addApplicant_Industry($industry_id);
        }
        
        //Unset $_POST
        unset($_POST);
    } 

    if (isset($_POST["file_submit"])) {

        File::uploadFile($_FILES["fileToUpload"], $current_user_id);

        //Unset and delete file from server
        unset($_POST);
        
        $fileToUpload = $_FILES['fileToUpload']['tmp_name'];

        if (unlink($fileToUpload)) {
            echo "File deleted successfully.";
        } else {
            echo "Failed to delete the file.";
        }
        
        unset($_FILES);
        
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../../source/css/bulma.css">
    <link rel="stylesheet" href="../../source/css/profile.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body>
    <?php require_once '../parts/applicant_profile_navbar.php'; ?>

    <form class="form" action="./applicant_profile.php" method="post">

        <div class="row">
            <div class="field">
                <figure class="image is-128x128">
                    <?php 
                        $profile_pic = File::getFile($current_user_id, "Profile Picture");
                        $profile_pic_path = "/website/uplfiles/" . $current_user_id . "/" . $profile_pic["name"];

                        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . $profile_pic_path)) {
                            $profile_pic_path = "/website/source/img/user-icon.png";
                        }

                        //The result of file_exists() is cached. Use clearstatcache() to clear the cache.
                        clearstatcache();
                    ?>
                    <img class="is-rounded" src="<?php echo $profile_pic_path ?>">
                </figure>
            </div>
        </div>
        
        <div class="row">
            <div class="field">
                <label class="label">E-Mail</label>
                <div class="control">
                    <input name="email" class="input disabling" type="email" placeholder="Email" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Password</label>
                <button type="button" class="button js-modal-trigger" data-target="modal-js-example">Change Password</button>
            </div>
            </div>
        <div class="row">
            <div class="field">
                <label class="label">Vorname</label>
                <div class="control">
                    <input name="firstname" class="input disabling" type="text" placeholder="Firstname" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Nachname</label>
                <div class="control">
                    <input name="lastname" class="input disabling" type="text" placeholder="Lastname" required disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Birthday</label>
                <div class="control">
                    <input name="birthday" class="input disabling" type="date" required disabled>
                </div>
            </div>
            <div class="field"></div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Country</label>
                <div class="control">
                    <input name="country" class="input disabling" type="text" placeholder="Country" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">State</label>
                <div class="control">
                    <input name="state" class="input disabling" type="text" placeholder="State" required disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Postal Code</label>
                <div class="control">
                    <input name="postalcode" class="input disabling" type="text" placeholder="Postal Code" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">City</label>
                <div class="control">
                    <input name="city" class="input disabling" type="text" placeholder="City" required disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Street</label>
                <div class="control">
                    <input name="street" class="input disabling" type="text" placeholder="Street" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Street Num.</label>
                <div class="control">
                    <input name="streetnumber" class="input disabling" type="text" placeholder="Street Number" required disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Highest Degree</label>
                <div class="select">
                    <select class="disabling" name="education_id" required disabled>
                        <?php
                            $allEducations = Applicant::getEducation_Data();

                            foreach ($allEducations as $row) {
                                echo '<option value="' . $row["education_id"] . '">' . $row["name"] . '</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="field"></div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Industry</label>
                
                <div class="columns">
                    <?php
                        //if you have questions about the following, ask Julian 😘
                        $industries = Applicant::getIndustry_Data();
                        $count_industries = ceil(count($industries)/3);
                        $correction = ($count_industries*3)-count($industries);

                        $i = 0;

                        for ($x = 0; $x < 3; $x++) {
                            if ($x == 2) {
                                $corrector = $correction;
                            } else {
                                $corrector = 0;
                            }

                            echo '<div class="column is-one-thirds">';                                    
                            for ($j = 0; $j < $count_industries-$corrector; $j++) {
                                echo '<input class="checkbox-input disabling" type="checkbox" id="' . $industries[$i]["industry_id"] . '" name="industry_ids[]" value="' . $industries[$i]["industry_id"] . '" disabled>';
                                echo '<label for="' . $industries[$i]["industry_id"] . '">' . $industries[$i]["name"] . '</label><br>';
                                $i++;
                            }
                            echo '</div>';
                        }
                        
                    ?>
                </div>

            </div>    
        </div>
        <br>
        <div class="row">
            <div class="field">
                <label class="label">Industry test</label>
                <div class="columns">
                    <div class="container">
                        <div class="select is-multiple">
                            <select multiple size="3">
                                <?php
                                $data = Applicant::getIndustry_Data();
                                foreach ($data as $item)
                                {
                                    echo '<option value="'.$item[0].'">'.$item[1].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Allow Headhunting</label>
                <label class="checkbox">
                    <input class="checkbox-input disabling" name="headhunting" type="checkbox" disabled>
                    Yes
                </label>
            </div>  
            <div class="field"></div>
        </div>
    
        <diV class="row edit">
            <button type="button" class="button is-link" onclick="edit()">Edit Profile</button>
        </div>
        <diV class="row cancel hide">
            <button type="reset" class="button" onclick="cancel()">Cancel</button>
            <button type="submit" name="change_applicant_infos" class="button is-link">Change</button>
        </diV>
        
    </form>

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
                    <?php 
                        $files = File::getAllFilesByUser($current_user_id);

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
                                    <button class="button is-danger is-outlined is-rounded" type="button">
                                        <span class="icon is-small">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </button>
                                </td>
                            ';
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <form action="./applicant_profile.php" method="post" enctype="multipart/form-data">
        <div class="columns">
            <div class="column">
                <label class="label" for="fileToUpload">Choose a file:</label>
                <input class="button" type="file" name="fileToUpload" id="fileToUpload">        
            </div>
            <div class="column">
                <label class="label">File Type:</label>
                <div class="select">
                    <select class="" name="filetype_id" required>
                        <?php
                            $allFileTypes = File::getAllFileTypes();

                            foreach ($allFileTypes as $row) {
                                echo '<option value="' . $row["filetype_id"] . '">' . $row["type"] . '</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="column is-4"></div>
        </div>        

        <button class="button" type="submit" name="file_submit">Upload File</button>

    </form>

    <div id="modal-js-example" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <form class="form" method="post" action="./applicant_profile.php">
                    <div class="row">
                        <div class="field">
                            <label class="label">Current Password</label>
                            <div class="control">
                                <input id="currentpassword" name="current_pw" class="input" type="password" placeholder="Current Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input id="password" name="new_pw" class="input" type="password" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Repeat Password</label>
                            <div class="control">
                                <input id="repeatpassword" name="repeat_new_pw" class="input" type="password" placeholder="Repeat Password" oninput="checkpw()" required> 
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
                        <button type="submit" name="changepw" class="button is-link">Change</button>
                    </div>
                </form>
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close"></button>
    </div>
</body>
</html>

<script src="/website/source/js/hideButton.js"></script>
<script src="/website/source/js/modal.js"></script>
<script src="/website/source/js/checkpassword.js"></script>