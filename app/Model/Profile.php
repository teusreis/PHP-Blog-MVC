<?php

namespace App\Model;

use App\Library\Model;

class Profile extends Model
{
    private string $nickname;
    private bool $hasPhoto;
    private string $photoPath;

    public function __construct()
    {
        $this->table = "profiles";
        parent::__construct();
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
    public function setHasPhoto($hasPhoto)
    {
        $this->hasPhoto = $hasPhoto;

        return $this;
    }

    public function createProfile(int $userId, string $nickname): bool
    {
        $sql = "INSERT INTO profiles(nickname, user_id) VALUE(:nickname, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            ":nickname" => $nickname,
            ":user_id" => $userId,
        ]);
    }

    /**
     * Get the value of nickname
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
    public function setPhotoPath($photoPath)
    {
        $this->photoPath = $photoPath;

        return $this;
    }
}