-- Crear base de datos
CREATE DATABASE zoo_app;
USE zoo_app;

-- Tabla de usuarios (debe crearse primero)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    es_admin BOOLEAN DEFAULT FALSE,
    -- Indica si es un usuario administrador
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de itinerarios (después de usuarios)
CREATE TABLE itinerarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    duracion INT NOT NULL,
    -- En horas
    puntos_interes TEXT,
    -- JSON con los puntos de interés
    usuario_id INT,
    -- ID del usuario que creó el itinerario
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de especies
CREATE TABLE especies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_especie VARCHAR(100) NOT NULL,
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de animales
CREATE TABLE animales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_animal VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    especie_id INT,
    itinerario_id INT,
    -- Relación con itinerarios
    fecha_nacimiento DATE,
    descripcion TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (especie_id) REFERENCES especies(id) ON DELETE CASCADE,
    -- Relación con la especie
    FOREIGN KEY (itinerario_id) REFERENCES itinerarios(id) ON DELETE SET NULL
    -- Relación con itinerarios
);

-- Tabla de reservas
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    itinerario_id INT,
    animal_id INT,
    -- Relación con los animales (pueden elegir un animal para la reserva)
    fecha_reserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_visita DATE NOT NULL,
    cantidad_personas INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    -- Relación con usuarios
    FOREIGN KEY (itinerario_id) REFERENCES itinerarios(id) ON DELETE CASCADE,
    -- Relación con itinerarios
    FOREIGN KEY (animal_id) REFERENCES animales(id) ON DELETE SET NULL
    -- Relación con animales
);