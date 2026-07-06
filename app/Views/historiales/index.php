<?php
/** @var array $historiales */
$historiales = $historiales ?? [];
?>

<div class="page-header">
    <a href="index.php?url=historiales/crear" class="btn btn-primary">ABRIR NUEVO HISTORIAL</a>
</div>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID HISTORIAL</th>
                <th>PACIENTE</th>
                <th>FECHA DE APERTURA</th>
                <th class="text-center">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($historiales)): ?>
                <?php foreach ($historiales as $historial): ?>
                    <tr>
                        <td><?= htmlspecialchars($historial['id']); ?></td>
                        <td><strong><?= htmlspecialchars($historial['paciente']); ?></strong></td>
                        <td><?= htmlspecialchars($historial['fecha_creacion']); ?></td>
                        <td class="text-center">
                            <div class="actions-flex unique-actions-center">
                            <a href="index.php?url=historiales/ver&id=<?= $historial['id']; ?>" class="btn-action btn-info">VER</a>
                          <a href="index.php?url=historiales/editar&id=<?= $historial['id']; ?>" class="btn-action btn-edit">EDITAR</a>
                         </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">
                        No existen historiales clínicos registrados en el sistema.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>