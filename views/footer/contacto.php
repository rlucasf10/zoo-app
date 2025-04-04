<?php include $_SERVER['DOCUMENT_ROOT'] . '/zoo-app/views/plantillas/header.php'; ?>

<main>
    <section id="contacto" class="contacto">
        <div class="container">
            <h2>Contacto</h2>
            <p>Si tienes alguna pregunta, comentario o inquietud, no dudes en ponerte en contacto con nosotros.
                Estaremos encantados de atenderte.</p>

            <h3>Formulario de Contacto</h3>
            <form action="/controllers/contactoController.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>

            <h3>Información de Contacto</h3>
            <p><strong>Dirección:</strong> Calle del Zoológico, 123, Ciudad, País</p>
            <p><strong>Teléfono:</strong> +1 (123) 456-7890</p>
            <p><strong>Email:</strong> <a href="mailto:contacto@zoologico.com">contacto@zoologico.com</a></p>
            <p><strong>Redes Sociales:</strong> <a href="https://www.facebook.com/zoologico"
                    target="_blank">Facebook</a>, <a href="https://www.instagram.com/zoologico"
                    target="_blank">Instagram</a></p>
        </div>
    </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/zoo-app/views/plantillas/footer.php'; ?>