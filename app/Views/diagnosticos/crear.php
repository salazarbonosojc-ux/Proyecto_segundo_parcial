<div class="page-header">
    <h2>Registrar Nuevo Diagnóstico Clínico</h2>
    <a href="index.php?url=diagnosticos" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <form action="index.php?url=diagnosticos/guardar" method="POST">
        <div class="form-group">
            <label for="id_historial">Seleccionar Historial del Paciente:</label>
            <select id="id_historial" name="id_historial" required>
                <option value="">-- Seleccionar Paciente --</option>
                <?php foreach ($historiales as $hist): ?>
                    <option value="<?= $hist['id']; ?>">
                        <?= htmlspecialchars($hist['paciente']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="id_medico">Médico Diagnosticador:</label>
            <select id="id_medico" name="id_medico" required>
                <option value="">-- Seleccionar Médico --</option>
                <?php foreach ($medicos as $med): ?>
                    <option value="<?= $med['id']; ?>">
                        <?= htmlspecialchars($med['medico']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="fecha_diagnostico">Fecha del Diagnóstico:</label>
            <input type="date" id="fecha_diagnostico" name="fecha_diagnostico" value="<?= date('Y-m-d'); ?>" required>
        </div>

        <div class="form-group">
            <label for="dias_reposo">Días de Reposo Médico:</label>
            <input type="number" id="dias_reposo" name="dias_reposo" value="0" min="0" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción del Diagnóstico / Cuadro Clínico:</label>
            <textarea id="descripcion" name="descripcion" style="width: 100%; min-height: 80px; padding: 14px; background-color: rgba(13, 21, 39, 0.9); border: 1px solid #1e293b; border-radius: 8px; color: #ffffff; font-size: 1rem; box-sizing: border-box; resize: vertical;" placeholder="Síntomas detectados, patologías diagnosticadas..." required></textarea>
        </div>

        <div class="form-group">
            <label for="tratamiento">Tratamiento / Receta Médica:</label>
            <textarea id="tratamiento" name="tratamiento" style="width: 100%; min-height: 100px; padding: 14px; background-color: rgba(13, 21, 39, 0.9); border: 1px solid #1e293b; border-radius: 8px; color: #ffffff; font-size: 1rem; box-sizing: border-box; resize: vertical;" placeholder="Medicamentos prescritos, dosis, frecuencia y cuidados generales..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Diagnóstico</button>
    </form>
</div>
