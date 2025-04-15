<?php require_once __DIR__ . '/../plantillas/header.php'; ?>

<style>
    section#contacto {
        margin: 0 auto;
        padding: 2rem 0;
    }

    .contacto h2 {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        text-align: center;
        font-weight: 700;
    }

    .contacto p {
        line-height: 1.6;
        margin-bottom: 1.2rem;
        color: #34495e;
    }

    .contacto h3 {
        color: #3498db;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
        border-bottom: 2px solid #ecf0f1;
        padding-bottom: 0.5rem;
    }

    .contacto .container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }

    .contacto .form-group {
        margin-bottom: 1.5rem;
    }

    .contacto label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .contacto input,
    .contacto textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .contacto input:focus,
    .contacto textarea:focus {
        border-color: #3498db;
        outline: none;
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    }

    .contacto .btn-primary {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .contacto .btn-primary:hover {
        background-color: #2980b9;
    }

    .contacto .info-contacto {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .contacto .info-contacto p {
        margin-bottom: 0.75rem;
    }

    .contacto .info-contacto a {
        color: #3498db;
        text-decoration: none;
        transition: color 0.3s;
    }

    .contacto .info-contacto a:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    .contacto .redes-sociales {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .contacto .redes-sociales a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: #3498db;
        color: white;
        border-radius: 50%;
        transition: background-color 0.3s;
    }

    .contacto .redes-sociales a:hover {
        background-color: #2980b9;
    }

    .contacto .mapa {
        margin-top: 2rem;
        border-radius: 8px;
        overflow: hidden;
        height: 300px;
    }

    .contacto .mapa iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }

    @media (max-width: 768px) {
        .contacto .container {
            padding: 1.5rem;
        }

        .contacto .redes-sociales {
            justify-content: center;
        }
    }
</style>

<main>
    <section id="contacto" class="contacto">
        <div class="container">
            <h2>Contacto</h2>
            <p>Si tienes alguna pregunta, comentario o inquietud, no dudes en ponerte en contacto con nosotros.
                Estaremos encantados de atenderte y responder a tus necesidades.</p>

            <div class="row">
                <div class="col-md-6">
                    <h3>Formulario de Contacto</h3>
                    <form id="formulario-contacto" onsubmit="return enviarPorCorreo(event)">
                        <div class="form-group">
                            <label for="nombre">Nombre completo</label>
                            <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre completo">
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" required placeholder="tu@email.com">
                        </div>

                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" id="asunto" name="asunto" required placeholder="Asunto de tu mensaje">
                        </div>

                        <div class="form-group">
                            <label for="mensaje">Mensaje</label>
                            <textarea id="mensaje" name="mensaje" rows="5" required
                                placeholder="Escribe tu mensaje aquí..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                    </form>
                </div>

                <div class="col-md-6">
                    <h3>Información de Contacto</h3>
                    <div class="info-contacto">
                        <p><i class="fas fa-map-marker-alt"></i> <strong>Dirección:</strong> Calle Luis Vélez de
                            Guevara, Plasencia, España</p>
                        <p><i class="fas fa-phone"></i> <strong>Teléfono:</strong> +34 678926696</p>
                        <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <a
                                href="mailto:r.lucasf10@gmail.com">r.lucasf10@gmail.com</a></p>
                        <p><i class="fas fa-clock"></i> <strong>Horario de Atención:</strong> Lunes a Domingo de 9:00 a
                            18:00</p>

                        <p><strong>Redes Sociales:</strong></p>
                        <div class="redes-sociales">
                            <a href="https://www.facebook.com/zoologico" target="_blank" title="Facebook"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/zoologico" target="_blank" title="Instagram"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="https://www.twitter.com/zoologico" target="_blank" title="Twitter"><i
                                    class="fab fa-twitter"></i></a>
                            <a href="https://www.youtube.com/zoologico" target="_blank" title="YouTube"><i
                                    class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                    <div class="mapa">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3084.845475475475!2d-6.0894!3d40.0286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd3c9b5c8c5c5c5c5c%3A0x5c5c5c5c5c5c5c5c!2sCalle%20Luis%20V%C3%A9lez%20de%20Guevara%2C%20Plasencia%2C%20C%C3%A1ceres%2C%20Espa%C3%B1a!5e0!3m2!1ses!2ses!4v1234567890"
                            allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formulario = document.getElementById('formulario-contacto');

        function enviarPorCorreo(e) {
            e.preventDefault();

            // Validación básica
            const nombre = document.getElementById('nombre').value.trim();
            const email = document.getElementById('email').value.trim();
            const asunto = document.getElementById('asunto').value.trim();
            const mensaje = document.getElementById('mensaje').value.trim();

            if (nombre === '' || email === '' || asunto === '' || mensaje === '') {
                alert('Por favor, completa todos los campos del formulario.');
                return false;
            }

            // Validación de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Por favor, introduce un correo electrónico válido.');
                return false;
            }

            // Preparar el cuerpo del correo
            const cuerpoCorreo = `
Nombre: ${nombre}
Email: ${email}

Mensaje:
${mensaje}`;

            // Crear el enlace mailto con los datos
            const mailtoLink = `mailto:r.lucasf10@gmail.com?subject=${encodeURIComponent(asunto)}&body=${encodeURIComponent(cuerpoCorreo)}`;

            // Abrir el cliente de correo predeterminado
            window.location.href = mailtoLink;

            return false;
        }

        formulario.onsubmit = enviarPorCorreo;
    });
</script>

<?php require_once __DIR__ . '/../plantillas/footer.php'; ?>