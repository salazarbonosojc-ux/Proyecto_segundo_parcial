<?php
/**
 * ==========================================================================
 * CONTROL DE ACCESOS - SISTEMA CLÍNICO NEÓN PREMIUM
 * ==========================================================================
 * Contraseña universal para todas las cuentas: admin123
 * * 🖥️ CUENTAS DE ADMINISTRADORES:
 * 1. Salazar Bonoso Yeancarlos Isaac -> Usuario: 'salazar_yeancarlos'
 * 2. Jama Villagran Joao Alexander   -> Usuario: 'jama_joao'
 * 3. Sabando Varela Angello Michael  -> Usuario: 'sabando_angello'
 * 4. Wanke Cedeño Carl Hermann       -> Usuario: 'wanke_carl'
 * 5. Icaza Lino Diana Valentina      -> Usuario: 'icaza_diana'
 * * 🥼 CUENTAS DE MÉDICOS DE PRUEBA:
 * 1. Dr. Carlos Andrade  -> Usuario: 'andrade_carlos'
 * 2. Dra. María Cevallos -> Usuario: 'cevallos_maria'
 * 3. Dr. Jorge Mendoza   -> Usuario: 'mendoza_jorge'
 * 4. Dra. Ana Guerrero   -> Usuario: 'guerrero_ana'
 * 5. Dr. Luis Palacios   -> Usuario: 'palacios_luis'
 * ==========================================================================
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Core - Login</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">

    <div class="login-wrapper">
        <div class="login-card">
            
            <div class="login-header text-center">
                <h2 class="neon-text">Hospital Core</h2>
                <p class="login-subtitle">Sistema de Gestión Hospitalaria</p>
            </div>

            <?php if (isset($error) && $error): ?>
                <div class="alert-error"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="index.php?url=auth/login" method="POST" id="formHospitalLogin">
                <div class="form-group">
                    <label for="nombre_usuario">Nombre de Usuario</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-input" placeholder="Ej: salazar_yeancarlos" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña Corporativa</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <div class="form-actions text-center">
                    <button type="submit" class="btn-submit">Ingresar</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>