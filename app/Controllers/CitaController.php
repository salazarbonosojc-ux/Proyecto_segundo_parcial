<?php
require_once __DIR__ . '/../Models/Cita.php';

class CitaController {
    private $citaModel;

    public function __construct() {
        $this->citaModel = new Cita();
    }

    public function index() {
        $url = 'citas';
        $citas = $this->citaModel->listar();

        $viewContent = __DIR__ . '/../Views/citas/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function crear() {
        $url = 'citas/crear';
        $error = null;

        $viewContent = __DIR__ . '/../Views/citas/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }
}