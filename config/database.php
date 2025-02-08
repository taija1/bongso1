<?php
class Database {
    private static $instance = null;
    private $conn = null;

    private function __construct() {
        try {
            // Local Docker MySQL connection
            $host = 'db'; // Docker service name
            $port = 3306;
            $dbname = 'bongso1_db';
            $user = 'bongso1_user';
            $pass = 'userpassword';

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
            
            $this->conn = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ]);

            // Test connection
            $this->conn->query("SELECT 1");
            error_log("Database connected successfully!");

        } catch(PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }

    // Helper method to test connection
    public static function testConnection() {
        try {
            $db = self::getInstance();
            $conn = $db->getConnection();
            $result = $conn->query("SHOW TABLES")->fetchAll();
            var_dump($result);
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}