<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../style/bulma.css">
    <link rel="stylesheet" href="../../style/side_navbar.css">
</head>
<body>
<nav class="navbar is-black" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item">
            <img src="../../style/img/jobify_slogan.png" alt="Jobify">
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item">
                Published Jobs
            </a>
            <a class="navbar-item">
                Applications
            </a>
            <a class="navbar-item">
                Headhunting
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    More
                </a>
                <div class="navbar-dropdown">
                    <a class="navbar-item">
                        About
                    </a>
                    <a class="navbar-item">
                        Contact
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item">
                        Report an issue
                    </a>
                </div>
            </div>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-white">
                        <strong>Account</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
<nav class="sidebar">
    <aside class="menu">
        <form>
            <div class="bd-sidebar-search">
                <input id="sidebarSearch" class="input is-small" type="text" name placeholder="Search Applicant">
                <span class="bd-key">f</span>
            </div>
            <p class="menu-label">
                Header 1
            </p>
            <ul class="menu-list">
                <li><a>Subheader1</a></li>
                <li><a>Subheader2</a></li>
            </ul>
            <p class="menu-label">
                Header 2
            </p>
        </form>
    </aside>
</nav>
</body>
</html>
<script src="../../scripts/dropdown.js"></script>


<?php
