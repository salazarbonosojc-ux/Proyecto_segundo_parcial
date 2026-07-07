<div class="page-header">
    <h2>Modificar Datos del Paciente</h2>
    <a href="index.php?url=pacientes" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (isset($paciente) && $paciente): ?>
    <form action="index.php?url=pacientes/editar&id=<?= $paciente['id']; ?>" method="POST" id="formPacienteEditar">
        <div class="form-group">
            <label for="cedula">Cédula (Obligatorio):</label>
            <input type="text" id="cedula" name="cedula" value="<?= htmlspecialchars($paciente['cedula']); ?>" maxlength="10" required>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre (Obligatorio):</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($paciente['nombre']); ?>" required>
        </div>

        <div class="form-group">
            <label for="apellido">Apellido (Obligatorio):</label>
            <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($paciente['apellido']); ?>" required>
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento (Obligatorio):</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($paciente['fecha_nacimiento']); ?>" required>
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($paciente['telefono'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($paciente['email'] ?? ''); ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
        </div>
    </form>
    <?php else: ?>
        <div class="alert alert-danger">No se pudieron cargar los datos del paciente para editar.</div>
    <?php endif; ?>
</div>