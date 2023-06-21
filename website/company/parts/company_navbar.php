<?php
echo "<script>";
require $_SERVER['DOCUMENT_ROOT'] . "/website/source/js/navbar.js";
echo "</script>";
include $_SERVER['DOCUMENT_ROOT'] .'/website/classes/getClasses.php';
?>
<!--Navbar Company Home -->
<nav class="navbar is-black has-shadow" id="comNavHome" role="navigation" aria-label="main navigation">
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
            <a class="navbar-item">
                Published Jobs
            </a>
            <a class="navbar-item">
                Applicants
            </a>
            <a class="navbar-item">
                Headhunting
            </a>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-white">
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
        <header class="card-header">
            <p class="card-header-title">Filter Applicants</p>
            <button class="card-header-icon toggleFilter"  aria-label="more options" onclick="test('toggleFilter', 'filter')" >
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
            </button>
        </header>
        <div class="card test filter">
            <div class="card-content">
                <div class="content">
                    <div class="columns">
                        <div class="column is-2">
                            <input class="input is-dark" type="text" placeholder="Name">
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
                    </div>
                    <div class="columns">
                        <div class="column is-2">
                            <div class="field">
                                <label class="label">Fachbereich</label>
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
                        <div class="column is-3">
                            <div class="field">
                                <label for="education" class="label">Abschluss/Ausbildung</label>
                                <div class="control">
                                    <div class="select is-dark"><!-- Dropdown select for industries-->
                                        <select name="education">
                                            <?php
                                            $data = Applicant::getEducation_Data();
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
                                <label class="label" for="jobtitle">Jobbeschreibung</label>
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
</form>



