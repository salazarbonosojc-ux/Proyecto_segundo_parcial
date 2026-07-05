<?php
class Database {
    private static $host = "127.0.0.1";
    private static $port = "3307"; //Puerto específico de XAMPP
    private static $db_name = "sistema_hospitalario";
    private static $username = "root";
    private static $password = ""; 
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            try {
                // Añadimos el parámetro port=3307 a la cadena de conexión
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$db_name . ";charset=utf8", 
                    self::$username, 
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $exception) {
                die("Error de conexión en la base de datos: " . $exception->getMessage());
            }
        }
        return self::$conn;
    }
}