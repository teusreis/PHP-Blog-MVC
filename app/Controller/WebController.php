<?php

namespace App\Controller;

use App\Model\Post;
use App\Library\Controller;

class WebController extends Controller
{
    private Post $post;

    public function __construct()
    {
        $this->post = new Post();
    }

    public function index()
    {
        $posts = $this->post->findAll();

        $this->render("web/index.php", [
            "posts" => $posts,
            "css" => "indexPage"
        ]);
    }
}
