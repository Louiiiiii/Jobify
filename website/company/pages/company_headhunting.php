<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <link rel="stylesheet" href="../../source/css/bulma.css">
    <link rel="stylesheet" href="../../source/css/applicant.css">
    <link rel="stylesheet" href="../../source/css/person_card.css">
    <link rel="stylesheet" href="../../source/css/send_request.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    <script src="../../source/js/favourites.js"></script>
</head>
<body>
<?php require_once '../parts/company_profile_navbar.php'; ?>
    <div class="row">
        <div class="column">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="left-content">
                            <div>Human 1</div>
                            <figure class="image is-64x64">
                                <img class="is-rounded" src="../../source/img/user-icon.png">
                            </figure>
                        </div>
                        <div class="content__button">
                            <button class="button is-info is-rounded js-modal-trigger" data-target="modal-js-example">
                                <span class="icon is-small">
                                    <i class="fas fa-envelope-open-text"></i>
                                </span>
                            </button>
                            <button class="button is-info is-rounded">
                                <span class="icon is-small">
                                    <i class="fas fa-info"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="left-content">
                            <div>Human 2</div>
                            <figure class="image is-64x64">
                                <img class="is-rounded" src="../../source/img/user-icon.png">
                            </figure>
                        </div>
                        <div class="content__button">
                            <button class="button is-info is-rounded js-modal-trigger" data-target="modal-js-example">
                                <span class="icon is-small">
                                    <i class="fas fa-envelope-open-text"></i>
                                </span>
                            </button>
                            <button class="button is-info is-rounded">
                                <span class="icon is-small">
                                    <i class="fas fa-info"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="column">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="left-content">
                            <div>Human 3</div>
                            <figure class="image is-64x64">
                                <img class="is-rounded" src="../../source/img/user-icon.png">
                            </figure>
                        </div>
                        <div class="content__button">
                            <button class="button is-info is-rounded js-modal-trigger" data-target="modal-js-example">
                                <span class="icon is-small">
                                    <i class="fas fa-envelope-open-text"></i>
                                </span>
                            </button>
                            <button class="button is-info is-rounded">
                                <span class="icon is-small">
                                    <i class="fas fa-info"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="left-content">
                            <div>Human 4</div>
                            <figure class="image is-64x64">
                                <img class="is-rounded" src="../../source/img/user-icon.png">
                            </figure>
                        </div>
                        <div class="content__button">
                            <button class="button is-info is-rounded js-modal-trigger" data-target="modal-js-example">
                                <span class="icon is-small">
                                    <i class="fas fa-envelope-open-text"></i>
                                </span>
                            </button>
                            <button class="button is-info is-rounded">
                                <span class="icon is-small">
                                    <i class="fas fa-info"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-js-example" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <form class="form" method="post" action="./applicant_profile.php">
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
</body>
</html>

<script src="/website/source/js/modal.js"></script>