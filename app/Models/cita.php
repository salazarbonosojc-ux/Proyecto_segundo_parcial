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
    public function crear($id_paciente, $id_medico, $fecha_hora, $estado = 'Pendiente') {
    try {
       
        $query = "INSERT INTO citas_medicas (id_paciente, id_medico, fecha_hora, estado) 
                  VALUES (:id_paciente, :id_medico, :fecha_hora, :estado)";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
        $stmt->bindParam(':id_medico', $id_medico, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_hora', $fecha_hora);
        $stmt->bindParam(':estado', $estado);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        die("Error al guardar la cita médica: " . $e->getMessage());
    }
}
public function obtenerPorId($id) {
    try {
        $query = "SELECT * FROM citas_medicas WHERE id = :id LIMIT 0,1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al obtener la cita: " . $e->getMessage());
    }
}

public function actualizar($id, $id_paciente, $id_medico, $fecha_hora, $estado) {
    try {
        $query = "UPDATE citas_medicas 
                  SET id_paciente = :id_paciente, id_medico = :id_medico, fecha_hora = :fecha_hora, estado = :estado 
                  WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
        $stmt->bindParam(':id_medico', $id_medico, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_hora', $fecha_hora);
        $stmt->bindParam(':estado', $estado);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        die("Error al actualizar la cita médica: " . $e->getMessage());
    }
}
}