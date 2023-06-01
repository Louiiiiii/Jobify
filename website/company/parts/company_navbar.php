<?php
    echo "<script>";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/source/scripts/navbar.js";      
    echo "</script>";
?>
<!--Navbar Company Home -->
<nav class="navbar is-black has-shadow" id="comNavHome" role="navigation" aria-label="main navigation">
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
                Published Jobs
            </a>
            <a class="navbar-item">
                Applicants
            </a>
            <a class="navbar-item">
                Headhunting
            </a>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-white">
                        <strong>Profile</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
<!--Filter -->
<div class="card">
    <header class="card-header">
        <p class="card-header-title">
        <h1>Mein Name lena wurmsdobler suiiii</h1>
        </p>
        <button class="card-header-icon" aria-label="more options">
      <span class="icon">
        <i class="fas fa-angle-down" aria-hidden="true"></i>
      </span>
        </button>
    </header>
    <div class="card">
        <div class="card-content">
            <div class="content">
                Lorem ipsum leo risus, porta ac consectetur ac, vestibulum at eros. Donec id elit non mi porta gravida at eget metus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras mattis consectetur purus sit amet fermentum.
            </div>
        </div>
    </div>
</div>



