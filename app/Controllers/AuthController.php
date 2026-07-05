<?php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    // Muestra la vista del formulario de Login
    public function showLogin() {
        // Si ya tiene sesión activa, lo manda directo a pacientes
        if (isset($_SESSION['usuario'])) {
            header('Location: index.php?url=pacientes');
            exit();
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    // Procesa el envío del formulario de Login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
            $password = trim($_POST['password']);

            if (empty($username) || empty($password)) {
                $error = "Por favor, llene todos los campos.";
                require_once __DIR__ . '/../views/auth/login.php';
                return;
            }

            // Buscar usuario en la base de datos
            $user = $this->usuarioModel->buscarPorUsuario($username);

            // Validar si el usuario existe y si la contraseña coincide
            if ($user && password_verify($password, $user['password'])) {
                // Crear variables de sesión globales
                $_SESSION['usuario'] = $user['nombre_usuario'];
                $_SESSION['rol'] = $user['rol'];
                $_SESSION['usuario_id'] = $user['id'];

                // Redirección inmediata al panel de pacientes
                header('Location: index.php?url=pacientes');
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
                require_once __DIR__ . '/../views/auth/login.php';
            }
        }
    }

    // Cierra la sesión de forma segura
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?url=login');
        exit();
    }
}