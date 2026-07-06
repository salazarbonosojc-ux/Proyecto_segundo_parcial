<?php
class Medico {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function listar() {
        // Seleccionamos los campos reales que se ven en tu phpMyAdmin
        $query = "SELECT id, nombre, apellido, licencia_medica FROM medicos ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorId($id) {
    $query = "SELECT * FROM medicos WHERE id = :id LIMIT 0,1";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function actualizar($id, $licencia_medica, $nombre, $apellido) {
    $query = "UPDATE medicos SET licencia_medica = :licencia, nombre = :nombre, apellido = :apellido WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':licencia', $licencia_medica);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    return $stmt->execute();
    }
}