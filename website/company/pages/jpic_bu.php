<?php 



    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/website/classes/getClasses.php';

    $current_user_email = $_SESSION["current_user_email"];
    $current_user_pwhash = $_SESSION["current_user_pwhash"];
    $current_user_id = $_SESSION["current_user_id"];

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
        <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
        <script src="../../source/js/favourites.js"></script>
    </head>
    <body>
        <?php

            include '../parts/company_navbar.php';
            include '../parts/company_filters.php';

            $name = null;
            $place = null;
            $industry = null;
            $education = null;

            if (isset($_POST['filters'])) {

                if ($_POST['employee'] != "") {
                    $name = '%' . $_POST['employee'] . '%';
                }

                if ($_POST['place'] != "") {
                    $place = '%' . $_POST['place'] . '%';
                }

                if ($_POST['industry'] != "--Alle--") {
                    $industry = '%' . $_POST['industry'] . '%';
                }

                if ($_POST['education'] != "--Alle--") {
                    $education = '%' . $_POST['education'] . '%';
                }
            }

            $db = new DB();

            $filter = $db->pdo->prepare('
                select 
                    concat_ws(" ",a.firstname, a.lastname ) employee, 
                    a.birthdate birthday, 
                    ad.street street, 
                    ad.number number, 
                    c.city city, 
                    p.postalcode postalcode, 
                    e.name education, 
                    u.user_id user
                from Applicant a, Education e, Address ad, City_Postalcode cp, City c, Postalcode p, Applicant_Industry ap, Industry i, User u
                where a.education_id = e.education_id
                and a.address_id = ad.address_id
                and ad.City_Postalcode_id = cp.City_Postalcode_id
                and cp.city_id = c.city_id
                and cp.postalcode_id = p.postalcode_id
                and a.applicant_id = ap.applicant_id
                and ap.industry_id = i.industry_id
                and a.user_id = u.user_id
                and (lower(concat_ws(" ", a.firstname, a.lastname)) like lower(:employee) or :employee is null)
                and (lower(c.city) like lower(:city) or :city is null)
                and (lower(i.name) like lower(:industry) or :industry is null)
                and (lower(e.name) like lower(:education) or :education is null)
            ');

            $filter->bindParam('employee', $employee);
            $filter->bindParam('city', $city);
            $filter->bindParam('industry', $industry);
            $filter->bindParam('education', $education);
            $filter->execute();

            ?>

            <br>

            <div class="columns">
                <div class="column is-full">
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
                                <?php
                                echo $filter->rowCount().' applicants currently available';
                                ?>
                            </p>
                        </header>
                    </div>
                </div>
            </div>

            <?php

            for ($i = 1; $i <= ceil($filter->rowCount()/2); $i++){

            ?>

            <div class="columns">

                <?php

                    for($j = 0; $j < 2; $j++) {
                        if ($result = $filter->fetch()) {

                            $profile_pic = File::getFile($result['user'], "Profile Picture");
                            if (is_null($profile_pic)) {
                                $profile_pic_path = "/website/source/img/user-icon.png";
                            } else {
                                $profile_pic_path = '/website/uplfiles/' .$result['user']. "/" . $profile_pic['name'];
                            }

                ?>
                <div class="column">
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img class="is-rounded" src="<?php echo $profile_pic_path;?>" alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <p class="title is-4"><?php echo $result['employee']; ?></p>
                                    <p class="subtitle is-6"><?php echo $result['education']; ?></p>
                                </div>
                            </div>
                            <div class="content">
                                <button class="button is-dark js-modal-trigger" data-target="modal-js-example">
                                            <span class="icon is-small">
                                                <i class="fas fa-envelope-open-text"></i>
                                            </span>
                                </button>
                                <button class="button is-outlined-light js-modal-trigger" data-target="modal-js-example-info">
                                            <span class="icon is-small">
                                                <i class="fas fa-info"></i>
                                            </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                        }
                    } 
                ?>

                </div>

                <?php
                    }
                ?>

        <div id="modal-js-example" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <form class="form" method="post">
                        <div class="row">
                            <div class="column">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="../../source/img/user-icon.png">
                                </figure>
                            </div>
                        </div>
                        <div class="row">
                            <div class="column">
                                <div>Human's name</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="column">
                                <label class="label">Select Job</label>
                            </div>
                            <div class="column">
                                <div class="select">
                                    <select name="job" required>
                                        <option>Goofy Marketing</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="column">
                                <textarea name="text" class="textarea" placeholder="Here could be your goofy Text even if nobody except for you will ever read it!"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="column">
                                <button class="button is-info" type="submit">
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
        </div>
        <div id="modal-js-example-info" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                <div class="header">
                    <div class="row">
                            <div class="column">
                                <figure class="image is-64x64">
                                    <img class="is-rounded" src="../../source/img/user-icon.png">
                                </figure>
                            </div>
                    </div>
                    <b><h6><b>Name: </b>Hugo Maier</h6></b>
                    </div>
                    <div>
                        <b>State: </b>Florida
                    </div>
                    <div>
                        <b>City: </b>Buxtehude
                    </div>
                    <div>
                        <b>Birthday: </b>10.10.2010
                    </div>
                    <div>
                        <b>Highest Degree: </b>Bachelor of Sience
                    </div>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close"></button>
        </div>
    </body>
</html>
<script src="/website/source/js/modal.js"></script>