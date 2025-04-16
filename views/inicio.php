<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/plantillas/header.php';
require_once __DIR__ . '/../config/sql/database.php';

// Incluir CSS específico para la página de inicio
echo '<link rel="stylesheet" href="' . BASE_URL . '/assets/css/inicio.css">';
?>

<div class="inicio-container">
    <!-- Sección de Bienvenida -->
    <section class="inicio-bienvenida">
        <div class="inicio-bienvenida-contenido">
            <h1 class="inicio-bienvenida-titulo">Bienvenido a ZooApp</h1>
            <p class="inicio-bienvenida-subtitulo">Descubre la magia de la naturaleza en nuestro zoológico</p>
            <a href="#descubrir" class="inicio-boton inicio-boton-primario">Explorar</a>
        </div>
    </section>

    <!-- Sección Descubrir -->
    <section id="descubrir" class="inicio-descubrir">
        <div class="container">
            <h2 class="inicio-seccion-titulo">Descubre Nuestro Zoológico</h2>
            <div class="inicio-separador"></div>
            <div class="inicio-categorias">
                <div class="inicio-categoria">
                    <img src="<?php echo BASE_URL; ?>/assets/images/animales.jpg" alt="Animales"
                        class="inicio-categoria-imagen">
                    <div class="inicio-categoria-contenido">
                        <h3 class="inicio-categoria-titulo">Animales</h3>
                        <p class="inicio-categoria-texto">Conoce nuestra increíble colección de animales de todo el
                            mundo.</p>
                        <a href="<?php echo BASE_URL; ?>/views/animales"
                            class="inicio-boton inicio-boton-secundario">Ver Animales</a>
                    </div>
                </div>
                <div class="inicio-categoria">
                    <img src="<?php echo BASE_URL; ?>/assets/images/ruta-default.webp" alt="Itinerarios"
                        class="inicio-categoria-imagen">
                    <div class="inicio-categoria-contenido">
                        <h3 class="inicio-categoria-titulo">Itinerarios</h3>
                        <p class="inicio-categoria-texto">Planifica tu visita con nuestras rutas recomendadas.</p>
                        <a href="<?php echo BASE_URL; ?>/views/itinerarios"
                            class="inicio-boton inicio-boton-secundario">Ver Itinerarios</a>
                    </div>
                </div>
                <div class="inicio-categoria">
                    <img src="<?php echo BASE_URL; ?>/assets/images/experiencias.jpeg" alt="Experiencias"
                        class="inicio-categoria-imagen">
                    <div class="inicio-categoria-contenido">
                        <h3 class="inicio-categoria-titulo">Experiencias</h3>
                        <p class="inicio-categoria-texto">Vive experiencias únicas con nuestros animales.</p>
                        <a href="<?php echo BASE_URL; ?>/views/conocer-mas"
                            class="inicio-boton inicio-boton-secundario">Conocer Más</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Animales Destacados -->
    <section class="inicio-destacados">
        <div class="container">
            <h2 class="inicio-seccion-titulo">Animales Destacados</h2>
            <div class="inicio-separador"></div>
            <div class="inicio-animales">
                <?php
                $query = "SELECT * FROM animales LIMIT 6";
                $stmt = $conn->query($query);
                $animales = $stmt->fetchAll();

                if (count($animales) > 0) {
                    foreach ($animales as $animal) {
                        // Extraer solo el nombre del archivo de la ruta completa
                        $imagen_url = htmlspecialchars($animal['imagen_url']);
                        $nombre_archivo = basename($imagen_url);
                        ?>
                        <div class="inicio-animal">
                            <img src="<?php echo BASE_URL; ?>/assets/images/<?php echo $nombre_archivo; ?>"
                                alt="<?php echo htmlspecialchars($animal['nombre_animal']); ?>" class="inicio-animal-imagen">
                            <div class="inicio-animal-contenido">
                                <h3 class="inicio-animal-titulo"><?php echo htmlspecialchars($animal['nombre_animal']); ?></h3>
                                <p class="inicio-animal-especie"><?php echo htmlspecialchars($animal['categoria']); ?></p>
                                <p class="inicio-animal-descripcion"><?php echo htmlspecialchars($animal['descripcion']); ?></p>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Sección Experiencias -->
    <section class="inicio-experiencias">
        <div class="container">
            <h2 class="inicio-seccion-titulo">Experiencias Únicas</h2>
            <div class="inicio-separador"></div>
            <div class="inicio-experiencias-grid">
                <div class="inicio-experiencia">
                    <img src="<?php echo BASE_URL; ?>/assets/images/experiencia1.jpeg" alt="Experiencia 1"
                        class="inicio-experiencia-imagen">
                    <div class="inicio-experiencia-contenido">
                        <h3 class="inicio-experiencia-titulo">Encuentro con Osos</h3>
                        <p class="inicio-experiencia-descripcion">Vive la emoción de estar cerca de los majestuosos
                            leones.</p>
                    </div>
                </div>
                <div class="inicio-experiencia">
                    <img src="<?php echo BASE_URL; ?>/assets/images/experiencia2.jpeg" alt="Experiencia 2"
                        class="inicio-experiencia-imagen">
                    <div class="inicio-experiencia-contenido">
                        <h3 class="inicio-experiencia-titulo">Alimentación de Jirafas</h3>
                        <p class="inicio-experiencia-descripcion">Alimenta a nuestras amigables jirafas desde una
                            plataforma especial.</p>
                    </div>
                </div>
                <div class="inicio-experiencia">
                    <img src="<?php echo BASE_URL; ?>/assets/images/experiencia3.jpeg" alt="Experiencia 3"
                        class="inicio-experiencia-imagen">
                    <div class="inicio-experiencia-contenido">
                        <h3 class="inicio-experiencia-titulo">Show de Delfines</h3>
                        <p class="inicio-experiencia-descripcion">Disfruta de nuestro espectacular show de delfines.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Testimonios -->
    <section class="inicio-testimonios">
        <div class="container">
            <h2 class="inicio-seccion-titulo">Lo que dicen nuestros visitantes</h2>
            <div class="inicio-separador"></div>
            <div class="inicio-testimonios-grid">
                <div class="inicio-testimonio">
                    <p class="inicio-testimonio-texto">"Una experiencia increíble. Los animales están muy bien cuidados
                        y el personal es muy amable."</p>
                    <p class="inicio-testimonio-autor">- María García</p>
                </div>
                <div class="inicio-testimonio">
                    <p class="inicio-testimonio-texto">"El mejor zoológico que he visitado. Las instalaciones son
                        impresionantes y los shows son espectaculares."</p>
                    <p class="inicio-testimonio-autor">- Juan Pérez</p>
                </div>
                <div class="inicio-testimonio">
                    <p class="inicio-testimonio-texto">"Perfecto para pasar un día en familia. Los niños disfrutaron
                        mucho y aprendieron sobre los animales."</p>
                    <p class="inicio-testimonio-autor">- Ana Martínez</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección CTA -->
    <section class="inicio-cta">
        <div class="inicio-cta-contenido">
            <h2 class="inicio-cta-titulo">¿Listo para tu próxima aventura?</h2>
            <p class="inicio-cta-texto">Reserva tu visita ahora y vive una experiencia inolvidable en nuestro zoológico.
            </p>
            <a href="<?php echo BASE_URL; ?>/views/reservas" class="inicio-boton inicio-boton-primario">Reservar
                Ahora</a>
        </div>
    </section>
</div>

<!-- Incluir JavaScript específico para la página de inicio -->
<script src="<?php echo BASE_URL; ?>/assets/js/inicio.js"></script>
<?php require_once __DIR__ . '/plantillas/footer.php'; ?>