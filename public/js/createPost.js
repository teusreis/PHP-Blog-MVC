const form = document.querySelector("form#post");
const title = form.title;
const description = form.description;
const btnDelete = document.querySelector(".btnExPara");
const btnAdd = document.querySelector(".btnNewPara");
const paraContainer = document.querySelector(".paragraph-container");
let paras = paraContainer.querySelectorAll(".form-group");

title.addEventListener("change", () => {
    checkTitle();
});

description.addEventListener("change", () => {
    checkDesc();
});

addEvent();

function addEvent(){
    paras.forEach( para => {
        para.addEventListener("change", () => {
            checkPara(para);
        });
    });
};

form.addEventListener("submit", (event) => {
    event.preventDefault();
    let error = [];

    error.push(checkTitle());
    error.push(checkDesc());
    error.push(checkPara());
 
    if(error.includes(false)){
        alert("Ops! There're some errors.");
    } else {
        form.submit();
    }

});

btnAdd.addEventListener("click", (event) => {
    event.preventDefault();

    if (paras.length >= 10) {
        alert("Max of 10 paragraphes per post!");
        return;
    }

    let index = ++paras.length;

    let html = `
        <div class="form-group">
            <label for="">Paragraph ${index}</label>
            <textarea name="post[paragraph][]" id="" cols="30" rows="10"></textarea>
            <div class="errorMenagem"></div>
        </div>
    `;

    let newPara = document.createRange().createContextualFragment(html);
    paraContainer.appendChild(newPara);
    paras = paraContainer.querySelectorAll(".form-group");
    addEvent();
});

btnDelete.addEventListener("click", (event) => {
    event.preventDefault();

    if (paras.length == 1) {
        alert("Your post must have at least one paragraph!");
        return;
    }

    paraContainer.removeChild(paras[paras.length - 1]);
    paras = paraContainer.querySelectorAll(".form-group");
});

function checkTitle() {
    if (title.value === "") {
        title.parentNode.classList.remove("success");
        title.parentNode.classList.add("error");
        title.parentNode.querySelector(".errorMenagem").textContent = "Title is required!";
        return false;
    } else if (title.value.length > 50) {
        title.parentNode.classList.remove("success");
        title.parentNode.classList.add("error");
        title.parentNode.querySelector(".errorMenagem").textContent = "Title must not be greiter than 50 characters!";
        return false;
    } else {
        title.parentNode.classList.remove("error");
        title.parentNode.classList.add("success");
        title.parentNode.querySelector(".errorMenagem").textContent = "";
        return true;
    }  
}

function checkDesc() {
    if (description.value === "") {
        description.parentNode.classList.remove("success");
        description.parentNode.classList.add("error");
        description.parentNode.querySelector(".errorMenagem").textContent = "description is required!";
        return false;
    } else if (description.value.length > 255) {
        description.parentNode.classList.remove("success");
        description.parentNode.classList.add("error");
        description.parentNode.querySelector(".errorMenagem").textContent = "description must not be greiter than 250 characters!";
        return false;
    } else {
        description.parentNode.classList.remove("error");
        description.parentNode.classList.add("success");
        description.parentNode.querySelector(".errorMenagem").textContent = "";
        return true;
    }  
}

function checkPara(para = "") {
    let hasError = true;
    if(para == "") {
        paras.forEach( para => {
            let paragraph = para.querySelector("textarea");

            if(paragraph.value == ""){
                paragraph.parentNode.classList.remove("success");
                paragraph.parentNode.classList.add("error");
                paragraph.parentNode.querySelector(".errorMenagem").textContent = "paragraph is required!";
                hasError = false;
            } else {
                paragraph.parentNode.classList.remove("error");
                paragraph.parentNode.classList.add("success");
                paragraph.parentNode.querySelector(".errorMenagem").textContent = "";
            }
            
        });
    } else {
        let paragraph = para.querySelector("textarea");

        if(paragraph.value == ""){
            paragraph.parentNode.classList.remove("success");
            paragraph.parentNode.classList.add("error");
            paragraph.parentNode.querySelector(".errorMenagem").textContent = "paragraph is required!";
            hasError = false;
        } else {
            paragraph.parentNode.classList.remove("error");
            paragraph.parentNode.classList.add("success");
            paragraph.parentNode.querySelector(".errorMenagem").textContent = "";
        }
    }

    return hasError;
}