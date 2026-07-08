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

    /**
     * Dar de Alta a un Paciente (Actualiza fecha_alta y libera habitación)
     */
    public function darAlta() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id > 0) {
            try {
                $this->db->beginTransaction();

                // 1. Obtener la habitación asociada a este ingreso
                $stmtIngreso = $this->db->prepare("SELECT id_habitacion FROM ingresos_hospitalarios WHERE id = :id");
                $stmtIngreso->execute([':id' => $id]);
                $ingreso = $stmtIngreso->fetch(PDO::FETCH_ASSOC);

                if ($ingreso) {
                    $id_habitacion = $ingreso['id_habitacion'];
                    $fecha_alta = date('Y-m-d H:i:s');

                    // 2. Registrar fecha de alta en la asignación
                    $updateIngreso = "UPDATE ingresos_hospitalarios SET fecha_alta = :fecha_alta WHERE id = :id";
                    $stmtUpdate = $this->db->prepare($updateIngreso);
                    $stmtUpdate->execute([
                        ':fecha_alta' => $fecha_alta,
                        ':id'         => $id
                    ]);

                    // 3. Cambiar estado de la habitación a 'Disponible'
                    $updateHab = "UPDATE habitaciones SET estado = 'Disponible' WHERE id = :id_habitacion";
                    $stmtUpdateHab = $this->db->prepare($updateHab);
                    $stmtUpdateHab->execute([':id_habitacion' => $id_habitacion]);
                }

                $this->db->commit();
            } catch (PDOException $e) {
                $this->db->rollBack();
            }
        }

        header('Location: index.php?url=ingresos');
        exit();
    }
}