<?php 
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/website/classes/getClasses.php';

    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $pw = $_POST["password"];

        if (User::doesemailexist($email) == false) {
            echo "<script>alert('E-Mail does not exist, please sign up first.');</script>";
            echo '<script>window.location.replace(location.protocol + "//" + location.host + "/source/view/login/signup.php");</script>';
            exit;
        } else {
            if(User::validateCredentials($email, $pw) == true) {
                $user = new User($email, $pw);
                $pwhash = $user->passwordhash;
                $user_id = $user->getUser_id();

                $_SESSION["current_user_email"] = $email;
                $_SESSION["current_user_pwhash"] = $pwhash;
                $_SESSION["current_user_id"] = $user_id;

                $user_is = $user->isUserCompanyOrApplicant();
                
                if ($user_is == "Company") {
                    echo '<script>window.location.replace(location.protocol + "//" + location.host + "/website/company/pages/company_profile.php");</script>';
                } else {
                    echo '<script>window.location.replace(location.protocol + "//" + location.host + "/website/applicant/pages/applicant_profile.php");</script>';
                }

            } else {
                echo "<script>alert('E-Mail or Password wrong!');</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../source/css/bulma.css">
    <link rel="stylesheet" href="../source/css/login_signup.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body>
    <div class="card">
        <p class="title is-2">Login</p>
        <div class="card-content">
            <div class="card-content__login">
                <form action="./login.php" method="post">
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
                            <input name="password" class="input" type="password" placeholder="Password" required>
                            <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <a>Forgot password?</a>
                    </div>
                    <div class="field">
                        <button type="submit" class="button is-primary">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-content__signup">
                <div class="signup">
                    Not a member? 
                    <a href="signup.php">Signup now</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>