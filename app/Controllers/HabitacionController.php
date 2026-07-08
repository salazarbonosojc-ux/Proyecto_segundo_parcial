<?php

class HabitacionController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        try {
            $query = "SELECT id, numero_habitacion, tipo, estado FROM habitaciones ORDER BY numero_habitacion ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $habitaciones = [];
        }
        $viewContent = __DIR__ . '/../Views/habitaciones/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function crear() {
        try {
            $stmtPacientes = $this->db->prepare("SELECT id, cedula, nombre, apellido FROM pacientes ORDER BY apellido ASC");
            $stmtPacientes->execute();
            $pacientes = $stmtPacientes->fetchAll(PDO::FETCH_ASSOC);

            // Muestra todas las habitaciones para poder asignar libremente
            $stmtHabitaciones = $this->db->prepare("SELECT id, numero_habitacion, tipo, estado FROM habitaciones ORDER BY numero_habitacion ASC");
            $stmtHabitaciones->execute();
            $habitaciones = $stmtHabitaciones->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $pacientes = [];
            $habitaciones = [];
        }
        $viewContent = __DIR__ . '/../Views/habitaciones/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_paciente = isset($_POST['id_paciente']) ? intval($_POST['id_paciente']) : 0;
            $id_habitacion = isset($_POST['id_habitacion']) ? intval($_POST['id_habitacion']) : 0;
            $fecha_ingreso = date('Y-m-d H:i:s');

            if ($id_paciente > 0 && $id_habitacion > 0) {
                try {
                    $this->db->beginTransaction();

                    // 1. Insertar asignación
                    $query = "INSERT INTO ingresos_hospitalarios (id_paciente, id_habitacion, fecha_ingreso) VALUES (:id_paciente, :id_habitacion, :fecha_ingreso)";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([
                        ':id_paciente'   => $id_paciente,
                        ':id_habitacion' => $id_habitacion,
                        ':fecha_ingreso' => $fecha_ingreso
                    ]);

                    // 2. Cambiar estado a Ocupada
                    $updateStmt = $this->db->prepare("UPDATE habitaciones SET estado = 'Ocupada' WHERE id = :id_habitacion");
                    $updateStmt->execute([':id_habitacion' => $id_habitacion]);

                    $this->db->commit();
                    header('Location: index.php?url=ingresos');
                    exit();
                } catch (PDOException $e) {
                    $this->db->rollBack();
                }
            }
        }
        header('Location: index.php?url=habitaciones/crear');
        exit();
    }

    public function editar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numero_habitacion = isset($_POST['numero_habitacion']) ? htmlspecialchars(trim($_POST['numero_habitacion'])) : '';
            $tipo = isset($_POST['tipo']) ? htmlspecialchars(trim($_POST['tipo'])) : '';
            $estado = isset($_POST['estado']) ? htmlspecialchars(trim($_POST['estado'])) : '';

            if ($id > 0 && !empty($numero_habitacion) && !empty($tipo) && !empty($estado)) {
                try {
                    $this->db->beginTransaction();

                    // 1. Actualizar habitación
                    $query = "UPDATE habitaciones SET numero_habitacion = :numero_habitacion, tipo = :tipo, estado = :estado WHERE id = :id";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([
                        ':numero_habitacion' => $numero_habitacion,
                        ':tipo'              => $tipo,
                        ':estado'            => $estado,
                        ':id'                => $id
                    ]);

                    // 2. AUTOMATIZACIÓN: Si pasa a Disponible, se registra la fecha de alta automáticamente
                    if ($estado === 'Disponible') {
                        $fecha_alta = date('Y-m-d H:i:s');
                        $updateQuery = "UPDATE ingresos_hospitalarios SET fecha_alta = :fecha_alta WHERE id_habitacion = :id_habitacion AND fecha_alta IS NULL";
                        $updateStmt = $this->db->prepare($updateQuery);
                        $updateStmt->execute([
                            ':fecha_alta'    => $fecha_alta,
                            ':id_habitacion' => $id
                        ]);
                    }

                    $this->db->commit();
                    header('Location: index.php?url=habitaciones');
                    exit();
                } catch (PDOException $e) {
                    $this->db->rollBack();
                }
            }
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM habitaciones WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $habitacion = null;
        }

        $viewContent = __DIR__ . '/../Views/habitaciones/editar.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            try {
                $stmt = $this->db->prepare("DELETE FROM habitaciones WHERE id = :id");
                $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                // Manejo de error
            }
        }
        header('Location: index.php?url=habitaciones');
        exit();
    }
}