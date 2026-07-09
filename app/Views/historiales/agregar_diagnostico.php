<?php
/** @var array $historial */
/** @var array $medicos */
/** @var string|null $error */
?>
<div class="page-header">
    <h2>Registrar Consulta Médica (Diagnóstico y Receta)</h2>
    <a href="index.php?url=historiales/ver&id=<?= $historial['id']; ?>" class="btn btn-secondary">← Cancelar y Volver</a>
</div>

<div class="form-container" style="background: rgba(0, 255, 150, 0.03); border: 1px solid rgba(0, 255, 150, 0.15); padding: 25px; border-radius: 8px;">
    
    <div style="background: rgba(255, 255, 255, 0.02); padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #00ff96;">
        <p style="margin: 0; color: #aaa; font-size: 13px; text-transform: uppercase;">Paciente Receptor</p>
        <h3 style="margin: 5px 0 0 0; color: #fff;"><?= htmlspecialchars($historial['nombre'] . ' ' . $historial['apellido']); ?> (Ced: <?= htmlspecialchars($historial['cedula']); ?>)</h3>
    </div>

    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger" style="margin-bottom: 20px;"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=historiales/guardarDiagnostico" method="POST" id="formAgregarDiagnostico">
        <!-- Input oculto para transmitir el ID del Historial -->
        <input type="hidden" name="id_historial" value="<?= $historial['id']; ?>">

        <div class="form-group">
            <label for="id_medico">Médico Tratante (Obligatorio):</label>
            <select id="id_medico" name="id_medico" required style="width: 100%; padding: 10px; background: rgba(0, 0, 0, 0.5); border: 1px solid rgba(0, 255, 150, 0.2); color: #fff; border-radius: 4px;">
                <option value="">-- Seleccione un Médico --</option>
                <?php if (!empty($medicos)): ?>
                    <?php foreach ($medicos as $medico): ?>
                        <option value="<?= $medico['id']; ?>">
                            Dr(a). <?= htmlspecialchars($medico['nombre'] . ' ' . $medico['apellido']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group" style="display: flex; gap: 20px;">
            <div style="flex: 1;">
                <label for="fecha_diagnostico">Fecha de la Consulta (Obligatorio):</label>
                <input type="date" id="fecha_diagnostico" name="fecha_diagnostico" value="<?= date('Y-m-d'); ?>" required style="width: 100%; padding: 10px; background: rgba(0, 0, 0, 0.5); border: 1px solid rgba(0, 255, 150, 0.2); color: #fff; border-radius: 4px;">
            </div>
            <div style="flex: 1;">
                <label for="dias_reposo">Días de Reposo (Opcional):</label>
                <input type="number" id="dias_reposo" name="dias_reposo" value="0" min="0" max="60" style="width: 100%; padding: 10px; background: rgba(0, 0, 0, 0.5); border: 1px solid rgba(0, 255, 150, 0.2); color: #fff; border-radius: 4px;">
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion">Diagnóstico Clínico (Obligatorio):</label>
            <textarea id="descripcion" name="descripcion" placeholder="Describa el diagnóstico detallado del paciente..." required rows="4" style="width: 100%; padding: 10px; background: rgba(0, 0, 0, 0.5); border: 1px solid rgba(0, 255, 150, 0.2); color: #fff; border-radius: 4px; font-family: sans-serif; resize: vertical;"></textarea>
        </div>

        <div class="form-group">
            <label for="tratamiento">Tratamiento / Receta Médica (Obligatorio):</label>
            <textarea id="tratamiento" name="tratamiento" placeholder="Escriba la receta detallada (medicinas, dosis, frecuencia)..." required rows="4" style="width: 100%; padding: 10px; background: rgba(0, 0, 0, 0.5); border: 1px solid rgba(0, 255, 150, 0.2); color: #fff; border-radius: 4px; font-family: sans-serif; resize: vertical;"></textarea>
        </div>

        <div class="form-actions" style="margin-top: 25px;">
            <button type="submit" class="btn btn-primary" style="box-shadow: 0 0 10px rgba(0, 255, 150, 0.3);">Registrar Diagnóstico y Receta</button>
            <a href="index.php?url=historiales/ver&id=<?= $historial['id']; ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
