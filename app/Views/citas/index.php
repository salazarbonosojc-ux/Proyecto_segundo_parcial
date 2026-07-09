<div class="page-header">
    <a href="index.php?url=citas/crear" class="btn btn-primary">Agendar Nueva Cita</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID Cita</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha y Hora</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($citas)): ?>
                <tr>
                    <td colspan="7" class="text-center">No hay citas médicas programadas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td><?= $cita['id']; ?></td>
                        <td><?= htmlspecialchars($cita['paciente'] ?? 'Paciente ID: ' . $cita['id_paciente']); ?></td>
                        <td><?= htmlspecialchars($cita['medico'] ?? 'Médico ID: ' . $cita['id_medico']); ?></td>
                        <td><?= $cita['fecha_hora']; ?></td>
                        <td><?= htmlspecialchars($cita['motivo'] ?? 'No especificado'); ?></td>
                        <td>
                            <span class="status-badge"><?= htmlspecialchars($cita['estado'] ?? 'Pendiente'); ?></span>
                        </td>
                        <td>
                            <div class="actions-flex">
                                <a href="index.php?url=citas/editar&id=<?= $cita['id']; ?>" class="btn-action btn-edit">Editar</a>
                                <a href="index.php?url=citas/eliminar&id=<?= $cita['id']; ?>" class="btn-action btn-delete" onclick="return confirm('¿Está seguro de que desea cancelar permanentemente esta cita médica?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>