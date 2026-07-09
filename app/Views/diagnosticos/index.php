<div class="page-header">
    <h2>Listado de Diagnósticos Médicos</h2>
    <a href="index.php?url=diagnosticos/crear" class="btn btn-primary">✚ Registrar Diagnóstico</a>
</div>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Médico Tratante</th>
                <th>Fecha</th>
                <th>Diagnóstico / Patología</th>
                <th>Días de Reposo</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($diagnosticos)): ?>
                <?php foreach ($diagnosticos as $diag): ?>
                    <tr>
                        <td><?= htmlspecialchars($diag['id']); ?></td>
                        <td><strong><?= htmlspecialchars($diag['paciente']); ?></strong></td>
                        <td><?= htmlspecialchars($diag['medico']); ?></td>
                        <td><?= htmlspecialchars($diag['fecha_diagnostico']); ?></td>
                        <td><?= htmlspecialchars($diag['descripcion']); ?></td>
                        <td class="text-center" style="font-weight: bold; color: #ffcc00;"><?= htmlspecialchars($diag['dias_reposo'] ?? '0'); ?></td>
                        <td class="text-center">
                            <div class="actions-flex unique-actions-center">
                                <a href="index.php?url=diagnosticos/editar&id=<?= $diag['id']; ?>" class="btn-action btn-edit">EDITAR</a>
                                <a href="index.php?url=diagnosticos/eliminar&id=<?= $diag['id']; ?>" class="btn-action btn-delete" onclick="return confirm('¿Está seguro de eliminar este diagnóstico?');">ELIMINAR</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No existen diagnósticos registrados en el sistema.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
