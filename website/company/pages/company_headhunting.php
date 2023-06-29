<?php 

    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/website/classes/getClasses.php';

    $current_user_email = $_SESSION["current_user_email"];
    $current_user_pwhash = $_SESSION["current_user_pwhash"];
    $current_user_id = $_SESSION["current_user_id"];

    //show chat modal
        if (isset($_POST["show-chat-applicant-modal-btn"])) {

            $headhunted_applicant_id = $_POST["show-chat-applicant-modal-btn"];

            $headhunted_user_id = Applicant::getUserIDByApplicantID($headhunted_applicant_id);
            $headhunted_user_id = $headhunted_user_id["user_id"];

            $headhunted_applicant = Applicant::getProfileDataFromApplicant($headhunted_user_id);

            $profile_pic = File::getFile($headhunted_user_id, "Profile Picture");
                        
            if (is_null($profile_pic)) {
                $profile_pic_path = "/website/source/img/user-icon.png";
            } else {                            
                $profile_pic_path = "/website/uplfiles/" . $headhunted_user_id . "/" . $profile_pic["name"];
            }

            $current_company = Company::getCompanyByUserId($current_user_id);
            $current_company_id = $current_company->company_id;

            $all_jobs = Job::getAllJobsByCompany($current_company_id);

            $all_jobs_as_options = "";

            foreach ($all_jobs as $job) {
                $all_jobs_as_options = $all_jobs_as_options . '<option value="' . $job["job_id"] . '">' . $job["title"] . "</option>";
            }

            $chat_applicant_modal = '
                <div id="modal-js-example" class="modal is-active">

                    <form type="submit" method="post">

                        <div class="modal-background"></div>

                        <div class="modal-content">
                            <div class="box">
                                <form class="form" method="post">
                                    <div class="row">
                                        <div class="column">
                                            <figure class="image is-64x64">
                                                <img class="is-rounded" src="' . $profile_pic_path . '">
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="column">
                                            <div>' . $headhunted_applicant["infos"]["0"]["firstname"] . ' ' . $headhunted_applicant["infos"]["0"]["lastname"] . '</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="column">
                                            <label class="label">Select Job</label>
                                        </div>
                                        <div class="column">
                                            <div class="select">
                                                <select name="headhuntjob" required>' .
                                                    $all_jobs_as_options
                                                . '</select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="column">
                                            <textarea name="headhunttext" class="textarea" placeholder="Here could be your goofy Text even if nobody except for you will ever read it!"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="column">
                                            <button class="button is-info" type="submit" name="send-headhunting-request" value="' . $headhunted_applicant_id . '">
                                                <span class="icon">
                                                    <i class="fa fa-paper-plane"></i>
                                                </span>
                                                <span>
                                                    Send
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <button class="modal-close is-large" aria-label="close"></button>
                    </form>
                </div>
            ';    
            
        } else {

            $chat_applicant_modal = '';  

        }
    //

    //show info modal   
        if (isset($_POST["show-info-applicant-modal-btn"])) {

            $headhunted_applicant_id = $_POST["show-info-applicant-modal-btn"];

            $headhunted_user_id = Applicant::getUserIDByApplicantID($headhunted_applicant_id);
            $headhunted_user_id = $headhunted_user_id["user_id"];

            $headhunted_applicant = Applicant::getProfileDataFromApplicant($headhunted_user_id);

            $profile_pic = File::getFile($headhunted_user_id, "Profile Picture");
                        
            if (is_null($profile_pic)) {
                $profile_pic_path = "/website/source/img/user-icon.png";
            } else {                            
                $profile_pic_path = "/website/uplfiles/" . $headhunted_user_id . "/" . $profile_pic["name"];
            }

            $info_applicant_modal = '
                <div id="modal-js-example-info" class="modal is-active">

                    <div class="modal-background"></div>

                    <div class="modal-content">
                        <div class="box">
                        <div class="header">
                            <div class="row">
                                    <div class="column">
                                        <figure class="image is-64x64">
                                            <img class="is-rounded" src="' . $profile_pic_path . '">
                                        </figure>
                                    </div>
                            </div>
                            <b><h6><b>Name: </b>' . $headhunted_applicant["infos"]["0"]["firstname"] . ' ' . $headhunted_applicant["infos"]["0"]["lastname"] . '</h6></b>
                            </div>
                            <div>
                                <b>E-Mail: </b>' . $headhunted_applicant["infos"]["0"]["email"] . '
                            </div>
                            <div>
                                <b>State: </b>' . $headhunted_applicant["infos"]["0"]["state"] . '
                            </div>
                            <div>
                                <b>City: </b>' . $headhunted_applicant["infos"]["0"]["city"] . '
                            </div>
                            <div>
                                <b>Birthday: </b>' . $headhunted_applicant["infos"]["0"]["birthdate"] . '
                            </div>
                            <div>
                                <b>Highest Degree: </b>' . $headhunted_applicant["infos"]["0"]["education"] . '
                            </div>
                        </div>
                    </div>
                    <button class="modal-close is-large" aria-label="close"></button>
                </div>
            ';

        } else {
            
            $info_applicant_modal = '';

        }
    //

    //send headhunting request
        if(isset($_POST["send-headhunting-request"])) {
            $headhunt_applicant_id = $_POST["send-headhunting-request"];
            $headhunt_job_id = $_POST["headhuntjob"];
            $headhunt_text = $_POST["headhunttext"];

            if(Job::addHeadhuntRequest($headhunt_text, $headhunt_job_id, $headhunt_applicant_id)) {
                doAlert("Your Headhunt Request was sent!");
            } else {
                doAlert("Something went wrong!");
            }
        }
    //

    //use filters
        if (isset($_POST["filters"])) {

            $filter_name = $_POST["employee"];
            $filter_city = $_POST["place"]; 

            if ($_POST["industry"] == "--Alle--") {
                $filter_industry_id = null;
            } else {
                $filter_industry_id = $_POST["industry"];
            }

            if ($_POST["education"] == "--Alle--") {
                $filter_education_id = null;
            } else {
                $filter_education_id = $_POST["education"];
            }

            $filers = array(
                "filter_name" => $filter_name, 
                "filter_city" => $filter_city, 
                "filter_industry_id" => $filter_industry_id, 
                "filter_education_id" => $filter_education_id
            );
            
            $applicants_to_headhunt = Applicant::getApplicantsToHeadhunt($filers);
            
        } else {
            $filers = array(
                "filter_name" => null, 
                "filter_city" => null, 
                "filter_industry_id" => null, 
                "filter_education_id" => null
            );

            $applicants_to_headhunt = Applicant::getApplicantsToHeadhunt($filers);
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
        <link rel="stylesheet" href="../../source/css/send_request.css">
    <link rel="stylesheet" href="/website/source/css/alert.css">
        <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
        <script src="../../source/js/favourites.js"></script>
    </head>
    <body>
        <?php
            echo $info_applicant_modal;
            echo $chat_applicant_modal;

            include '../parts/company_navbar.php';
            include '../parts/company_filters.php';

        ?>

        <br>

        <?php 

            if (is_null($applicants_to_headhunt)) {
                $count_applicants_to_headhunt = 0;
            } else {
                $count_applicants_to_headhunt = count($applicants_to_headhunt);
            }

            $counter = 0;

            //echo applicants counter
            ?>

            <div class="row">
                <div class="column is-full">
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
                                <?php 
                                
                                    if ($count_applicants_to_headhunt == 1) {
                                        echo $count_applicants_to_headhunt . " applicant currently available";
                                    } else {
                                        echo $count_applicants_to_headhunt . " applicants currently available";
                                    }
                                
                                ?>
                            </p>
                        </header>
                    </div>
                </div>
            </div>

            <?php

            //echo the applicants
            if (!is_null($applicants_to_headhunt)) {

                foreach ($applicants_to_headhunt as $applicant_to_headhunt) {
                
                    $applicant_to_headhunt_user_id = Applicant::getUserIDByApplicantID($applicant_to_headhunt["applicant_id"]);
                    $applicant_to_headhunt_user_id = $applicant_to_headhunt_user_id["user_id"];
                    
                    $profile_pic = File::getFile($applicant_to_headhunt_user_id, "Profile Picture");
    
                    if (is_null($profile_pic)) {
                        $profile_pic_path = "/website/source/img/user-icon.png";
                    } else {                            
                        $profile_pic_path = "/website/uplfiles/" . $applicant_to_headhunt_user_id . "/" . $profile_pic["name"];
                    }
    
                    if ($counter % 2 == 0) {
                        echo '<div class="row">';
                    }
    
                    ?>
    
                    <div class="column">
                        <div class="card">
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-left">
                                        <figure class="image is-48x48">
                                            <img class="is-rounded" src="<?php echo $profile_pic_path ?>" alt="Placeholder image">
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <p class="title is-4"><?php echo $applicant_to_headhunt["name"] ?></p>
                                        <p class="subtitle is-6">
                                            <?php echo $applicant_to_headhunt["email"] ?> <br>
                                            <?php echo $applicant_to_headhunt["education"] ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="content__button">
                                        <button class="button is-info is-rounded" type="sumbit" name="show-chat-applicant-modal-btn" value="<?php echo $applicant_to_headhunt["applicant_id"] ?>">
                                            <span class="icon is-small">
                                                <i class="fas fa-envelope-open-text"></i>
                                            </span>
                                        </button>
                                        <button class="button is-info is-outlined is-rounded" type="sumbit" name="show-info-applicant-modal-btn" value="<?php echo $applicant_to_headhunt["applicant_id"] ?>">
                                            <span class="icon is-small">
                                                <i class="fas fa-info"></i>
                                            </span>
                                        </button>
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

                if ($counter % 2 != 0) {
                    echo '<div class="column"> </div>';
                }

            }

        ?>        

    </body>

    <script src="/website/source/js/modal.js"></script>

</html>