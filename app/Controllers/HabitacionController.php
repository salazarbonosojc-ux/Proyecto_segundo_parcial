<?php
require_once __DIR__ . '/../Models/Habitacion.php';

class HabitacionController {
    private $habitacionModel;

    public function __construct() {
        $this->habitacionModel = new Habitacion();
    }

    public function index() {
        $url = 'habitaciones';
        $habitaciones = $this->habitacionModel->listar();

        $viewContent = __DIR__ . '/../Views/habitaciones/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function crear() {
        $url = 'habitaciones/crear';
        $error = null;

        $viewContent = __DIR__ . '/../Views/habitaciones/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }
}