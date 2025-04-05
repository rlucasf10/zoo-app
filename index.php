<?php
session_start();
require_once __DIR__ . '/views/plantillas/header.php';
?>

<main>
    <!-- Sección de Bienvenida -->
    <section id="hero" class="hero">
        <div class="hero-content">
            <h1>Bienvenidos a Zoo App</h1>
            <p>Un mundo lleno de maravillas naturales y animales fascinantes te espera. ¡Descúbrelo con nosotros!</p>
            <a href="<?php echo $base_url; ?>/views/conocer-mas.php" class="btn btn-conocer-mas">Conocer más</a>
        </div>
    </section>

    <!-- Sección Sobre Nosotros -->
    <section id="about" class="about">
        <h2>Sobre Nosotros</h2>
        <p>En Zoo App, ofrecemos una experiencia única para descubrir la vida salvaje. Con entornos naturales,
            actividades educativas y programas de conservación, es un lugar ideal para disfrutar con toda la familia.
        </p>
    </section>

    <!-- Sección de Galería de Animales -->
    <section id="animals" class="animals">
        <h2>Nuestros Animales</h2>
        <div class="gallery" id="animal-gallery">
            <div class="animal-item">
                <img src="<?php echo $base_url; ?>/assets/images/bengala.jpeg" alt="Tigre de Bengala">
                <p class="animal-name">Tigre de Bengala</p>
            </div>
            <div class="animal-item">
                <img src="<?php echo $base_url; ?>/assets/images/bufalo.jpeg" alt="Búfalo">
                <p class="animal-name">Búfalo</p>
            </div>
            <div class="animal-item">
                <img src="<?php echo $base_url; ?>/assets/images/cebra.jpeg" alt="Cebra">
                <p class="animal-name">Cebra</p>
            </div>
            <div class="animal-item">
                <img src="<?php echo $base_url; ?>/assets/images/elefante.jpeg" alt="Elefante">
                <p class="animal-name">Elefante</p>
            </div>
        </div>
        <div class="ver-animales">
            <a href="<?php echo $base_url; ?>/views/animales.php" class="btn">Ver más animales</a>
        </div>
    </section>

    <!-- Sección de Planificación de Visita -->
    <section id="visit" class="visit">
        <h2>Planifica tu Visita</h2>
        <p>Consulta nuestros horarios de apertura y compra tus entradas online para una experiencia sin igual.</p>
        <a href="<?php echo $base_url; ?>/views/entradas.php" class="btn">Comprar Entradas</a>
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