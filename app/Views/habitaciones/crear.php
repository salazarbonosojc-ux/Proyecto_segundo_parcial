<?php
/** @var array $pacientes */
/** @var array $habitaciones */
$pacientes = $pacientes ?? [];
$habitaciones = $habitaciones ?? [];
?>
<div class="form-container">
    <form action="index.php?url=habitaciones/guardar" method="POST">
        
        <div class="form-group">
            <label for="id_paciente">Seleccionar Paciente:</label>
            <select id="id_paciente" name="id_paciente" required>
                <option value="">-- Seleccione un Paciente --</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= $paciente['id']; ?>">
                        <?= htmlspecialchars($paciente['cedula'] . ' - ' . $paciente['nombre'] . ' ' . $paciente['apellido']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_habitacion">Seleccionar Habitación Física Disponible:</label>
            <select id="id_habitacion" name="id_habitacion" required>
                <option value="">-- Seleccione la Habitación --</option>
                <?php foreach ($habitaciones as $hab): ?>
                    <option value="<?= $hab['id']; ?>">
                        Nº <?= htmlspecialchars($hab['numero_habitacion'] . ' (' . $hab['tipo'] . ')'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Confirmar Asignación</button>
            <a href="index.php?url=ingresos" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>