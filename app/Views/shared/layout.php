<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Hospitalario</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
    $url_navegador = isset($_GET['url']) ? trim($_GET['url']) : ''; 

    $pageTitle = 'Panel Principal';
    if (preg_match('/paciente/i', $url_navegador)) {
        $pageTitle = 'Gestión de Pacientes';
    } elseif (preg_match('/medico/i', $url_navegador)) {
        $pageTitle = 'Gestión de Médicos';
    } elseif (preg_match('/cita/i', $url_navegador)) {
        $pageTitle = 'Citas Médicas';
    } elseif (preg_match('/historial/i', $url_navegador)) {
        $pageTitle = 'Historiales Clínicos';
    } elseif (preg_match('/habitacion/i', $url_navegador)) {
        $pageTitle = 'Estado de Habitaciones';
    } elseif (preg_match('/ingreso/i', $url_navegador)) {
        $pageTitle = 'Habitaciones Asignadas';
    }
    ?>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-top-group">
                <div class="sidebar-brand">
                    <h3 class="neon-text">Hospital Core</h3>
                </div>
                <nav class="sidebar-menu">
                    <ul>
                        <li>
                            <a href="index.php?url=pacientes" class="<?= preg_match('/paciente/i', $url_navegador) ? 'active' : ''; ?>">Pacientes</a>
                        </li>
                        <li>
                            <a href="index.php?url=medicos" class="<?= preg_match('/medico/i', $url_navegador) ? 'active' : ''; ?>">Médicos</a>
                        </li>
                        <li>
                            <a href="index.php?url=citas" class="<?= preg_match('/cita/i', $url_navegador) ? 'active' : ''; ?>">Citas Médicas</a>
                        </li>
                        <li>
                            <a href="index.php?url=historiales" class="<?= preg_match('/historial/i', $url_navegador) ? 'active' : ''; ?>">Historiales</a>
                        </li>
                        <li>
                            <a href="index.php?url=habitaciones" class="<?= preg_match('/habitacion/i', $url_navegador) ? 'active' : ''; ?>">Habitaciones</a>
                        </li>
                        <li>
                            <a href="index.php?url=ingresos" class="<?= preg_match('/ingreso/i', $url_navegador) ? 'active' : ''; ?>">Asignaciones</a>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <div class="sidebar-bottom-group">
                <nav class="sidebar-menu">
                    <ul>
                        <li class="logout-item">
                            <a href="index.php?url=auth/logout">Cerrar Sesión</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="header-title">
                    <h2><?= $pageTitle; ?></h2>
                </div>
                <div class="user-info">
                    <span>Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuario'] ?? 'Usuario'); ?></strong> (<?= htmlspecialchars($_SESSION['rol'] ?? 'Rol'); ?>)</span>
                </div>
            </header>
            
            <section class="content-body">
                <?php 
                if (isset($viewContent) && file_exists($viewContent)) {
                    include $viewContent; 
                } else {
                    echo "<p>Error: La vista solicitada no existe o no se pudo cargar.</p>";
                }
                ?>
            </section>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>
</html>