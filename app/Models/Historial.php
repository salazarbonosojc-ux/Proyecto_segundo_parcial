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
    
    public function obtenerPorId($id) {
    try {
        $query = "SELECT h.id, p.cedula, p.nombre, p.apellido, p.fecha_nacimiento, p.telefono, h.fecha_creacion 
                  FROM historiales_clinicos h
                  JOIN pacientes p ON h.id_paciente = p.id
                  WHERE h.id = :id LIMIT 0,1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al obtener el historial: " . $e->getMessage());
    }
   }

   public function actualizar($id, $id_paciente, $fecha_creacion) {
    try {
        $query = "UPDATE historiales_clinicos 
                  SET id_paciente = :id_paciente, fecha_creacion = :fecha_creacion 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_creacion', $fecha_creacion);
        return $stmt->execute();
    } catch (PDOException $e) {
        die("Error al actualizar el historial clínico: " . $e->getMessage());
    }
   }
}