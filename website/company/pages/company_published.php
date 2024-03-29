<?php 

    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/website/classes/getClasses.php';

    $current_user_email = $_SESSION["current_user_email"];
    $current_user_pwhash = $_SESSION["current_user_pwhash"];
    $current_user_id = $_SESSION["current_user_id"];
    
    //Delete Job
        if (isset($_POST["del-job-btn"])) {

            $del_job_id = $_POST["del-job-btn"];
            $del_job = Job::getDatabyId($del_job_id);
            $del_job_title = $del_job->title;

            $del_job_modal = '
                <div class="modal is-active">
                    <div class="modal-background is-active"></div>
                    <div class="modal-content modal-content-delete-job">
                        <div class="box">
                            <form action="./company_published.php" method="post">
                                <h1>Wollen Sie denn Job "' . $del_job_title . '" wirklick löschen?</h1>
                                <input type="number" name="del-job-id" value="'.$del_job_id.'" style="display: none;" readonly>
                                <br> 
                                <div class="columns">
                                    <div class="column">
                                        <button class="button is-dark" type="submit" name="now-delete-job-btn">Delete</button>
                                    </div>                              
                                    <div class="column">
                                        <button class="button is-danger" type="submit" name="reset-delete-job-btn">Cancel</button>
                                    </div>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            ';
            
        } else {

            $del_job_modal = "";

        }
        
        if (isset($_POST["now-delete-job-btn"])) {
            $del_job_modal = "";

            $file_deleted = JOB::deleteJobByJobID($_POST["del-job-id"]);

            if($file_deleted) {
                doAlert("Your Job was deleted!");
            } else {
                doAlert("Something went wrong!");
            }
        }

        if (isset($_POST["reset-delete-file-btn"])) {
            $del_job_modal = "";
        }
    //

    //Save edited Job
        if (isset($_POST["save-edited-job-btn"])) {
            //get data
                $title = $_POST['title'];

                if (isset($_POST["description"])) {
                    $description = $_POST['description'];
                } else {
                    $description = null;
                }

                if (isset($_POST["industry_ids"])) {
                    $industry_ids = $_POST['industry_ids'];
                } else {
                    $industry_ids = null;
                }

                if (isset($_POST["isapprenticeship"])) {
                    $isapprenticeship = 1;
                } else {
                    $isapprenticeship = 0;
                }

                $salary = $_POST['salary'];

                if ($_POST['save-edited-job-btn']>0) {
                    $job_id = $_POST['save-edited-job-btn'];
                } else {
                    $job_id = false;
                }

                $company = Company::getCompanyByUserId($current_user_id);
                $company_id = $company->company_id;
            //

            //insert Job
                $job = new JOB ($title, $isapprenticeship, $company_id, $salary, $description);

                if($job_id == false) {
                    //insert
                    $job_id = $job -> insertjob();
                } else {
                    //update
                    $job->job_id = $job_id;
                    $job ->updateJob();
                }
            // 
            
            //add Industries
                //del all
                JOB::delAllIndustriesByJob($job_id);
                
                if ($industry_ids != null) {
                    //add new
                    foreach($industry_ids as $industry_id) {
                        JOB::addIndustryToJob($job_id, $industry_id);
                    }
                }
            //

            unset($_POST);
        }
    //

    //Stop Edit Job
        if (isset($_POST["stop-edit-job-btn"])) {
            unset($_POST);
        }
    //

    //spawn new job
        if (isset($_POST["spawn-new-job"])) {
            $spawn_new_job = true;
        } else {
            $spawn_new_job = false; 
        }
    //

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <link rel="stylesheet" href="../../source/css/bulma.css">
    <link rel="stylesheet" href="../../source/css/applicant.css">
    <link rel="stylesheet" href="/website/source/css/alert.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    <script src="../../source/js/favourites.js"></script>
</head>
<body>
    <?php 
        include '../parts/company_navbar.php'; 

        echo $del_job_modal;
    ?>

    <div class="search-row">
        <div class="field">
            <p class="control has-icons-left">
                <input class="input" placeholder="Search">
                <span class="icon is-small is-left">
                    <i class="fas fa-search"></i>
                </span>
            </p>
        </div>
    </div>

        <?php
        
            $counter = 0;

            //spawn new job
            if ($spawn_new_job) {
                
                if ($counter % 2 == 0) { 
                    echo '<div class="row">';
                }

                $counter++;

                ?>
                    <div class="column">
                        <form action="./company_published.php" method="post" id="add-job-form">
                            <div class="card">
                                <header class="card-header">
                                    <div class="columns" style="width: 100%;">
                                        <div class="column is-one-fifth">
                                            <p class="card-header-title">
                                                <labe for="title">Title: </label>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="card-header-title">
                                                <input class="input is-small" type="text" id="title" name="title" required>
                                            </p>
                                        </div>
                                    </div>
                                </header>
                                <div class="card-content">
                                    <div class="content">
                                        <div class="columns">
                                            <div class="column is-two-third">
                                                <p class="title is-5">Description:</p>
                                                <p>
                                                    <textarea class="textarea has-fixed-size input" type="description" id="description" name="description"></textarea>
                                                </p>
                                            </div>
                                            <div class="column is-one-third">
                                                <p class="title is-5">Type:</p>
                                                <p>
                                                    <label class="checkbox" name="isapprenticeship">
                                                        <input type="checkbox" name="isapprenticeship">
                                                        Apprenticeship
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="columns">
                                            <div class="column is-two-third">
                                                <p class="title is-5">Industries:</p>
                                                <div class="industries-select">
                                                    <?php
                                                        $industries = Applicant::getIndustry_Data();
                                                        
                                                        foreach($industries as $industry) {   

                                                            echo '<input class="checkbox-input" type="checkbox" id="' . $industry["industry_id"] . '" name="industry_ids[]" value="' . $industry["industry_id"] . '">';
                                                            echo '<label class="checkbox-label" for="' . $industry["industry_id"] . '"> ' . $industry["name"] . '</label><br>';

                                                        }
                                                        
                                                    ?>    
                                                </div>                                            
                                            </div>
                                        </div>
                                        <div class="columns salary-columns">
                                            <div class="column title is-5">
                                                <labe for="salary">Salary: </label>
                                            </div>
                                            <div class="column">
                                                <input class="input" type="number" id="salary" name="salary" required>
                                            </div>
                                            <div class="column title is-5">
                                                <p>€</p>
                                            </div>

                                            <div class="columns columns-button">
                                                <div class="column column-button">
                                                    <button type="submit" class="button is-primary is-outlined is-rounded" name="save-edited-job-btn">
                                                        <span class="icon is-small">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                                <div class="column column-button">
                                                    <button type="submit" onclick="submitForm('add-job-form')" class="button is-danger is-outlined is-rounded" name="stop-edit-job-btn">
                                                        <span class="icon is-small">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php
            }

            //show jobs from d
            $company = Company::getCompanyByUserId($current_user_id);

            $company_id = $company->company_id;

            $all_jobs= Job::getAllJobsByCompany($company_id);

            foreach ($all_jobs as $job) {

                $job_industries = JOB::getJobIndustries($job["job_id"]);
                
                if ($counter % 2 == 0) { 
                    echo '<div class="row">';
                }

                if (isset($_POST["edit-job-btn"]) && $_POST["edit-job-btn"] == $job["job_id"]) {

                ?>
                    <div class="column">
                        <form action="./company_published.php" method="post" id="edit-job-form">
                            <div class="card">
                                <header class="card-header">
                                    <div class="columns" style="width: 100%;">
                                        <div class="column is-one-fifth">
                                            <p class="card-header-title">
                                                <labe for="title">Title: </label>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="card-header-title">
                                                <input class="input is-small" type="text" id="title" name="title" value="<?php echo $job["title"] ?>" required>
                                            </p>
                                        </div>
                                    </div>
                                </header>
                                <div class="card-content">
                                    <div class="content">
                                        <div class="columns">
                                            <div class="column is-two-third">
                                                <p class="title is-5">Description:</p>
                                                <p>
                                                    <textarea class="textarea has-fixed-size input" type="description" id="description" name="description"><?php echo $job["description"] ?></textarea>
                                                </p>
                                            </div>
                                            <div class="column is-one-third">
                                                <p class="title is-5">Type:</p>
                                                <p>
                                                    <?php 
                                                        if ($job["isapprenticeship"] == 1) {
                                                            $isapprenticeship = "checked";
                                                        } else {
                                                            $isapprenticeship = "";
                                                        }
                                                    ?>
                                                    <label class="checkbox" for="isapprenticeship">
                                                        <input type="checkbox" id="isapprenticeship" name="isapprenticeship" <?php echo $isapprenticeship ?>>
                                                        Apprenticeship
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="columns">
                                            <div class="column is-two-third">
                                                <p class="title is-5">Industries:</p>
                                                <div class="industries-select">
                                                    <?php
                                                        $industries = Applicant::getIndustry_Data();
                                                        
                                                        foreach($industries as $industry) {   

                                                            $checked = "";

                                                            if(isset($job_industries)) {
                                                                foreach($job_industries as $job_industry) {
                                                                    if ($job_industry["name"] == $industry["name"]) {
                                                                        $checked = "checked";
                                                                    }
                                                                } 
                                                            } 

                                                            echo '<input class="checkbox-input" type="checkbox" id="' . $industry["industry_id"] . '" name="industry_ids[]" value="' . $industry["industry_id"] . '" ' . $checked . '>';
                                                            echo '<label class="checkbox-label" for="' . $industry["industry_id"] . '"> ' . $industry["name"] . '</label><br>';

                                                        }
                                                        
                                                    ?>    
                                                </div>                                            
                                            </div>
                                        </div>
                                        <div class="columns salary-columns">
                                            <div class="column title is-5">
                                                <labe for="salary">Salary: </label>
                                            </div>
                                            <div class="column">
                                                <input class="input" type="number" id="salary" name="salary" value="<?php echo $job["salary"] ?>" required>
                                            </div>
                                            <div class="column title is-5">
                                                <p>€</p>
                                            </div>

                                            <div class="columns columns-button">
                                                <div class="column column-button">
                                                    <button type="submit" class="button is-primary is-outlined is-rounded" name="save-edited-job-btn" value="<?php echo $job["job_id"] ?>">
                                                        <span class="icon is-small">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                                <div class="column column-button">
                                                    <button type="button" onclick="submitForm('edit-job-form')" class="button is-danger is-outlined is-rounded" name="stop-edit-job-btn" value="<?php echo $job["job_id"] ?>">
                                                        <span class="icon is-small">
                                                            <i class="fas fa-times"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php

                } else {

                ?>
                    <div class="column">
                        <div class="card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    <?php echo $job["title"] ?>
                                </p>
                            </header>
                            <div class="card-content">
                                <div class="content">
                                    <div class="columns">
                                        <div class="column is-two-third">
                                            <p class="title is-5">Description:</p>
                                            <p><?php echo $job["description"] ?></p>
                                        </div>
                                        <div class="column is-one-third">
                                            <p class="title is-5">Type:</p>
                                            <p>
                                                <?php 
                                                    if ($job["isapprenticeship"] == 0) {
                                                        echo "Job";
                                                    } else {
                                                        echo "Apprenticeship";
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="columns">
                                        <div class="column is-two-third">
                                            <p class="title is-5">Industries:</p>
                                            <?php 
                                                if(isset($job_industries)) {
                                                    foreach($job_industries as $job_industry) {
                                                        echo "<p>" . $job_industry["name"] . "</p>";
                                                    } 
                                                } else {
                                                    echo "<p>Keine Industry ausgewählt</p>";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="columns salary-columns">
                                        <div class="column">
                                            <p class="title is-5"><?php echo $job["salary"] ?>€</p>
                                        </div>

                                        <form action="./company_published.php" method="post">

                                            <div class="columns columns-button">
                                                <div class="column column-button">
                                                    <button tpye="submit" class="button is-info is-rounded" name="edit-job-btn" value="<?php echo $job["job_id"] ?>">
                                                        <span class="icon is-small">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                                <div class="column column-button">
                                                    <button tpye="submit" class="button is-danger is-outlined is-rounded" name="del-job-btn" value="<?php echo $job["job_id"] ?>">
                                                        <span class="icon is-small">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php

                }

                if ($counter % 2 != 0) { 
                    echo '</div>';
                }

                $counter++;

            }

            if ($counter % 2 != 0) { 
                echo '<div class="column"></div>';
            }

        ?>
    
        <form class="add-form" action="./company_published.php" method="post">
            <button name="spawn-new-job" class="button is-info is-rounded add-button">
                <span class="icon is-small">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </form>
        
</body>
<script>
  function submitForm(id) {
    document.getElementById(id).submit();
  }
</script>
</html>