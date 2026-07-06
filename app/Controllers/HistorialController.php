<?php

class HistorialController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Listado Maestro de Historiales Clínicos
     */
    public function index() {
        try {
            $query = "SELECT 
                        h.id, 
                        h.id_paciente, 
                        h.fecha_creacion,
                        CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                        p.cedula
                      FROM historiales_clinicos h
                      INNER JOIN pacientes p ON h.id_paciente = p.id
                      ORDER BY h.id DESC";

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $historiales = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $historiales = [];
        }

        $viewContent = __DIR__ . '/../Views/historiales/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    /**
     * MÉTODO VER: Cargar detalle del Historial Clínico
     */
    public function ver() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        try {
            $query = "SELECT 
                        h.id, 
                        h.id_paciente, 
                        h.fecha_creacion,
                        p.cedula, 
                        p.nombre, 
                        p.apellido, 
                        p.fecha_nacimiento
                      FROM historiales_clinicos h
                      INNER JOIN pacientes p ON h.id_paciente = p.id
                      WHERE h.id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);
            $historial = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $historial = null;
        }

        $viewContent = __DIR__ . '/../Views/historiales/ver.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    /**
     * MÉTODO EDTIAR: Modificar asignación o fecha de apertura
     */
    public function editar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_paciente = isset($_POST['id_paciente']) ? intval($_POST['id_paciente']) : 0;
            $fecha_creacion = isset($_POST['fecha_creacion']) ? htmlspecialchars(trim($_POST['fecha_creacion'])) : '';

            if ($id > 0 && $id_paciente > 0 && !empty($fecha_creacion)) {
                try {
                    $query = "UPDATE historiales_clinicos SET id_paciente = :id_paciente, fecha_creacion = :fecha_creacion WHERE id = :id";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([
                        ':id_paciente'   => $id_paciente,
                        ':fecha_creacion' => $fecha_creacion,
                        ':id'             => $id
                    ]);
                    header('Location: index.php?url=historiales');
                    exit();
                } catch (PDOException $e) {
                    $error = "Error al actualizar el historial clínico.";
                }
            }
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM historiales_clinicos WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $historial = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmtPacientes = $this->db->prepare("SELECT id, cedula, nombre, apellido FROM pacientes ORDER BY apellido ASC");
            $stmtPacientes->execute();
            $pacientes = $stmtPacientes->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $historial = null;
            $pacientes = [];
        }

        $viewContent = __DIR__ . '/../Views/historiales/editar.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }
}