<?php
    include $_SERVER['DOCUMENT_ROOT'] .'/website/classes/getClasses.php';

    $current_page = basename($_SERVER['PHP_SELF']);

    $published = "";
    $applicants = "";
    $headhunting = "";

    switch ($current_page) {
        case "company_published.php":
            $published = "navbar-current-page";
            break;
        case "company_applications.php":
            $applicants = "navbar-current-page";
            break;
        case "company_headhunting.php":
            $headhunting = "navbar-current-page";
            break;
        default:
            echo "Invalid header option";
    }
?>
<nav class="navbar is-black has-shadow" id="comNavHome" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="company_published.php">
            <img src="/website/source/img/jobify_slogan_white.png">
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item  <?php echo $published ?>" href="../pages/company_published.php" >
                Published Jobs
            </a>
            <a class="navbar-item <?php echo $applicants ?>" href="../pages/company_applications.php">
                Applicants
            </a>
            <a class="navbar-item <?php echo $headhunting ?>" href="../pages/company_headhunting.php">
                Headhunting
            </a>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <button class="button is-outlined" onclick="window.location.href = '../pages/company_profile.php';">Profile</button>
                    <button class="button is-dark" href="../../mainpages/logout.php">Logout</button>
                </div>
            </div>
        </div>
    </div>
</nav>

<script src="../../source/js/navbar.js"></script>



