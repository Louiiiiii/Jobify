let dropdown = document.querySelector('.dropdown');
let dropdownItems = document.querySelectorAll('.dropdown-item');
let activeDropdownItem = document.querySelector('.dropdown-item.is-active');
let selectedItem = document.querySelector('.selected-item');

dropdown.addEventListener('click', function(event) {
    event.stopPropagation();
    dropdown.classList.toggle('is-active');
});

dropdownItems.forEach(dropdownItem => {
    dropdownItem.addEventListener('click', function(event) {
        event.stopPropagation();
        dropdownItem.classList.toggle('is-active');
        activeDropdownItem.classList.toggle('is-active');

        activeDropdownItem = document.querySelector('.dropdown-item.is-active');
        selectedItem.innerHTML = activeDropdownItem.innerHTML;
        selectedItem.classList.remove('select-role')
    });
});