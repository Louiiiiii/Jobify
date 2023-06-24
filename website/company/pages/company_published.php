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

            $file_deleted = false; //JOB::deleteJobByJobID($_POST["del-job-id"]);

            if($file_deleted) {
                echo "<script>alert('Your Job was deleted!');</script>";
            } else {
                echo "<script>alert('Ahhhh shit something went wrong!');</script>";
            }
        }

        if (isset($_POST["reset-delete-file-btn"])) {
            $del_job_modal = "";
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

        <div class="field">
            <form action="./company_create_job.php">
                <button style="margin-bottom: 25px" class="button is-info is-rounded">
                    <span class="icon is-small">
                        <i class="fas fa-plus"></i>
                    </span>
                </button>
            </form>
        </div>
    </div>

        <?php

        $company = Company::getCompanyByUserId($current_user_id);

        $company_id = $company->company_id;

        $all_jobs= Job::getAllJobsByCompany($company_id);

        $counter = 0;

        foreach ($all_jobs as $job) {

            $job_industries = JOB::getJobIndustries($job["job_id"]);
            
            if ($counter % 2 == 0) { 
                echo '<div class="row">';
            }
            
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
                                        foreach($job_industries as $job_industry) {
                                            echo "<p>" . $job_industry["name"] . "</p>";
                                        } 
                                    ?>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <p class="title is-3"><?php echo $job["salary"] ?>€</p>
                                </div>

                                <form action="./company_published.php" method="post">

                                    <div class="columns">
                                        <div class="column">
                                            <button tpye="submit" class="button is-info is-rounded" type="button">
                                                <span class="icon is-small">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="column">
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

            if ($counter % 2 != 0) { 
                echo '</div>';
            }

            $counter++;

        }

        ?>
        
</body>
</html>