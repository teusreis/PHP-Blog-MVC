import { nicknakeExist, emailExist } from "./_async.js";

const form = document.querySelector("form#register");
const username = form.name;
const lastName = form.lastName;
const nickname = form.nickname;
const email = form.email;
const password = form.password;
const confirmPassword = form.confirmPassword;

username.addEventListener("change", () => {
    checkName();
});

lastName.addEventListener("change", () => {
    checkLastName();
});

nickname.addEventListener("change", () => {
    checkNicname();
})

email.addEventListener("change", () => {
    checkEmail();
});

password.addEventListener("change", () => {
    checkPassword();
});

confirmPassword.addEventListener("change", () => {
    checkConfirmPassword();
});

form.addEventListener("submit", (event) => {
    event.preventDefault();
    let error = [];

    error.push(checkName());
    error.push(checkLastName());
    error.push(checkNicname());
    error.push(checkEmail());
    error.push(checkPassword());
    error.push(checkConfirmPassword());

    if (error.includes(false)) {
        alert("Ops! There's some errors!");
    } else {
        form.submit();
    }
})

function checkName() {
    if (username.value === "") {
        username.parentNode.classList.remove("success");
        username.parentNode.classList.add("error");
        username.parentNode.querySelector(".errorMenagem").textContent = "Last name is required!";
        return false;
    } else if (username.value.length > 50) {
        username.parentNode.classList.remove("success");
        username.parentNode.classList.add("error");
        username.parentNode.querySelector(".errorMenagem").textContent = "Last name must not be greiter than 50 characters!";
        return false;
    } else {
        username.parentNode.classList.remove("error");
        username.parentNode.classList.add("success");
        username.parentNode.querySelector(".errorMenagem").textContent = "";
        return true;
    }
}

function checkLastName() {
    if (lastName.value === "") {
        lastName.parentNode.classList.remove("success");
        lastName.parentNode.classList.add("error");
        lastName.parentNode.querySelector(".errorMenagem").textContent = "Last name is required!";
        return false;
    } else if (lastName.value.length > 50) {
        lastName.parentNode.classList.remove("success");
        lastName.parentNode.classList.add("error");
        lastName.parentNode.querySelector(".errorMenagem").textContent = "Last name must not be greiter than 50 characters!";
        return false;
    } else {
        lastName.parentNode.classList.remove("error");
        lastName.parentNode.classList.add("success");
        lastName.parentNode.querySelector(".errorMenagem").textContent = "";
        return true;
    }
}

function checkNicname() {
    if (nickname.value === "") {
        nickname.parentNode.classList.remove("success");
        nickname.parentNode.classList.add("error");
        nickname.parentNode.querySelector(".errorMenagem").textContent = "Nickname is required!";
        return false;
    } else if (nickname.value.length > 50) {
        nickname.parentNode.classList.remove("success");
        nickname.parentNode.classList.add("error");
        nickname.parentNode.querySelector(".errorMenagem").textContent = "Nickname must not be greiter than 50 characters!";
        return false;
    }

    nicknakeExist(nickname.value).then(data => {
        if (data.exist) {
            nickname.parentNode.classList.remove("success");
            nickname.parentNode.classList.add("error");
            nickname.parentNode.querySelector(".errorMenagem").textContent = data.message;
            return false;
        }
    }).catch(error => {
        console.log(error);
        return false;
    })

    nickname.parentNode.classList.remove("error");
    nickname.parentNode.classList.add("success");
    nickname.parentNode.querySelector(".errorMenagem").textContent = "";
    return true;
}

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
    }

    emailExist(email.value).then(data => {
        if (data.exist) {
            email.parentNode.classList.remove("success");
            email.parentNode.classList.add("error");
            email.parentNode.querySelector(".errorMenagem").textContent = data.message;
            return false;
        }
    }).catch(error => {
        console.log(error);
        return false;
    })

    email.parentNode.classList.remove("error");
    email.parentNode.classList.add("success");
    email.parentNode.querySelector(".errorMenagem").textContent = "";
    return true;

}

function checkPassword() {
    if (password.value === "") {
        password.parentNode.classList.remove("success");
        password.parentNode.classList.add("error");
        password.parentNode.querySelector(".errorMenagem").textContent = "password is required!";
        return false;
    } else if (password.value.length < 6) {
        password.parentNode.classList.remove("success");
        password.parentNode.classList.add("error");
        password.parentNode.querySelector(".errorMenagem").textContent = "Your password is not strong enough!";
        return false;
    } else if (password.value !== confirmPassword.value) {
        password.parentNode.classList.remove("success");
        password.parentNode.classList.add("error");
        password.parentNode.querySelector(".errorMenagem").textContent = "Your password does not metch with confirm password!";
    } else {
        password.parentNode.classList.remove("error");
        password.parentNode.classList.add("success");
        password.parentNode.querySelector(".errorMenagem").textContent = "";
    }
}

function checkConfirmPassword() {
    if (confirmPassword.value === "") {
        confirmPassword.parentNode.classList.remove("success");
        confirmPassword.parentNode.classList.add("error");
        confirmPassword.parentNode.querySelector(".errorMenagem").textContent = "Confirm Password is required!";
        return false;
    } else {
        confirmPassword.parentNode.classList.remove("error");
        confirmPassword.parentNode.classList.add("success");
        confirmPassword.parentNode.querySelector(".errorMenagem").textContent = "";
        checkPassword();
        return true;
    }
}