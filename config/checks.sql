-- USAR BASE DE DATOS
use zoo_app;

-- ITINERARIOS
SELECT * FROM itinerarios;
DELETE FROM itinerarios WHERE id > 0;
ALTER TABLE itinerarios AUTO_INCREMENT = 1;

-- USUARIOS
select * from usuarios;
SELECT id, email, contraseña FROM usuarios WHERE email = 'admin@example.com';
DELETE FROM usuarios WHERE id > 0;
ALTER TABLE usuarios AUTO_INCREMENT = 1;

-- USUARIO ADMIN
INSERT INTO usuarios (nombre, email, password, es_admin)
VALUES ('Admin', 'admin@gmail.com', '$2b$12$lmPK8ptLmtZvORcXNPNd9uI/T5zusmIU2JI828S5yltvjD94.Tjgu', 1);

-- ESPECIES
select * from especies;
DELETE FROM especies WHERE id > 0;
ALTER TABLE especies AUTO_INCREMENT = 1;

-- ANIMALES
SELECT * FROM animales;
DELETE FROM animales WHERE id > 0;
ALTER TABLE animales AUTO_INCREMENT = 1;

-- RESERVAS
SELECT * FROM reservas;
DELETE FROM reservas WHERE id > 0;
ALTER TABLE reservas AUTO_INCREMENT = 1;
