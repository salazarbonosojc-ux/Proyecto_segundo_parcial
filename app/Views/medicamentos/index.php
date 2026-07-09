<div class="page-header">
    <h2>Catálogo e Inventario de Medicamentos</h2>
    <a href="index.php?url=medicamentos/crear" class="btn btn-primary">✚ Registrar Medicamento</a>
</div>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre del Fármaco</th>
                <th>Descripción</th>
                <th>Stock Disponible</th>
                <th>Precio Unitario</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($medicamentos)): ?>
                <?php foreach ($medicamentos as $med): ?>
                    <tr>
                        <td><?= htmlspecialchars($med['id']); ?></td>
                        <td><code style="background: rgba(6, 182, 212, 0.1); padding: 4px 8px; border-radius: 4px; color: #06b6d4; font-weight: bold;"><?= htmlspecialchars($med['codigo']); ?></code></td>
                        <td><strong><?= htmlspecialchars($med['nombre']); ?></strong></td>
                        <td><?= htmlspecialchars($med['descripcion'] ?? 'Sin descripción'); ?></td>
                        <td class="text-center" style="font-weight: bold; <?= $med['stock'] < 20 ? 'color: #ff4444;' : 'color: #00ff96;'; ?>">
                            <?= htmlspecialchars($med['stock']); ?> uds
                        </td>
                        <td>$<?= number_format($med['precio'], 2); ?></td>
                        <td class="text-center">
                            <div class="actions-flex unique-actions-center">
                                <a href="index.php?url=medicamentos/editar&id=<?= $med['id']; ?>" class="btn-action btn-edit">EDITAR</a>
                                <a href="index.php?url=medicamentos/eliminar&id=<?= $med['id']; ?>" class="btn-action btn-delete" onclick="return confirm('¿Está seguro de eliminar este medicamento?');">ELIMINAR</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No existen medicamentos registrados en el sistema.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
