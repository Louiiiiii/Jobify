<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../../style/bulma.css">
    <link rel="stylesheet" href="../../style/profile.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body>
<?php require_once 'applicant_profile_navbar.php'; ?>
    <form class="form">
        <div class="row">
            <div class="field">
                <div class="file">
                    <label class="file-label">
                        <input class="file-input disabling" type="file" name="profilePic" disabled>
                        <figure class="image is-128x128">
                            <img class="is-rounded" src="../../style/img/user-icon.png">
                        </figure>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">E-Mail</label>
                <div class="control">
                    <input name="email" class="input disabling" type="email" placeholder="Email" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Password</label>
                <button type="button" class="button js-modal-trigger" data-target="modal-js-example">Change Password</button>
            </div>
            </div>
        <div class="row">
            <div class="field">
                <label class="label">Firstname</label>
                <div class="control">
                    <input name="firstname" class="input disabling" type="text" placeholder="Firstname" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Lastname</label>
                <div class="control">
                    <input name="lastname" class="input disabling" type="text" placeholder="Lastname" required disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Birthday</label>
                <div class="control">
                    <input name="birthday" class="input disabling" type="date" required disabled>
                </div>
            </div>
            <div class="field"></div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Country</label>
                <div class="control">
                    <input name="country" class="input disabling" type="text" placeholder="Country" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">State</label>
                <div class="control">
                    <input name="state" class="input disabling" type="text" placeholder="State" required disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Postal Code</label>
                <div class="control">
                    <input name="postalcode" class="input disabling" type="text" placeholder="Postal Code" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">City</label>
                <div class="control">
                    <input name="city" class="input disabling" type="text" placeholder="City" required disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Street</label>
                <div class="control">
                    <input name="street" class="input disabling" type="text" placeholder="Street" required disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Street Num.</label>
                <div class="control">
                    <input name="streetnumber" class="input disabling" type="text" placeholder="Street Number" required disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Highest Degree</label>
                <div class="select">
                    <select class="disabling" name="degree" required disabled>
                        <option value="highest">Highest Degree</option>
                    </select>
                </div>
            </div>
            <div class="field"></div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Industry</label>
                <div class="select">
                    <select class="disabling" name="industry" required disabled>
                        <option value="industry">Industry</option>
                    </select>
                </div>
            </div>
            <div class="field"></div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Allow Headhunting</label>
                <label class="checkbox">
                    <input class="checkbox-input disabling" name="headhunting" type="checkbox" disabled>
                    Yes
                </label>
            </div>  
            <div class="field"></div>
        </div>
        <div class="row">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>File</th>
                            <th>File Extension</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1</th>
                            <td>Lebenslauf</td>
                            <td>.docx</td>
                            <td>
                                <button class="button is-danger is-outlined is-rounded disabling" type="button" disabled>
                                    <span class="icon is-small">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <td>LAP Zeugnis</td>
                            <td>.pdf</td>
                            <td>
                                <button class="button is-danger is-outlined is-rounded disabling" type="button" disabled>
                                    <span class="icon is-small">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th>3</th>
                            <td>Matura Zeugnis</td>
                            <td>.png</td>
                            <td>
                                <button class="button is-danger is-outlined is-rounded disabling" type="button" disabled>
                                    <span class="icon is-small">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <div class="file">
                    <label class="file-label">
                        <input class="file-input disabling" type="file" name="file" disabled>
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">Add a file…</span>
                        </span>
                    </label>
                </div>
            </div>
            <div class="field"></div>
        </div>
        <diV class="row edit">
            <button type="button" class="button is-link" onclick="edit()">Edit Profile</button>
        </diV>
        <diV class="row cancel hide">
            <button type="button" class="button" onclick="cancel()">Cancel</button>
            <button class="button is-link">Change</button>
        </diV>
    </form>

    <div id="modal-js-example" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <form class="form">
                    <div class="row">
                        <div class="field">
                            <label class="label">Current Password</label>
                            <div class="control">
                                <input id="currentpassword" name="currentpassword" class="input" type="password" placeholder="Current Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control">
                                <input id="password" name="password" class="input" type="password" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Repeat Password</label>
                            <div class="control">
                                <input id="repeatpassword" name="repeatpassword" class="input" type="password" placeholder="Repeat Password" oninput="checkpw()" required> 
                            </div>
                        </div>
                    </div>
                    <div class="row checkpasswordtext">
                        <div class="field">
                            <label class="label"></label>
                            <div class="checkpasswordtext" id="checkpasswordtext"></div>
                        </div>
                    </div>
                    <div class="row">
                        <button class="button is-link">Change</button>
                    </div>
                </form>
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close"></button>
    </div>
</body>
</html>

<script src="../../scripts/hideButton.js"></script>
<script src="../../scripts/modal.js"></script>
<script src="../../scripts/checkpassword.js"></script>