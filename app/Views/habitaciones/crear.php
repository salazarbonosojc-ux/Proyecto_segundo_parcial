<div class="page-header">
    <h2>Asignar e Instanciar Habitación</h2>
    <a href="index.php?url=habitaciones" class="btn btn-secondary">Volver al listado</a>
</div>
<div class="form-container">
    <form action="index.php?url=habitaciones/crear" method="POST">
        <div class="form-group">
            <label for="numero_habitacion">Número de Habitación:</label>
            <input type="text" id="numero_habitacion" name="numero_habitacion" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo de Habitación:</label>
            <select id="tipo" name="tipo" required>
                <option value="General">General</option>
                <option value="UCI">UCI</option>
                <option value="Pediatría">Pediatría</option>
                <option value="Maternidad">Maternidad</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Habitación</button>
    </form>
</div>