<?php
class Paciente {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function listar() {
        $query = "SELECT * FROM pacientes ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM pacientes WHERE id = :id LIMIT 0,1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($cedula, $nombre, $apellido, $fecha_nacimiento, $telefono, $email = '') {
        $query = "INSERT INTO pacientes (cedula, nombre, apellido, fecha_nacimiento, telefono, email) 
                  VALUES (:cedula, :nombre, :apellido, :fecha_nacimiento, :telefono, :email)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);

        return $stmt->execute();
    }

    public function actualizar($id, $cedula, $nombre, $apellido, $fecha_nacimiento, $telefono, $email = '') {
        $query = "UPDATE pacientes 
                  SET cedula = :cedula, nombre = :nombre, apellido = :apellido, fecha_nacimiento = :fecha_nacimiento, telefono = :telefono, email = :email 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);

        return $stmt->execute();
    }

    public function eliminar($id) {
        $query = "DELETE FROM pacientes WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function existeCedula($cedula, $idExcluir = 0) {
        $query = "SELECT id FROM pacientes WHERE cedula = :cedula AND id != :id_excluir LIMIT 0,1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':id_excluir', $idExcluir, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}