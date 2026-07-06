CREATE DATABASE IF NOT EXISTS sistema_hospitalario;
USE sistema_hospitalario;

/* ==========================================================================
   1. ESTRUCTURA DE TABLAS (ORGANIZADA POR INTEGRANTES)
   ========================================================================== */

-- INTEGRANTE 1: Roles y Usuarios (Login)
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_rol INT,
    FOREIGN KEY (id_rol) REFERENCES roles(id)
);

-- INTEGRANTE 2: Especialidades y Médicos
CREATE TABLE especialidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    licencia_medica VARCHAR(50) NOT NULL UNIQUE,
    id_especialidad INT,
    FOREIGN KEY (id_especialidad) REFERENCES especialidades(id)
);

-- INTEGRANTE 3: Pacientes y Citas Médicas
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(10) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    telefono VARCHAR(15)
);

CREATE TABLE citas_medicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    id_medico INT,
    fecha_hora DATETIME NOT NULL,
    motivo TEXT,
    estado ENUM('Pendiente', 'Completada', 'Cancelada') DEFAULT 'Pendiente',
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_medico) REFERENCES medicos(id)
);

-- INTEGRANTE 4: Historiales y Diagnósticos
CREATE TABLE historiales_clinicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT UNIQUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id)
);

CREATE TABLE diagnosticos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_historial INT,
    id_medico INT,
    descripcion TEXT NOT NULL,
    tratamiento TEXT NOT NULL,
    fecha_diagnostico DATE NOT NULL,
    FOREIGN KEY (id_historial) REFERENCES historiales_clinicos(id),
    FOREIGN KEY (id_medico) REFERENCES medicos(id)
);

-- INTEGRANTE 5: Habitaciones e Ingresos (Sincronización Automatizada)
CREATE TABLE habitaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_habitacion VARCHAR(10) NOT NULL UNIQUE,
    tipo ENUM('General', 'UCI', 'Pediatría', 'Maternidad') NOT NULL,
    estado ENUM('Disponible', 'Ocupada', 'Mantenimiento') DEFAULT 'Disponible'
);

CREATE TABLE ingresos_hospitalarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT,
    id_habitacion INT,
    fecha_ingreso DATETIME NOT NULL,
    fecha_alta DATETIME NULL,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE,
    FOREIGN KEY (id_habitacion) REFERENCES habitaciones(id) ON DELETE CASCADE
);

/* ==========================================================================
   2. INSERCIÓN MASIVA DE DATA REAL DE PRUEBA (100% COMPATIBLE)
   ========================================================================== */

-- POBLAR TABLA: roles
INSERT INTO roles (id, nombre) VALUES 
(1, 'Administrador'), 
(2, 'Médico'), 
(3, 'Recepcionista');

-- POBLAR TABLA: usuarios (Credenciales por defecto: admin / admin123)
INSERT INTO usuarios (id, nombre_usuario, password, id_rol) VALUES 
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
(2, 'salazar_yeancarlos', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),
(3, 'icaza_diana', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- POBLAR TABLA: especialidades
INSERT INTO especialidades (id, nombre, descripcion) VALUES
(1, 'Cardiología', 'Evaluación y tratamiento de enfermedades del sistema cardiovascular.'),
(2, 'Medicina General', 'Atención médica primaria y chequeos preventivos integrales.'),
(3, 'Traumatología', 'Tratamiento de lesiones óseas, fracturas y sistema muscular.'),
(4, 'Pediatría', 'Atención médica especializada para bebés, niños y adolescentes.'),
(5, 'Ginecología', 'Cuidado de la salud del sistema reproductor femenino y obstetricia.');

-- POBLAR TABLA: medicos
INSERT INTO medicos (id, id_especialidad, nombre, apellido, licencia_medica) VALUES
(1, 1, 'Carlos', 'Andrade', 'MED-1001'),
(2, 2, 'María', 'Cevallos', 'MED-1002'),
(3, 3, 'Jorge', 'Mendoza', 'MED-1003'),
(4, 4, 'Ana Lucía', 'Guerrero', 'MED-1004'),
(5, 5, 'Luis', 'Palacios', 'MED-1005');

-- POBLAR TABLA: pacientes
INSERT INTO pacientes (id, cedula, nombre, apellido, fecha_nacimiento, telefono) VALUES
(1, '0951423678', 'Elena Beatriz', 'Suárez Villamar', '2001-07-09', '0953334445'),
(2, '0915647382', 'Christian Omar', 'Brito Saltos', '1892-12-14', '0961112223'),
(3, '2401239874', 'Gabriela Lisbeth', 'Plaza Benítez', '2018-03-02', '0985556667'),
(4, '0922883377', 'Roberto Javier', 'Gómez Cevallos', '1962-05-25', '0994441112'),
(5, '0961234567', 'Diana Carolina', 'Meza Torres', '1993-09-18', '0972223334'),
(6, '0911223344', 'Juan Carlos', 'Pérez Mora', '1985-04-12', '0987654321'),
(7, '0922334455', 'Ricardo Andrés', 'Castro Vélez', '1990-11-23', '0998887776'),
(8, '0933445566', 'Patricia Rossana', 'Luna Almeida', '1978-08-30', '0965554443'),
(9, '0944556677', 'Luis Alberto', 'Zambrano Cevallos', '2005-01-15', '0952221110'),
(10, '0955667788', 'Sofía Valentina', 'Barros Miranda', '2012-06-20', '0941112229');

-- POBLAR TABLA: citas_medicas
INSERT INTO citas_medicas (id, id_paciente, id_medico, fecha_hora, motivo, estado) VALUES
(1, 1, 1, '2026-07-06 08:00:00', 'Chequeo general preventivo y laboratorios.', 'Pendiente'),
(2, 2, 2, '2026-07-06 09:30:00', 'Evaluación por cuadro febril y tos seca.', 'Pendiente'),
(3, 3, 3, '2026-07-06 11:00:00', 'Valoración por dolor lumbar crónico.', 'Pendiente'),
(4, 4, 4, '2026-07-07 10:00:00', 'Control de crecimiento y desarrollo infantil.', 'Pendiente'),
(5, 5, 5, '2026-07-07 14:00:00', 'Monitoreo de glucosa y ajuste de dosis.', 'Pendiente'),
(6, 6, 5, '2026-07-08 08:30:00', 'Control ecográfico de rutina prenatal.', 'Pendiente'),
(7, 7, 3, '2026-07-08 11:30:00', 'Revisión post-operatoria de rodilla.', 'Pendiente'),
(8, 8, 4, '2026-07-09 15:00:00', 'Evaluación alérgica y respiratoria.', 'Pendiente'),
(9, 9, 2, '2026-07-09 16:15:00', 'Dolor agudo de garganta y placas visibles.', 'Pendiente'),
(10, 10, 1, '2026-07-10 09:00:00', 'Control de presión arterial y fatiga.', 'Pendiente');

-- POBLAR TABLA: historiales_clinicos
INSERT INTO historiales_clinicos (id, id_paciente, fecha_creacion) VALUES
(1, 1, '2026-07-05 08:00:00'),
(2, 2, '2026-07-05 08:30:00'),
(3, 3, '2026-07-05 09:00:00'),
(4, 4, '2026-07-05 09:30:00'),
(5, 5, '2026-07-05 10:00:00'),
(6, 6, '2026-07-05 10:30:00'),
(7, 7, '2026-07-05 11:00:00'),
(8, 8, '2026-07-05 11:30:00'),
(9, 9, '2026-07-05 12:00:00'),
(10, 10, '2026-07-05 12:30:00');

-- POBLAR TABLA: diagnosticos
INSERT INTO diagnosticos (id_historial, id_medico, descripcion, tratamiento, fecha_diagnostico) VALUES
(1, 1, 'Hiperlipidemia y sospecha de hipertensión leve.', 'Dieta baja en grasas y sodio. Cardio 30 min diarios.', '2026-07-05'),
(2, 2, 'Rinofaringitis aguda (resfriado común).', 'Paracetamol 500mg cada 8h e hidratación abundante.', '2026-07-05'),
(3, 3, 'Lumbago mecánico por sobreesfuerzo físico.', 'Complejo B y analgésicos. Reposo postural relativo.', '2026-07-05'),
(4, 4, 'Desnutrición leve en percentil de crecimiento.', 'Suplementación vitamínica y plan nutricional guiado.', '2026-07-05'),
(5, 5, 'Diabetes Mellitus Tipo 2 controlada.', 'Continuar Metformina 850mg diario en el almuerzo.', '2026-07-05'),
(6, 5, 'Control prenatal normal y estable.', 'Suplementación de hierro y ácido fólico.', '2026-07-05'),
(7, 3, 'Post-operatorio de reconstrucción ligamentosa.', 'Fisioterapia y control de dolor con Ibuprofeno.', '2026-07-05'),
(8, 4, 'Rinitis alérgica estacional.', 'Antihistamínicos según esquema por las noches.', '2026-07-05'),
(9, 2, 'Faringoamigdalitis eritematosa aguda.', 'Antibioticoterapia oral y antiinflamatorios.', '2026-07-05'),
(10, 1, 'Hipertensión bajo control farmacológico.', 'Seguimiento de presión arterial en consulta ambulatoria.', '2026-07-05');

-- POBLAR TABLA: habitaciones (Catálogo base reiniciado a Disponible)
INSERT INTO habitaciones (id, numero_habitacion, tipo, estado) VALUES 
(1, '101', 'General', 'Disponible'),
(2, '102', 'General', 'Disponible'),
(3, '201', 'UCI', 'Disponible'),
(4, '202', 'UCI', 'Disponible'),
(5, '301', 'Pediatría', 'Disponible'),
(6, '302', 'Pediatría', 'Disponible'),
(7, '401', 'Maternidad', 'Disponible'),
(8, '402', 'Maternidad', 'Disponible'),
(9, '501', 'General', 'Disponible'),
(10, '502', 'UCI', 'Disponible');

-- POBLAR TABLA: ingresos_hospitalarios (Limpia de asignaciones activas por reseteo)
-- Se poblará dinámicamente mediante la ejecución del sistema web.