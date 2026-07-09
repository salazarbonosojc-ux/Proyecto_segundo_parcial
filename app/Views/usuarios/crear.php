<div class="page-header">
    <h2>Registrar Nuevo Usuario</h2>
    <a href="index.php?url=usuarios" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <form action="index.php?url=usuarios/guardar" method="POST">
        <div class="form-group">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Ej: andrade_carlos, gomez_juan" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña Corporativa:</label>
            <input type="password" id="password" name="password" placeholder="Mínimo 6 caracteres" required>
        </div>
        <div class="form-group">
            <label for="id_rol">Rol del Usuario:</label>
            <select id="id_rol" name="id_rol" required>
                <option value="">-- Seleccionar Rol --</option>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?= $rol['id']; ?>">
                        <?= htmlspecialchars($rol['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cuenta</button>
    </form>
</div>
