<div class="page-header">
    <h2>Registrar Nuevo Médico</h2>
    <a href="index.php?url=medicos" class="btn btn-secondary">Volver al listado</a>
</div>
<div class="form-container">
    <form action="index.php?url=medicos/crear" method="POST">
        <div class="form-group">
            <label for="licencia_medica">Licencia Médica:</label>
            <input type="text" id="licencia_medica" name="licencia_medica" required>
        </div>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Médico</button>
    </form>
</div>