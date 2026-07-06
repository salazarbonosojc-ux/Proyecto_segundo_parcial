<?php
/** @var array $historial */
/** @var array $pacientes */
$historial = $historial ?? ['id' => '', 'id_paciente' => '', 'fecha_creacion' => ''];
$pacientes = $pacientes ?? [];
$error = $error ?? null;
?>
<div class="page-header">
    <a href="index.php?url=historiales" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert-error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=historiales/editar&id=<?= $historial['id']; ?>" method="POST" id="formHistorialEditar">
        <div class="form-group">
            <label for="id_paciente">Paciente Asignado:</label>
            <select id="id_paciente" name="id_paciente" required>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= $paciente['id']; ?>" <?= $paciente['id'] == $historial['id_paciente'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($paciente['cedula'] . ' - ' . $paciente['nombre'] . ' ' . $paciente['apellido']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fecha_creacion">Fecha de Apertura:</label>
            <input type="date" id="fecha_creacion" name="fecha_creacion" value="<?= date('Y-m-d', strtotime($historial['fecha_creacion'])); ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Historial</button>
        </div>
    </form>
</div>