function recuperarPass() {
    const login = document.getElementById("login");
    const recuperarPass = document.getElementById("recuperarPass");
    const flipboxinner = document.getElementById("flipboxinner");

    if (login.classList.contains("active")) {
        login.classList.remove("active");
        recuperarPass.classList.add("active");

        flipboxinner.style.transform = "rotateY(180deg)";
    } else {
        recuperarPass.classList.remove("active");
        login.classList.add("active");

        flipboxinner.style.transform = "rotateY(0deg)"; 
    }
}


function voltarLogin() {
    const login = document.getElementById("login");
    const recuperarPass = document.getElementById("recuperarPass");
    const flipboxinner = document.getElementById("flipboxinner");

    recuperarPass.classList.remove("active");
    login.classList.add("active");

    flipboxinner.style.transform = "rotateY(0deg)"; 
}

