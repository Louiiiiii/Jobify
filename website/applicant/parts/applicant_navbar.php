<?php

    include $_SERVER['DOCUMENT_ROOT'] .'/website/classes/getClasses.php';

    $current_page = basename($_SERVER['PHP_SELF']);
    
    switch ($current_page) {
        case "applicant_overview.php":
            $overview = "navbar-current-page";
            break;
        case "applicant_applications.php":
            $applications = "navbar-current-page";
            break;
        case "applicant_favourite.php":
            $favourite = "navbar-current-page";
            break;
		case "applicant_requested.php":
			$requested = "navbar-current-page";
			break;
		case "applicant_job.php":
			break;
        default:
            echo "Invalid header option";
    }
?>
<nav class="navbar is-black has-shadow" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="applicant_overview.php">
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
            <a class="navbar-item <?php echo $overview ?>" href="../pages/applicant_overview.php">
                Available Jobs
            </a>
            <a class="navbar-item <?php echo $applications ?>" href="../pages/applicant_applications.php">
                Applications
            </a>
            <a class="navbar-item <?php echo $favourite ?>" href="../pages/applicant_favourite.php">
                Favorites
            </a>
            <a class="navbar-item <?php echo $requested ?>" href="../pages/applicant_requested.php">
                Job Offers
            </a>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                </div>
            </div>
        </div>
    </div>
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="../mainpages/logout.php" class="button is-white">
                        <strong>Log Out</strong>
                    </a>
                </div>
            </div>
            <div class="navbar-item">
                <div class="buttons">
                    <a href="applicant_profile.php" class="button is-white">
                        <!--Link profile page here-->
                        <strong>Profile</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<script src="../../source/js/navbar.js"></script>