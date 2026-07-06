<?php
/** @var array $cita */
/** @var array $pacientes */
/** @var array $medicos */
$cita = $cita ?? ['id' => '', 'id_paciente' => '', 'id_medico' => '', 'fecha_hora' => '', 'estado' => ''];
$pacientes = $pacientes ?? [];
$medicos = $medicos ?? [];
$error = $error ?? null;
?>
<div class="page-header">
    <a href="index.php?url=citas" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert-error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=citas/editar&id=<?= $cita['id']; ?>" method="POST" id="formCitaEditar">
        <div class="form-group">
            <label for="id_paciente">Seleccionar Paciente:</label>
            <select id="id_paciente" name="id_paciente" required>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= $paciente['id']; ?>" <?= $paciente['id'] == $cita['id_paciente'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($paciente['cedula'] . ' - ' . $paciente['nombre'] . ' ' . $paciente['apellido']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_medico">Seleccionar Médico:</label>
            <select id="id_medico" name="id_medico" required>
                <?php foreach ($medicos as $medico): ?>
                    <option value="<?= $medico['id']; ?>" <?= $medico['id'] == $cita['id_medico'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($medico['nombre'] . ' ' . $medico['apellido']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fecha_hora">Fecha y Hora:</label>
            <input type="datetime-local" id="fecha_hora" name="fecha_hora" value="<?= str_replace(' ', 'T', $cita['fecha_hora']); ?>" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado de la Cita:</label>
            <select id="estado" name="estado" required>
                <option value="Pendiente" <?= $cita['estado'] === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="Completada" <?= $cita['estado'] === 'Completada' ? 'selected' : ''; ?>>Completada</option>
                <option value="Cancelada" <?= $cita['estado'] === 'Cancelada' ? 'selected' : ''; ?>>Cancelada</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Cita</button>
        </div>
    </form>
</div>