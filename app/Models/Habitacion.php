<?php
class Habitacion {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function listar() {
        $query = "SELECT * FROM habitaciones ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorId($id) {
    $query = "SELECT * FROM habitaciones WHERE id = :id LIMIT 0,1";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }   

    public function actualizar($id, $numero_habitacion, $tipo, $estado) {
    $query = "UPDATE habitaciones SET numero_habitacion = :num, tipo = :tipo, estado = :estado WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':num', $numero_habitacion);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':estado', $estado);
    return $stmt->execute();
    }
    public function crear($numero_habitacion, $tipo, $estado = 'Disponible') {
    try {
        $query = "INSERT INTO habitaciones (numero_habitacion, tipo, estado) VALUES (:num, :tipo, :estado)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':num', $numero_habitacion);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    } catch (PDOException $e) {
        die("Error al guardar la habitación: " . $e->getMessage());
    } 
}

}