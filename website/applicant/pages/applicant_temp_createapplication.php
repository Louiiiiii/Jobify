<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requested</title>
    <link rel="stylesheet" href="../../source/css/bulma.css">
    <link rel="stylesheet" href="../../source/css/applicant.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    <script src="../../source/js/favourites.js"></script>
</head>
<body>
<?php require_once '../parts/applicant_profile_navbar.php'; ?>
    <div class="row">
        <div class="column">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div>
                            <b><div>Apply:</div></b>
                            <br>
                            <div>Choose upload files</div>
                            <br>
                            <div>
                                <label class="checkbox">
                                 <input type="checkbox">
                                  Lebenslauf
                                </label>
                            </div>
                            <div>
                                <label class="checkbox">
                                <input type="checkbox">
                                    Maturazeugnis
                                </label>
                            </div>
                            <div>
                                <label class="checkbox">
                                <input type="checkbox">
                                    Dienstzeugnis
                                </label>
                            </div>
                            <br>
                            <b><label>File upload:</label></b>
                            <br>
                            <div class="file has-name">
                                <label class="file-label">
                                    <input class="file-input" type="file" name="resume">
                                    <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">
                                            Choose a file…
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>