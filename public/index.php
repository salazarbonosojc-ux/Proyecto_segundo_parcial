<?php
session_start();

require_once __DIR__ . '/../app/config/Database.php';
$url = isset($_GET['url']) ? $_GET['url'] : 'login';

if (!isset($_SESSION['usuario']) && $url !== 'login' && $url !== 'auth/login') {
    header('Location: index.php?url=login');
    exit();
}

switch ($url) {
    // AUTENTICACIÓN
    case 'login':
    case 'auth/login':
    case 'auth/logout':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        if ($url === 'login') $controller->showLogin();
        if ($url === 'auth/login') $controller->login();
        if ($url === 'auth/logout') $controller->logout();
        break;

    // PACIENTES
    case 'pacientes':
    case 'pacientes/crear':
    case 'pacientes/editar':
    case 'pacientes/eliminar':
        require_once __DIR__ . '/../app/controllers/PacienteController.php';
        $controller = new PacienteController();
        if ($url === 'pacientes') $controller->index();
        if ($url === 'pacientes/crear') $controller->crear();
        if ($url === 'pacientes/editar') $controller->editar();
        if ($url === 'pacientes/eliminar') $controller->eliminar();
        break;

    // MÉDICOS
    case 'medicos':
    case 'medicos/crear':
        require_once __DIR__ . '/../app/controllers/MedicoController.php';
        $controller = new MedicoController();
        ($url === 'medicos') ? $controller->index() : $controller->crear();
        break;

    // CITAS
    case 'citas':
    case 'citas/crear':
        require_once __DIR__ . '/../app/controllers/CitaController.php';
        $controller = new CitaController();
        ($url === 'citas') ? $controller->index() : $controller->crear();
        break;

    // HISTORIALES
    case 'historiales':
    case 'historiales/crear':
        require_once __DIR__ . '/../app/controllers/HistorialController.php';
        $controller = new HistorialController();
        ($url === 'historiales') ? $controller->index() : $controller->crear();
        break;

    // HABITACIONES
    case 'habitaciones':
    case 'habitaciones/crear':
        require_once __DIR__ . '/../app/controllers/HabitacionController.php';
        $controller = new HabitacionController();
        ($url === 'habitaciones') ? $controller->index() : $controller->crear();
        break;

    default:
        echo "Error 404: El recurso solicitado no existe.";
        break;
}