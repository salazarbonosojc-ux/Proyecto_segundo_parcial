<?php
/** @var array $usuario */
$usuario = $usuario ?? ['id' => '', 'nombre_usuario' => '', 'id_rol' => ''];
$roles = $roles ?? [];
$error = $error ?? null;
?>
<div class="page-header">
    <h2>Editar Cuenta de Usuario</h2>
    <a href="index.php?url=usuarios" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert-error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=usuarios/editar&id=<?= $usuario['id']; ?>" method="POST">
        <div class="form-group">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?= htmlspecialchars($usuario['nombre_usuario']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Contraseña Corporativa (Dejar vacío para mantener la actual):</label>
            <input type="password" id="password" name="password" placeholder="Nueva contraseña opcional">
        </div>
        
        <div class="form-group">
            <label for="id_rol">Rol del Usuario:</label>
            <select id="id_rol" name="id_rol" required>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?= $rol['id']; ?>" <?= $usuario['id_rol'] == $rol['id'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($rol['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Cuenta</button>
        </div>
    </form>
</div>
