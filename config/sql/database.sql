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