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
                        <input class="file-input" type="file" name="profilePic">
                        <figure class="image is-128x128">
                            <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
                        </figure>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Firstname</label>
                <div class="control">
                    <input name="firstname" class="input" type="text" placeholder="Firstname" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Lastname</label>
                <div class="control">
                    <input name="lastname" class="input" type="text" placeholder="Lastname" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Birthday</label>
                <div class="control">
                    <input name="birthday" class="input" type="date" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Country</label>
                <div class="control">
                    <input name="country" class="input" type="text" placeholder="Country" required>
                </div>
            </div>
            <div class="field">
                <label class="label">State</label>
                <div class="control">
                    <input name="state" class="input" type="text" placeholder="State" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Postal Code</label>
                <div class="control">
                    <input name="postalcode" class="input" type="text" placeholder="Postal Code" required>
                </div>
            </div>
            <div class="field">
                <label class="label">City</label>
                <div class="control">
                    <input name="city" class="input" type="text" placeholder="City" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Street</label>
                <div class="control">
                    <input name="street" class="input" type="text" placeholder="Street" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Street Num.</label>
                <div class="control">
                    <input name="streetnumber" class="input" type="text" placeholder="Street Number" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Highest Degree</label>
                <div class="select">
                    <select name="degree" required>
                        <option value="highest">Highest Degree</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="field">
                <label class="label">Industry</label>
                <div class="select">
                    <select name="industry" required>
                        <option value="industry">Industry</option>
                    </select>
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
        <div class="row">
            <div class="field">
                <div class="file">
                    <label class="file-label">
                        <input class="file-input" type="file" name="file">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">Choose a file…</span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div>
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
                            <td><button type="button">delete</button></td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <td>LAP Zeugnis</td>
                            <td>.pdf</td>
                            <td><button type="button">delete</button></td>
                        </tr>
                        <tr>
                            <th>3</th>
                            <td>Matura Zeugnis</td>
                            <td>.png</td>
                            <td><button type="button">delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <diV class="row">
            <button class="button is-link" disabled>Change</button>
        </diV>
    </form>
</body>
</html>