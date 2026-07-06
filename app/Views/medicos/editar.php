<?php
/** @var array $medico */
$medico = $medico ?? ['id' => '', 'licencia_medica' => '', 'nombre' => '', 'apellido' => ''];
$error = $error ?? null;
?>
<div class="page-header">
    <a href="index.php?url=medicos" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert-error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=medicos/editar&id=<?= $medico['id']; ?>" method="POST">
        <div class="form-group">
            <label for="licencia_medica">Licencia Médica:</label>
            <input type="text" id="licencia_medica" name="licencia_medica" value="<?= htmlspecialchars($medico['licencia_medica']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($medico['nombre']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($medico['apellido']); ?>" required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Médico</button>
        </div>
    </form>
</div>