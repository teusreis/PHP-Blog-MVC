<?php

namespace App\Model;

use PDO;
use Exception;
use App\Model\User;
use App\Library\Model;

class Post extends Model
{
    private string $title;
    private string $description;
    private string $paragraph;
    private bool $hasPhoto;
    private string $photoPath;
    private int $user_id;

    public function __construct()
    {
        $this->table = "posts";
        parent::__construct();
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle(string $title)
    {
        if ($title === "") {
            $this->hasError = true;
            $this->error['title'] = "Title is required!";
        }
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription(string $description)
    {

        if ($description === "") {
            $this->hasError = true;
            $this->error['description'] = "Description is required!";
        }

        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of paragraph
     */
    public function getParagraph()
    {
        return $this->paragraph;
    }

    /**
     * Set the value of paragraph
     *
     * @return  self
     */
    public function setParagraph(array $paragraph)
    {
        if (empty($paragraph)) {
            $this->hasError = true;
            $this->error["paragraph"] = "Paragraph is required!";
        }
        $this->paragraph = implode("{{paragraphEnd}}", $paragraph);

        return $this;
    }

    public function save(int $id = null): bool
    {
        if ($this->hasError) {
            return false;
        }

        $sql = "INSERT INTO posts(title, description, paragraph, user_id)
                VALUE(:title, :description, :paragraph, :user_id)";

        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            ":title" => $this->title,
            ":description" => $this->description,
            ":paragraph" => $this->paragraph,
            ":user_id" => $id ?? $_SESSION["user"]['id']
        ]);

        return $success;
    }

    public function update($id): bool
    {
        if ($this->hasError) {
            return false;
        }

        $sql = "UPDATE posts
                SET title = :title, description = :description, description = :description, paragraph = :paragraph
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            ":title" => $this->title,
            ":description" => $this->description,
            ":paragraph" => $this->paragraph,
            ":id" => $id
        ]);

        return $success;
    }

    public function find($id)
    {

        $sql = "SELECT p.id, p.user_id, p.title, p.description, p.paragraph, DATE(p.created_at) as created_at, DATE(p.updated_at) updated_at, CONCAT(u.name, ' ', u.lastName) as author from posts as p
                JOIN users as u
                ON u.id = p.user_id
                WHERE p.id = :id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            ":id" => $id
        ]);

        if ($success) {
            return $stmt->fetch();
        } else {
            throw new Exception("Algo de errado não está certo!");
        }
    }

    public function findByTitle(string $title, int $offset = null, int $limit = null): array
    {
        $offset = $offset ?? 1;
        $limit = $limit ?? 100000000000;
        $title = "%" . $title . "%";

        $sql = "SELECT p.id, p.user_id, p.title, p.description, p.paragraph, DATE(p.created_at) as created_at, DATE(p.updated_at) updated_at, CONCAT(u.name, ' ', u.lastName) as author from posts as p
                JOIN users as u
                ON u.id = p.user_id
                WHERE p.title like :title
                ORDER BY p.created_at DESC
                LIMIT :offset, :limit";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":title", $title);

        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        } else {
            throw new Exception("Algo de errado não está certo!");
        }
    }

    public function findAll(): array
    {
        $start = 0;
        $limit = 10;

        $sql = "SELECT p.id, p.user_id, p.title, p.description, p.paragraph, DATE(p.created_at) as created_at, DATE(p.updated_at) updated_at, CONCAT(u.name, ' ', u.lastName) as author from posts as p
                JOIN users as u
                ON u.id = p.user_id
                ORDER By p.created_at DESC
                LIMIT :start, :limit";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":start", $start, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);

        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        } else {
            throw new Exception("Algo de errado não está certo!");
        }
    }
}
