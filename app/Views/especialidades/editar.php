<?php
/** @var array $especialidad */
$especialidad = $especialidad ?? ['id' => '', 'nombre' => '', 'descripcion' => ''];
$error = $error ?? null;
?>
<div class="page-header">
    <h2>Editar Especialidad Médica</h2>
    <a href="index.php?url=especialidades" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert-error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=especialidades/editar&id=<?= $especialidad['id']; ?>" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre de la Especialidad:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($especialidad['nombre']); ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" style="width: 100%; min-height: 100px; padding: 14px; background-color: rgba(13, 21, 39, 0.9); border: 1px solid #1e293b; border-radius: 8px; color: #ffffff; font-size: 1rem; box-sizing: border-box; resize: vertical;"><?= htmlspecialchars($especialidad['descripcion'] ?? ''); ?></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Especialidad</button>
        </div>
    </form>
</div>
