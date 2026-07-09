<div class="page-header">
    <h2>Agendar Nueva Cita</h2>
    <a href="index.php?url=citas" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=citas/crear" method="POST" id="formCitaCrear">
        
        <div class="form-group">
            <label for="id_paciente">Seleccionar Paciente:</label>
            <select id="id_paciente" name="id_paciente" required>
                <option value="">-- Seleccione un Paciente --</option>
                <?php if (!empty($pacientes)): ?>
                    <?php foreach ($pacientes as $paciente): ?>
                        <option value="<?= $paciente['id']; ?>">
                            <?= htmlspecialchars($paciente['cedula'] . ' - ' . $paciente['nombre'] . ' ' . $paciente['apellido']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_medico">Seleccionar Médico:</label>
            <select id="id_medico" name="id_medico" required>
                <option value="">-- Seleccione un Médico --</option>
                <?php if (!empty($medicos)): ?>
                    <?php foreach ($medicos as $medico): ?>
                        <option value="<?= $medico['id']; ?>">
                            <?= htmlspecialchars($medico['nombre'] . ' ' . $medico['apellido'] . ' (' . $medico['licencia_medica'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fecha_hora">Fecha y Hora:</label>
            <input type="datetime-local" id="fecha_hora" name="fecha_hora" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Agendar Cita</button>
        </div>
    </form>
</div>