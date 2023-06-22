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
include $_SERVER['DOCUMENT_ROOT'] .'/website/classes/getClasses.php';
if (isset($_SESSION['currjob_id'])){
    $currjob_id = $_SESSION['currjob_id'];
}
else{
    $currjob_id = 1;
}
$job = Job::getDatabyId($currjob_id);
$company = Company::getDatabyId($job->company_id);
?>
    <div class="row">
        <div class="column">
            <div class="card">
            <header class="card-header">
                    <p class="card-header-title">
                        <?php echo $job->title;?>
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        <div>
                            <?php echo $job->description; ?>
                        </div>
                        <div>
                            <br><b>Anforderungen:</b>
                            <ul>
                                <li>Fachkenntnisse</li>
                                <li>Erfahrung</li>
                                <li>Kreativität</li>
                                <li>Zuverlässigkeit</li>
                            </ul>
                        </div>
                        <div>
                            <br><b>Benefits:</b>
                            <ul>
                                <li>Flexible Arbeitszeiten</li>
                                <li>Mitarbeiterbeteiligung</li>
                                <li>Gesundheitsförderung</li>
                                <li>Teamarbeit und Zusammenhalt</li>
                            </ul>
                        </div>
                        <?php
                        if($job->salary != null) {
                            echo "<div>";
                            echo "<br><b>Gehalt: ".$job->salary."€ brutto</b>";
                            echo "</div>";
                        }
                        ?>

                        <div class="header">
                            <b><h4><?php echo $company->name;?></h4></b>
                        </div>
                    </div>
                    <div>
                        <button class="button is-black js-modal-trigger" data-target="modal-js-example">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-js-example" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <form class="form" method="post">
                    <div class="row">
                        <label class="label">Choose upload files</label>
                    </div>
                    <div class="row">
                        <div class="column">
                            <input type="checkbox">
                            <label class="checkbox">
                                Lebenslauf
                            </label>
                        </div>
                        <div class="column">
                            <input type="checkbox">
                            <label class="checkbox">
                                Maturazeugnis
                            </label>
                        </div>
                        <div class="column">
                            <input type="checkbox">
                            <label class="checkbox">
                                Dienstzeugnis
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column">
                            <input type="checkbox">
                            <label class="checkbox">
                                Lebenslauf
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column">
                            <input type="checkbox">
                            <label class="checkbox">
                                Lebenslauf
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <label class="label">Choose upload files</label>
                    </div>
                    <div class="row">
                        <div class="file has-name">
                            <label class="file-label">
                                <input class="file-input" type="file" name="resume">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">
                                        Upload a file…
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
</body>
</html>

<script src="/website/source/js/modal.js"></script>