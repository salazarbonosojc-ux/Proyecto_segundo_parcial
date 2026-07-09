<?php

class MedicamentoController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM medicamentos ORDER BY id DESC");
            $stmt->execute();
            $medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $medicamentos = [];
        }

        $viewContent = __DIR__ . '/../Views/medicamentos/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function crear() {
        $viewContent = __DIR__ . '/../Views/medicamentos/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
            $codigo = isset($_POST['codigo']) ? htmlspecialchars(trim($_POST['codigo'])) : '';
            $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : '';
            $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
            $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0.0;

            if (!empty($nombre) && !empty($codigo) && $precio >= 0) {
                try {
                    $stmt = $this->db->prepare("INSERT INTO medicamentos (nombre, codigo, descripcion, stock, precio) VALUES (:nombre, :codigo, :descripcion, :stock, :precio)");
                    $stmt->execute([
                        ':nombre'      => $nombre,
                        ':codigo'      => $codigo,
                        ':descripcion' => $descripcion,
                        ':stock'       => $stock,
                        ':precio'      => $precio
                    ]);
                    header('Location: index.php?url=medicamentos');
                    exit();
                } catch (PDOException $e) {
                    // Manejo interno
                }
            }
        }
        header('Location: index.php?url=medicamentos/crear');
        exit();
    }

    public function editar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
            $codigo = isset($_POST['codigo']) ? htmlspecialchars(trim($_POST['codigo'])) : '';
            $descripcion = isset($_POST['descripcion']) ? htmlspecialchars(trim($_POST['descripcion'])) : '';
            $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
            $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0.0;

            if ($id > 0 && !empty($nombre) && !empty($codigo) && $precio >= 0) {
                try {
                    $stmt = $this->db->prepare("UPDATE medicamentos SET nombre = :nombre, codigo = :codigo, descripcion = :descripcion, stock = :stock, precio = :precio WHERE id = :id");
                    $stmt->execute([
                        ':nombre'      => $nombre,
                        ':codigo'      => $codigo,
                        ':descripcion' => $descripcion,
                        ':stock'       => $stock,
                        ':precio'      => $precio,
                        ':id'          => $id
                    ]);
                    header('Location: index.php?url=medicamentos');
                    exit();
                } catch (PDOException $e) {
                    $error = "Error al actualizar.";
                }
            }
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM medicamentos WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $medicamento = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $medicamento = null;
        }

        $viewContent = __DIR__ . '/../Views/medicamentos/editar.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            try {
                $stmt = $this->db->prepare("DELETE FROM medicamentos WHERE id = :id");
                $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                // Manejo relacional
            }
        }
        header('Location: index.php?url=medicamentos');
        exit();
    }
}
