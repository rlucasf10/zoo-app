<?php
require_once __DIR__ . '/../config/config.php';
session_start();
require_once __DIR__ . '/plantillas/header.php';
?>

<!-- Agregar el nuevo CSS -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/conocer-mas.css">

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
                    <img src="<?php echo BASE_URL; ?>/assets/images/historia-zoo.jpg" alt="Historia del Zoo">
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

    <!-- Sección de Experiencia Inmersiva 3D -->
    <section class="inmersiva-section">
        <div class="container">
            <h2>Experiencia Inmersiva 3D</h2>
            <div class="inmersiva-content">
                <div class="inmersiva-texto">
                    <p>En Zoo App, hemos revolucionado la forma de interactuar con la vida salvaje a través de nuestra
                        exclusiva experiencia inmersiva 3D. Con tecnología de última generación y gafas de realidad
                        virtual, nuestros visitantes pueden sumergirse en entornos naturales de todo el mundo sin salir
                        del zoo.</p>
                    <p>Esta innovadora experiencia te permite caminar junto a elefantes africanos, nadar con delfines en
                        el océano o sobrevolar la selva amazónica, todo mientras aprendes sobre estos increíbles
                        ecosistemas y sus habitantes.</p>
                    <p>Nuestros guías expertos te acompañarán en este viaje virtual, proporcionando información
                        detallada sobre cada especie y su hábitat natural. Una experiencia educativa y emocionante que
                        no te puedes perder.</p>
                    <div class="inmersiva-caracteristicas">
                        <div class="caracteristica">
                            <i class="fas fa-vr-cardboard"></i>
                            <span>Gafas VR de alta resolución</span>
                        </div>
                        <div class="caracteristica">
                            <i class="fas fa-volume-up"></i>
                            <span>Audio envolvente 360°</span>
                        </div>
                        <div class="caracteristica">
                            <i class="fas fa-clock"></i>
                            <span>Sesiones de 30 minutos</span>
                        </div>
                    </div>
                </div>
                <div class="inmersiva-imagen">
                    <img src="<?php echo BASE_URL; ?>/assets/images/experiencias.jpeg" alt="Experiencia Inmersiva 3D">
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
                <a href="<?php echo BASE_URL; ?>/views/reservas" class="btn btn-secondary">Comprar Entradas</a>
                <a href="<?php echo BASE_URL; ?>/views/footer/contacto" class="btn btn-secondary">Contactar</a>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/plantillas/footer.php'; ?>