<?php
class Database {
    private static $host;
    private static $port;
    private static $db_name;
    private static $username;
    private static $password;
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            $dbUrl = getenv('DATABASE_URL');
            if ($dbUrl) {
                $urlParts = parse_url($dbUrl);
                self::$host = $urlParts['host'] ?? '127.0.0.1';
                self::$port = $urlParts['port'] ?? '3306';
                self::$username = $urlParts['user'] ?? 'root';
                self::$password = $urlParts['pass'] ?? '';
                self::$db_name = isset($urlParts['path']) ? ltrim($urlParts['path'], '/') : 'sistema_hospitalario';
            } else {
                self::$host = getenv('DB_HOST') ?: '127.0.0.1';
                self::$port = getenv('DB_PORT') ?: '3306';
                self::$db_name = getenv('DB_NAME') ?: 'sistema_hospitalario';
                self::$username = getenv('DB_USERNAME') ?: 'root';
                self::$password = getenv('DB_PASSWORD') ?: '';
            }

            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$db_name . ";charset=utf8",
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                die("Error de conexión en la base de datos: " . $exception->getMessage());
            }
        }
        return self::$conn;
    }
}