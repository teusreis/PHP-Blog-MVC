const form = document.querySelector("form");
const email = form.email;
const password = form.password;

email.addEventListener("change", () => {
    checkEmail();
});

password.addEventListener("change", () => {
    checkPassword();
});

form.addEventListener("submit", (event) => {
    event.preventDefault();

    let error = [];
    error.push(checkEmail());
    error.push(checkPassword());

    if(error.includes(false)){
        alert("Ops! There's some errors!");
    } else {
        form.submit();
    }
});

function checkEmail() {
    let valid = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    if (email.value === "") {
        email.parentNode.classList.remove("success");
        email.parentNode.classList.add("error");
        email.parentNode.querySelector(".errorMenagem").textContent = "email is required!";
        return false;
    } else if (!valid.test(email.value)) {
        email.parentNode.classList.remove("success");
        email.parentNode.classList.add("error");
        email.parentNode.querySelector(".errorMenagem").textContent = `${email.value} is not a valid email addres`;
        return false;
    } else {
        email.parentNode.classList.remove("error");
        email.parentNode.classList.add("success");
        email.parentNode.querySelector(".errorMenagem").textContent = "";
        return true;
    }
}

function checkPassword() {
    if (password.value === "") {
        password.parentNode.classList.remove("success");
        password.parentNode.classList.add("error");
        password.parentNode.querySelector(".errorMenagem").textContent = "password is required!";
        return false;
    } else {
        password.parentNode.classList.remove("error");
        password.parentNode.classList.add("success");
        password.parentNode.querySelector(".errorMenagem").textContent = "";
        return true;
    }
}