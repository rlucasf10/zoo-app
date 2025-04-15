<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../plantillas/header.php'; ?>

<style>
    section#politica-privacidad {
        margin: 0 auto;
        padding: 2rem 0;
    }

    .politica-privacidad h2 {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 700;
    }

    .politica-privacidad .fecha-actualizacion {
        text-align: center;
        color: #7f8c8d;
        margin-bottom: 2rem;
        font-style: italic;
    }

    .politica-privacidad h3 {
        color: #3498db;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
        border-bottom: 2px solid #ecf0f1;
        padding-bottom: 0.5rem;
    }

    .politica-privacidad p {
        line-height: 1.6;
        margin-bottom: 1.2rem;
        color: #34495e;
    }

    .politica-privacidad ul {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }

    .politica-privacidad li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
        color: #34495e;
    }

    .politica-privacidad a {
        color: #3498db;
        text-decoration: none;
        transition: color 0.3s;
    }

    .politica-privacidad a:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    .politica-privacidad .container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }

    .politica-privacidad .info-box {
        background-color: #f8f9fa;
        border-left: 4px solid #3498db;
        padding: 1rem;
        margin: 1.5rem 0;
        border-radius: 0 4px 4px 0;
    }

    @media (max-width: 768px) {
        .politica-privacidad .container {
            padding: 1.5rem;
        }
    }
</style>

<main>
    <section id="politica-privacidad" class="politica-privacidad">
        <div class="container">
            <h2>Política de Privacidad</h2>
            <p class="fecha-actualizacion">Última actualización: <?php echo date('d/m/Y'); ?></p>

            <h3>1. Información que recopilamos</h3>
            <p>Recopilamos información que nos proporcionas directamente, como tu nombre, dirección de correo
                electrónico y otra información de contacto cuando te registras en nuestro sitio o te comunicas con
                nosotros.</p>

            <div class="info-box">
                <p><strong>Tipos de información que recopilamos:</strong></p>
                <ul>
                    <li>Información de identificación personal (nombre, correo electrónico, dirección)</li>
                    <li>Información de pago (cuando realizas compras)</li>
                    <li>Información de uso (cómo interactúas con nuestro sitio)</li>
                    <li>Información del dispositivo (tipo de navegador, sistema operativo)</li>
                </ul>
            </div>

            <h3>2. Cómo usamos tu información</h3>
            <p>Utilizamos la información que recopilamos para:</p>
            <ul>
                <li>Proporcionar y mantener nuestro servicio</li>
                <li>Notificarte sobre cambios en nuestro servicio</li>
                <li>Permitirte participar en funciones interactivas de nuestro servicio</li>
                <li>Proporcionar atención al cliente y soporte</li>
                <li>Mejorar y personalizar tu experiencia</li>
                <li>Enviar boletines informativos y comunicaciones de marketing (con tu consentimiento)</li>
            </ul>

            <h3>3. Divulgación de datos</h3>
            <p>No vendemos ni alquilamos tu información personal a terceros. Podemos compartir tu información personal
                con proveedores de servicios que nos ayudan a operar nuestro sitio web o administrar nuestras
                actividades.</p>

            <p>Estos proveedores de servicios tienen acceso a tu información personal solo para realizar tareas en
                nuestro nombre y están obligados a no revelarla ni utilizarla para ningún otro propósito.</p>

            <h3>4. Tus derechos</h3>
            <p>Tienes derecho a:</p>
            <ul>
                <li>Acceder a tus datos personales</li>
                <li>Corregir datos inexactos o incompletos</li>
                <li>Solicitar la eliminación de tus datos personales</li>
                <li>Oponerte al procesamiento de tus datos personales</li>
                <li>Solicitar la transferencia de tus datos personales</li>
                <li>Retirar tu consentimiento en cualquier momento</li>
            </ul>

            <h3>5. Seguridad de los datos</h3>
            <p>Implementamos medidas de seguridad técnicas y organizativas para proteger tu información personal. Sin
                embargo, ningún método de transmisión por Internet o método de almacenamiento electrónico es 100%
                seguro.</p>

            <h3>6. Cookies y tecnologías similares</h3>
            <p>Utilizamos cookies y tecnologías similares para rastrear la actividad en nuestro servicio y mantener
                cierta información. Puedes instruir a tu navegador para que rechace todas las cookies o para que indique
                cuándo se envía una cookie.</p>

            <h3>7. Cambios en esta política</h3>
            <p>Podemos actualizar nuestra política de privacidad de vez en cuando. Te notificaremos cualquier cambio
                publicando la nueva política de privacidad en esta página y actualizando la fecha de "última
                actualización".</p>

            <h3>8. Contacto</h3>
            <p>Si tienes alguna pregunta sobre esta política de privacidad, por favor contáctanos a través de nuestro <a
                    href="<?php echo BASE_URL; ?>/views/footer/contacto.php">formulario de contacto</a>.</p>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../plantillas/footer.php'; ?>