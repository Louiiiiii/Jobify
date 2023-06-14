<?php 

    session_start();
    
    $_SESSION["current_user_email"] = "j.p@g.com";
    $_SESSION["current_user_pwhash"] = "b7c3bd1e3976deb58236e6fb91da0cd5f4b0c2f6290cdc2b6f17c6da88d000420ec2d5d73b3e1e8ae14cafeabafe117a58060f427a66bdab1b97cf2d52aa0a94";
    $_SESSION["current_user_id"] = 3;

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

    <form class="form" action="" method="post">

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
                <label class="label">Firstname</label>
                <div class="control">
                    <input name="firstname" class="input disabling" type="text" placeholder="Firstname" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Lastname</label>
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
                    <select class="disabling" name="degree" required disabled>
                        <option value="highest">Highest Degree</option>
                    </select>
                </div>
            </div>
            <div class="field"></div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Industry</label>
                <div class="select">
                    <select class="disabling" name="industry" required disabled>
                        <option value="industry">Industry</option>
                    </select>
                </div>
            </div>
            <div class="field"></div>
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
            <button type="button" class="button" onclick="cancel()">Cancel</button>
            <button class="button is-link">Change</button>
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
                    <!--
                    <tr>
                        <th>1</th>
                        <td>Lebenslauf</td>
                        <td>.docx</td>
                        <td>CV</td>
                        <td>
                            <button class="button is-danger is-outlined is-rounded" type="button">
                                <span class="icon is-small">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>LAP Zeugnis</td>
                        <td>.pdf</td>
                        <td>Resumee</td>
                        <td>
                            <button class="button is-danger is-outlined is-rounded" type="button">
                                <span class="icon is-small">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td>Matura Zeugnis</td>
                        <td>.png</td>
                        <td>Resumee</td>
                        <td>
                            <button class="button is-danger is-outlined is-rounded" type="button">
                                <span class="icon is-small">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                    -->
                </tbody>
            </table>
        </div>
    </div>

    <form action="">

        <div class="row">
            <div class="field is-justify-content-left">
                <div class="file has-name">
                    <label class="file-label">
                        <input class="file-input" type="file" name="resume">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Choose a file…
                            </span>
                        </span>
                        <span class="file-name">
                            file name
                        </span>
                    </label>
                </div>
            </div>
        </div>

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