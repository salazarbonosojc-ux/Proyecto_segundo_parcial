<?php
/** @var array $habitacion */
$habitacion = $habitacion ?? ['id' => '', 'numero_habitacion' => '', 'tipo' => '', 'estado' => ''];
$error = $error ?? null;
?>
<div class="page-header">
    <a href="index.php?url=habitaciones" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert-error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=habitaciones/editar&id=<?= $habitacion['id']; ?>" method="POST">
        <div class="form-group">
            <label for="numero_habitacion">Nº Habitación:</label>
            <input type="text" id="numero_habitacion" name="numero_habitacion" value="<?= htmlspecialchars($habitacion['numero_habitacion']); ?>" required>
        </div>

        <div class="form-group">
            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" value="<?= htmlspecialchars($habitacion['tipo']); ?>" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="Disponible" <?= $habitacion['estado'] === 'Disponible' ? 'selected' : ''; ?>>Disponible</option>
                <option value="Ocupada" <?= $habitacion['estado'] === 'Ocupada' ? 'selected' : ''; ?>>Ocupada</option>
                <option value="Mantenimiento" <?= $habitacion['estado'] === 'Mantenimiento' ? 'selected' : ''; ?>>Mantenimiento</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Habitación</button>
        </div>
    </form>
</div>