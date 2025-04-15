SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET collation_connection = 'utf8mb4_unicode_ci';

create database zoo_app;

-- Usar la base de datos existente
USE zoo_app;
-- Tabla de usuarios (debe crearse primero)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    nombre_usuario VARCHAR(50) NOT NULL,
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
    edad INT,
    especie_id INT NOT NULL,
    itinerario_id INT,
    habitat VARCHAR(100) NOT NULL,
    peso VARCHAR(50) NOT NULL,
    categoria ENUM(
        'mamiferos',
        'aves',
        'reptiles',
        'anfibios',
        'peces'
    ) NOT NULL,
    imagen_url VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_nacimiento DATE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (especie_id) REFERENCES especies(id) ON DELETE CASCADE,
    FOREIGN KEY (itinerario_id) REFERENCES itinerarios(id) ON DELETE
    SET NULL
);
-- Tabla de reservas
CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    itinerario_id INT,
    animal_id INT,
    fecha_visita DATE NOT NULL,
    cantidad_personas INT NOT NULL,
    tipo_entrada ENUM('general', 'familiar', 'vip') NOT NULL,
    precio_total DECIMAL(10, 2) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (itinerario_id) REFERENCES itinerarios(id),
    FOREIGN KEY (animal_id) REFERENCES animales(id)
);