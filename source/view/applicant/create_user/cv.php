<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="../../../style/bulma.css">
    <link rel="stylesheet" href="../../../style/create_user.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body>
    <div class="card">
        <p class="title is-2">Applicant Part 2</p>
        <div class="card-content">
            <div class="card-content__body">
                <form class="form">
                    <div class="row">
                        <div class="field">
                            <label class="label">Highest Degree</label>
                            <div class="select">
                                <select>
                                    <option>Highest Degree</option>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Educational Institution</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Educational Institution">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Graduation</label>
                            <div class="control">
                                <input class="input" type="month">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Industry</label>
                            <div class="select">
                                <select>
                                    <option>Industry</option>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Last/Current Job</label>
                            <div class="select">
                                <input class="input" type="text" list="Jobs" placeholder="Other">
                                <datalist id="Jobs">
                                    <option>Job</option>
                                </datalist>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Allow Headhunting</label>
                            <label class="checkbox">
                                <input type="checkbox">
                                Yes
                            </label>
                        </div>
                    </div>
                    <diV class="row applicant-row">
                        <button class="button is-link">Submit</button>
                    </diV>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script src="../../scripts/dropdown.js"></script>