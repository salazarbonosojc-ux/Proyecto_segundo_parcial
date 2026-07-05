<?php
require_once __DIR__ . '/../models/Medico.php'; 

class MedicoController {
    private $medicoModel;

    public function __construct() {
        // Instanciamos el modelo de médicos para poder consultar la base de datos
        $this->medicoModel = new Medico();
    }

    public function index() {
        $url = 'medicos';
        
        // 1. Llamamos al método listar() del modelo para traer los datos reales de la BBDD
        $medicos = $this->medicoModel->listar(); 

        // 2. Definimos la ruta de la vista y cargamos el layout
        $viewContent = __DIR__ . '/../views/medicos/index.php';
        require_once __DIR__ . '/../views/shared/layout.php';
    }

    public function crear() {
        $url = 'medicos/crear';
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Aquí irá la lógica para guardar el médico en la BBDD
        }

        $viewContent = __DIR__ . '/../views/medicos/crear.php';
        require_once __DIR__ . '/../views/shared/layout.php';
    }
}