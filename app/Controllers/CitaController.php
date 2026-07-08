<?php

class CitaController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Listado Maestro de Citas Médicas
     */
    public function index() {
        try {
            $query = "SELECT 
                        c.id, 
                        c.id_paciente, 
                        c.id_medico, 
                        c.fecha_hora, 
                        c.motivo, 
                        c.estado,
                        CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                        CONCAT(m.nombre, ' ', m.apellido) AS medico
                      FROM citas_medicas c
                      INNER JOIN pacientes p ON c.id_paciente = p.id
                      INNER JOIN medicos m ON c.id_medico = m.id
                      ORDER BY c.id DESC";

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $citas = [];
        }

        $viewContent = __DIR__ . '/../Views/citas/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    /**
     * Cargar Vista para Agendar Nueva Cita
     */
    public function crear() {
        try {
            $stmtPacientes = $this->db->prepare("SELECT id, cedula, nombre, apellido FROM pacientes ORDER BY apellido ASC");
            $stmtPacientes->execute();
            $pacientes = $stmtPacientes->fetchAll(PDO::FETCH_ASSOC);

            $stmtMedicos = $this->db->prepare("SELECT id, nombre, apellido, licencia_medica FROM medicos ORDER BY apellido ASC");
            $stmtMedicos->execute();
            $medicos = $stmtMedicos->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $pacientes = [];
            $medicos = [];
        }

        $viewContent = __DIR__ . '/../Views/citas/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    /**
     * Guardar una Nueva Cita Médica (Con Sanitización Estricta)
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitización de llaves e inputs de texto
            $id_paciente = isset($_POST['id_paciente']) ? intval($_POST['id_paciente']) : 0;
            $id_medico = isset($_POST['id_medico']) ? intval($_POST['id_medico']) : 0;
            $fecha_hora = isset($_POST['fecha_hora']) ? htmlspecialchars(trim($_POST['fecha_hora'])) : '';
            $motivo = isset($_POST['motivo']) ? htmlspecialchars(trim($_POST['motivo'])) : '';
            $estado = isset($_POST['estado']) ? htmlspecialchars(trim($_POST['estado'])) : 'Pendiente';

            // Validación Backend contra campos vacíos
            if ($id_paciente > 0 && $id_medico > 0 && !empty($fecha_hora) && !empty($motivo)) {
                try {
                    $query = "INSERT INTO citas_medicas (id_paciente, id_medico, fecha_hora, motivo, estado) 
                              VALUES (:id_paciente, :id_medico, :fecha_hora, :motivo, :estado)";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([
                        ':id_paciente' => $id_paciente,
                        ':id_medico'   => $id_medico,
                        ':fecha_hora'   => $fecha_hora,
                        ':motivo'       => $motivo,
                        ':estado'       => $estado
                    ]);

                    header('Location: index.php?url=citas');
                    exit();
                } catch (PDOException $e) {
                    // Manejo interno del error
                }
            }
        }
        header('Location: index.php?url=citas/crear');
        exit();
    }

    /**
     * Modificar Cita Médica (Con Sanitización Estricta)
     */
    public function editar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitización completa del envío POST
            $id_paciente = isset($_POST['id_paciente']) ? intval($_POST['id_paciente']) : 0;
            $id_medico = isset($_POST['id_medico']) ? intval($_POST['id_medico']) : 0;
            $fecha_hora = isset($_POST['fecha_hora']) ? htmlspecialchars(trim($_POST['fecha_hora'])) : '';
            $estado = isset($_POST['estado']) ? htmlspecialchars(trim($_POST['estado'])) : '';

            if ($id_paciente > 0 && $id_medico > 0 && !empty($fecha_hora) && !empty($estado)) {
                try {
                    $updateQuery = "UPDATE citas_medicas 
                                    SET id_paciente = :id_paciente, 
                                        id_medico = :id_medico, 
                                        fecha_hora = :fecha_hora, 
                                        estado = :estado 
                                    WHERE id = :id";
                    
                    $stmt = $this->db->prepare($updateQuery);
                    $stmt->execute([
                        ':id_paciente' => $id_paciente,
                        ':id_medico'   => $id_medico,
                        ':fecha_hora'   => $fecha_hora,
                        ':estado'       => $estado,
                        ':id'           => $id
                    ]);

                    header('Location: index.php?url=citas');
                    exit();

                } catch (PDOException $e) {
                    $error = "Error al actualizar la cita: " . $e->getMessage();
                }
            } else {
                $error = "Por favor, complete todos los campos obligatorios.";
            }
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM citas_medicas WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $cita = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmtPacientes = $this->db->prepare("SELECT id, cedula, nombre, apellido FROM pacientes ORDER BY apellido ASC");
            $stmtPacientes->execute();
            $pacientes = $stmtPacientes->fetchAll(PDO::FETCH_ASSOC);

            $stmtMedicos = $this->db->prepare("SELECT id, nombre, apellido, licencia_medica FROM medicos ORDER BY apellido ASC");
            $stmtMedicos->execute();
            $medicos = $stmtMedicos->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $error = "Error de conexión con las tablas relacionales.";
        }

        $viewContent = __DIR__ . '/../Views/citas/editar.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    /**
     * Cancelar / Eliminar una Cita Médica
     */
    public function eliminar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            try {
                $stmt = $this->db->prepare("DELETE FROM citas_medicas WHERE id = :id");
                $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                // Captura relacional
            }
        }
        header('Location: index.php?url=citas');
        exit();
    }
}