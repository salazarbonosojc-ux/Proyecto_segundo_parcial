<?php
/** @var array $historial */
$historial = $historial ?? ['id' => '', 'id_paciente' => '', 'cedula' => '', 'nombre' => '', 'apellido' => '', 'fecha_nacimiento' => ''];
$error = $error ?? null;
?>
<div class="page-header">
    <a href="index.php?url=historiales" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert-error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=historiales/ver&id=<?= $historial['id']; ?>" method="POST">
        <input type="hidden" name="id_paciente" value="<?= $historial['id_paciente']; ?>">
        
        <div class="form-group">
            <label for="cedula">Cédula de Identidad:</label>
            <input type="text" id="cedula" name="cedula" value="<?= htmlspecialchars($historial['cedula']); ?>" maxlength="10" required>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre del Paciente:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($historial['nombre']); ?>" required>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido del Paciente:</label>
            <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($historial['apellido']); ?>" required>
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($historial['fecha_nacimiento']); ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Historial</button>
        </div>
    </form>
</div>