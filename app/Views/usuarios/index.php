<div class="page-header">
    <h2>Listado de Cuentas de Usuarios</h2>
    <a href="index.php?url=usuarios/crear" class="btn btn-primary">✚ Registrar Usuario</a>
</div>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Rol Asignado</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']); ?></td>
                        <td><strong><?= htmlspecialchars($user['nombre_usuario']); ?></strong></td>
                        <td>
                            <span class="badge badge-success" style="background: rgba(6, 182, 212, 0.2) !important; color: #06b6d4 !important; border: 1px solid #06b6d4 !important;">
                                <?= htmlspecialchars($user['rol']); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="actions-flex unique-actions-center">
                                <a href="index.php?url=usuarios/editar&id=<?= $user['id']; ?>" class="btn-action btn-edit">EDITAR</a>
                                <a href="index.php?url=usuarios/eliminar&id=<?= $user['id']; ?>" class="btn-action btn-delete" onclick="return confirm('¿Está seguro de eliminar este usuario?');">ELIMINAR</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No existen usuarios registrados en el sistema.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
