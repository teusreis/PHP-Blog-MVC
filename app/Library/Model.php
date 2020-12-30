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

    public function find($value, $primaryKey = "id")
    {
        $sql = "SELECT * from $this->table where :primaryKey = :value LIMIT 1";
        $stmt = $this->pdo->prepare($sql);

        $bool = $stmt->execute([
            ":primaryKey" => $primaryKey,
            ":value" => $value
        ]);

        if($bool){
            return $stmt->fetch();
        } else {
            return false;
        }

    }
}
