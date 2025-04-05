<?php
session_start();
require_once __DIR__ . '/plantillas/header.php';
?>

<!-- Agregar el CSS específico de la página -->
<link rel="stylesheet" href="/zoo-app/assets/css/animales.css">

<main>
    <!-- Sección Hero de Animales -->
    <section class="hero-animales">
        <div class="hero-content">
            <h1>Nuestros Animales</h1>
            <p>Descubre la increíble diversidad de especies que habitan en nuestro zoológico</p>
        </div>
    </section>

    <!-- Filtros de Búsqueda -->
    <section class="filtros-animales">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="filtros-content">
                        <input type="text" id="buscarAnimal" class="form-control" placeholder="Buscar animal...">
                        <div class="filtros-botones">
                            <button class="btn btn-filtro active" data-categoria="todos">Todos</button>
                            <button class="btn btn-filtro" data-categoria="mamiferos">Mamíferos</button>
                            <button class="btn btn-filtro" data-categoria="aves">Aves</button>
                            <button class="btn btn-filtro" data-categoria="reptiles">Reptiles</button>
                            <button class="btn btn-filtro" data-categoria="acuaticos">Acuáticos</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Galería de Animales -->
    <section class="galeria-animales">
        <div class="container">
            <div class="row">
                <!-- Tigre de Bengala -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="mamiferos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/bengala.jpeg" alt="Tigre de Bengala">
                            <div class="animal-overlay">
                                <h3>Tigre de Bengala</h3>
                                <p>Panthera tigris tigris</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Tigre de Bengala</h4>
                            <p>El tigre de Bengala es uno de los felinos más majestuosos del mundo, conocido por su
                                pelaje naranja con rayas negras distintivas.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: Asia</span>
                                <span><i class="fas fa-weight"></i> Peso: 180-258 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Búfalo -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="mamiferos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/bufalo.jpeg" alt="Búfalo">
                            <div class="animal-overlay">
                                <h3>Búfalo</h3>
                                <p>Syncerus caffer</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Búfalo Africano</h4>
                            <p>El búfalo africano es uno de los "Cinco Grandes" de África, conocido por su fuerza y
                                comportamiento social.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: África</span>
                                <span><i class="fas fa-weight"></i> Peso: 500-900 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cebra -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="mamiferos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/cebra.jpeg" alt="Cebra">
                            <div class="animal-overlay">
                                <h3>Cebra</h3>
                                <p>Equus quagga</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Cebra de Planicie</h4>
                            <p>La cebra de planicie es conocida por sus distintivas rayas negras y blancas, que son
                                únicas en cada individuo.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: África</span>
                                <span><i class="fas fa-weight"></i> Peso: 350-450 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Elefante -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="mamiferos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/elefante.jpeg" alt="Elefante">
                            <div class="animal-overlay">
                                <h3>Elefante</h3>
                                <p>Loxodonta africana</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Elefante Africano</h4>
                            <p>El elefante africano es el animal terrestre más grande del mundo, conocido por su
                                inteligencia y comportamiento social complejo.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: África</span>
                                <span><i class="fas fa-weight"></i> Peso: 4000-7000 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- León -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="mamiferos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/leon.jpeg" alt="León">
                            <div class="animal-overlay">
                                <h3>León</h3>
                                <p>Panthera leo</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>León Africano</h4>
                            <p>El león es conocido como el "rey de la selva" y es el segundo felino más grande del
                                mundo.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: África</span>
                                <span><i class="fas fa-weight"></i> Peso: 150-250 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jirafa -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="mamiferos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/jirafa.jpeg" alt="Jirafa">
                            <div class="animal-overlay">
                                <h3>Jirafa</h3>
                                <p>Giraffa camelopardalis</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Jirafa Masai</h4>
                            <p>La jirafa es el animal más alto del mundo, con un cuello largo que le permite alcanzar
                                las hojas más altas.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: África</span>
                                <span><i class="fas fa-weight"></i> Peso: 800-1200 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Águila Real -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="aves">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/aguila.jpeg" alt="Águila Real">
                            <div class="animal-overlay">
                                <h3>Águila Real</h3>
                                <p>Aquila chrysaetos</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Águila Real</h4>
                            <p>El águila real es una de las aves rapaces más poderosas y emblemáticas del hemisferio
                                norte.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: Hemisferio Norte</span>
                                <span><i class="fas fa-weight"></i> Peso: 3-7 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flamenco -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="aves">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/flamenco.jpeg" alt="Flamenco">
                            <div class="animal-overlay">
                                <h3>Flamenco</h3>
                                <p>Phoenicopterus roseus</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Flamenco Rosa</h4>
                            <p>El flamenco es conocido por su distintivo color rosa y su comportamiento social en
                                grandes colonias.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: África, Asia, Europa</span>
                                <span><i class="fas fa-weight"></i> Peso: 2-4 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cocodrilo -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="reptiles">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/cocodrilo.jpeg" alt="Cocodrilo">
                            <div class="animal-overlay">
                                <h3>Cocodrilo</h3>
                                <p>Crocodylus niloticus</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Cocodrilo del Nilo</h4>
                            <p>El cocodrilo del Nilo es uno de los reptiles más grandes y temidos de África.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: África</span>
                                <span><i class="fas fa-weight"></i> Peso: 225-750 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tortuga Marina -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="reptiles">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/tortuga.jpeg" alt="Tortuga Marina">
                            <div class="animal-overlay">
                                <h3>Tortuga Marina</h3>
                                <p>Caretta caretta</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Tortuga Boba</h4>
                            <p>La tortuga boba es una especie marina que puede vivir más de 50 años en libertad.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: Océanos</span>
                                <span><i class="fas fa-weight"></i> Peso: 80-200 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delfín -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="acuaticos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/delfin.jpeg" alt="Delfín">
                            <div class="animal-overlay">
                                <h3>Delfín</h3>
                                <p>Tursiops truncatus</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Delfín Mular</h4>
                            <p>El delfín mular es uno de los cetáceos más inteligentes y sociables.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: Océanos</span>
                                <span><i class="fas fa-weight"></i> Peso: 150-650 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pingüino -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="aves">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/pinguino.jpeg" alt="Pingüino">
                            <div class="animal-overlay">
                                <h3>Pingüino</h3>
                                <p>Aptenodytes forsteri</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Pingüino Emperador</h4>
                            <p>El pingüino emperador es el más grande de todas las especies de pingüinos.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: Antártida</span>
                                <span><i class="fas fa-weight"></i> Peso: 22-45 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Oso Polar -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="mamiferos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/oso-polar.jpeg" alt="Oso Polar">
                            <div class="animal-overlay">
                                <h3>Oso Polar</h3>
                                <p>Ursus maritimus</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Oso Polar</h4>
                            <p>El oso polar es el carnívoro terrestre más grande del mundo y está perfectamente adaptado
                                al frío ártico.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: Ártico</span>
                                <span><i class="fas fa-weight"></i> Peso: 350-700 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panda -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="mamiferos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/panda.jpeg" alt="Panda">
                            <div class="animal-overlay">
                                <h3>Panda</h3>
                                <p>Ailuropoda melanoleuca</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Panda Gigante</h4>
                            <p>El panda gigante es un símbolo de conservación y una de las especies más queridas del
                                mundo.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: China</span>
                                <span><i class="fas fa-weight"></i> Peso: 85-125 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Koala -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="mamiferos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/koala.jpeg" alt="Koala">
                            <div class="animal-overlay">
                                <h3>Koala</h3>
                                <p>Phascolarctos cinereus</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Koala</h4>
                            <p>El koala es un marsupial endémico de Australia conocido por su dieta basada en hojas de
                                eucalipto.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: Australia</span>
                                <span><i class="fas fa-weight"></i> Peso: 4-15 kg</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Canguro -->
                <div class="col-md-4 col-lg-3 mb-4" data-categoria="mamiferos">
                    <div class="animal-card">
                        <div class="animal-imagen">
                            <img src="/zoo-app/assets/images/canguro.jpeg" alt="Canguro">
                            <div class="animal-overlay">
                                <h3>Canguro</h3>
                                <p>Macropus rufus</p>
                            </div>
                        </div>
                        <div class="animal-info">
                            <h4>Canguro Rojo</h4>
                            <p>El canguro rojo es el marsupial más grande del mundo y un símbolo de Australia.</p>
                            <div class="animal-details">
                                <span><i class="fas fa-map-marker-alt"></i> Hábitat: Australia</span>
                                <span><i class="fas fa-weight"></i> Peso: 20-90 kg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Información Adicional -->
    <section class="info-animales">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-card">
                        <i class="fas fa-clock"></i>
                        <h3>Horarios de Visita</h3>
                        <p>Los mejores momentos para observar a nuestros animales son durante las horas de alimentación
                            y actividades especiales.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <i class="fas fa-map-marked-alt"></i>
                        <h3>Ubicación</h3>
                        <p>Nuestros hábitats están diseñados para replicar el entorno natural de cada especie.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <i class="fas fa-info-circle"></i>
                        <h3>Información</h3>
                        <p>Contamos con guías especializados que pueden proporcionarte información detallada sobre cada
                            animal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Agregar el JavaScript específico de la página -->
<script src="/zoo-app/assets/js/animales.js"></script>

<?php require_once __DIR__ . '/plantillas/footer.php'; ?>
<?php require_once __DIR__ . '/plantillas/footer.php'; ?>