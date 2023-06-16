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
                                    <button class="button is-light in-row">Add</button>
                                    <ul>
                                        <li>Fachkenntnisse</li>
                                        <li>Erfahrung</li>
                                        <li>Kreativität</li>
                                        <li>Zuverlässigkeit</li>
                                    </ul>
                                    <br>
                                </div>
                                <div>
                                    <label for="fname">Benefits:</label><br>
                                    <input class="input" type="text" id="fname" name="fname" style="max-width: 350px;">
                                    <button class="button is-light in-row">Add</button>
                                    <ul>
                                        <li>Flexible Arbeitszeiten</li>
                                        <li>Mitarbeiterbeteiligung</li>
                                        <li>Gesundheitsförderung</li>
                                        <li>Teamarbeit und Zusammenhalt</li>
                                    </ul>
                                    <br>
                                </div>
                                <div>
                                    <label for="fname">Gehalt in brutto:</label><br>
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