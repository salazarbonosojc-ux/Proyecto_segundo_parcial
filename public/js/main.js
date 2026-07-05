// Esperar a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {
    
    // Capturar todos los botones de eliminación del sistema
    const deleteButtons = document.querySelectorAll(".btn-delete");
    
    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            // Detener el viaje del enlace temporalmente
            const confirmar = confirm("¿Está completamente seguro de que desea eliminar permanentemente este registro?");
            
            if (!confirmar) {
                event.preventDefault(); // Cancela la acción si el usuario le da a Cancelar
            }
        });
    });

    // Ejemplo: Validación rápida del formulario de edición/creación en el cliente
    const hospitalForms = document.querySelectorAll("form");
    hospitalForms.forEach(function (form) {
        form.addEventListener("submit", function () {
            const submitBtn = form.querySelector("button[type='submit']");
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerText = "Procesando...";
            }
        });
    });
});