<?php
class Usuario {
    private $db;

    public function __construct() {
        // Obtiene la conexión compartida de la base de datos
        $this->db = Database::getConnection();
    }

    // Busca un usuario por su nombre de usuario en la base de datos
    public function buscarPorUsuario($nombre_usuario) {
        try {
            $query = "SELECT u.*, r.nombre as rol 
                      FROM usuarios u 
                      JOIN roles r ON u.id_rol = r.id 
                      WHERE u.nombre_usuario = :nombre_usuario LIMIT 0,1";
                      
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre_usuario', $nombre_usuario);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al consultar el usuario: " . $e->getMessage());
        }
    }
}