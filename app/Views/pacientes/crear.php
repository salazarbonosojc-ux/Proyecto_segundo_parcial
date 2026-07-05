<div class="page-header">
    <h2>Registrar Paciente</h2>
    <a href="index.php?url=pacientes" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form action="index.php?url=pacientes/crear" method="POST" id="formPaciente">
        <div class="form-group">
            <label for="cedula">Cédula (Obligatorio):</label>
            <input type="text" id="cedula" name="cedula" maxlength="10" required>
            <small class="error-msg" id="errorCedula"></small>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre (Obligatorio):</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido (Obligatorio):</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento (Obligatorio):</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Paciente</button>
    </form>
</div>