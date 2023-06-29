<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/getClasses.php";            

    // Befor Submit:
    $current_user_email = $_SESSION["current_user_email"];
    $current_user_id = $_SESSION["current_user_id"];
    $current_user_pwhash = $_SESSION["current_user_pwhash"];

    //After Submit:
    if (isset($_POST["company"])) {
        //from Form
        $company = $_POST["company"];
        $slogan = $_POST["slogan"];
        $country = $_POST["country"];
        $state = $_POST["state"];
        $postalcode = $_POST["postalcode"];
        $city = $_POST["city"];
        $street = $_POST["street"];
        $streetnumber = $_POST["streetnumber"];
        $description = $_POST["description"];

        //Inserts

        //Address
        $address = new Address($street, $streetnumber, $state, $country, $postalcode, $city);
        $address->addToDB();
        
        //Company
        $company = new Company($company, $address->address_id, $slogan, $description, $current_user_id);
        $company->insertCompany();
        
        //Unset $_POST
        unset($_POST["company"]);
        unset($_POST["slogan"]);
        unset($_POST["country"]);
        unset($_POST["state"]);
        unset($_POST["postalcode"]);
        unset($_POST["city"]);
        unset($_POST["street"]);
        unset($_POST["streetnumber"]);
        unset($_POST["description"]);

        echo '<script>window.location.replace(location.protocol + "//" + location.host + "/website/company/pages/company_profile.php");</script>';
        exit;
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Company</title>
    <link rel="stylesheet" href="/website/source/css/bulma.css">
    <link rel="stylesheet" href="/website/source/css/create_user.css">
    <link rel="stylesheet" href="/website/source/css/alert.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body class="company">
    <div class="card">
        <p class="title is-2">Create Company</p>
        <div class="card-content">
            <div class="card-content__body">
                <form action="./create_user_company.php" method="post" class="form">
                    <div class="row">
                        <div class="field">
                            <label class="label">Company</label>
                            <div class="control">
                                <input name="company" class="input" type="text" placeholder="Company Name" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Slogan</label>
                            <div class="control">
                                <input name="slogan" class="input" type="text" placeholder="Slogan">
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
                            <label class="label">Description</label>
                            <textarea name="description" class="textarea has-fixed-size" placeholder="Description of the Company"></textarea>
                        </div>
                    </div>
                    <diV class="row company-submit">
                        <button type="submit" class="button is-link">Submit</button>
                    </diV>
                </form>
            </div>
        </div>
    </div>
</body>
</html>