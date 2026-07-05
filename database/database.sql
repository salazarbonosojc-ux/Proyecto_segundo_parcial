CREATE DATABASE IF NOT EXISTS sistema_hospitalario;
USE sistema_hospitalario;

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
    fecha_diagnostico TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_historial) REFERENCES historiales_clinicos(id),
    FOREIGN KEY (id_medico) REFERENCES medicos(id)
);

-- INTEGRANTE 5: Habitaciones e Ingresos
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
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_habitacion) REFERENCES habitaciones(id)
);

-- Inserciones iniciales para pruebas
INSERT INTO roles (nombre) VALUES ('Administrador'), ('Médico'), ('Recepcionista');
-- Contraseña y usuario por defecto: admin: admin123 (encriptada con password_hash)
INSERT INTO usuarios (nombre_usuario, password, id_rol) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);