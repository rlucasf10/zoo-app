-- Script para insertar especies y animales en la base de datos
-- Primero insertamos las especies
INSERT INTO especies (nombre_especie)
VALUES ('Panthera tigris tigris'),
    ('Syncerus caffer'),
    ('Equus quagga'),
    ('Loxodonta africana'),
    ('Panthera leo'),
    ('Giraffa camelopardalis'),
    ('Aquila chrysaetos'),
    ('Phoenicopterus roseus'),
    ('Crocodylus niloticus'),
    ('Caretta caretta'),
    ('Tursiops truncatus'),
    ('Aptenodytes forsteri'),
    ('Ursus maritimus'),
    ('Ailuropoda melanoleuca'),
    ('Phascolarctos cinereus'),
    ('Macropus rufus');
-- Luego insertamos los animales
INSERT INTO animales (
        nombre_animal,
        especie_id,
        descripcion,
        habitat,
        peso,
        categoria,
        imagen_url
    )
VALUES -- Mamíferos
    (
        'Tigre de Bengala',
        1,
        'El tigre de Bengala es uno de los felinos más majestuosos del mundo, conocido por su pelaje naranja con rayas negras distintivas.',
        'Asia',
        '180-258',
        'mamiferos',
        '/zoo-app/assets/images/bengala.jpeg'
    ),
    (
        'Búfalo Africano',
        2,
        'El búfalo africano es uno de los "Cinco Grandes" de África, conocido por su fuerza y comportamiento social.',
        'África',
        '500-900',
        'mamiferos',
        '/zoo-app/assets/images/bufalo.jpeg'
    ),
    (
        'Cebra de Planicie',
        3,
        'La cebra de planicie es conocida por sus distintivas rayas negras y blancas, que son únicas en cada individuo.',
        'África',
        '350-450',
        'mamiferos',
        '/zoo-app/assets/images/cebra.jpeg'
    ),
    (
        'Elefante Africano',
        4,
        'El elefante africano es el animal terrestre más grande del mundo, conocido por su inteligencia y comportamiento social complejo.',
        'África',
        '4000-7000',
        'mamiferos',
        '/zoo-app/assets/images/elefante.jpeg'
    ),
    (
        'León Africano',
        5,
        'El león es conocido como el "rey de la selva" y es el segundo felino más grande del mundo.',
        'África',
        '150-250',
        'mamiferos',
        '/zoo-app/assets/images/leon.jpeg'
    ),
    (
        'Jirafa Masai',
        6,
        'La jirafa es el animal más alto del mundo, con un cuello largo que le permite alcanzar las hojas más altas.',
        'África',
        '800-1200',
        'mamiferos',
        '/zoo-app/assets/images/jirafa.jpeg'
    ),
    (
        'Oso Polar',
        13,
        'El oso polar es el carnívoro terrestre más grande del mundo y está perfectamente adaptado al frío ártico.',
        'Ártico',
        '350-700',
        'mamiferos',
        '/zoo-app/assets/images/oso-polar.jpeg'
    ),
    (
        'Panda Gigante',
        14,
        'El panda gigante es un símbolo de conservación y una de las especies más queridas del mundo.',
        'China',
        '85-125',
        'mamiferos',
        '/zoo-app/assets/images/panda.jpeg'
    ),
    (
        'Koala',
        15,
        'El koala es un marsupial endémico de Australia conocido por su dieta basada en hojas de eucalipto.',
        'Australia',
        '4-15',
        'mamiferos',
        '/zoo-app/assets/images/koala.jpeg'
    ),
    (
        'Canguro Rojo',
        16,
        'El canguro rojo es el marsupial más grande del mundo y un símbolo de Australia.',
        'Australia',
        '20-90',
        'mamiferos',
        '/zoo-app/assets/images/canguro.jpeg'
    ),
    -- Aves
    (
        'Águila Real',
        7,
        'El águila real es una de las aves rapaces más poderosas y emblemáticas del hemisferio norte.',
        'Hemisferio Norte',
        '3-7',
        'aves',
        '/zoo-app/assets/images/aguila.jpeg'
    ),
    (
        'Flamenco Rosa',
        8,
        'El flamenco es conocido por su distintivo color rosa y su comportamiento social en grandes colonias.',
        'África, Asia, Europa',
        '2-4',
        'aves',
        '/zoo-app/assets/images/flamenco.jpeg'
    ),
    (
        'Pingüino Emperador',
        12,
        'El pingüino emperador es el más grande de todas las especies de pingüinos.',
        'Antártida',
        '22-45',
        'aves',
        '/zoo-app/assets/images/pinguino.jpeg'
    ),
    -- Reptiles
    (
        'Cocodrilo del Nilo',
        9,
        'El cocodrilo del Nilo es uno de los reptiles más grandes y temidos de África.',
        'África',
        '225-750',
        'reptiles',
        '/zoo-app/assets/images/cocodrilo.jpeg'
    ),
    (
        'Tortuga Boba',
        10,
        'La tortuga boba es una especie marina que puede vivir más de 50 años en libertad.',
        'Océanos',
        '80-200',
        'reptiles',
        '/zoo-app/assets/images/tortuga.jpeg'
    ),
    -- Acuáticos
    (
        'Delfín Mular',
        11,
        'El delfín mular es uno de los cetáceos más inteligentes y sociables.',
        'Océanos',
        '150-650',
        'acuaticos',
        '/zoo-app/assets/images/delfin.jpeg'
    );