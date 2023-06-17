<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/getClasses.php";

    // Before Submit:
    $current_user_email = $_SESSION["current_user_email"];
    $current_user_id = $_SESSION["current_user_id"];
    $current_user_pwhash = $_SESSION["current_user_pwhash"];

    //After Submit:
    if (isset($_POST["signup_applicant"])) {

        //from Form
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

        echo '<script>window.location.replace(location.protocol + "//" + location.host + "/website/applicant/pages/applicant_profile.php");</script>';
        exit;
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="/website/source/css/bulma.css">
    <link rel="stylesheet" href="/website/source/css/create_user.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body>
    <div class="card">
        <p class="title is-2">Applicant</p>
        <div class="card-content">
            <div class="card-content__body">
                <form action="./create_user_applicant.php" method="post" class="form">
                    <div class="row">
                        <div class="field">
                            <label class="label">Firstname</label>
                            <div class="control">
                                <input name="firstname" class="input" type="text" placeholder="Firstname" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Lastname</label>
                            <div class="control">
                                <input name="lastname" class="input" type="text" placeholder="Lastname" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Birthday</label>
                            <div class="control">
                                <input name="birthday" class="input" type="date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Country</label>
                            <div class="control">
                                <input name="country" class="input" type="text" placeholder="Country" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">State</label>
                            <div class="control">
                                <input name="state" class="input" type="text" placeholder="State" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Postal Code</label>
                            <div class="control">
                                <input name="postalcode" class="input" type="text" placeholder="Postal Code" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">City</label>
                            <div class="control">
                                <input name="city" class="input" type="text" placeholder="City" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Street</label>
                            <div class="control">
                                <input name="street" class="input" type="text" placeholder="Street" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Street Num.</label>
                            <div class="control">
                                <input name="streetnumber" class="input" type="text" placeholder="Street Number" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Highest Degree</label>
                            <div class="select">
                                <select name="education_id" required>
                                    <?php
                                        $allEducations = Applicant::getEducation_Data();

                                        foreach ($allEducations as $row) {
                                            echo '<option value="' . $row["education_id"] . '">' . $row["name"] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
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
                                            echo '<input type="checkbox" id="' . $industries[$i]["industry_id"] . '" name="industry_ids[]" value="' . $industries[$i]["industry_id"] . '">';
                                            echo '<label for="' . $industries[$i]["industry_id"] . '">' . $industries[$i]["name"] . '</label><br>';
                                            $i++;
                                        }
                                        echo '</div>';
                                    }
                                    
                                ?>
                            </div>

                        </div>    
                    </div>
                    
                    <div class="row">
                        <div class="field">
                            <label class="label">Allow Headhunting</label>
                            <label class="checkbox">
                                <input name="headhunting" type="checkbox">
                                Yes
                            </label>
                        </div>
                    </div>
                    <diV class="row">
                        <button type="submit" name="signup_applicant" class="button is-link">Submit</button>
                    </diV>
                </form>
            </div>
        </div>
    </div>
</body>
</html>