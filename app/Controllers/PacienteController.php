<?php
require_once __DIR__ . '/../Models/Paciente.php';

class PacienteController {
    private $pacienteModel;

    public function __construct() {
        $this->pacienteModel = new Paciente();
    }

    public function index() {
        $url = 'pacientes';
        $pacientes = $this->pacienteModel->listar();
        $viewContent = __DIR__ . '/../Views/pacientes/index.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function crear() {
        $url = 'pacientes/crear';
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = trim(filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_SPECIAL_CHARS));
            $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS));
            $apellido = trim(filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_SPECIAL_CHARS));
            $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
            $telefono = trim(filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_SPECIAL_CHARS));
            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

            if (empty($cedula) || empty($nombre) || empty($apellido) || empty($fecha_nacimiento)) {
                $error = "Todos los campos obligatorios deben ser llenados.";
            } elseif (strlen($cedula) !== 10 || !ctype_digit($cedula)) {
                $error = "La cédula debe tener exactamente 10 dígitos numéricos.";
            } elseif ($this->pacienteModel->existeCedula($cedula)) {
                $error = "Esta cédula ya se encuentra registrada.";
            } else {
                if ($this->pacienteModel->crear($cedula, $nombre, $apellido, $fecha_nacimiento, $telefono, $email)) {
                    header('Location: index.php?url=pacientes');
                    exit();
                } else {
                    $error = "Ocurrió un error al registrar al paciente.";
                }
            }
        }

        $viewContent = __DIR__ . '/../Views/pacientes/crear.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function editar() {
        $url = 'pacientes/editar';
        $error = null;
        
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $paciente = $this->pacienteModel->buscarPorId($id);

        if (!$paciente) {
            die("Error: El paciente solicitado no existe.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = trim(filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_SPECIAL_CHARS));
            $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS));
            $apellido = trim(filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_SPECIAL_CHARS));
            $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
            $telefono = trim(filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_SPECIAL_CHARS));
            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

            if (empty($cedula) || empty($nombre) || empty($apellido) || empty($fecha_nacimiento)) {
                $error = "Todos los campos obligatorios deben ser llenados.";
            } elseif (strlen($cedula) !== 10 || !ctype_digit($cedula)) {
                $error = "La cédula debe tener exactamente 10 dígitos numéricos.";
            } elseif ($this->pacienteModel->existeCedula($cedula, $id)) {
                $error = "Esta cédula ya pertenece a otro paciente registrado.";
            } else {
                if ($this->pacienteModel->actualizar($id, $cedula, $nombre, $apellido, $fecha_nacimiento, $telefono, $email)) {
                    header('Location: index.php?url=pacientes');
                    exit();
                } else {
                    $error = "Ocurrió un error al actualizar los datos del paciente.";
                }
            }
        }

        $viewContent = __DIR__ . '/../Views/pacientes/editar.php';
        require_once __DIR__ . '/../Views/shared/layout.php';
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            $this->pacienteModel->eliminar($id);
        }
        header('Location: index.php?url=pacientes');
        exit();
    }
}