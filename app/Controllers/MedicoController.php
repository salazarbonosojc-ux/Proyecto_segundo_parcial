<?php

class MedicoController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Listado Maestro de Médicos
     */
    public function index() {
        try {
            $query = "SELECT m.id, m.nombre, m.apellido, m.licencia_medica, e.nombre AS especialidad 
                      FROM medicos m
                      INNER JOIN especialidades e ON m.id_especialidad = e.id
                      ORDER BY m.id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $medicos = [];
        }

        $viewContent = __DIR__ . '/../Views/medicos/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    /**
     * Cargar Formulario de Registro de Médicos
     */
    public function crear() {
        try {
            $stmt = $this->db->prepare("SELECT id, nombre FROM especialidades ORDER BY nombre ASC");
            $stmt->execute();
            $especialidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $especialidades = [];
        }

        $viewContent = __DIR__ . '/../Views/medicos/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    /**
     * Procesar Guardado de un Médico (Con Sanitización Estricta)
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_especialidad = isset($_POST['id_especialidad']) ? intval($_POST['id_especialidad']) : 0;
            $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
            $apellido = isset($_POST['apellido']) ? htmlspecialchars(trim($_POST['apellido'])) : '';
            $licencia_medica = isset($_POST['licencia_medica']) ? htmlspecialchars(trim($_POST['licencia_medica'])) : '';

            if ($id_especialidad > 0 && !empty($nombre) && !empty($apellido) && !empty($licencia_medica)) {
                try {
                    $query = "INSERT INTO medicos (id_especialidad, nombre, apellido, licencia_medica) 
                              VALUES (:id_especialidad, :nombre, :apellido, :licencia_medica)";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([
                        ':id_especialidad' => $id_especialidad,
                        ':nombre'          => $nombre,
                        ':apellido'        => $apellido,
                        ':licencia_medica' => $licencia_medica
                    ]);

                    header('Location: index.php?url=medicos');
                    exit();
                } catch (PDOException $e) {
                    // Captura interna
                }
            }
        }
        header('Location: index.php?url=medicos/crear');
        exit();
    }

    /**
     * Editar Datos del Médico (Con Sanitización Estricta)
     */
    public function editar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_especialidad = isset($_POST['id_especialidad']) ? intval($_POST['id_especialidad']) : 0;
            $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
            $apellido = isset($_POST['apellido']) ? htmlspecialchars(trim($_POST['apellido'])) : '';
            $licencia_medica = isset($_POST['licencia_medica']) ? htmlspecialchars(trim($_POST['licencia_medica'])) : '';

            if ($id > 0 && !empty($nombre) && !empty($apellido) && !empty($licencia_medica)) {
                try {
                    $query = "UPDATE medicos SET id_especialidad = :id_especialidad, nombre = :nombre, 
                              apellido = :apellido, licencia_medica = :licencia_medica WHERE id = :id";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([
                        ':id_especialidad' => $id_especialidad,
                        ':nombre'          => $nombre,
                        ':apellido'        => $apellido,
                        ':licencia_medica' => $licencia_medica,
                        ':id'              => $id
                    ]);
                    header('Location: index.php?url=medicos');
                    exit();
                } catch (PDOException $e) {
                    $error = "Error al actualizar.";
                }
            }
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM medicos WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $medico = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmtEsp = $this->db->prepare("SELECT id, nombre FROM especialidades ORDER BY nombre ASC");
            $stmtEsp->execute();
            $especialidades = $stmtEsp->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $medico = null;
        }

        $viewContent = __DIR__ . '/../Views/medicos/editar.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    /**
     * Eliminar un Médico
     */
    public function eliminar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            try {
                $stmt = $this->db->prepare("DELETE FROM medicos WHERE id = :id");
                $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                // Captura interna
            }
        }
        header('Location: index.php?url=medicos');
        exit();
    }
}