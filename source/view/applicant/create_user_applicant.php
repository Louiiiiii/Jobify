<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="../../style/bulma.css">
    <link rel="stylesheet" href="../../style/create_user.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body>
    <div class="card">
        <p class="title is-2">Applicant</p>
        <div class="card-content">
            <div class="card-content__body">
                <form class="form">
                    <div class="row">
                        <div class="field">
                            <label class="label">Firstname</label>
                            <div class="control">
                                <input name="firstname" class="input" type="text" placeholder="Firstname">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Lastname</label>
                            <div class="control">
                                <input name="lastname" class="input" type="text" placeholder="Lastname">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Birthday</label>
                            <div class="control">
                                <input name="birthday" class="input" type="date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Country</label>
                            <div class="control">
                                <input name="country" class="input" type="text" placeholder="Country">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">State</label>
                            <div class="control">
                                <input name="state" class="input" type="text" placeholder="State">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Postal Code</label>
                            <div class="control">
                                <input name="postalcode" class="input" type="text" placeholder="Postal Code">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">City</label>
                            <div class="control">
                                <input name="city" class="input" type="text" placeholder="City">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Street</label>
                            <div class="control">
                                <input name="street" class="input" type="text" placeholder="Street">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Street Num.</label>
                            <div class="control">
                                <input name="streetnumber" class="input" type="text" placeholder="Street Number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Highest Degree</label>
                            <div class="select">
                                <select name="degree">
                                    <option value="highest">Highest Degree</option>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Educational Institution</label>
                            <div class="control">
                                <input name="institution" class="input" type="text" placeholder="Educational Institution">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Graduation</label>
                            <div class="control">
                                <input name="graduation" class="input" type="month">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Industry</label>
                            <div class="select">
                                <select name="industry">
                                    <option value="industry">Industry</option>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Last/Current Job</label>
                            <div class="select">
                                <input name="job" class="input" type="text" list="Jobs" placeholder="Other">
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
                                <input name="headhunting" type="checkbox">
                                Yes
                            </label>
                        </div>
                    </div>
                    <diV class="row">
                        <button class="button is-link">Submit</button>
                    </diV>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script src="../../scripts/cardMargin.js"></script>