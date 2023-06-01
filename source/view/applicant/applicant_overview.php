<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../../style/bulma.css">
    <link rel="stylesheet" href="../../style/tabs.css">
    <script src="https://kit.fontawesome.com/12c744b539.js" crossOrigin="anonymous"></script>
    <script src="../../scripts/tabs.js" crossOrigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div class="tabs is-centered is-boxed">
        <ul>
            <li><a><span class="icon tabLinks" onclick="openTab(event,'Available')"><i class="fa-solid fa-list"></i></span><span>Available</span></a></li>
            <li><a><span class="icon tabLinks" onclick="openTab(event,'Applications')"><i class="fa-solid fa-paper-plane"></i></span><span>Applications</span></a></li>
            <li><a><span class="icon tabLinks" onclick="openTab(event,'Favorites')"><i class="fa-solid fa-heart"></i></span><span>Favorites</span></a></li>
            <li><a><span class="icon tabLinks" onclick="openTab(event,'Requested')"><i class="fa-solid fa-building"></i></i></span><span>Requested Jobs</span></a></li>
        </ul>
    </div>
    <div class="tabs">
        <ul>
        <li><button class="tablinks" onclick="openTab(event, 'London')" style="background: none; border: none">London</button></li>
        <button class="tablinks" onclick="openTab(event, 'Paris')">Paris</button>
        <button class="tablinks" onclick="openTab(event, 'Tokyo')">Tokyo</button>
        </ul>
    </div>
<p id="demo"></p>
    <!-- Tab content -->
    <div id="London" class="tabcontent">
        <h3>London</h3>
        <p>London is the capital city of England.</p>
    </div>

    <div id="Paris" class="tabcontent">
        <h3>Paris</h3>
        <p>Paris is the capital of France.</p>
    </div>

    <div id="Tokyo" class="tabcontent">
        <h3>Tokyo</h3>
        <p>Tokyo is the capital of Japan.</p>
    </div>
    <div id="Requested" class="tabcontent">
        <h3>Requested</h3>
        <p>Tokyo is the capital of Japan.</p>
    </div>
</div>
</body>
</html>