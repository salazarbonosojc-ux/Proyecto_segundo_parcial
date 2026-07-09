<?php

class DiagnosticoController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        try {
            $query = "SELECT d.id, d.descripcion, d.tratamiento, d.fecha_diagnostico, d.dias_reposo, 
                             CONCAT(p.nombre, ' ', p.apellido) AS paciente, 
                             CONCAT(m.nombre, ' ', m.apellido) AS medico 
                      FROM diagnosticos d 
                      INNER JOIN historiales_clinicos h ON d.id_historial = h.id 
                      INNER JOIN pacientes p ON h.id_paciente = p.id 
                      INNER JOIN medicos m ON d.id_medico = m.id 
                      ORDER BY d.id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $diagnosticos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $diagnosticos = [];
        }

        $viewContent = __DIR__ . '/../Views/diagnosticos/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function crear() {
        try {
            // Obtener historiales con el nombre del paciente
            $queryH = "SELECT h.id, CONCAT(p.nombre, ' ', p.apellido, ' (CI: ', p.cedula, ')') AS paciente 
                       FROM historiales_clinicos h
                       INNER JOIN pacientes p ON h.id_paciente = p.id
                       ORDER BY p.apellido ASC";
            $stmtH = $this->db->prepare($queryH);
            $stmtH->execute();
            $historiales = $stmtH->fetchAll(PDO::FETCH_ASSOC);

            // Obtener todos los médicos
            $queryM = "SELECT id, CONCAT(nombre, ' ', apellido) AS medico FROM medicos ORDER BY apellido ASC";
            $stmtM = $this->db->prepare($queryM);
            $stmtM->execute();
            $medicos = $stmtM->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $historiales = [];
            $medicos = [];
        }

        $viewContent = __DIR__ . '/../Views/diagnosticos/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_historial = isset($_POST['id_historial']) ? intval($_POST['id_historial']) : 0;
            $id_medico = isset($_POST['id_medico']) ? intval($_POST['id_medico']) : 0;
            $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : '';
            $tratamiento = isset($_POST['tratamiento']) ? htmlspecialchars(trim($_POST['tratamiento'])) : '';
            $fecha_diagnostico = isset($_POST['fecha_diagnostico']) ? htmlspecialchars(trim($_POST['fecha_diagnostico'])) : '';
            $dias_reposo = isset($_POST['dias_reposo']) ? intval($_POST['dias_reposo']) : 0;

            if ($id_historial > 0 && $id_medico > 0 && !empty($descripcion) && !empty($tratamiento) && !empty($fecha_diagnostico)) {
                try {
                    $query = "INSERT INTO diagnosticos (id_historial, id_medico, descripcion, tratamiento, fecha_diagnostico, dias_reposo) 
                              VALUES (:id_historial, :id_medico, :descripcion, :tratamiento, :fecha_diagnostico, :dias_reposo)";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([
                        ':id_historial'      => $id_historial,
                        ':id_medico'         => $id_medico,
                        ':descripcion'       => $descripcion,
                        ':tratamiento'       => $tratamiento,
                        ':fecha_diagnostico' => $fecha_diagnostico,
                        ':dias_reposo'       => $dias_reposo
                    ]);
                    header('Location: index.php?url=diagnosticos');
                    exit();
                } catch (PDOException $e) {
                    // Manejo interno
                }
            }
        }
        header('Location: index.php?url=diagnosticos/crear');
        exit();
    }

    public function editar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_historial = isset($_POST['id_historial']) ? intval($_POST['id_historial']) : 0;
            $id_medico = isset($_POST['id_medico']) ? intval($_POST['id_medico']) : 0;
            $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : '';
            $tratamiento = isset($_POST['tratamiento']) ? htmlspecialchars(trim($_POST['tratamiento'])) : '';
            $fecha_diagnostico = isset($_POST['fecha_diagnostico']) ? htmlspecialchars(trim($_POST['fecha_diagnostico'])) : '';
            $dias_reposo = isset($_POST['dias_reposo']) ? intval($_POST['dias_reposo']) : 0;

            if ($id > 0 && $id_historial > 0 && $id_medico > 0 && !empty($descripcion) && !empty($tratamiento) && !empty($fecha_diagnostico)) {
                try {
                    $query = "UPDATE diagnosticos 
                              SET id_historial = :id_historial, id_medico = :id_medico, descripcion = :descripcion, 
                                  tratamiento = :tratamiento, fecha_diagnostico = :fecha_diagnostico, dias_reposo = :dias_reposo 
                              WHERE id = :id";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([
                        ':id_historial'      => $id_historial,
                        ':id_medico'         => $id_medico,
                        ':descripcion'       => $descripcion,
                        ':tratamiento'       => $tratamiento,
                        ':fecha_diagnostico' => $fecha_diagnostico,
                        ':dias_reposo'       => $dias_reposo,
                        ':id'                => $id
                    ]);
                    header('Location: index.php?url=diagnosticos');
                    exit();
                } catch (PDOException $e) {
                    $error = "Error al actualizar.";
                }
            }
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM diagnosticos WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $diagnostico = $stmt->fetch(PDO::FETCH_ASSOC);

            // Obtener historiales
            $queryH = "SELECT h.id, CONCAT(p.nombre, ' ', p.apellido, ' (CI: ', p.cedula, ')') AS paciente 
                       FROM historiales_clinicos h
                       INNER JOIN pacientes p ON h.id_paciente = p.id
                       ORDER BY p.apellido ASC";
            $stmtH = $this->db->prepare($queryH);
            $stmtH->execute();
            $historiales = $stmtH->fetchAll(PDO::FETCH_ASSOC);

            // Obtener médicos
            $queryM = "SELECT id, CONCAT(nombre, ' ', apellido) AS medico FROM medicos ORDER BY apellido ASC";
            $stmtM = $this->db->prepare($queryM);
            $stmtM->execute();
            $medicos = $stmtM->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $diagnostico = null;
            $historiales = [];
            $medicos = [];
        }

        $viewContent = __DIR__ . '/../Views/diagnosticos/editar.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            try {
                $stmt = $this->db->prepare("DELETE FROM diagnosticos WHERE id = :id");
                $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                // Manejo relacional
            }
        }
        header('Location: index.php?url=diagnosticos');
        exit();
    }
}
