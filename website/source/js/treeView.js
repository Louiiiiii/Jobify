var toggler = document.getElementsByClassName("caret");

for (var i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    for (var j = 0; j < this.parentElement.querySelectorAll(".nested").length; j++) {
      this.parentElement.querySelectorAll(".nested")[j].classList.toggle("active");
    }
    this.parentElement.querySelector(".triangle").classList.toggle("triangle-down");
  });
}