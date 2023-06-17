let editElement = document.querySelector('.edit');
let cancelElement = document.querySelector('.cancel');

function edit() {
    cancelElement.classList.toggle("hide");
    editElement.classList.toggle("hide");
    disabled();
    console.log("test");
}

function cancel() {
    editElement.classList.toggle("hide");
    cancelElement.classList.toggle("hide");
    disabled();
}

function disabled() {
    let disables = document.querySelectorAll(".disabling");

    if (disables[0].disabled) {
        console.log("thats the correct way");
        disables.forEach(disable => {
            disable.removeAttribute("disabled");
        })
    } else {
        disables.forEach(disable => {
            disable.setAttribute("disabled", "");
        });
    }  
}