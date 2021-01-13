<?php

namespace App\Controller;

use App\Library\Controller;
use Faker\Factory;
use App\Model\Post;
use App\Model\User;

class FakerController extends Controller
{
    private User $user;
    private Post $Post;

    public function __construct()
    {
        $this->user = new User();
        $this->post = new Post();
    }

    public function users($data)
    {
        $qtd = $data["qtd"] ?? 5;

        $faker = Factory::create();

        for ($i = 0; $i < $qtd; $i++) {
            $name = $faker->firstName();
            $lastName = $faker->lastName();
            $email = $faker->email();
            $nickname = $faker->sentence(1, false);
            $password = "123456";

            $this->user->setName($name)
                ->setLastname($lastName)
                ->setEmail($email)
                ->setNickname($nickname)
                ->setPassword($password, $password);

            $this->user->save();
        }

        $this->redirect("/");
    }

    public function posts($data)
    {

        if($data["id"] == null || $data["id"] == "null") $data["id"] = getUserId();

        $qtd = $data["qtd"] ?? 5;
        

        $faker = Factory::create();

        for ($i = 0; $i < $qtd; $i++) {

            $title = $faker->sentence(2);
            $description = $faker->text();
            $paragraph = $faker->paragraphs(8);

            $this->post->setTitle($title)
                ->setDescription($description)
                ->setParagraph($paragraph);

            $this->post->save($data["id"]);
        }

        $this->redirect("/");
        
    }
}
