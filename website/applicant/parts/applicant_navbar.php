<?php

    echo "<script>";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/website/source/js/navbar.js";
    echo "</script>";

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
        default:
            echo "Invalid header option";
    }
?>
<nav class="navbar is-black has-shadow" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
            <img src="/website/source/img/jobify_slogan.png">
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
                Requested Jobs
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
                    <a href="/website/applicant/pages/applicant_profile.php" class="button is-white">
                        <!--Link profile page here-->
                        <strong>Profile</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
<!--Filter -->
<form method="post">
    <div class="card">
        <header class="card-header" onclick="hide_show_something('filters'); hide_show_something('filters-footer')">
            <p class="card-header-title">Filter Jobs</p>
            <button class="card-header-icon" aria-label="more options">
      <span class="icon">
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
            </button>
        </header>
        <div class="card" id="filters" style="display: block">
            <div class="card-content">
                <div class="content">
                    <div class="columns">
                        <div class="column is-3">
                            <input class="input is-dark" type="text" placeholder="Beruf">
                        </div>
                        <div class="column is-2">
                            <div class="field">
                                <p class="control has-icons-left has-icons-right">
                                    <input class="input is-dark" type="place" placeholder="Ort">
                                    <span class="icon is-small is-left">
                          <i class="fas fa-city"></i>
                        </span>
                                </p>
                            </div>
                        </div>
                        <div class="column is-2">
                            <input class="input is-dark" type="text" placeholder="Branche">
                        </div>
                        <div class="column is-5"></div>
                    </div>
                    <div class="columns">
                        <div class="column is-1">
                            <div class="field">
                                <label class="label">Branche</label>
                                <div class="control">
                                    <div class="select is-dark"><!-- Dropdown select for industries-->
                                        <select name="industry">
                                            <?php
                                            $data = Applicant::getIndustry_Data();
                                            foreach($data as $item)
                                            {
                                                echo '<option value="'.$item[0].'">'.$item[1].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column is-2">
                            <div class="field">
                                <label class="label" for="jobtitle">Beruf</label>
                                <div class="control">
                                    <div class="select is-dark">
                                        <select name="jobtitle">
                                            <?php
                                            $data = Job::getJob_Data();
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
                        <div class="column is-2">
                            <div class="field">
                                <label class="label">Firma</label>
                                <div class="control">
                                    <div class="select is-dark">
                                        <select name="companyname">
                                            <?php
                                            $data = Company::getCompany_Data();
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
                        <div class="column is-1">
                            <label class="label" for="salaryfrom">Gehalt von</label>
                            <input class="input is-dark" name="salaryfrom" type="number" min="500" placeholder="€">
                        </div>
                        <div class="column is-1">
                            <label class="label" for="salaryto" hidden>bis</label>
                            <input class="input is-dark" name="salaryto" type="number" placeholder="€ ">
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-4">
                            <div class="buttons">
                                <button class="button is-dark is-rounded">Speichern</button>
                                <button class="button is-light">Filter zurücksetzen</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
