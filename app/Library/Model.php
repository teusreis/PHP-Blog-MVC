<?php

namespace App\Library;

use App\Database\Db;
use PDO;

class Model
{
    protected string $table;
    public bool $hasError = false;
    protected PDO $pdo;
    public array $error = [];

    public function __construct()
    {
        $this->pdo = Db::connect();
    }

    public function findByPk($search, $primaryKey = "id"): object
    {
        $sql = "SELECT * from $this->table where $primaryKey = :value LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":value" => $search
        ]);

        return $stmt->fetch();
    }

    public function delete($id): bool
    {

        $sql = "DELETE FROM $this->table WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
