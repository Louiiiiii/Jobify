<?php
include $_SERVER['DOCUMENT_ROOT'] .'/website/classes/getClasses.php';

$current_page = basename($_SERVER['PHP_SELF']);

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
<!--Navbar Company Home -->
<nav class="navbar is-black has-shadow" id="comNavHome" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
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
                    <button class="button is-white" onclick="window.location.href = 'company_profile.php';">Profil</button>
                </div>
            </div>
        </div>
    </div>
</nav>
<!--Filter -->
<form method="post">
    <div class="card">
        <header class="card-header">
            <p class="card-header-title">Filter Applicants</p>
            <button class="card-header-icon toggleFilter" type="button" aria-label="more options" onclick="hide_show_something('filter')" >
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
            </button>
        </header>
        <div class="card test filter" id="filter">
            <div class="card-content">
                <div class="content">
                    <div class="columns">
                        <div class="column is-2">
                            <input class="input" type="text" placeholder="Name" name="name">
                        </div>
                        <div class="column is-2">
                            <input class="input" type="text" placeholder="Ort" name="place">
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-2">
                            <div class="field">
                                <label class="label">Fachbereich</label>
                                <div class="control">
                                    <div class="select"><!-- Dropdown select for industries-->
                                        <select name="industry">
                                            <?php
                                            $data = Applicant::getIndustry_Data();
                                            echo '<option>--Alle--</option>';
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
                        <div class="column is-3">
                            <div class="field">
                                <label for="education" class="label">Abschluss/Ausbildung</label>
                                <div class="control">
                                    <div class="select"><!-- Dropdown select for industries-->
                                        <select name="education">
                                            <?php
                                            $data = Applicant::getEducation_Data();
                                            echo '<option>--Alle--</option>';
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
                    </div>
                    <div class="columns">
                        <div class="column is-4">
                            <div class="buttons">
                                <button class="button is-dark is-rounded" name="filters">Speichern</button>
                                <button class="button is-light">Filter zurücksetzen</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</form>
<script src="../../source/js/navbar.js"></script>



