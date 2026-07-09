<?php

class EspecialidadController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM especialidades ORDER BY id DESC");
            $stmt->execute();
            $especialidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $especialidades = [];
        }

        $viewContent = __DIR__ . '/../Views/especialidades/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function crear() {
        $viewContent = __DIR__ . '/../Views/especialidades/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
            $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : '';

            if (!empty($nombre)) {
                try {
                    $stmt = $this->db->prepare("INSERT INTO especialidades (nombre, descripcion) VALUES (:nombre, :descripcion)");
                    $stmt->execute([
                        ':nombre' => $nombre,
                        ':descripcion' => $descripcion
                    ]);
                    header('Location: index.php?url=especialidades');
                    exit();
                } catch (PDOException $e) {
                    // Manejo interno
                }
            }
        }
        header('Location: index.php?url=especialidades/crear');
        exit();
    }

    public function editar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
            $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : '';

            if ($id > 0 && !empty($nombre)) {
                try {
                    $stmt = $this->db->prepare("UPDATE especialidades SET nombre = :nombre, descripcion = :descripcion WHERE id = :id");
                    $stmt->execute([
                        ':nombre' => $nombre,
                        ':descripcion' => $descripcion,
                        ':id' => $id
                    ]);
                    header('Location: index.php?url=especialidades');
                    exit();
                } catch (PDOException $e) {
                    $error = "Error al actualizar.";
                }
            }
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM especialidades WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $especialidad = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $especialidad = null;
        }

        $viewContent = __DIR__ . '/../Views/especialidades/editar.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            try {
                $stmt = $this->db->prepare("DELETE FROM especialidades WHERE id = :id");
                $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                // Manejo relacional
            }
        }
        header('Location: index.php?url=especialidades');
        exit();
    }
}
