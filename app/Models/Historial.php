<?php
class Historial {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function listar() {
        // Usamos 'historiales_clinicos' que es el nombre real en tu BD
        $query = "SELECT h.id, p.cedula, CONCAT(p.nombre, ' ', p.apellido) AS paciente, h.fecha_creacion 
                  FROM historiales_clinicos h
                  JOIN pacientes p ON h.id_paciente = p.id
                  ORDER BY h.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}