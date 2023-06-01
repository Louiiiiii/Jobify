<?php
    echo "<script>";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/source/scripts/navbar.js";      
    echo "</script>";
?>
<nav class="navbar is-black has-shadow" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
            <img src="../../../source/style/img/jobify_slogan.png">
        </a>
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item">
                Available Jobs
            </a>
            <a class="navbar-item">
                Applications
            </a>
            <a class="navbar-item">
                Favorites
            </a>
            <a class="navbar-item">
                Requested Jobs
            </a>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                </div>
            </div>
        </div>
    </div>
</nav>