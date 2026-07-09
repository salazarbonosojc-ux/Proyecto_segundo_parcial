<?php
session_start();

// Carga de la conexión centralizada a la Base de Datos
require_once __DIR__ . '/../app/config/Database.php';

// Capturamos la URL por el método GET, si está vacía redirige al login por defecto
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'login';

// Guardrail de Seguridad: Si no hay sesión activa y no va al login, se le fuerza a loguearse
// Excepto para rutas de PDF que requieren estar autenticado
if (!isset($_SESSION['usuario']) && $url !== 'login' && $url !== 'auth/login' && strpos($url, 'pdf') === false) {
    header('Location: index.php?url=login');
    exit();
}

// Homologación de la ruta raíz del login hacia el controlador correspondiente
if ($url === 'login') {
    $url = 'auth/showLogin';
}

// Segmentamos la URL para identificar el Módulo (Controlador) y la Acción (Método)
$urlParts = explode('/', $url);
$modulo = $urlParts[0];

/* ==========================================================================
   SISTEMA DE MAPEO M.V.C. - TRADUCCIÓN DE PLURALES A SINGULAR
   ========================================================================== */
if ($modulo === 'historiales') {
    $modulo = 'historial';
} elseif ($modulo === 'habitaciones') {
    $modulo = 'habitacion';
} elseif ($modulo === 'ingresos') {
    // CORRECCIÓN CRÍTICA: Mapeo de la sección de asignaciones de habitaciones
    $modulo = 'ingreso';
} elseif (substr($modulo, -1) === 's' && $modulo !== 'auth') {
    // Si termina en "s" le remueve la última letra, excepto si es el módulo 'auth'
    $modulo = rtrim($modulo, 's');
}

// Construimos los nombres físicos de la clase y del método
$controladorNombre = ucfirst($modulo) . 'Controller';
$metodoNombre = isset($urlParts[1]) ? $urlParts[1] : 'index';

// Ruta física absoluta del archivo en el servidor de XAMPP
$controladorRuta = __DIR__ . '/../app/Controllers/' . $controladorNombre . '.php';

/* ==========================================================================
   DESPACHADOR DE RUTAS (ROUTER DISPATCHER)
   ========================================================================== */
if (file_exists($controladorRuta)) {
    require_once $controladorRuta;
    
    // Instanciamos dinámicamente el controlador requerido
    $controller = new $controladorNombre();

    // Verificamos que el método (ej: index, crear, ver, editar) exista dentro de la clase
    if (method_exists($controller, $metodoNombre)) {
        $controller->$metodoNombre();
    } else {
        echo "<h1>Error 404: El método '{$metodoNombre}' no existe en el controlador '{$controladorNombre}'.</h1>";
    }
} else {
    echo "<h1>Error 404: El recurso solicitado no existe.</h1>";
    echo "<p>Ruta buscada: {$controladorRuta}</p>";
}