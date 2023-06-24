<?php 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/website/source/css/bulma.css">
    <link rel="stylesheet" href="/website/source/css/profile.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body>
<?php require_once '../parts/company_profile_navbar.php'; ?>
    <form class="form">
        <div class="row">
            <div class="field">
                <div class="file" >
                    <label class="file-label">
                        <input class="file-input" type="file" name="profilePic" disabled>
                        <figure class="image is-128x128">
                            <img class="is-rounded" src="../../source/img/user-icon.png">
                        </figure>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Company Name</label>
                <div class="control">
                    <input name="country" class="input disabling" type="text" placeholder="Company Name" disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Slogan</label>
                <div class="control">
                    <input name="state" class="input disabling" type="text" placeholder="Company Slogan" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <div class="field">
                    <label class="label">Description</label>
                    <div class="control">
                        <textarea  name="description" class="textarea input disabling" placeholder="Description of the Company" disabled></textarea>
                    </div>
                </div>
            </div>
        </div>
        <hr class="solid">
        <div class="row">
            <div class="field">
                <label class="label" for="email">Email</label>
                <div class="control">
                    <input name="email" id="email" class="input disabling" type="text" placeholder="$user->email" disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Password</label>
                <button type="button" class="button js-modal-trigger" data-target="modal-js-example">Change Password</button>
            </div>
        </div>
        <hr class="solid">
        <div class="row">
            <div class="field">
                <label class="label">Country</label>
                <div class="control">
                    <input name="country" class="input disabling" type="text" placeholder="Country" disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">State</label>
                <div class="control">
                    <input name="state" class="input disabling" type="text" placeholder="State" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Postal Code</label>
                <div class="control">
                    <input name="postalcode" class="input disabling" type="text" placeholder="Postal Code" disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">City</label>
                <div class="control">
                    <input name="city" class="input disabling" type="text" placeholder="City" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Street</label>
                <div class="control">
                    <input name="street" class="input disabling" type="text" placeholder="Street" disabled>
                </div>
            </div>
            <div class="field">
                <label class="label">Street Num.</label>
                <div class="control">
                    <input name="streetnumber" class="input disabling" type="text" placeholder="Street Number" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="table-container">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Job</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>$job->title</td>
                        <td>$jb->description</td>
                        <td>
                            <button class="button is-danger is-outlined is-rounded disabling" type="button" disabled>
                                <span class="icon is-small">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>$job->title</td>
                        <td>$jb->description</td>
                        <td>
                            <button class="button is-danger is-outlined is-rounded disabling" type="button" disabled>
                                <span class="icon is-small">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>$job->title</td>
                        <td>$jb->description</td>
                        <td>
                            <button class="button is-danger is-outlined is-rounded disabling" type="button" disabled>
                                <span class="icon is-small">
                                    <i class="fas fa-trash"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>$job->title</td>
                        <td>$jb->description</td>
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
        <diV class="row edit">
            <button type="button" class="button is-link" onclick="edit()">Edit Profile</button>
        </diV>
        <div class="row cancel hide">
            <button type="button" class="button" onclick="cancel()">Cancel</button>
            <button class="button is-link">Change</button>
        </div>
    </div>
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

<script src="../../source/js/hideButton.js"></script>
<script src="../../source/js/modal.js"></script>
<script src="../../source/js/checkpassword.js"></script>
<script src="../../source/js/navbar.js"></script>