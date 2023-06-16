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
    <style>
        .hoverable-label {
        color: black;
        text-decoration: none;
        cursor: pointer;
        width: fit-content;
        }

        .hoverable-label:hover {
        text-decoration: line-through;
        color: grey;
        }
    </style>
</head>
<body>
<?php require_once '../parts/company_profile_navbar.php'; ?>
    <form class="form" action="" method="post">
        <div class="row">
            <div class="column">
                <div class="card">
                <header class="card-header">
                        <p class="card-header-title">
                            Jobausschreibung erstellen:
                        </p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <div class="header">
                                <label for="fname">Job Beschreibung:</label>
                                <textarea class="textarea" placeholder="" rows="7"></textarea><br>
                                <div>
                                    <label for="fname">Anforderung:</label><br>
                                    <input class="input" type="text" id="fname" name="fname" style="max-width: 350px;">
                                    <button class="button is-light in-row" type="button">Add</button>
                                    <ul>
                                        <li><label class="hoverable-label">Cool</label></li>
                                        <li><label class="hoverable-label">Erfahrung</label></li>
                                        <li><label class="hoverable-label">Kreativität</label></li>
                                        <li><label class="hoverable-label">Zuverlässigkeit</label></li>
                                    </ul>
                                    <br>
                                </div>
                                <div>
                                    <label for="fname">Benefits:</label><br>
                                    <input class="input" type="text" id="fname" name="fname" style="max-width: 350px;">
                                    <button class="button is-light in-row" type="button">Add</button>
                                    <ul>
                                        <li><label class="hoverable-label">Flexible Arbeitszeiten</label></li>
                                        <li><label class="hoverable-label">Mitarbeiterbeteiligung</label></li>
                                        <li><label class="hoverable-label">Gesundheitsförderung</label></li>
                                        <li><label class="hoverable-label">Teamarbeit und Zusammenhalt</label></li>
                                    </ul>
                                    <br>
                                </div>
                                <div>
                                    <label for="fname">Gehalt in brutto €:</label><br>
                                    <input class="input" type="text" id="fname" name="fname" style="max-width: 350px;">
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="button is-black">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>

<script src="../../source/js/treeView.js"></script>