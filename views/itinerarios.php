<?php
session_start();
require_once __DIR__ . '/plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="/zoo-app/assets/css/itinerarios.css">

<main>
    <!-- Sección Hero de Itinerarios -->
    <section class="hero-itinerarios">
        <div class="hero-content">
            <h1>Planifica tu Visita</h1>
            <p>Descubre nuestras rutas predefinidas o crea tu propio itinerario personalizado</p>
        </div>
    </section>

    <!-- Sección de Itinerarios Predefinidos -->
    <section class="itinerarios-predefinidos">
        <div class="container">
            <h2>Rutas Predefinidas</h2>
            <div class="row">
                <!-- Ruta de Mamíferos -->
                <div class="col-md-4 mb-4">
                    <div class="itinerario-card">
                        <div class="itinerario-imagen">
                            <img src="/zoo-app/assets/images/ruta-mamiferos.jpeg" alt="Ruta de Mamíferos">
                            <div class="itinerario-overlay">
                                <h3>Ruta de Mamíferos</h3>
                                <p>Duración: 2.5 horas</p>
                            </div>
                        </div>
                        <div class="itinerario-info">
                            <h4>Ruta de Mamíferos</h4>
                            <p>Descubre los mamíferos más impresionantes de nuestro zoológico.</p>
                            <ul class="itinerario-detalles">
                                <li><i class="fas fa-clock"></i> Horario: 10:00 - 12:30</li>
                                <li><i class="fas fa-map-marker-alt"></i> Puntos de interés: 6</li>
                                <li><i class="fas fa-walking"></i> Distancia: 2.5 km</li>
                            </ul>
                            <button class="btn btn-itinerario" data-ruta="mamiferos">Ver Ruta</button>
                        </div>
                    </div>
                </div>

                <!-- Ruta de Aves -->
                <div class="col-md-4 mb-4">
                    <div class="itinerario-card">
                        <div class="itinerario-imagen">
                            <img src="/zoo-app/assets/images/ruta-aves.jpeg" alt="Ruta de Aves">
                            <div class="itinerario-overlay">
                                <h3>Ruta de Aves</h3>
                                <p>Duración: 2 horas</p>
                            </div>
                        </div>
                        <div class="itinerario-info">
                            <h4>Ruta de Aves</h4>
                            <p>Explora el fascinante mundo de las aves de nuestro zoológico.</p>
                            <ul class="itinerario-detalles">
                                <li><i class="fas fa-clock"></i> Horario: 11:00 - 13:00</li>
                                <li><i class="fas fa-map-marker-alt"></i> Puntos de interés: 5</li>
                                <li><i class="fas fa-walking"></i> Distancia: 2 km</li>
                            </ul>
                            <button class="btn btn-itinerario" data-ruta="aves">Ver Ruta</button>
                        </div>
                    </div>
                </div>

                <!-- Ruta Familiar -->
                <div class="col-md-4 mb-4">
                    <div class="itinerario-card">
                        <div class="itinerario-imagen">
                            <img src="/zoo-app/assets/images/ruta-familiar.jpeg" alt="Ruta Familiar">
                            <div class="itinerario-overlay">
                                <h3>Ruta Familiar</h3>
                                <p>Duración: 3 horas</p>
                            </div>
                        </div>
                        <div class="itinerario-info">
                            <h4>Ruta Familiar</h4>
                            <p>La ruta perfecta para disfrutar en familia con los más pequeños.</p>
                            <ul class="itinerario-detalles">
                                <li><i class="fas fa-clock"></i> Horario: 10:30 - 13:30</li>
                                <li><i class="fas fa-map-marker-alt"></i> Puntos de interés: 8</li>
                                <li><i class="fas fa-walking"></i> Distancia: 3 km</li>
                            </ul>
                            <button class="btn btn-itinerario" data-ruta="familiar">Ver Ruta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Crear Itinerario Personalizado -->
    <section class="itinerario-personalizado">
        <div class="container">
            <h2>Crea tu Itinerario Personalizado</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="formulario-itinerario">
                        <form id="formItinerario">
                            <div class="form-group">
                                <label for="nombreItinerario">Nombre del Itinerario</label>
                                <input type="text" class="form-control" id="nombreItinerario" required>
                            </div>
                            <div class="form-group">
                                <label for="duracion">Duración Estimada</label>
                                <select class="form-control" id="duracion" required>
                                    <option value="1">1 hora</option>
                                    <option value="2">2 horas</option>
                                    <option value="3">3 horas</option>
                                    <option value="4">4 horas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Puntos de Interés</label>
                                <div class="puntos-interes">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="mamiferos"
                                            value="mamiferos">
                                        <label class="custom-control-label" for="mamiferos">Mamíferos</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="aves" value="aves">
                                        <label class="custom-control-label" for="aves">Aves</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="reptiles"
                                            value="reptiles">
                                        <label class="custom-control-label" for="reptiles">Reptiles</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="acuaticos"
                                            value="acuaticos">
                                        <label class="custom-control-label" for="acuaticos">Acuáticos</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Crear Itinerario</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="vista-previa-itinerario">
                        <h3>Vista Previa del Itinerario</h3>
                        <div id="vistaPrevia" class="vista-previa-content">
                            <p class="text-muted">Tu itinerario personalizado aparecerá aquí...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Consejos -->
    <section class="consejos-itinerario">
        <div class="container">
            <h2>Consejos para tu Visita</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="consejo-card">
                        <i class="fas fa-sun"></i>
                        <h3>Mejor Momento</h3>
                        <p>Las primeras horas de la mañana son ideales para ver a los animales más activos.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="consejo-card">
                        <i class="fas fa-umbrella"></i>
                        <h3>Preparación</h3>
                        <p>Lleva agua, protector solar y ropa cómoda para disfrutar al máximo.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="consejo-card">
                        <i class="fas fa-camera"></i>
                        <h3>Fotografías</h3>
                        <p>No olvides tu cámara para capturar los momentos especiales.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Agregar el JavaScript específico de la página -->
<script src="/zoo-app/assets/js/itinerarios.js"></script>

<?php require_once __DIR__ . '/plantillas/footer.php'; ?>