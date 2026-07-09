<?php
/** @var array $ingresos */
$ingresos = $ingresos ?? [];
?>
<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>CÉDULA</th>
                <th>PACIENTE</th>
                <th>Nº HABITACIÓN</th>
                <th>TIPO</th>
                <th>FECHA INGRESO</th>
                <th>FECHA ALTA</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($ingresos)): ?>
                <?php foreach ($ingresos as $ingreso): ?>
                    <tr>
                        <td><?= htmlspecialchars($ingreso['id']); ?></td>
                        <td><?= htmlspecialchars($ingreso['cedula']); ?></td>
                        <td><strong><?= htmlspecialchars($ingreso['paciente']); ?></strong></td>
                        <td>Nº <?= htmlspecialchars($ingreso['numero_habitacion']); ?></td>
                        <td><?= htmlspecialchars($ingreso['tipo_habitacion']); ?></td>
                        <td><?= htmlspecialchars($ingreso['fecha_ingreso']); ?></td>
                        <td>
                            <?php if ($ingreso['fecha_alta']): ?>
                                <?= htmlspecialchars($ingreso['fecha_alta']); ?>
                            <?php else: ?>
                                <span style="color: #00ff96; font-weight: bold;">Activo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($ingreso['fecha_alta']): ?>
                                <span style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Completado</span>
                            <?php else: ?>
                                <a href="index.php?url=ingresos/darAlta&id=<?= $ingreso['id']; ?>" class="btn-action btn-delete" style="padding: 8px 16px !important; font-size: 0.8rem !important; min-width: auto;" onclick="return confirm('¿Está seguro de que desea dar de alta a este paciente y liberar la habitación?')">
                                    Dar de Alta
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center; color: #a5f3fc; padding: 20px;">
                        No hay asignaciones de habitaciones activas en este momento.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>