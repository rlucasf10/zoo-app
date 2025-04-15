<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../plantillas/header.php';
?>

<style>
    section#terminos-servicio {
        margin: 0 auto;
        padding: 2rem 0;
    }

    .terminos-servicio h2 {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 700;
    }

    .terminos-servicio .fecha-actualizacion {
        text-align: center;
        color: #7f8c8d;
        margin-bottom: 2rem;
        font-style: italic;
    }

    .terminos-servicio h3 {
        color: #3498db;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
        border-bottom: 2px solid #ecf0f1;
        padding-bottom: 0.5rem;
    }

    .terminos-servicio p {
        line-height: 1.6;
        margin-bottom: 1.2rem;
        color: #34495e;
    }

    .terminos-servicio ul {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }

    .terminos-servicio li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
        color: #34495e;
    }

    .terminos-servicio a {
        color: #3498db;
        text-decoration: none;
        transition: color 0.3s;
    }

    .terminos-servicio a:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    .terminos-servicio .container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }

    @media (max-width: 768px) {
        .terminos-servicio .container {
            padding: 1.5rem;
        }
    }
</style>

<main>
    <section id="terminos-servicio" class="terminos-servicio">
        <div class="container">
            <h2>Términos de Servicio</h2>
            <p class="fecha-actualizacion">Última actualización: <?php echo date('d/m/Y H:i:s'); ?></p>

            <h3>1. Aceptación de los Términos</h3>
            <p>Al acceder y utilizar este sitio web, aceptas cumplir y estar sujeto a estos términos de servicio. Si no
                estás de acuerdo con alguna parte de estos términos, no podrás acceder al servicio.</p>

            <h3>2. Uso del Servicio</h3>
            <p>El servicio está destinado a usuarios que deseen obtener información sobre el zoológico, realizar
                reservas y acceder a otros servicios relacionados. Te comprometes a utilizar el servicio solo para fines
                legales y de acuerdo con estos términos.</p>
            <ul>
                <li>No utilizar el servicio de manera que pueda dañar, deshabilitar, sobrecargar o perjudicar el
                    servicio.</li>
                <li>No interferir con la seguridad del servicio o con cualquier servicio relacionado con el servicio.
                </li>
                <li>No intentar acceder a cualquier parte del servicio a través de medios no autorizados.</li>
            </ul>

            <h3>3. Registro y Cuenta</h3>
            <p>Para acceder a ciertas funciones del servicio, deberás registrarte y crear una cuenta. Eres responsable
                de mantener la confidencialidad de tu cuenta y contraseña. Aceptas asumir toda la responsabilidad por
                todas las actividades que ocurran bajo tu cuenta o contraseña.</p>

            <h3>4. Privacidad</h3>
            <p>Tu privacidad es importante para nosotros. Consulta nuestra <a
                    href="<?php echo BASE_URL; ?>/views/footer/politica_privacidad.php">Política de Privacidad</a> para
                obtener
                detalles sobre cómo manejamos tu información personal y protegemos tu privacidad.</p>

            <h3>5. Limitación de Responsabilidad</h3>
            <p>No seremos responsables por ningún daño directo, indirecto, incidental, especial o consecuente que
                resulte del uso o la imposibilidad de usar el servicio. Esto incluye, pero no se limita a, pérdida de
                datos, pérdida de beneficios, pérdida de reputación o interrupción del negocio.</p>

            <h3>6. Modificaciones de los Términos</h3>
            <p>Nos reservamos el derecho de modificar o reemplazar estos términos en cualquier momento. Si una revisión
                es importante, proporcionaremos un aviso con al menos 30 días de anticipación antes de que los nuevos
                términos entren en vigor.</p>

            <h3>7. Contacto</h3>
            <p>Si tienes alguna pregunta sobre estos términos, por favor contáctanos a través de nuestro <a
                    href="/zoo-app/views/footer/contacto.php">formulario de contacto</a>.</p>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../plantillas/footer.php'; ?>