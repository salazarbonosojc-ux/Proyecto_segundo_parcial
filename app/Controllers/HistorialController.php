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
        $error = null;

        try {
            // 1. Traer información básica del historial y paciente
            $query = "SELECT 
                        h.id, 
                        h.id_paciente, 
                        h.fecha_creacion,
                        p.cedula, 
                        p.nombre, 
                        p.apellido, 
                        p.fecha_nacimiento,
                        p.telefono,
                        p.email
                      FROM historiales_clinicos h
                      INNER JOIN pacientes p ON h.id_paciente = p.id
                      WHERE h.id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);
            $historial = $stmt->fetch(PDO::FETCH_ASSOC);

            // 2. Traer diagnósticos/recetas asociadas
            $diagnosticos = [];
            if ($historial) {
                $queryDiag = "SELECT 
                                d.id,
                                d.fecha_diagnostico,
                                d.descripcion,
                                d.tratamiento,
                                d.dias_reposo,
                                CONCAT(m.nombre, ' ', m.apellido) AS medico
                              FROM diagnosticos d
                              INNER JOIN medicos m ON d.id_medico = m.id
                              WHERE d.id_historial = :id_historial
                              ORDER BY d.fecha_diagnostico DESC";
                
                $stmtDiag = $this->db->prepare($queryDiag);
                $stmtDiag->execute([':id_historial' => $id]);
                $diagnosticos = $stmtDiag->fetchAll(PDO::FETCH_ASSOC);
            }

            // 3. Traer últimas citas del paciente
            $citas = [];
            if ($historial) {
                $queryCitas = "SELECT 
                                c.id,
                                c.fecha_hora,
                                c.motivo,
                                c.estado,
                                CONCAT(m.nombre, ' ', m.apellido) AS medico,
                                e.nombre AS especialidad
                              FROM citas_medicas c
                              INNER JOIN medicos m ON c.id_medico = m.id
                              INNER JOIN especialidades e ON m.id_especialidad = e.id
                              WHERE c.id_paciente = :id_paciente
                              ORDER BY c.fecha_hora DESC
                              LIMIT 5";
                
                $stmtCitas = $this->db->prepare($queryCitas);
                $stmtCitas->execute([':id_paciente' => $historial['id_paciente']]);
                $citas = $stmtCitas->fetchAll(PDO::FETCH_ASSOC);
            }

        } catch (PDOException $e) {
            $historial = null;
            $diagnosticos = [];
            $citas = [];
            $error = "Error al cargar el historial clínico.";
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

    /**
     * Cargar Vista para Agregar Diagnóstico/Receta
     */
    public function agregarDiagnostico() {
        $id_historial = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $error = null;

        try {
            // Traer información básica del historial clínico para mostrar el paciente
            $query = "SELECT h.id, p.nombre, p.apellido, p.cedula 
                      FROM historiales_clinicos h
                      INNER JOIN pacientes p ON h.id_paciente = p.id
                      WHERE h.id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id_historial]);
            $historial = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$historial) {
                die("Error: El historial clínico no existe.");
            }

            // Obtener lista de médicos para la asignación
            $stmtMedicos = $this->db->prepare("SELECT id, nombre, apellido FROM medicos ORDER BY apellido ASC");
            $stmtMedicos->execute();
            $medicos = $stmtMedicos->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $historial = null;
            $medicos = [];
            $error = "Error al conectar con la base de datos.";
        }

        $viewContent = __DIR__ . '/../Views/historiales/agregar_diagnostico.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    /**
     * Guardar Diagnóstico/Receta en la Base de Datos (Sanitización Estricta)
     */
    public function guardarDiagnostico() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_historial = isset($_POST['id_historial']) ? intval($_POST['id_historial']) : 0;
            $id_medico = isset($_POST['id_medico']) ? intval($_POST['id_medico']) : 0;
            $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : '';
            $tratamiento = isset($_POST['tratamiento']) ? htmlspecialchars(trim($_POST['tratamiento'])) : '';
            $dias_reposo = isset($_POST['dias_reposo']) ? intval($_POST['dias_reposo']) : 0;
            $fecha_diagnostico = isset($_POST['fecha_diagnostico']) ? htmlspecialchars(trim($_POST['fecha_diagnostico'])) : '';

            if ($id_historial > 0 && $id_medico > 0 && !empty($descripcion) && !empty($tratamiento) && !empty($fecha_diagnostico)) {
                try {
                    $query = "INSERT INTO diagnosticos (id_historial, id_medico, descripcion, tratamiento, fecha_diagnostico, dias_reposo) 
                              VALUES (:id_historial, :id_medico, :descripcion, :tratamiento, :fecha_diagnostico, :dias_reposo)";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([
                        ':id_historial'       => $id_historial,
                        ':id_medico'          => $id_medico,
                        ':descripcion'        => $descripcion,
                        ':tratamiento'        => $tratamiento,
                        ':fecha_diagnostico'  => $fecha_diagnostico,
                        ':dias_reposo'        => $dias_reposo
                    ]);

                    header('Location: index.php?url=historiales/ver&id=' . $id_historial);
                    exit();
                } catch (PDOException $e) {
                    // Manejo interno de error
                }
            }
        }
        
        $id_historial_url = isset($_POST['id_historial']) ? intval($_POST['id_historial']) : 0;
        header('Location: index.php?url=historiales/ver&id=' . $id_historial_url);
        exit();
    }
}