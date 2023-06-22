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

function hide_show_something(ID) {

    if (document.getElementById(ID).style.display == "none") {

        document.getElementById(ID).style.display = "block";

    } else {

        document.getElementById(ID).style.display = "none";

    }
}

function test (button, card)
{
    var buttons = document.querySelectorAll(button);
    var contents = document.querySelectorAll(card);

    buttons.forEach((item) =>
        item.addEventListener("click", function(e) {
            const content = document.querySelector(`#${this.id}-content`);
            content.classList.toggle("show");

            contents.forEach((item) => {
                if (!item.id.startsWith(this.id)) {
                    item.classList.remove("show");
                }
            });
        })
    );
}

/*
function test (ID)
{
    var x = document.getElementById(ID);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}*/