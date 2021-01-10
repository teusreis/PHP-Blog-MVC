import { deletePost } from "./_async.js";

const postContainer = document.querySelector(".cardContainer");
const posts = postContainer.querySelectorAll(".post");

const askDelete = document.querySelectorAll(".deletePost");
const btnCancel = document.querySelector("#cancel");
const btnDelete = document.querySelector("#delete");
const modal = document.querySelector(".modal");

// Auxiliar variables
var id;
var indexPost;

askDelete.forEach(btn => {
    btn.addEventListener("click", (event) => {

        if (event.target.dataset.id == undefined) {
            return;
        }

        scrollTo(0, 0);
        let mensagem = `Do you really want to delete the post: #${event.target.dataset.id} - ${event.target.dataset.title}`;

        /* 
            The following lines load two auxiliar variables!
            The fist one is the post's id that will be deleted
            The second one is the postCard's index;
        */
        id = event.target.dataset.id;
        indexPost = event.target.dataset.index;

        modal.querySelector("p").textContent = mensagem;
        modal.style.display = "block";

    });
});

btnDelete.addEventListener("click", () => {
    deletePost(id)
        .then(data => {
            if (data.status === 200) {
                alert(data.body);
                modal.style.display = "none";
                postContainer.removeChild(posts[indexPost]);
            }
        }).catch(error => {
            console.log(error);
        });
});

btnCancel.addEventListener("click", (event) => {
    modal.style.display = "none";
});

