document.addEventListener('click', function classClicked(event) {
    if (event.target.classList.contains("fa-heart")) {
        event.target.classList.toggle('liked');
    }
});