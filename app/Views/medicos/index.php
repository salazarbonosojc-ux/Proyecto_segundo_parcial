<div class="page-header">
    <a href="index.php?url=medicos/crear" class="btn btn-primary">Registrar Nuevo Médico</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Licencia Médica</th>
                <th>Nombre Completo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($medicos)): ?>
                <tr>
                    <td colspan="4" class="text-center">No hay médicos registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($medicos as $medico): ?>
                    <tr>
                        <td><?= $medico['id']; ?></td>
                        <td><?= htmlspecialchars($medico['licencia_medica']); ?></td>
                        <td><?= htmlspecialchars($medico['nombre'] . ' ' . $medico['apellido']); ?></td>
                        <td>
                            <a href="index.php?url=medicos/editar&id=<?= $medico['id']; ?>" class="btn-action btn-edit">Editar</a>
                            <a href="index.php?url=medicos/eliminar&id=<?= $medico['id']; ?>" class="btn-action btn-delete" onclick="return confirm('¿Está seguro de que desea eliminar permanentemente a este médico?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>