<?php
require_once __DIR__ . '/../config/database.php';

class Database {
    private $pdo;

    public function __construct() {
        $dsn = 'mysql:host=' . DatabaseConfig::HOST . ';dbname=' . DatabaseConfig::DATABASE . ';charset=' . DatabaseConfig::CHARSET;
        try {
            $this->pdo = new PDO($dsn, DatabaseConfig::USERNAME, DatabaseConfig::PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    // Run a query and return true/false
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // Fetch a single row
    public function fetch($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all rows
    public function fetchAll($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get last inserted ID
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
?>