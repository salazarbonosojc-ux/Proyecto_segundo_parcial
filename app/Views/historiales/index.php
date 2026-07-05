<div class="page-header">
    <h2>Historiales Clínicos</h2>
    <a href="index.php?url=historiales/crear" class="btn btn-primary">Abrir Nuevo Historial</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID Historial</th>
                <th>Cédula Paciente</th>
                <th>Paciente</th>
                <th>Fecha Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($historiales)): ?>
                <tr>
                    <td colspan="5" class="table-empty">No hay historiales clínicos abiertos.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($historiales as $hist): ?>
                    <tr>
                        <td><?= $hist['id']; ?></td>
                        <td><?= htmlspecialchars($hist['cedula']); ?></td>
                        <td><?= htmlspecialchars($hist['paciente']); ?></td>
                        <td><?= $hist['fecha_creacion']; ?></td>
                        <td>
                            <a href="index.php?url=historiales/ver&id=<?= $hist['id']; ?>" class="btn-action btn-edit" style="background: #06b6d4;">Ver</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>