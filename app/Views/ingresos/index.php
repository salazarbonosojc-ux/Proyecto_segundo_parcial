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
                                <span style="color: #06b6d4; font-weight: bold;">Activo</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #a5f3fc; padding: 20px;">
                        No hay asignaciones de habitaciones activas en este momento.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>