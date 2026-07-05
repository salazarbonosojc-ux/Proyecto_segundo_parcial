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
}