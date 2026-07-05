<div class="page-header">
    <h2>Agendar Nueva Cita</h2>
    <a href="index.php?url=citas" class="btn btn-secondary">Volver al listado</a>
</div>
<div class="form-container">
    <form action="index.php?url=citas/crear" method="POST">
        <div class="form-group">
            <label for="id_paciente">Seleccionar Paciente:</label>
            <select id="id_paciente" name="id_paciente" required>
                <option value="">-- Seleccione un Paciente --</option>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_hora">Fecha y Hora:</label>
            <input type="datetime-local" id="fecha_hora" name="fecha_hora" required>
        </div>
        <button type="submit" class="btn btn-primary">Agendar Cita</button>
    </form>
</div>