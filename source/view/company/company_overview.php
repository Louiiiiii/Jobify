<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../../style/bulma.css">
    <link rel="stylesheet" href="../../style/profile.css">
    <link rel="stylesheet" href="../../style/icons/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,700,1,0" />    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    <script src="https://kit.fontawesome.com/12c744b539.js" crossOrigin="anonymous"></script>
</head>
<body>
<form class="form">
    <div class="row">
        <div class="field">
            <div class="file" >
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
            <label class="label">Company Name</label>
            <div class="control">
                <input name="country" class="input" type="text" placeholder="Company Name">
            </div>
        </div>
        <div class="field">
            <label class="label">Slogan</label>
            <div class="control">
                <input name="state" class="input" type="text" placeholder="Company Slogan">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="field">
            <label class="label" >Description</label>
            <div class="control">
                <input name="description" class="input" type="text" placeholder="Company Description">
            </div>
        </div>
    </div>
    <hr class="solid">
    <div class="row">
        <div class="field">
            <label class="label" for="email">Email</label>
            <div class="control">
                <input name="email" id="email" class="input" type="text" placeholder="$user->email">
            </div>
        </div>
        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input name="password" class="input" type="text" placeholder="$user->password">
            </div>
        </div>
    </div>
    <hr class="solid">
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
    <diV class="row">
        <div class="column"></div>
        <button class="button is-link">Change</button>
        <div></div>
    </diV>
</form>
<div class="row box" >
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
                <td><button type="submit" style="background: none; border: none" ><span class="icon"><i class="fa-solid fa-file-pen fa-2xl"></i></span></button></td>
            </tr>
            <tr>
                <td>$job->title</td>
                <td>$jb->description</td>
                <td><button type="submit" style="background: none; border: none" ><span class="icon"><i class="fa-solid fa-file-pen fa-2xl"></i></span></button></td>
            </tr>
            <tr>
                <td>$job->title</td>
                <td>$jb->description</td>
                <td><button type="submit" style="background: none; border: none" ><span class="icon"><i class="fa-solid fa-file-pen fa-2xl"></i></span></button></td>
            </tr>
            <tr>
                <td>$job->title</td>
                <td>$jb->description</td>
                <td><button type="submit" style="background: none; border: none" ><span class="icon"><i class="fa-solid fa-file-pen fa-2xl"></i></span></button></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>