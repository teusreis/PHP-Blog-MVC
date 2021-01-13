<?php

namespace App\Model;

use PDO;
use Exception;
use App\Library\Model;

class User extends Model
{
    private string $name;
    private string $lastName;
    private string $email;
    private string $nickname;
    private string $password;

    public function __construct()
    {
        $this->table = "users";
        parent::__construct();
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        if ($name === "") {
            $this->hasError = true;
            $this->error['name'] = "Name is required";
        } else if (strlen($name) >= 50) {
            $this->hasError = true;
            $this->error['name'] = "Name most not be greater than 50 character";
        }
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */
    public function setLastName($lastName)
    {
        if ($lastName === "") {
            $this->hasError = true;
            $this->error['lastName'] = "lastName is required";
        } else if (strlen($lastName) >= 50) {
            $this->hasError = true;
            $this->error['lastName'] = "Last name most not be greater than 50 character";
        }

        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set the value of nickname
     *
     * @return  self
     */
    public function setNickname($nickname)
    {
        if ($nickname === "") {
            $this->hasError = true;
            $this->error['nickname'] = "nickname is required";
        } else if ($this->nicknameExist($nickname)) {
            $this->hasError = true;
            $this->error['nickname'] = "nickname alredy exist!";
        }

        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        if ($email === "") {
            $this->hasError = true;
            $this->error['email'] = "Email is required";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->hasError = true;
            $this->error['email'] = "$email is not a valide";
        } else if ($this->emailExist($email)) {
            $this->hasError = true;
            $this->error['email'] = "Email alredy exist!";
        }

        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Create a new user account
     */
    public function save(): bool
    {

        if ($this->hasError) {
            return false;
        }

        $sql = "INSERT INTO users(name, lastName,  password, email)
                VALUE(:name, :lastName, :password, :email)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":lastName", $this->lastName);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);

        if ($stmt->execute()) {
            $_SESSION["user"]["id"] = $this->getId();
            $_SESSION["user"]["name"] = $this->name;
            $this->profile = new Profile();
            $this->profile->createProfile($_SESSION["user"]["id"], $this->nickname);
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password): bool
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);

        if (!$stmt->execute([":email" => $email,])) {
            throw new Exception("Ops! Something went wrong, pleace try again later!");
        }

        if ($stmt->rowCount() < 1) {
            $this->error["login"] = "invalid email or password!";
            return false;
        }

        $user = $stmt->fetch();

        $passwordVerify = password_verify($password, $user->password);

        if ($passwordVerify) {
            $_SESSION['user']['id'] = $user->id;
            $_SESSION['user']['name'] = $user->name;
            return true;
        } else {
            $this->error["login"] = "invalid email or password!";
            return false;
        }
    }

    public function logout(): bool
    {
        return session_destroy();
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password, $confirmPassword)
    {
        if ($password === "" || $confirmPassword === "") {
            $this->hasError = true;
            $this->error['password'] = "Password is required";
        } else if ($password !== $confirmPassword) {
            $this->hasError = true;
            $this->error['password'] = "Password does not match with confirm password";
        }

        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    public function nicknameExist($nickname): bool
    {
        $sql = "SELECT * FROM profiles
                WHERE nickname = :nickname LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute([":nickname" => $nickname])) {
            $user = $stmt->rowCount();
        } else {
            die($stmt->errorInfo());
        }

        return $user > 0 ? true : false;
    }

    public function emailExist($email): bool
    {
        $sql = "SELECT * FROM users
                WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute([":email" => $email])) {
            $user = $stmt->rowCount();
        } else {
            die($stmt->errorInfo());
        }

        return $user > 0 ? true : false;
    }

    private function getId(): int
    {
        $sql = "SELECT id FROM users ORDER BY created_at DESC";
        $resul = $this->pdo->query($sql);
        $nextId = $resul->fetch()->id;

        return $nextId;
    }

    public function posts(int $offset = null, int $limit = null): array
    {
        $sql = "SELECT p.id, p.user_id, p.title, p.description, p.hasPhoto, p.photoPath, DATE(p.created_at) as created_at, DATE(p.updated_at) updated_at, CONCAT(u.name, ' ', u.lastName) as author FROM users as u
                JOIN posts as p
                ON u.id = p.user_id
                WHERE u.id = :id";

        if ($offset !== null && $limit !== null) {
            $sql .= " ORDER BY p.created_at DESC LIMIT :offset, :limit";
        } else {
            $sql .= " ORDER BY p.created_at DESC";
        }

        $stmt = $this->pdo->prepare($sql);

        if ($offset !== null && $limit !== null) {
            $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
            $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        }

        $id = getUserId();
        $stmt->bindParam(":id", $id);

        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        } else {
            throw new Exception("Algo de errado não está certo!");
        }
    }
}
