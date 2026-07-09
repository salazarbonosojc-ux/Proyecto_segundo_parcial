<?php
/** @var array $ingresos */
$ingresos = $ingresos ?? [];
?>
<div class="page-header">
    <h2>Habitaciones Asignadas a Pacientes</h2>
</div>

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
                        <td><?= htmlspecialchars($ingreso['numero_habitacion']); ?></td>
                        <td><?= htmlspecialchars($ingreso['tipo_habitacion']); ?></td>
                        <td><?= htmlspecialchars($ingreso['fecha_ingreso']); ?></td>
                        <td>
                            <?= $ingreso['fecha_alta'] ? htmlspecialchars($ingreso['fecha_alta']) : '<span class="status-badge occupied">Activo</span>'; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay asignaciones de habitaciones registradas actualmente.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>