import { deletePost } from "./_async.js";

const askDelete = document.querySelector(".deletePost");

const btnCancel = document.querySelector("#cancel");
const btnDelete = document.querySelector("#delete");
const modal = document.querySelector(".modal");

var id;

askDelete.addEventListener("click", (event) => {

    if (event.target.dataset.id == undefined) {
        return;
    }
    scrollTo(0, 0);
    document.body.style.overflow = "hidden";
    
    let mensagem = `Do you really want to delete the post: #${event.target.dataset.id} - ${event.target.dataset.title}`;

    /* 
        The following lines load two auxiliar variables!
        The fist one is the post's id that will be deleted
        The second one is the postCard's index;
    */
    id = event.target.dataset.id;

    modal.querySelector("p").textContent = mensagem;
    modal.style.display = "block";

});

btnDelete.addEventListener("click", () => {
    deletePost(id)
        .then(data => {
            if (data.status === 200) {
                alert(data.body);
                window.location.href = "http://localhost/blog/public/post/myPost";
            }
        }).catch(error => {
            console.log(error);
        });
});

btnCancel.addEventListener("click", (event) => {
    modal.style.display = "none";
    document.body.style.overflow = "auto";
});

