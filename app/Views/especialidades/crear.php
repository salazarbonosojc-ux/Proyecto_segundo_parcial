<div class="page-header">
    <h2>Registrar Nueva Especialidad</h2>
    <a href="index.php?url=especialidades" class="btn btn-secondary">Volver al listado</a>
</div>

<div class="form-container">
    <form action="index.php?url=especialidades/guardar" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre de la Especialidad:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ej: Pediatría, Cardiología..." required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" style="width: 100%; min-height: 100px; padding: 14px; background-color: rgba(13, 21, 39, 0.9); border: 1px solid #1e293b; border-radius: 8px; color: #ffffff; font-size: 1rem; box-sizing: border-box; resize: vertical;" placeholder="Breve descripción de las patologías o tratamientos a cargo..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Especialidad</button>
    </form>
</div>
