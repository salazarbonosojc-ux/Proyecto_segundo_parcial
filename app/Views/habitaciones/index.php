<div class="page-header">
    <a href="index.php?url=habitaciones/crear" class="btn btn-primary">Asignar Habitación</a>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nº Habitación</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($habitaciones)): ?>
                <tr>
                    <td colspan="5" class="table-empty">No hay habitaciones configuradas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($habitaciones as $hab): ?>
                    <tr>
                        <td><?= $hab['id']; ?></td>
                        <td><?= htmlspecialchars($hab['numero_habitacion']); ?></td>
                        <td><?= htmlspecialchars($hab['tipo']); ?></td>
                        <td><?= htmlspecialchars($hab['estado']); ?></td>
                        <td>
                            <a href="index.php?url=habitaciones/editar&id=<?= $hab['id']; ?>" class="btn-action btn-edit">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>