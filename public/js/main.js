// public/js/main.js

document.addEventListener('DOMContentLoaded', () => {
    console.log("Hospital Core JS - Sistema de Validaciones Activo");

    // 1. Capturar todos los formularios del proyecto de manera dinámica
    const formularios = document.querySelectorAll('form');

    formularios.forEach(form => {
        form.addEventListener('submit', (e) => {
            let inputsObligatorios = form.querySelectorAll('input[required], select[required]');
            let formularioValido = true;

            // Limpiar alertas previas dentro del contenedor del formulario
            const alertaPrevia = form.querySelector('.alert-error');
            if (alertaPrevia) alertaPrevia.remove();

            // 2. Validar campos vacíos o con puros espacios en blanco
            inputsObligatorios.forEach(input => {
                if (input.value.trim() === '') {
                    formularioValido = false;
                    input.classList.add('input-error'); // Opcional por si deseas estilizar el borde en rojo
                } else {
                    input.classList.remove('input-error');
                }
            });

            // 3. Detener el envío si la validación falla
            if (!formularioValido) {
                e.preventDefault();
                
                // Crear dinámicamente un contenedor de alerta consistente con tu CSS
                const alerta = document.createElement('div');
                alerta.className = 'alert-error';
                alerta.innerText = 'Error: Por favor, no envíe campos vacíos o con puros espacios.';
                
                // Insertar al principio del formulario
                form.insertBefore(alerta, form.firstChild);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });
});