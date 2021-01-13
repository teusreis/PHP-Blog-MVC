<?php

namespace App\Model;

use PDO;
use Exception;
use App\Model\User;
use App\Library\Model;
use CoffeeCode\Uploader\Image;

class Post extends Model
{
    private string $title;
    private string $description;
    private string $paragraph;
    private bool $hasPhoto = false;
    private string|null $photoPath;
    private int $user_id;
    private Image $upload;

    private array $file;
    private string $path;

    public function __construct()
    {
        $this->table = "posts";
        $this->upload = new Image("img", "userImg");
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

    /**
     * Get the value of hasPhoto
     */
    public function getHasPhoto()
    {
        return $this->hasPhoto;
    }

    /**
     * Set the value of hasPhoto
     *
     * @return  self
     */
    public function setHasPhoto(bool $hasPhoto)
    {
        $this->hasPhoto = $hasPhoto;

        return $this;
    }

    /**
     * Get the value of photoPath
     */
    public function getPhotoPath()
    {
        return $this->photoPath;
    }

    /**
     * Set the value of photoPath
     *
     * @return  self
     */
    public function setPhotoPath(array $files = null, string $oldBanner = null)
    {
        if ((empty($files['banner']) || empty($files["banner"]['type'])) && empty($oldBanner)) {
            $this->photoPath = null;
            $this->setHasPhoto(false);
            return $this;
        }

        if (empty($files["banner"]['type']) && !empty($oldBanner)) {
            $this->photoPath = $oldBanner;
            $this->setHasPhoto(true);
            return $this;
        }

        $file = $files['banner'];

        if (in_array($file['type'], $this->upload::isAllowed())) {
            $photoPath = $this->upload->upload($file, pathinfo($file['name'], PATHINFO_FILENAME), 350);
            $this->setHasPhoto(true);
        } else {
            $this->hasError = true;
            $this->error["banner"] = "Image extation not allowed!";
        }

        $this->photoPath = $photoPath;

        return $this;
    }

    public function save(int $id = null): bool
    {
        if ($this->hasError) {
            return false;
        }

        $sql = "INSERT INTO posts(title, description, paragraph, hasPhoto, photoPath, user_id)
                VALUE(:title, :description, :paragraph, :hasPhoto, :photoPath, :user_id)";

        $stmt = $this->pdo->prepare($sql);

        $id = $id ??  $_SESSION["user"]['id'];

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":paragraph", $this->paragraph);
        $stmt->bindParam(":hasPhoto", $this->hasPhoto, PDO::PARAM_BOOL);
        $stmt->bindParam(":photoPath", $this->photoPath);
        $stmt->bindParam(":user_id", $id);

        $success = $stmt->execute();

        return $success;
    }

    public function update($id): bool
    {
        if ($this->hasError) {
            return false;
        }

        $sql = "UPDATE posts
                SET title = :title, description = :description, paragraph = :paragraph, hasPhoto = :hasPhoto, photoPath = :photoPath, updated_at = NOW()
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":paragraph", $this->paragraph);
        $stmt->bindParam(":hasPhoto", $this->hasPhoto, PDO::PARAM_BOOL);
        $stmt->bindParam(":photoPath", $this->photoPath);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public function find($id)
    {

        $sql = "SELECT p.id, p.user_id, p.title, p.hasPhoto, p.photoPath, p.description, p.paragraph, DATE(p.created_at) as created_at, DATE(p.updated_at) updated_at, CONCAT(u.name, ' ', u.lastName) as author from posts as p
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
        $title = "%" . $title . "%";

        $sql = "SELECT p.id, p.user_id, p.title, p.hasPhoto, p.photoPath, p.description, p.paragraph, DATE(p.created_at) as created_at, DATE(p.updated_at) updated_at, CONCAT(u.name, ' ', u.lastName) as author from posts as p
                JOIN users as u
                ON u.id = p.user_id
                WHERE p.title like :title";

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

        $stmt->bindParam(":title", $title);

        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        } else {
            throw new Exception("Algo de errado não está certo!");
        }
    }

    public function findAll(int $offset = 0, int $limit = 10): array
    {
        $sql = "SELECT p.id, p.user_id, p.title, p.hasPhoto, p.photoPath, p.description, p.paragraph, DATE(p.created_at) as created_at, DATE(p.updated_at) updated_at, CONCAT(u.name, ' ', u.lastName) as author from posts as p
                JOIN users as u
                ON u.id = p.user_id
                ORDER By p.created_at DESC
                LIMIT :offset, :limit";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);

        $success = $stmt->execute();

        if ($success) {
            return $stmt->fetchAll();
        } else {
            throw new Exception("Algo de errado não está certo!");
        }
    }
}
