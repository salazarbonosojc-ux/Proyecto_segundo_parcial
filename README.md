# Hospital Core - Sistema de Gestión Hospitalaria

Aplicación web dinámica desarrollada bajo la arquitectura **MVC (Modelo-Vista-Controlador)** utilizando **PHP nativo** y **MySQL** para la persistencia de datos. Proyecto desarrollado para la evaluación práctica del Segundo Parcial.

## 🎯 ¿Para qué sirve este proyecto? (Proceso que resuelve)
**Hospital Core** es una solución tecnológica diseñada para automatizar y centralizar los flujos administrativos y clínicos de un centro de salud. Resuelve la desorganización de datos médicos mediante la integración matricial de módulos, permitiendo:
- Controlar el flujo de admisiones mediante el registro exhaustivo de **Pacientes**.
- Gestionar el personal activo mediante el mapeo de **Médicos** y sus respectivas especialidades.
- Optimizar la agenda médica evitando cruces de horarios en las **Citas Médicas**.
- Mantener la integridad clínica a través del seguimiento cronológico de **Historiales y Diagnósticos**.
- Monitorear en tiempo real la disponibilidad y la asignación activa en el **Estado de Habitaciones**.

## 🚀 Características Técnicas y Reglas de Negocio
- **Arquitectura Limpia**: Separación lógica estricta mediante el patrón MVC.
- **Operaciones CRUD Completas**: Gestión funcional en todas las entidades maestros y relacionales.
- **Sincronización Automatizada Relacional (Tiempo Real)**: El módulo de habitaciones cuenta con lógica transaccional integrada. Al asignar un paciente a una cama, la habitación conmuta su estado a **Ocupada** y levanta un registro de asignación. Si el administrador edita una habitación física y conmuta manualmente su estado de vuelta a **Disponible**, el backend detecta este evento de alta y ejecuta una eliminación física (`DELETE`) del registro en la tabla matricial `ingresos_hospitalarios`, manteniendo las tablas coordinadas al instante y libres de inconsistencias.
- **Interfaz Profesional**: Tema visual oscuro con efectos neón celeste y simetría geométrica en botoneras operativas (*glassmorphism*), 100% libre de estilos embebidos (*inline*) y con persistencia de estado activa en la barra de navegación lateral utilizando variables globales del servidor.
- **Validaciones Avanzadas Bi-direccionales**: Protección contra campos vacíos o inconsistencias tanto en el cliente (JavaScript/HTML5) como en el servidor mediante sanitización estricta (`trim()` y `htmlspecialchars()`) contra ataques XSS.

## 🔐 Credenciales de Acceso (Para Pruebas)
Para evaluar el sistema de control de sesiones y roles configurado en el login, utilice los siguientes usuarios registrados en la base de datos (todos comparten la misma contraseña):

- **Contraseña global**: `admin123`
- **Usuarios disponibles**:
  - `admin` (Rol: Administrador)
  - `salazar_yeancarlos` (Rol: Administrador)
  - `icaza_diana` (Rol: Administrador)

## 🛠️ Requisitos de Instalación Locales
1. Descargar e instalar [XAMPP](https://www.apachefriends.org/) (Soporte para PHP 8.x y MySQL).
2. Abrir la terminal o consola de comandos y clonar este repositorio dentro de la ruta raíz de tu servidor local XAMPP:
   ```bash
   cd c:/xampp/htdocs/
   git clone [https://github.com/salazarbonosojc-u/Proyecto_segundo_parcial.git](https://github.com/salazarbonosojc-u/Proyecto_segundo_parcial.git)

* 3. Iniciar los módulos de Apache y MySQL desde el Panel de Control de XAMPP.
* 4. Entrar a tu gestor de base de datos desde el navegador web: http://localhost/*phpmyadmin.
* 5. Crear una nueva base de datos llamada exactamente: sistema_hospitalario.
* 6. Seleccionar la base de datos recién creada, ir a la pestaña Importar, seleccionar el archivo database.sql ubicado dentro de la carpeta app/database/ de este proyecto y hacer clic en Importar.
* 7. Abrir tu navegador web preferido y acceder a la dirección de ejecución del entorno:
http://localhost/Proyecto_segundo_parcial/public/index.php

## 📂 Estructura Orgánica del Software
- **/public:** Punto de acceso único de la aplicación (index.php), estilos CSS globales unificados (/css/style.css) y lógica interactiva de validación del cliente (/js/main.js).
- **/app/Controllers:** Clases controladoras encargadas de capturar las peticiones, procesar transacciones seguras de negocio y despachar el flujo en singular.
- **/app/Models:** Clases dedicadas a la lógica de negocio y mapeo de consultas SQL utilizando la API nativa PDO de PHP.
- **/app/Views:** Plantillas visuales fragmentadas por módulos funcionales e inyectadas dinámicamente dentro del Layout maestro compartido.
- **/app/config:** Configuraciones de red del servidor y conector estructural de la base de datos.
- **/app/database/database.sql:** Script maestro de respaldo para la creación y población masiva de datos de la clínica.

## 👥 Desarrolladores
* Salazar Bonoso Yeancarlos Isaac -> Usuario: salazar_yeancarlos
* Jama Villagran Joao Alexander   -> Usuario: jama_joao
* Sabando Varela Angello Michael  -> Usuario: sabando_angello
* Wanke Cedeño Carl Hermann       -> Usuario: wanke_carl
* Icaza Lino Diana Valentina      -> Usuario: icaza_diana