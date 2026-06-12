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

    // pro data
    public function getAllProData(): array
    {
        $pdo = $this->connect();

        $sql = "
            SELECT DISTINCT
                trno,
                description,
                Qty_ordered
            FROM DBA.Beva_vProBI
            WHERE trno IS NOT NULL
            AND description IS NOT NULL
            AND Status = 'Open'
            ORDER BY trno
        ";

        return $pdo->query($sql)->fetchAll();
    }

    // shipment data
    public function getShipmentData(): array
    {
        $pdo = $this->connect();

        $sql = "
            SELECT DISTINCT
                trno,
                custname,
                description,
                qt
            FROM DBA.Beva_vShipmentQC
            WHERE trno IS NOT NULL
            AND description IS NOT NULL
            AND YEAR(trdate) >= 2026
            ORDER BY trno
        ";

        return $pdo->query($sql)->fetchAll();
    }
}
