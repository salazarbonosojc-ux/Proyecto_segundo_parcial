<div class="page-header">
    <h2>Registrar Nuevo Medicamento</h2>
    <a href="index.php?url=medicamentos" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <form action="index.php?url=medicamentos/guardar" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre del Medicamento:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ej: Paracetamol 500mg, Amoxicilina suspensión..." required>
        </div>
        
        <div class="form-group">
            <label for="codigo">Código Único (Cód. de barra / interno):</label>
            <input type="text" id="codigo" name="codigo" placeholder="Ej: MED-PAR500" required>
        </div>

        <div class="form-group" style="display: flex; gap: 15px;">
            <div style="flex: 1;">
                <label for="stock">Stock Inicial (Unidades):</label>
                <input type="number" id="stock" name="stock" value="0" min="0" required>
            </div>
            <div style="flex: 1;">
                <label for="precio">Precio Unitario ($):</label>
                <input type="number" id="precio" name="precio" value="0.00" step="0.01" min="0.00" required>
            </div>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción / Indicaciones:</label>
            <textarea id="descripcion" name="descripcion" style="width: 100%; min-height: 80px; padding: 14px; background-color: rgba(13, 21, 39, 0.9); border: 1px solid #1e293b; border-radius: 8px; color: #ffffff; font-size: 1rem; box-sizing: border-box; resize: vertical;" placeholder="Indicaciones de uso, efectos secundarios o dosificación estándar..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Medicamento</button>
    </form>
</div>
