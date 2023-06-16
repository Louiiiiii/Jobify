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
<?php require_once '../parts/applicant_profile_navbar.php'; ?>
    <div class="row">
        <div class="column">
            <div class="card">
            <header class="card-header">
                    <p class="card-header-title">
                        Job as Gooflord
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        <div class="header">
                            <b><h6>Goofy Gmbh Marchtrenk;    we make a difference</h6></b>
                        </div>
                        <div>
                            Wir suchen einen motivierten und goofy Junior Marketing Manager, der Teil unseres dynamischen und goofy Teams werden möchte. In dieser goofy Rolle unterstützen Sie uns bei der Entwicklung und Umsetzung von goofy Marketingstrategien, der goofy Marktforschung und der Erstellung von goofy Marketingmaterialien. Sie arbeiten goofy eng mit dem Marketingteam zusammen, um goofy innovative Kampagnen zu entwickeln und unsere goofy Marktposition zu stärken. Der goofy ideale Kandidat verfügt über eine goofy Leidenschaft für Marketing, eine goofy kreative Denkweise und goofy gute kommunikative Fähigkeiten. Erfahrungen im goofy digitalen Marketing und mit goofy Social-Media-Kanälen sind von goofy Vorteil. Wenn Sie eine goofy Karriere im Marketing anstreben und goofy bereit sind, neue goofy Herausforderungen anzunehmen, freuen wir uns auf Ihre goofy Bewerbung.
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
                        <div>
                            <br><b>Gehalt: 3200€ brutto</b>
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