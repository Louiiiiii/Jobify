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
        <p class="title is-2">Create User</p>
        <div class="card-content">
            <div class="card-content__body">
                <form style="height: 100%">
                    <div class="row">
                        <div class="field">
                            <label class="label">Company</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Company Name">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Slogan</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Slogan">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Country</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Country">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">State</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="State">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Postal Code</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Postal Code">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">City</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="City">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Street</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Street">
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Street Num.</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Street Number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field">
                            <label class="label">Description</label>
                            <textarea class="textarea" placeholder="Description of the Company"></textarea>
                        </div>
                    </div>
                    <diV class="row company-row">
                        <button class="button is-link">Submit</button>
                    </diV>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<script src="../../scripts/dropdown.js"></script>