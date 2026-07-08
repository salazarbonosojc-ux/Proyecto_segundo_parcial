<?php

class IngresoController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    /**
     * Listado de Habitaciones Asignadas a Pacientes
     */
    public function index() {
        try {
            $query = "SELECT 
                        i.id,
                        i.fecha_ingreso,
                        i.fecha_alta,
                        h.numero_habitacion,
                        h.tipo AS tipo_habitacion,
                        CONCAT(p.nombre, ' ', p.apellido) AS paciente,
                        p.cedula
                      FROM ingresos_hospitalarios i
                      INNER JOIN pacientes p ON i.id_paciente = p.id
                      INNER JOIN habitaciones h ON i.id_habitacion = h.id
                      ORDER BY i.id DESC";

            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $ingresos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $ingresos = [];
        }

        $viewContent = dirname(__DIR__) . '/Views/ingresos/index.php';
        require_once dirname(__DIR__) . '/Views/shared/layout.php';
    }

    /**
     * Guardar una Nueva Asignación (Ingreso Hospitalario)
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_paciente = isset($_POST['id_paciente']) ? intval($_POST['id_paciente']) : 0;
            $id_habitacion = isset($_POST['id_habitacion']) ? intval($_POST['id_habitacion']) : 0;
            $fecha_ingreso = date('Y-m-d H:i:s'); // Captura la fecha y hora actual del servidor automáticamente

            if ($id_paciente > 0 && $id_habitacion > 0) {
                try {
                    // 1. Insertar el registro en ingresos hospitalarios
                    $query = "INSERT INTO ingresos_hospitalarios (id_paciente, id_habitacion, fecha_ingreso) 
                              VALUES (:id_paciente, :id_habitacion, :fecha_ingreso)";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([
                        ':id_paciente'   => $id_paciente,
                        ':id_habitacion' => $id_habitacion,
                        ':fecha_ingreso' => $fecha_ingreso
                    ]);

                    // 2. Opcional: Cambiar el estado de la habitación a 'Ocupada'
                    $updateHab = "UPDATE habitaciones SET estado = 'Ocupada' WHERE id = :id_habitacion";
                    $stmtUpdate = $this->db->prepare($updateHab);
                    $stmtUpdate->execute([':id_habitacion' => $id_habitacion]);

                    header('Location: index.php?url=ingresos');
                    exit();
                } catch (PDOException $e) {
                    // Manejo interno de error
                }
            }
        }
        header('Location: index.php?url=habitaciones');
        exit();
    }
}