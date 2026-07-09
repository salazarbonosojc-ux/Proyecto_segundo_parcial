<?php
/** @var array $medicamento */
$medicamento = $medicamento ?? ['id' => '', 'nombre' => '', 'codigo' => '', 'descripcion' => '', 'stock' => 0, 'precio' => 0.0];
$error = $error ?? null;
?>
<div class="page-header">
    <h2>Editar Medicamento</h2>
    <a href="index.php?url=medicamentos" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <?php if (isset($error) && $error): ?>
        <div class="alert-error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="index.php?url=medicamentos/editar&id=<?= $medicamento['id']; ?>" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre del Medicamento:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($medicamento['nombre']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="codigo">Código Único:</label>
            <input type="text" id="codigo" name="codigo" value="<?= htmlspecialchars($medicamento['codigo']); ?>" required>
        </div>

        <div class="form-group" style="display: flex; gap: 15px;">
            <div style="flex: 1;">
                <label for="stock">Stock Disponible:</label>
                <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($medicamento['stock']); ?>" min="0" required>
            </div>
            <div style="flex: 1;">
                <label for="precio">Precio Unitario ($):</label>
                <input type="number" id="precio" name="precio" value="<?= htmlspecialchars($medicamento['precio']); ?>" step="0.01" min="0.00" required>
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción / Indicaciones:</label>
            <textarea id="descripcion" name="descripcion" style="width: 100%; min-height: 80px; padding: 14px; background-color: rgba(13, 21, 39, 0.9); border: 1px solid #1e293b; border-radius: 8px; color: #ffffff; font-size: 1rem; box-sizing: border-box; resize: vertical;"><?= htmlspecialchars($medicamento['descripcion']); ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Medicamento</button>
        </div>
    </form>
</div>
