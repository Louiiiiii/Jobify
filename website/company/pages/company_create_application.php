<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <link rel="stylesheet" href="../../source/css/bulma.css">
    <link rel="stylesheet" href="../../source/css/applicant.css">
    <link rel="stylesheet" href="../../source/css/create_application.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    <script src="../../source/js/favourites.js"></script>
</head>
<body>
<?php require_once '../parts/company_profile_navbar.php'; ?>
    <form class="form" action="" method="post">
        <div class=row>
            <div class="column">
                <label class="label">Description: </label>
                <textarea class="textarea" placeholder="Description of the job"></textarea>
            </div>
        </div>    
        <div class=row>
            <div class="column">
                <label class="label">Requirements: </label>
                <input class="input" type="text" id="fname" name="fname" style="max-width: 350px;">
                <button class="button is-light in-row" type="button">Add</button>
            </div>
        </div>
        <div class="row">
            <div class="column reqs0">
                <ul class="ul">
                    <li><label class="hoverable-label-req">Cool</label></li>
                    <li><label class="hoverable-label-req">Erfahrung</label></li>
                    <li><label class="hoverable-label-req">Kreativität</label></li>
                    <li><label class="hoverable-label-req">Zuverlässigkeit</label></li>
                </ul>
            </div>
            <div class="column reqs1">
                <ul class="ul">
                    <li><label class="hoverable-label-req">Cool</label></li>
                    <li><label class="hoverable-label-req">Erfahrung</label></li>
                    <li><label class="hoverable-label-req">Kreativität</label></li>
                    <li><label class="hoverable-label-req">Zuverlässigkeit</label></li>
                </ul>
            </div>
            <div class="column reqs2">
                <ul class="ul">
                    <li><label class="hoverable-label-req">Cool</label></li>
                    <li><label class="hoverable-label-req">Erfahrung</label></li>
                    <li><label class="hoverable-label-req">Kreativität</label></li>
                    <li><label class="hoverable-label-req">Zuverlässigkeit</label></li>
                </ul>
            </div>
        </div>
        <div class=row>
            <div class="column">
                <label class="label">Benefits:</label>
                <input class="input" type="text" id="fname" name="fname" style="max-width: 350px;">
                <button class="button is-light in-row" type="button">Add</button>
            </div>
        </div>
        <div class="row">
            <div class="column benfs0">
                <ul class="ul">
                    <li><label class="hoverable-label-benf">Flexible Arbeitszeiten</label></li>
                    <li><label class="hoverable-label-benf">Mitarbeiterbeteiligung</label></li>
                    <li><label class="hoverable-label-benf">Gesundheitsförderung</label></li>
                    <li><label class="hoverable-label-benf">Teamarbeit und Zusammenhalt</label></li>
                </ul>
            </div>
            <div class="column benfs1">
                <ul class="ul">
                    <li><label class="hoverable-label-benf">Flexible Arbeitszeiten</label></li>
                    <li><label class="hoverable-label-benf">Mitarbeiterbeteiligung</label></li>
                    <li><label class="hoverable-label-benf">Gesundheitsförderung</label></li>
                    <li><label class="hoverable-label-benf">Teamarbeit und Zusammenhalt</label></li>
                </ul>
            </div>
            <div class="column benfs2">
                <ul class="ul">
                    <li><label class="hoverable-label-benf">Flexible Arbeitszeiten</label></li>
                    <li><label class="hoverable-label-benf">Mitarbeiterbeteiligung</label></li>
                    <li><label class="hoverable-label-benf">Gesundheitsförderung</label></li>
                    <li><label class="hoverable-label-benf">Teamarbeit und Zusammenhalt</label></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <button type="submit" class="button is-info"> Create</button>
        </div>
    </form>
</body>
</html>

<script src="/website/source/js/modal.js"></script>