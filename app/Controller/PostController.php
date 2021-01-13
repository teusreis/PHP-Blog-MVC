<?php

namespace App\Controller;

use App\Model\Post;
use App\Model\User;
use App\Library\Controller;
use CoffeeCode\Paginator\Paginator;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    private Post $post;
    private User $user;

    public function __construct()
    {
        $this->post = new Post();
        $this->user = new User();

        parent::__construct();
    }

    public function index()
    {
        if (!isLogin()) {
            $this->redirect("login");
            http_response_code(403);
        }

        $posts = $this->user->posts();

        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $link = url("/post/myPost?page=");
        $paginator = new Paginator($link, "Pages", ["First Page", "First Page"], ["Last Page", "Last Page"]);
        $paginator->pager(count($posts), 10, $page, 3);

        $posts = $this->user->posts($paginator->offset(), $paginator->limit());

        $this->render("post/index.php", [
            "posts" => $posts,
            "paginator" => $paginator,
            "css" => "myPosts"
        ]);
    }

    public function search($data)
    {
        $data = $this->serialize($_GET);

        $posts = $this->post->findByTitle($data["search"]);

        $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
        $link = url("/post/search?search={$data["search"]}&page=");
        $paginator = new Paginator($link, "Pages", ["First Page", "First Page"], ["Last Page", "Last Page"]);
        $paginator->pager(count($posts), 10, $page, 3);

        $posts = $this->post->findByTitle($data["search"], $paginator->offset(), $paginator->limit());

        $this->render("post/search.php", [
            "posts" => $posts,
            "css" => "search",
            "paginator" => $paginator,
            "search" => $data["search"]
        ]);
    }

    public function show($data)
    {
        $post = $this->post->find($data['id']);

        $post->paragraph = explode("{{paragraphEnd}}", $post->paragraph);

        $this->render("post/show.php", [
            "post" => $post,
            "css" => "showPost"
        ]);
    }

    public function create()
    {
        if (!isLogin()) {
            $this->redirect("login");
            http_response_code(403);
        }

        if (isset($_POST['post'])) {
            $data = $this->serialize($_POST['post']);
            $data['paragraph'] = $this->serialize($_POST['post']['paragraph']);

            extract($data);

            $this->post->setTitle($title)
                ->setDescription($description)
                ->setParagraph($paragraph)
                ->setPhotoPath($_FILES);

            if ($this->post->save()) {
                $this->redirect("post/myPost");
            }
        }

        $this->render("post/newPost.php", [
            "css" => "newPost"
        ]);
    }

    public function edit($data)
    {
        $id = $data["id"];

        if (isset($_POST['post'])) {


            $post = $this->post->findByPk($_POST["id"]);

            if (!canModify($post->user_id)) {
                $this->redirect("/");
            }

            $data = $this->serialize($_POST['post']);
            $data['paragraph'] = $this->serialize($_POST['post']['paragraph']);

            extract($data);

            $this->post->setTitle($title)
                ->setDescription($description)
                ->setParagraph($paragraph)
                ->setPhotoPath($_FILES, $oldBanner);

            if ($this->post->update($_POST['id'])) {
                $this->redirect("post/myPost");
            }
        }

        $post = $this->post->findByPk($id);

        if (!canModify($post->user_id)) {
            $this->redirect("/");
        }

        $post->paragraph = explode("{{paragraphEnd}}", $post->paragraph);

        $this->render("post/newPost.php", [
            "post" => $post,
            "id" => $id,
            "css" => "newPost",
        ]);
    }

    public function delete()
    {
        $data = [];
        $delete = json_decode(file_get_contents("php://input"));

        $post = $this->post->findByPk($delete->id);

        if (!canModify($post->user_id)) {
            $data['status'] = 403;
            $data['body'] = "You are not allowed to perfor this action!";
            http_response_code(403);
        } else {

            $deleted = $this->post->delete($post->id);

            if ($deleted) {
                $data['status'] = 200;
                $data['body'] = "Post deleted successfully";
            }
        }

        echo json_encode($data);
    }
}
