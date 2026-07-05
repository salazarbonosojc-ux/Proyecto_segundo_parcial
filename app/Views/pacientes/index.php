<div class="page-header">
    <h2>Gestión de Pacientes</h2>
    <a href="index.php?url=pacientes/crear" class="btn btn-primary">Registrar Nuevo Paciente</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Nombre Completo</th>
                <th>Fecha Nacimiento</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($pacientes)): ?>
                <tr>
                    <td colspan="6" style="text-align: center;">No hay pacientes registrados.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($pacientes as $paciente): ?>
                    <tr>
                        <td><?= $paciente['id']; ?></td>
                        <td><?= htmlspecialchars($paciente['cedula']); ?></td>
                        <td><?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']); ?></td>
                        <td><?= $paciente['fecha_nacimiento']; ?></td>
                        <td><?= htmlspecialchars($paciente['telefono'] ?? 'N/A'); ?></td>
                        <td>
                            <a href="index.php?url=pacientes/editar&id=<?= $paciente['id']; ?>" class="btn-action btn-edit" style="background: #eab308; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 14px; margin-right: 5px;">Editar</a>
                            <a href="index.php?url=pacientes/eliminar&id=<?= $paciente['id']; ?>" class="btn-action btn-delete" style="background: #ef4444; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 14px;" onclick="return confirm('¿Está seguro de que desea eliminar permanentemente a este paciente?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>