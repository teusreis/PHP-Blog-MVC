const ham = document.querySelector(".hamburguer");
const navMenu = document.querySelector(".navbar nav");

ham.addEventListener("click", () => {
    if(!navMenu.classList.contains("active")){
        navMenu.classList.add("active");
        document.body.style.overflow = "hidden";
    } else {
        navMenu.classList.remove("active");
        document.body.style.overflow = "auto";
    }
});