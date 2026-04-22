<?php

namespace App\Services;

use PDO;

class SybaseService
{
    public function connect(): PDO
    {
        return new PDO(
            'odbc:' . env('SYBASE_DSN'),
            env('DB_USERNAME_SYBASE'),
            env('DB_PASSWORD_SYBASE'),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public function getProReferences(): array
    {
        $pdo = $this->connect();

        $sql = "
            SELECT DISTINCT trno, description
            FROM Beva_vProBI
            WHERE trno IS NOT NULL
              AND description IS NOT NULL
              AND TRIM(trno) <> ''
              AND TRIM(description) <> ''
            ORDER BY trno
        ";

        $stmt = $pdo->query($sql);

        return $stmt->fetchAll();
    }
}