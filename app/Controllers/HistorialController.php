<?php
require_once __DIR__ . '/../Models/Historial.php';

class HistorialController {
    private $historialModel;

    public function __construct() {
        $this->historialModel = new Historial();
    }

    public function index() {
        $url = 'historiales';
        $historiales = $this->historialModel->listar();

        $viewContent = __DIR__ . '/../Views/historiales/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function crear() {
        $url = 'historiales/crear';
        $error = null;

        $viewContent = __DIR__ . '/../Views/historiales/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }
}