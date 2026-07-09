<?php
/** @var array $diagnostico */
$diagnostico = $diagnostico ?? ['id' => '', 'id_historial' => '', 'id_medico' => '', 'descripcion' => '', 'tratamiento' => '', 'fecha_diagnostico' => '', 'dias_reposo' => ''];
$historiales = $historiales ?? [];
$medicos = $medicos ?? [];
$error = $error ?? null;
?>
<div class="page-header">
    <h2>Editar Diagnóstico Clínico</h2>
    <a href="index.php?url=diagnosticos" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert-error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=diagnosticos/editar&id=<?= $diagnostico['id']; ?>" method="POST">
        <div class="form-group">
            <label for="id_historial">Seleccionar Historial del Paciente:</label>
            <select id="id_historial" name="id_historial" required>
                <?php foreach ($historiales as $hist): ?>
                    <option value="<?= $hist['id']; ?>" <?= $diagnostico['id_historial'] == $hist['id'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($hist['paciente']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="id_medico">Médico Diagnosticador:</label>
            <select id="id_medico" name="id_medico" required>
                <?php foreach ($medicos as $med): ?>
                    <option value="<?= $med['id']; ?>" <?= $diagnostico['id_medico'] == $med['id'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($med['medico']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="fecha_diagnostico">Fecha del Diagnóstico:</label>
            <input type="date" id="fecha_diagnostico" name="fecha_diagnostico" value="<?= htmlspecialchars($diagnostico['fecha_diagnostico']); ?>" required>
        </div>

        <div class="form-group">
            <label for="dias_reposo">Días de Reposo Médico:</label>
            <input type="number" id="dias_reposo" name="dias_reposo" value="<?= htmlspecialchars($diagnostico['dias_reposo']); ?>" min="0" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción del Diagnóstico / Cuadro Clínico:</label>
            <textarea id="descripcion" name="descripcion" style="width: 100%; min-height: 80px; padding: 14px; background-color: rgba(13, 21, 39, 0.9); border: 1px solid #1e293b; border-radius: 8px; color: #ffffff; font-size: 1rem; box-sizing: border-box; resize: vertical;" required><?= htmlspecialchars($diagnostico['descripcion']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="tratamiento">Tratamiento / Receta Médica:</label>
            <textarea id="tratamiento" name="tratamiento" style="width: 100%; min-height: 100px; padding: 14px; background-color: rgba(13, 21, 39, 0.9); border: 1px solid #1e293b; border-radius: 8px; color: #ffffff; font-size: 1rem; box-sizing: border-box; resize: vertical;" required><?= htmlspecialchars($diagnostico['tratamiento']); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Diagnóstico</button>
        </div>
    </form>
</div>
