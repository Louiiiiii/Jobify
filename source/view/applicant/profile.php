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
                                <button class="button is-danger is-outlined disabling" type="button" disabled>
                                    <span>Delete</span>
                                    <span class="icon is-small">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <td>LAP Zeugnis</td>
                            <td>.pdf</td>
                            <td>
                                <button class="button is-danger is-outlined disabling" type="button" disabled>
                                    <span>Delete</span>
                                    <span class="icon is-small">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <th>3</th>
                            <td>Matura Zeugnis</td>
                            <td>.png</td>
                            <td>
                                <button class="button is-danger is-outlined disabling" type="button" disabled>
                                    <span>Delete</span>
                                    <span class="icon is-small">
                                        <i class="fas fa-times"></i>
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
</body>
</html>

<script src="../../scripts/hideButton.js"></script>