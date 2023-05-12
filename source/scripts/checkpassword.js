function checkpw() {
    const password = document.getElementById("password").value;
    const repeatPassword = document.getElementById("repeatpassword").value;

    if (password !== repeatPassword) {
        document.getElementById("checkpasswordtext").innerHTML = "Password do not match"
        document.getElementById("checkpasswordtext").style.color = "red"
    } else {
        document.getElementById("checkpasswordtext").innerHTML = "Password matches"
        document.getElementById("checkpasswordtext").style.color = "green"
    }
}