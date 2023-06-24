
function myFunction() {
    // Declare variables
    var input, filter, ul, li, a, i, j, txtValue;
    input = document.getElementById('searchbar');
    filter = input.value.toUpperCase();
    ul = document.getElementsByTagName("header");
    for (i = 0; i < ul.length; i++){
        li = ul[i].getElementsByTagName("p");
        console.log(li[0].innerText);

        txtValue = li[0].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            ul[i].style.display = "";
        }
        else {
            ul[i].style.display = "none";
        }
    }
}