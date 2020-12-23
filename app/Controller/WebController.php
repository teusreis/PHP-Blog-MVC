<?php

namespace App\Controller;

use App\Library\Controller;

class WebController extends Controller
{

    public function index()
    {
        $this->render("index.php");
    }
}
