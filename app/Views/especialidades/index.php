<div class="page-header">
    <h2>Listado de Especialidades Médicas</h2>
    <a href="index.php?url=especialidades/crear" class="btn btn-primary">✚ Registrar Especialidad</a>
</div>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Especialidad</th>
                <th>Descripción</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($especialidades)): ?>
                <?php foreach ($especialidades as $esp): ?>
                    <tr>
                        <td><?= htmlspecialchars($esp['id']); ?></td>
                        <td><strong><?= htmlspecialchars($esp['nombre']); ?></strong></td>
                        <td><?= htmlspecialchars($esp['descripcion'] ?? 'Sin descripción'); ?></td>
                        <td class="text-center">
                            <div class="actions-flex unique-actions-center">
                                <a href="index.php?url=especialidades/editar&id=<?= $esp['id']; ?>" class="btn-action btn-edit">EDITAR</a>
                                <a href="index.php?url=especialidades/eliminar&id=<?= $esp['id']; ?>" class="btn-action btn-delete" onclick="return confirm('¿Está seguro de eliminar esta especialidad?');">ELIMINAR</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No existen especialidades registradas en el sistema.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
