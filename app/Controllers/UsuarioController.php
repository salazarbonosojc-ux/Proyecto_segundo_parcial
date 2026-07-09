<?php

class UsuarioController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        try {
            $query = "SELECT u.id, u.nombre_usuario, r.nombre AS rol 
                      FROM usuarios u
                      INNER JOIN roles r ON u.id_rol = r.id
                      ORDER BY u.id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $usuarios = [];
        }

        $viewContent = __DIR__ . '/../Views/usuarios/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function crear() {
        try {
            $stmt = $this->db->prepare("SELECT id, nombre FROM roles ORDER BY nombre ASC");
            $stmt->execute();
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $roles = [];
        }

        $viewContent = __DIR__ . '/../Views/usuarios/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = isset($_POST['nombre_usuario']) ? htmlspecialchars(trim($_POST['nombre_usuario'])) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $id_rol = isset($_POST['id_rol']) ? intval($_POST['id_rol']) : 0;

            if (!empty($nombre_usuario) && !empty($password) && $id_rol > 0) {
                try {
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $this->db->prepare("INSERT INTO usuarios (nombre_usuario, password, id_rol) VALUES (:user, :pass, :role)");
                    $stmt->execute([
                        ':user' => $nombre_usuario,
                        ':pass' => $hashed_password,
                        ':role' => $id_rol
                    ]);
                    header('Location: index.php?url=usuarios');
                    exit();
                } catch (PDOException $e) {
                    // Manejo interno
                }
            }
        }
        header('Location: index.php?url=usuarios/crear');
        exit();
    }

    public function editar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = isset($_POST['nombre_usuario']) ? htmlspecialchars(trim($_POST['nombre_usuario'])) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $id_rol = isset($_POST['id_rol']) ? intval($_POST['id_rol']) : 0;

            if ($id > 0 && !empty($nombre_usuario) && $id_rol > 0) {
                try {
                    if (!empty($password)) {
                        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                        $query = "UPDATE usuarios SET nombre_usuario = :user, password = :pass, id_rol = :role WHERE id = :id";
                        $params = [
                            ':user' => $nombre_usuario,
                            ':pass' => $hashed_password,
                            ':role' => $id_rol,
                            ':id' => $id
                        ];
                    } else {
                        $query = "UPDATE usuarios SET nombre_usuario = :user, id_rol = :role WHERE id = :id";
                        $params = [
                            ':user' => $nombre_usuario,
                            ':role' => $id_rol,
                            ':id' => $id
                        ];
                    }
                    $stmt = $this->db->prepare($query);
                    $stmt->execute($params);
                    header('Location: index.php?url=usuarios');
                    exit();
                } catch (PDOException $e) {
                    $error = "Error al actualizar.";
                }
            }
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmtRoles = $this->db->prepare("SELECT id, nombre FROM roles ORDER BY nombre ASC");
            $stmtRoles->execute();
            $roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $usuario = null;
            $roles = [];
        }

        $viewContent = __DIR__ . '/../Views/usuarios/editar.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            try {
                $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = :id");
                $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                // Manejo relacional
            }
        }
        header('Location: index.php?url=usuarios');
        exit();
    }
}
