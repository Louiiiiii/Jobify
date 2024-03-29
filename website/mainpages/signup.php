<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/getClasses.php";

    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $pw = $_POST["password"];
        //$pw = $_POST["password"] . "haha kein login weil anderes pw";
        $role = $_POST["role"];

        if (User::doesemailexist($email) == true) {
            doAlert("E-Mail already exists, please try to login!");
        } else {
            User::insertuser($email, $pw);

            $user = new User($email, $pw);
            $pwhash = $user->passwordhash;
            $user_id = $user->getUser_id();

            $_SESSION["current_user_email"] = $email;
            $_SESSION["current_user_pwhash"] = $pwhash;
            $_SESSION["current_user_id"] = $user_id;

            if ($role == "Company") {
                echo '<script>window.location.replace(location.protocol + "//" + location.host + "/website/company/signup/create_user_company.php");</script>';
                //echo '<script>window.location.replace(location.protocol + "//" + location.host + "/website/mainpages/login.php");</script>';
                exit;
            } else if ($role == "Applicant") {
                echo '<script>window.location.replace(location.protocol + "//" + location.host + "/website/applicant/signup/create_user_applicant.php");</script>';
                //echo '<script>window.location.replace(location.protocol + "//" + location.host + "/website/mainpages/login.php");</script>';
                exit;
            }
        }

        unset($_POST["email"]);
        unset($_POST["password"]);
        unset($_POST["role"]);
    } 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration</title>
        <link rel="stylesheet" href="../source/css/bulma.css">
        <link rel="stylesheet" href="../source/css/login_signup.css">
    <link rel="stylesheet" href="/website/source/css/alert.css">
        <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    </head>
    <body>
        <div class="card">
            <p class="title is-2">Registration</p>
            <div class="card-content">
                <form action="./signup.php" method="post">
                    <div class="card-content__login">
                        <div class="field">
                            <p class="control has-icons-left has-icons-right">
                                <input name="email" class="input" type="email" placeholder="Email" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <span class="icon is-small is-right">
                                    <i class="fas fa-check"></i>
                                </span>
                            </p>
                        </div>
                        <div class="field">
                            <p class="control has-icons-left">
                                <input id="password" name="password" class="input" type="password" placeholder="Password" required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </p>
                        </div>
                        <div class="field">
                            <p class="control has-icons-left">
                                <input id="repeatpassword" name="repeatpassword" class="input" type="password" placeholder="Repeat Password" oninput="checkpw()" required> 
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </p>
                            <p class="checkpasswordtext" id="checkpasswordtext"></p>
                        </div>
                        <div class="field">
                            <div class="select">
                                <select name="role" required>
                                    <option disabled value="" selected hidden>Select Role</option>
                                    <option value="Applicant">Applicant</option>
                                    <option value="Company">Company</option>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <button type="submit" class="button is-info">Register</button>
                        </div>
                    </div>
                    <div class="card-content__signup">
                        <div class="signup">
                            Already have an Account? 
                            <a href="login.php">Log in</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

<script src="/website/source/js/dropdown.js"></script>
<script src="/website/source/js/checkpassword.js"></script>