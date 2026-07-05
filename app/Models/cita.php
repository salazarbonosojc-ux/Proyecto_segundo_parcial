<?php
class Cita {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function listar() {
        // Usamos 'citas_medicas' que es el nombre real en tu BD
        $query = "SELECT c.id, CONCAT(p.nombre, ' ', p.apellido) AS paciente, 
                         CONCAT(m.nombre, ' ', m.apellido) AS medico, 
                         c.fecha_hora, c.estado 
                  FROM citas_medicas c
                  JOIN pacientes p ON c.id_paciente = p.id
                  JOIN medicos m ON c.id_medico = m.id
                  ORDER BY c.fecha_hora DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}