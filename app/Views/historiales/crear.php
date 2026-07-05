<div class="page-header">
    <h2>Abrir Nuevo Historial Clínico</h2>
    <a href="index.php?url=historiales" class="btn btn-secondary">Volver al listado</a>
</div>
<div class="form-container">
    <form action="index.php?url=historiales/crear" method="POST">
        <div class="form-group">
            <label for="id_paciente">Paciente sin Historial:</label>
            <select id="id_paciente" name="id_paciente" required>
                <option value="">-- Seleccione un Paciente --</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Abrir Expediente</button>
    </form>
</div>