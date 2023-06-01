document.addEventListener('DOMContentLoaded', () => {

    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
        el.addEventListener('click', () => {

            // Get the target from the "data-target" attribute
            const target = el.dataset.target;
            const $target = document.getElementById(target);

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');
        });
    });
});

function toggleNavbars() {
   alert('pipipupu');

   var comNavHome= document.getElementById("comNavHome");
   var comNavProfile = document.getElementById("comNavProfile");


    if (window.getComputedStyle(comNavHome).display === "none") {
        alert('Com Nav home is hidden')
        comNavHome.style.display = "block"
        comNavProfile.style.display = "none";
    } else {
        alert('Com Nav Company is hidden')
        comNavHome.style.display = "none";
        comNavProfile.style.display = "block";
    }
}