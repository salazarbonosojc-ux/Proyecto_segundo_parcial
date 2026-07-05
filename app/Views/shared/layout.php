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
    // Guardrail para evitar el error de strpos si $url es null
    $current_url = isset($url) ? $url : ''; 
    ?>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <h3>Hospital Core</h3>
            </div>
            <nav class="sidebar-menu">
                <ul>
                    <li>
                        <a href="index.php?url=pacientes" class="<?= (strpos($current_url, 'pacientes') === 0) ? 'active' : ''; ?>">Pacientes</a>
                    </li>
                    <li>
                        <a href="index.php?url=medicos" class="<?= ($current_url === 'medicos') ? 'active' : ''; ?>">Médicos</a>
                    </li>
                    <li>
                        <a href="index.php?url=citas" class="<?= ($current_url === 'citas') ? 'active' : ''; ?>">Citas Médicas</a>
                    </li>
                    <li>
                        <a href="index.php?url=historiales" class="<?= ($current_url === 'historiales') ? 'active' : ''; ?>">Historiales</a>
                    </li>
                    <li>
                        <a href="index.php?url=habitaciones" class="<?= ($current_url === 'habitaciones') ? 'active' : ''; ?>">Habitaciones</a>
                    </li>
                    <li class="logout-item">
                        <a href="index.php?url=auth/logout">Cerrar Sesión</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="main-header">
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