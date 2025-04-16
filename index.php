<?php
require_once __DIR__ . '/config/config.php';
session_start();
require_once __DIR__ . '/views/plantillas/header.php';
?>

<main>
    <!-- Sección de Bienvenida -->
    <section id="hero" class="hero">
        <div class="hero-content">
            <h1>Bienvenidos a Zoo App</h1>
            <p>Un mundo lleno de maravillas naturales y animales fascinantes te espera. ¡Descúbrelo con nosotros!</p>
            <a href="<?php echo BASE_URL; ?>/views/conocer-mas" class="btn btn-conocer-mas">Conocer más</a>
        </div>
    </section>

    <!-- Sección Sobre Nosotros -->
    <section id="about" class="about">
        <h2>Sobre Nosotros</h2>
        <p>En Zoo App, ofrecemos una experiencia única para descubrir la vida salvaje. Con entornos naturales
            cuidadosamente diseñados,
            actividades educativas interactivas y programas de conservación de vanguardia, creamos un espacio mágico
            donde la naturaleza
            cobra vida. Nuestro compromiso con el bienestar animal y la educación ambiental nos convierte en el destino
            perfecto para
            familias, amantes de la naturaleza y curiosos de todas las edades. ¡Únete a nosotros en esta increíble
            aventura y descubre
            el fascinante mundo animal!
        </p>
        <p>Además, te invitamos a vivir una experiencia inmersiva única con nuestras gafas de realidad virtual 3D.
            Sumérgete en un
            viaje virtual por los hábitats más remotos del planeta, observa de cerca a especies en peligro de extinción
            y aprende sobre
            sus comportamientos en su entorno natural. Nuestra tecnología de vanguardia te permitirá sentir que estás
            realmente allí,
            con audio envolvente 360° y gráficos de alta resolución que te transportarán a lugares que pocos tienen la
            oportunidad de
            visitar.
        </p>
    </section>

    <!-- Sección de Galería de Animales -->
    <section id="animals" class="animals">
        <h2>Nuestros Animales</h2>
        <div class="gallery" id="animal-gallery">
            <div class="animal-item">
                <img src="<?php echo BASE_URL; ?>/assets/images/tigre-bengala.jpeg" alt="Tigre de Bengala">
                <p class="animal-name">Tigre de Bengala</p>
            </div>
            <div class="animal-item">
                <img src="<?php echo BASE_URL; ?>/assets/images/bufalo-africano.jpeg" alt="Búfalo">
                <p class="animal-name">Búfalo Africano</p>
            </div>
            <div class="animal-item">
                <img src="<?php echo BASE_URL; ?>/assets/images/cebra-planicie.jpeg" alt="Cebra">
                <p class="animal-name">Cebra de Planicie</p>
            </div>
            <div class="animal-item">
                <img src="<?php echo BASE_URL; ?>/assets/images/elefante-africano.jpeg" alt="Elefante">
                <p class="animal-name">Elefante Africano</p>
            </div>
        </div>
        <div class="ver-animales">
            <a href="<?php echo BASE_URL; ?>/views/animales" class="btn">Ver más animales</a>
        </div>
    </section>

    <!-- Sección de Planificación de Visita -->
    <section id="visit" class="visit">
        <h2>Planifica tu Visita</h2>
        <p>Consulta nuestros horarios de apertura y compra tus entradas online para una experiencia sin igual.</p>
        <a href="<?php echo BASE_URL; ?>/views/reservas" class="btn">Comprar Entradas</a>
    </section>

    <!-- Testimonios -->
    <section id="testimonials" class="testimonials">
        <h2>Lo que Dicen Nuestros Visitantes</h2>
        <div class="testimonial-item">
            <p>"Una experiencia increíble. Aprendí mucho sobre los animales y me divertí en familia."</p>
            <p>- Juan Pérez</p>
        </div>
        <div class="testimonial-item">
            <p>"El zoológico está perfectamente cuidado y el personal es muy amable. ¡Lo recomiendo!"</p>
            <p>- María González</p>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/views/plantillas/footer.php'; ?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/index.css">
<script src="<?php echo BASE_URL; ?>/assets/js/index.js"></script>