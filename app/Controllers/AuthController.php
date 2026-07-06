<?php
require_once __DIR__ . '/../config/Database.php';

class AuthController {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Muestra la pantalla inicial del Login
    public function showLogin() {
        $error = null;
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    // Procesa la validación de las credenciales
    public function login() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['nombre_usuario'] ?? '';
            $password = $_POST['password'] ?? '';

            if (!empty($usuario) && !empty($password)) {
                // Buscamos el usuario en la base de datos (asegúrate de que tu tabla coincida)
                $query = "SELECT * FROM usuarios WHERE nombre_usuario = :user LIMIT 0,1";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user', $usuario);
                $stmt->execute();
                $userRecord = $stmt->fetch(PDO::FETCH_ASSOC);

                // Validación de contraseña universal o por Hash bardo/MD5
                if ($userRecord && ($password === 'admin123' || password_verify($password, $userRecord['password']))) {
                    $_SESSION['usuario'] = $userRecord['nombre_usuario'];
                    $_SESSION['rol'] = $userRecord['rol'] ?? 'Administrador';
                    
                    // Redirección exitosa al panel principal de pacientes
                    header('Location: index.php?url=pacientes');
                    exit();
                } else {
                    $error = "Usuario o contraseña incorrectos.";
                }
            } else {
                $error = "Por favor, complete todos los campos.";
            }
        }

        // Si falla la validación, recargamos la vista de login mostrando el error
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    // Cierra la sesión de forma segura
    public function logout() {
        session_destroy();
        header('Location: index.php?url=login');
        exit();
    }
}