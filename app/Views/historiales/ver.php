<?php
/** @var array $historial */
$historial = $historial ?? [];
$diagnosticos = $diagnosticos ?? [];
$citas = $citas ?? [];
$error = $error ?? null;

// Calcular edad del paciente
$fecha_nac = isset($historial['fecha_nacimiento']) ? new DateTime($historial['fecha_nacimiento']) : null;
$hoy = new DateTime();
$edad = $fecha_nac ? $hoy->diff($fecha_nac)->y : 'N/A';
?>

<div class="page-header">
    <h2>Historial Clínico Completo</h2>
    <a href="index.php?url=historiales" class="btn btn-secondary">Volver al listado</a>
</div>

<?php if (isset($error) && $error): ?>
    <div class="alert-error"><?= htmlspecialchars($error); ?></div>
<?php endif; ?>

<?php if ($historial): ?>

    <!-- SECCIÓN 1: INFORMACIÓN DEL PACIENTE -->
    <div class="card-section">
        <h3>📋 Información del Paciente</h3>
        <div class="info-grid">
            <div class="info-item">
                <label>Nombre Completo:</label>
                <span class="info-value"><?= htmlspecialchars($historial['nombre'] . ' ' . $historial['apellido']); ?></span>
            </div>
            <div class="info-item">
                <label>Cédula:</label>
                <span class="info-value"><?= htmlspecialchars($historial['cedula']); ?></span>
            </div>
            <div class="info-item">
                <label>Edad:</label>
                <span class="info-value"><?= htmlspecialchars($edad); ?> años</span>
            </div>
            <div class="info-item">
                <label>Teléfono:</label>
                <span class="info-value"><?= htmlspecialchars($historial['telefono'] ?? 'No registrado'); ?></span>
            </div>
            <div class="info-item">
                <label>Correo Electrónico:</label>
                <span class="info-value"><?= htmlspecialchars($historial['email'] ?? 'No registrado'); ?></span>
            </div>
            <div class="info-item">
                <label>Fecha de Nacimiento:</label>
                <span class="info-value"><?= htmlspecialchars($historial['fecha_nacimiento']); ?></span>
            </div>
            <div class="info-item">
                <label>Historial Abierto:</label>
                <span class="info-value"><?= htmlspecialchars($historial['fecha_creacion']); ?></span>
            </div>
        </div>
    </div>

    <!-- SECCIÓN 2: DIAGNÓSTICOS Y RECETAS -->
    <div class="card-section">
        <h3>💊 Diagnósticos y Recetas</h3>
        <?php if (!empty($diagnosticos)): ?>
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Fecha Diagnóstico</th>
                            <th>Médico Tratante</th>
                            <th>Diagnóstico</th>
                            <th>Tratamiento Recetado</th>
                            <th>Reposo (Días)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($diagnosticos as $diag): ?>
                            <tr>
                                <td><?= htmlspecialchars($diag['fecha_diagnostico']); ?></td>
                                <td><strong><?= htmlspecialchars($diag['medico']); ?></strong></td>
                                <td><?= htmlspecialchars($diag['descripcion']); ?></td>
                                <td class="highlight-treatment"><?= htmlspecialchars($diag['tratamiento']); ?></td>
                                <td class="text-center" style="font-weight: bold; color: #ffcc00; text-align: center;">
                                    <?= htmlspecialchars($diag['dias_reposo'] ?? '0'); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No hay diagnósticos registrados para este paciente.</p>
        <?php endif; ?>
    </div>

    <!-- SECCIÓN 3: ÚLTIMAS CITAS -->
    <div class="card-section">
        <h3>📅 Últimas Citas Médicas</h3>
        <?php if (!empty($citas)): ?>
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Fecha y Hora</th>
                            <th>Médico</th>
                            <th>Especialidad</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($citas as $cita): ?>
                            <tr>
                                <td><?= htmlspecialchars($cita['fecha_hora']); ?></td>
                                <td><?= htmlspecialchars($cita['medico']); ?></td>
                                <td><?= htmlspecialchars($cita['especialidad']); ?></td>
                                <td><?= htmlspecialchars($cita['motivo']); ?></td>
                                <td>
                                    <span class="badge badge-<?= strtolower($cita['estado']); ?>">
                                        <?= htmlspecialchars($cita['estado']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No hay citas registradas para este paciente.</p>
        <?php endif; ?>
    </div>

    <!-- ACCIONES PRINCIPALES -->
    <div class="form-actions" style="display: flex; gap: 10px; margin-top: 20px;">
        <a href="index.php?url=historiales" class="btn btn-secondary" title="Volver al listado de historiales">
            ← Volver
        </a>
        <a href="index.php?url=historiales/agregarDiagnostico&id=<?= $historial['id']; ?>" class="btn btn-primary" title="Registrar una nueva consulta con diagnóstico y receta">
            ✚ Registrar Consulta/Diagnóstico
        </a>
    </div>

    <?php if (isset($_SESSION['mensaje_correo'])): ?>
        <div class="alert-success" style="margin-top: 15px;">
            <?= htmlspecialchars($_SESSION['mensaje_correo']); ?>
        </div>
        <?php unset($_SESSION['mensaje_correo']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_correo'])): ?>
        <div class="alert-error" style="margin-top: 15px;">
            <?= htmlspecialchars($_SESSION['error_correo']); ?>
        </div>
        <?php unset($_SESSION['error_correo']); ?>
    <?php endif; ?>

<?php else: ?>
    <div class="alert-error">
        Error: No se pudo cargar el historial clínico solicitado.
    </div>
    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php?url=historiales" class="btn btn-secondary">Volver al listado</a>
    </div>
<?php endif; ?>

<style>
    .card-section {
        background: rgba(0, 255, 150, 0.05);
        border: 1px solid rgba(0, 255, 150, 0.2);
        border-radius: 6px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .card-section h3 {
        color: #00ff96;
        margin-top: 0;
        margin-bottom: 15px;
        text-shadow: 0 0 5px rgba(0, 255, 150, 0.4);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        padding: 10px;
        background: rgba(255, 255, 255, 0.02);
        border-left: 3px solid #00ff96;
        border-radius: 4px;
    }

    .info-item label {
        color: #999;
        font-size: 12px;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .info-value {
        color: #fff;
        font-size: 14px;
        font-weight: 500;
    }

    .highlight-treatment {
        background: rgba(0, 255, 150, 0.1);
        padding: 8px;
        border-radius: 3px;
        border-left: 3px solid #00ff96;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-pendiente {
        background: rgba(255, 200, 0, 0.2);
        color: #ffcc00;
        border: 1px solid #ffcc00;
    }

    .badge-completada {
        background: rgba(0, 255, 150, 0.2);
        color: #00ff96;
        border: 1px solid #00ff96;
    }

    .badge-cancelada {
        background: rgba(255, 100, 100, 0.2);
        color: #ff6464;
        border: 1px solid #ff6464;
    }

    .text-muted {
        color: #666;
        font-style: italic;
        text-align: center;
        padding: 20px;
    }
</style>