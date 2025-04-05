<?php
session_start();
require_once __DIR__ . '/plantillas/header.php';
?>

<!-- Agregar el nuevo CSS -->
<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/conocer-mas.css">

<main class="conocer-mas-container">
    <!-- Sección Hero -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Descubre Nuestro Mundo Salvaje</h1>
            <p>Una experiencia única donde la naturaleza y la conservación se unen</p>
        </div>
    </section>

    <!-- Sección de Historia -->
    <section class="historia-section">
        <div class="container">
            <h2>Nuestra Historia</h2>
            <div class="historia-content">
                <div class="historia-texto">
                    <p>Desde 1990, Zoo App ha sido un centro de conservación y educación dedicado a proteger la vida
                        silvestre y educar a las generaciones futuras. Nuestro compromiso con la conservación de
                        especies en peligro de extinción nos ha convertido en un referente mundial.</p>
                    <p>Con más de 30 años de experiencia, hemos logrado importantes avances en programas de reproducción
                        y reintroducción de especies amenazadas. Nuestro parque, ubicado en un entorno natural
                        privilegiado
                        de más de 50 hectáreas, alberga una diversidad única de flora y fauna.</p>
                    <p>Hemos sido pioneros en la implementación de programas de conservación para especies emblemáticas
                        como el tigre de Bengala, el elefante asiático y el gorila de montaña. Nuestro centro de
                        investigación ha contribuido significativamente al conocimiento científico sobre el
                        comportamiento
                        y la ecología de estas especies.</p>
                </div>
                <div class="historia-imagen">
                    <img src="<?php echo $base_url; ?>/assets/images/historia-zoo.jpg" alt="Historia del Zoo">
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Instalaciones -->
    <section class="instalaciones-section">
        <div class="container">
            <h2>Nuestras Instalaciones</h2>
            <div class="instalaciones-grid">
                <div class="instalacion-card">
                    <i class="fas fa-tree"></i>
                    <h3>Habitats Naturales</h3>
                    <p>Espacios diseñados para replicar los ecosistemas naturales de cada especie.</p>
                </div>
                <div class="instalacion-card">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Centro Educativo</h3>
                    <p>Programas educativos para todas las edades sobre conservación y biodiversidad.</p>
                </div>
                <div class="instalacion-card">
                    <i class="fas fa-flask"></i>
                    <h3>Centro de Investigación</h3>
                    <p>Investigación avanzada en comportamiento animal y conservación.</p>
                </div>
                <div class="instalacion-card">
                    <i class="fas fa-hospital"></i>
                    <h3>Centro Veterinario</h3>
                    <p>Cuidados especializados para todos nuestros animales.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Estadísticas -->
    <section class="estadisticas-section">
        <div class="container">
            <h2>Nuestro Impacto</h2>
            <div class="estadisticas-grid">
                <div class="estadistica-item">
                    <span class="numero">500+</span>
                    <p>Especies</p>
                </div>
                <div class="estadistica-item">
                    <span class="numero">1000+</span>
                    <p>Animales</p>
                </div>
                <div class="estadistica-item">
                    <span class="numero">50+</span>
                    <p>Programas de Conservación</p>
                </div>
                <div class="estadistica-item">
                    <span class="numero">1M+</span>
                    <p>Visitantes Anuales</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Compromiso -->
    <section class="compromiso-section">
        <div class="container">
            <h2>Nuestro Compromiso</h2>
            <div class="compromiso-content">
                <div class="compromiso-item">
                    <h3>Conservación</h3>
                    <p>Participamos activamente en programas de conservación globales y locales.</p>
                </div>
                <div class="compromiso-item">
                    <h3>Educación</h3>
                    <p>Programas educativos para crear conciencia sobre la importancia de la biodiversidad.</p>
                </div>
                <div class="compromiso-item">
                    <h3>Investigación</h3>
                    <p>Colaboramos con instituciones científicas en proyectos de investigación.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de CTA -->
    <section class="cta-section">
        <div class="container">
            <h2>¿Listo para la Aventura?</h2>
            <p>Únete a nosotros en esta increíble experiencia y ayuda a proteger nuestro planeta.</p>
            <div class="cta-buttons">
                <a href="<?php echo $base_url; ?>/views/reservas.php" class="btn btn-primary">Comprar Entradas</a>
                <a href="<?php echo $base_url; ?>/views/footer/contacto.php" class="btn btn-secondary">Contactar</a>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/plantillas/footer.php'; ?>