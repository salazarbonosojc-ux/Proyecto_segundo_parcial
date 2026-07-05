<div class="page-header">
    <h2>Control de Citas Médicas</h2>
    <a href="index.php?url=citas/crear" class="btn btn-primary">Agendar Nueva Cita</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha y Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($citas)): ?>
                <tr>
                    <td colspan="6" class="table-empty">No hay citas médicas agendadas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($citas as $cita): ?>
                    <tr>
                        <td><?= $cita['id']; ?></td>
                        <td><?= htmlspecialchars($cita['paciente']); ?></td>
                        <td><?= htmlspecialchars($cita['medico']); ?></td>
                        <td><?= $cita['fecha_hora']; ?></td>
                        <td><?= htmlspecialchars($cita['estado']); ?></td>
                        <td>
                            <a href="index.php?url=citas/editar&id=<?= $cita['id']; ?>" class="btn-action btn-edit">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>