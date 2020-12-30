<?php

namespace App\Controller;

use App\Model\User;
use App\Library\Controller;

class UserController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function login()
    {
        if (isset($_POST['login'])) {

            $response = $this->serialize($_POST['login']);

            extract($response);

            if ($this->user->login($email, $password)) {
                $this->redirect("/");
            }
        }

        $this->render("user/login.php", [
            "css" => "login",
            "error" => $this->user->error ?? null
        ]);
    }

    public function logout()
    {
        $this->user->logout();

        $this->redirect("/");
    }

    public function register()
    {
        if (isset($_POST['user'])) {

            extract($_POST['user']);
            $this->user->setName($name)
                ->setLastname($lastName)
                ->setEmail($email)
                ->setNickname($nickname)
                ->setPassword($password, $confirmPassword);

            if ($this->user->save()) {
                $this->redirect("/");
            }
        }

        $this->render("user/register.php", [
            "css" => "login",
            "error" => $this->user->error ?? []
        ]);
    }

    public function nickname()
    {
        $data = [];
        if ($this->user->nicknameExist($_GET["nickname"])) {
            $data['exist'] = true;
            $data['message'] = "This nickname have alredy been taken by another user!";
        } else {
            $data['exist'] = false;
        }

        echo json_encode($data);
    }

    public function email()
    {
        $data = [];
        if ($this->user->emailExist($_GET["email"])) {
            $data['exist'] = true;
            $data['message'] = "This email have alredy been taken by another user!";
        } else {
            $data['exist'] = false;
        }

        echo json_encode($data);
    }
}
