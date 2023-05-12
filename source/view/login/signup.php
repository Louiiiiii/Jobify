
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration</title>
        <link rel="stylesheet" href="../../style/bulma.css">
        <link rel="stylesheet" href="../../style/login_signup.css">
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

                                <input class="input" type="email" placeholder="Email">

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
                                
                                <input id="password" class="input" type="password" placeholder="Password">

                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </p>
                        </div>

                        <div class="field">
                            <p class="control has-icons-left">

                                <input id="repeatpassword" class="input" type="password" placeholder="Repeat Password" oninput="checkpw()">
                                
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </p>
                            <p class="checkpasswordtext" id="checkpasswordtext"></p>
                        </div>

                        <div class="field">
                            <div class="dropdown">
                                <div class="dropdown-trigger">
                                    <button type="button" class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                        <span class="selected-item select-role">
                                            Select Role
                                        </span>
                                        <span class="icon is-small">
                                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        <a class="dropdown-item is-active">Applicant</a>
                                        <a class="dropdown-item">Company</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <button type="submit" class="button is-primary">Register</button>
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

<script src="../../scripts/dropdown.js"></script>
<script src="../../scripts/checkpassword.js"></script>