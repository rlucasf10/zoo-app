<?php
require_once __DIR__ . '/../../config/config.php';
?>

<!-- Archivo: /views/plantillas/footer.php -->

<footer>
    <div class="footer-content">
        <p>&copy; 2025 Zoo App. Todos los derechos reservados.</p>
        <nav>
            <ul>
                <li><a href="<?php echo BASE_URL; ?>/views/footer/politica_privacidad.php">Política de privacidad</a>
                </li>
                <li><a href="<?php echo BASE_URL; ?>/views/footer/terminos_de_servicio.php">Términos de servicio</a>
                </li>
                <li><a href="<?php echo BASE_URL; ?>/views/footer/contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </div>
</footer>

<!-- Script index.php -->

<script src="<?php echo BASE_URL; ?>/assets/js/index.js"></script>

<!-- Script de cookies -->
<script src="<?php echo BASE_URL; ?>/assets/js/cookies.js"></script>

</body>

</html>