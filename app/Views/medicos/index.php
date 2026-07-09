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
                <th>Especialidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($medicos)): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay médicos registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($medicos as $medico): ?>
                    <tr>
                        <td><?= $medico['id']; ?></td>
                        <td><?= htmlspecialchars($medico['licencia_medica']); ?></td>
                        <td><?= htmlspecialchars($medico['nombre'] . ' ' . $medico['apellido']); ?></td>
                        <td><span style="background: rgba(6, 182, 212, 0.15); color: #22d3ee; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.85rem; border: 1px solid rgba(6, 182, 212, 0.3);"><?= htmlspecialchars($medico['especialidad'] ?? 'Sin Asignar'); ?></span></td>
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