<div class="page-header">
    <h2>Abrir Nuevo Historial Clínico</h2>
    <a href="index.php?url=historiales" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=historiales/crear" method="POST">
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
            <label for="fecha_creacion">Fecha de Apertura:</label>
            <input type="date" id="fecha_creacion" name="fecha_creacion" value="<?= date('Y-m-d'); ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Abrir Historial</button>
        </div>
    </form>
</div>