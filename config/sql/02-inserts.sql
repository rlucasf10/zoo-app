SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET collation_connection = 'utf8mb4_unicode_ci';
SET FOREIGN_KEY_CHECKS = 0;
-- USUARIO ADMIN
INSERT INTO usuarios (
        nombre_completo,
        nombre_usuario,
        email,
        password,
        es_admin
    )
VALUES (
        'Administrador',
        'admin',
        'admin@zoo.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        1
    );
-- INSERTAR ESPECIES
INSERT INTO especies (nombre_especie, descripcion)
VALUES -- MAMÍFEROS
    (
        'Panthera tigris tigris',
        'El tigre de Bengala es la subespecie más numerosa de tigre y habita en India, Bangladesh, Nepal y Bután.'
    ),
    (
        'Panthera tigris altaica',
        'El tigre siberiano es la subespecie más grande de tigre y habita en el extremo oriental de Rusia.'
    ),
    (
        'Panthera tigris tigris albino',
        'El tigre blanco es una variante genética del tigre de Bengala con una condición que elimina el pigmento naranja.'
    ),
    (
        'Panthera leo persica',
        'El león asiático es una subespecie de león que habita en el bosque de Gir en India.'
    ),
    (
        'Panthera leo krugeri',
        'El león blanco es una variante genética del león sudafricano con una condición que elimina el pigmento.'
    ),
    (
        'Panthera leo',
        'El león africano es el segundo felino más grande del mundo después del tigre siberiano.'
    ),
    (
        'Loxodonta africana',
        'El elefante africano es el animal terrestre más grande del mundo.'
    ),
    (
        'Syncerus caffer',
        'El búfalo africano es uno de los grandes bóvidos de África.'
    ),
    (
        'Equus quagga',
        'La cebra de planicie es la especie más común y extendida de cebra.'
    ),
    (
        'Giraffa camelopardalis tippelskirchi',
        'La jirafa Masai es una subespecie de jirafa que habita en Kenia y Tanzania.'
    ),
    (
        'Giraffa camelopardalis reticulata',
        'La jirafa reticulada es una subespecie de jirafa que habita en Somalia, Etiopía y Kenia.'
    ),
    (
        'Giraffa camelopardalis antiquorum',
        'La jirafa de Kordofán es una subespecie de jirafa que habita en Sudán, Chad y República Centroafricana.'
    ),
    (
        'Giraffa camelopardalis angolensis',
        'La jirafa angoleña es una subespecie de jirafa que habita en Namibia, Botswana, Zambia y Zimbabue.'
    ),
    (
        'Macropus rufus rufus',
        'El canguro rojo del sur es una subespecie de canguro rojo que habita en el sur de Australia.'
    ),
    (
        'Macropus rufus griseus',
        'El canguro rojo del norte es una subespecie de canguro rojo que habita en el norte de Australia.'
    ),
    (
        'Phascolarctos cinereus victoria',
        'El koala de Victoria es una subespecie de koala que habita en el estado de Victoria, Australia.'
    ),
    (
        'Phascolarctos cinereus adustus',
        'El koala de Queensland es una subespecie de koala que habita en el estado de Queensland, Australia.'
    ),
    (
        'Ailuropoda melanoleuca sichuanensis',
        'El panda gigante de Sichuan es una subespecie de panda gigante que habita en la provincia de Sichuan, China.'
    ),
    (
        'Ailuropoda melanoleuca qinlingensis',
        'El panda gigante de Qinling es una subespecie de panda gigante que habita en las montañas Qinling, China.'
    ),
    (
        'Ursus maritimus maritimus',
        'El oso polar occidental es una subespecie de oso polar que habita en el archipiélago ártico canadiense.'
    ),
    (
        'Ursus maritimus marinus',
        'El oso polar oriental es una subespecie de oso polar que habita en el archipiélago de Svalbard.'
    ),
    (
        'Tursiops truncatus pacificus',
        'El delfín mular del Pacífico es una subespecie de delfín mular que habita en el océano Pacífico.'
    ),
    (
        'Tursiops truncatus atlanticus',
        'El delfín mular del Atlántico es una subespecie de delfín mular que habita en el océano Atlántico.'
    ),
    (
        'Octopus vulgaris',
        'El pulpo común es una especie de molusco cefalópodo que habita en los océanos.'
    ),
    -- AVES
    (
        'Aquila chrysaetos chrysaetos',
        'El águila real europea es una subespecie de águila real que habita en Europa.'
    ),
    (
        'Aquila chrysaetos canadensis',
        'El águila real americana es una subespecie de águila real que habita en América del Norte.'
    ),
    (
        'Phoenicoparrus minor',
        'El flamenco menor es una especie de ave que habita en África y Asia.'
    ),
    (
        'Phoenicoparrus roseus',
        'El flamenco mayor es una especie de ave que habita en África, Asia y Europa.'
    ),
    (
        'Phoenicoparrus ruber',
        'El flamenco rosa es una especie de ave que habita en América.'
    ),
    (
        'Aptenodytes forsteri',
        'El pingüino emperador es la especie más grande de pingüino y habita en la Antártida.'
    ),
    (
        'Aptenodytes forsteri weddellii',
        'El pingüino emperador de Weddell es una subespecie de pingüino emperador que habita en el mar de Weddell.'
    ),
    (
        'Aptenodytes forsteri rossi',
        'El pingüino emperador de Ross es una subespecie de pingüino emperador que habita en el mar de Ross.'
    ),
    -- REPTILES
    (
        'Crocodylus niloticus',
        'El cocodrilo del Nilo es una especie de cocodrilo que habita en África.'
    ),
    (
        'Crocodylus niloticus occidentalis',
        'El cocodrilo del Nilo occidental es una subespecie de cocodrilo del Nilo que habita en África occidental.'
    ),
    (
        'Crocodylus niloticus orientalis',
        'El cocodrilo del Nilo oriental es una subespecie de cocodrilo del Nilo que habita en África oriental.'
    ),
    (
        'Caretta caretta',
        'La tortuga boba es una especie de tortuga marina que habita en los océanos Atlántico, Índico y Pacífico.'
    ),
    (
        'Caretta caretta pacifica',
        'La tortuga boba del Pacífico es una subespecie de tortuga boba que habita en el océano Pacífico.'
    ),
    (
        'Caretta caretta atlantica',
        'La tortuga boba del Atlántico es una subespecie de tortuga boba que habita en el océano Atlántico.'
    ),
    (
        'Varanus komodoensis',
        'El dragón de Komodo es el lagarto más grande del mundo, endémico de Indonesia.'
    ),
    (
        'Python reticulatus',
        'La pitón reticulada es una de las serpientes más largas del mundo.'
    ),
    -- ANFIBIOS
    (
        'Ambystoma mexicanum',
        'El ajolote es una especie de salamandra que habita en México.'
    ),
    (
        'Proteus anguinus',
        'El proteo es una especie de salamandra que habita en cuevas de Europa.'
    ),
    (
        'Rana temporaria',
        'La rana bermeja es una especie de rana que habita en Europa.'
    ),
    (
        'Hyla arborea',
        'La ranita de San Antonio es una especie de rana que habita en Europa.'
    ),
    (
        'Triturus cristatus',
        'El tritón crestado es una especie de tritón que habita en Europa.'
    ),
    (
        'Bufo bufo',
        'El sapo común es una especie de sapo que habita en Europa.'
    ),
    (
        'Salamandra salamandra',
        'La salamandra común es una especie de salamandra que habita en Europa.'
    ),
    (
        'Dendrobates azureus',
        'La rana azul es una especie de rana venenosa que habita en Sudamérica.'
    ),
    -- PECES
    (
        'Rhincodon typus',
        'El tiburón ballena es el pez más grande del mundo.'
    ),
    (
        'Manta birostris',
        'La manta gigante es una de las rayas más grandes del mundo.'
    ),
    (
        'Amphiprion ocellaris',
        'El pez payaso es conocido por su relación simbiótica con las anémonas.'
    ),
    (
        'Hippocampus kuda',
        'El caballito de mar es conocido por su forma única y su reproducción.'
    ),
    (
        'Paracanthurus hepatus',
        'El pez cirujano azul es conocido por su coloración distintiva.'
    ),
    (
        'Betta splendens',
        'El pez betta es conocido por sus aletas coloridas y su comportamiento territorial.'
    ),
    (
        'Pomacanthus imperator',
        'El pez ángel emperador es conocido por su coloración juvenil y adulta distintiva.'
    );
-- OBTENER IDs DE ESPECIES
SET @tigre_bengala_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Panthera tigris tigris'
    );
SET @tigre_siberiano_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Panthera tigris altaica'
    );
SET @tigre_blanco_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Panthera tigris tigris albino'
    );
SET @leon_asiatico_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Panthera leo persica'
    );
SET @leon_blanco_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Panthera leo krugeri'
    );
SET @leon_africano_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Panthera leo'
    );
SET @elefante_africano_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Loxodonta africana'
    );
SET @bufalo_africano_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Syncerus caffer'
    );
SET @cebra_planicie_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Equus quagga'
    );
SET @jirafa_masai_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Giraffa camelopardalis tippelskirchi'
    );
SET @jirafa_reticulada_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Giraffa camelopardalis reticulata'
    );
SET @jirafa_kordofan_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Giraffa camelopardalis antiquorum'
    );
SET @jirafa_angolana_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Giraffa camelopardalis angolensis'
    );
SET @canguro_sur_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Macropus rufus rufus'
    );
SET @canguro_norte_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Macropus rufus griseus'
    );
SET @koala_victoria_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Phascolarctos cinereus victoria'
    );
SET @koala_queensland_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Phascolarctos cinereus adustus'
    );
SET @panda_sichuan_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Ailuropoda melanoleuca sichuanensis'
    );
SET @panda_shaanxi_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Ailuropoda melanoleuca qinlingensis'
    );
SET @oso_polar_occidental_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Ursus maritimus maritimus'
    );
SET @oso_polar_oriental_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Ursus maritimus marinus'
    );
SET @delfin_pacifico_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Tursiops truncatus pacificus'
    );
SET @delfin_atlantico_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Tursiops truncatus atlanticus'
    );
SET @pulpo_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Octopus vulgaris'
    );
SET @aguila_europea_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Aquila chrysaetos chrysaetos'
    );
SET @aguila_americana_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Aquila chrysaetos canadensis'
    );
SET @flamenco_menor_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Phoenicoparrus minor'
    );
SET @flamenco_mayor_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Phoenicoparrus roseus'
    );
SET @flamenco_rosa_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Phoenicoparrus ruber'
    );
SET @pinguino_emperador_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Aptenodytes forsteri'
    );
SET @pinguino_weddell_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Aptenodytes forsteri weddellii'
    );
SET @pinguino_ross_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Aptenodytes forsteri rossi'
    );
SET @cocodrilo_nilo_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Crocodylus niloticus'
    );
SET @cocodrilo_occidental_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Crocodylus niloticus occidentalis'
    );
SET @cocodrilo_oriental_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Crocodylus niloticus orientalis'
    );
SET @tortuga_boba_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Caretta caretta'
    );
SET @tortuga_pacifico_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Caretta caretta pacifica'
    );
SET @tortuga_atlantico_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Caretta caretta atlantica'
    );
SET @dragon_komodo_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Varanus komodoensis'
    );
SET @piton_reticulada_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Python reticulatus'
    );
SET @ajolote_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Ambystoma mexicanum'
    );
SET @proteo_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Proteus anguinus'
    );
SET @rana_bermeja_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Rana temporaria'
    );
SET @ranita_san_antonio_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Hyla arborea'
    );
SET @triton_crestado_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Triturus cristatus'
    );
SET @sapo_comun_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Bufo bufo'
    );
SET @salamandra_comun_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Salamandra salamandra'
    );
SET @rana_azul_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Dendrobates azureus'
    );
SET @tiburon_ballena_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Rhincodon typus'
    );
SET @manta_gigante_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Manta birostris'
    );
SET @pez_payaso_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Amphiprion ocellaris'
    );
SET @caballito_mar_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Hippocampus kuda'
    );
SET @cirujano_azul_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Paracanthurus hepatus'
    );
SET @pez_betta_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Betta splendens'
    );
SET @pez_angel_id = (
        SELECT id
        FROM especies
        WHERE nombre_especie = 'Pomacanthus imperator'
    );
-- INSERTAR ANIMALES
INSERT INTO animales (
        especie_id,
        nombre_animal,
        descripcion,
        habitat,
        peso,
        categoria,
        imagen_url
    )
VALUES -- MAMÍFEROS
    (
        @tigre_bengala_id,
        'Tigre de Bengala',
        'El tigre de Bengala es la subespecie más numerosa de tigre, conocida por su pelaje naranja con rayas negras.',
        'Bosques de India y Bangladesh',
        '220',
        'mamiferos',
        'assets/images/tigre-bengala.jpeg'
    ),
    (
        @tigre_siberiano_id,
        'Tigre Siberiano',
        'El tigre siberiano es la subespecie más grande de tigre, con un pelaje más claro y denso para adaptarse al clima frío.',
        'Bosques boreales de Rusia',
        '300',
        'mamiferos',
        'assets/images/tigre-siberiano.jpeg'
    ),
    (
        @tigre_blanco_id,
        'Tigre Blanco',
        'El tigre blanco es una variante genética del tigre de Bengala con un pelaje blanco y rayas negras.',
        'Bosques de India',
        '220',
        'mamiferos',
        'assets/images/tigre-blanco.jpeg'
    ),
    (
        @leon_asiatico_id,
        'León Asiático',
        'El león asiático es una subespecie de león que habita en el bosque de Gir en India, con una melena menos prominente que el león africano.',
        'Bosque de Gir, India',
        '190',
        'mamiferos',
        'assets/images/leon-asiatico.jpeg'
    ),
    (
        @leon_blanco_id,
        'León Blanco',
        'El león blanco es una variante genética del león sudafricano con un pelaje blanco debido a una mutación recesiva.',
        'Sabanas de Sudáfrica',
        '190',
        'mamiferos',
        'assets/images/leon-blanco.jpeg'
    ),
    (
        @leon_africano_id,
        'León Africano',
        'El león africano es el segundo felino más grande del mundo, conocido por su melena y su comportamiento social.',
        'Sabanas africanas',
        '190',
        'mamiferos',
        'assets/images/leon-africano.jpeg'
    ),
    (
        @elefante_africano_id,
        'Elefante Africano',
        'El elefante africano es el animal terrestre más grande del mundo, conocido por su inteligencia y sus grandes orejas.',
        'Sabanas y bosques africanos',
        '6000',
        'mamiferos',
        'assets/images/elefante-africano.jpeg'
    ),
    (
        @bufalo_africano_id,
        'Búfalo Africano',
        'El búfalo africano es uno de los grandes bóvidos de África, conocido por su comportamiento gregario y su temperamento impredecible.',
        'Sabanas africanas',
        '900',
        'mamiferos',
        'assets/images/bufalo-africano.jpeg'
    ),
    (
        @cebra_planicie_id,
        'Cebra de Planicie',
        'La cebra de planicie es la especie más común y extendida de cebra, conocida por sus rayas negras y blancas.',
        'Sabanas africanas',
        '350',
        'mamiferos',
        'assets/images/cebra-planicie.jpeg'
    ),
    (
        @jirafa_masai_id,
        'Jirafa Masai',
        'La jirafa Masai es una subespecie de jirafa que habita en Kenia y Tanzania, con un patrón de manchas irregular.',
        'Sabanas de África Oriental',
        '1200',
        'mamiferos',
        'assets/images/jirafa-masai.jpeg'
    ),
    (
        @jirafa_reticulada_id,
        'Jirafa Reticulada',
        'La jirafa reticulada es una subespecie de jirafa que habita en Somalia, Etiopía y Kenia, con un patrón de manchas en forma de red.',
        'Sabanas de África Oriental',
        '1200',
        'mamiferos',
        'assets/images/jirafa-reticulada.jpeg'
    ),
    (
        @jirafa_kordofan_id,
        'Jirafa de Kordofán',
        'La jirafa de Kordofán es una subespecie de jirafa que habita en Sudán, Chad y República Centroafricana, con un patrón de manchas más claro.',
        'Sabanas de África Central',
        '1200',
        'mamiferos',
        'assets/images/jirafa-kordofan.jpeg'
    ),
    (
        @jirafa_angolana_id,
        'Jirafa Angoleña',
        'La jirafa angoleña es una subespecie de jirafa que habita en Namibia, Botswana, Zambia y Zimbabue, con un patrón de manchas más claro y bordes irregulares.',
        'Sabanas de África Austral',
        '1200',
        'mamiferos',
        'assets/images/jirafa-angolana.jpeg'
    ),
    (
        @canguro_sur_id,
        'Canguro del Sur',
        'El canguro rojo del sur es una subespecie de canguro rojo que habita en el sur de Australia, conocido por su capacidad de saltar.',
        'Sabanas del sur de Australia',
        '85',
        'mamiferos',
        'assets/images/canguro-sur.jpeg'
    ),
    (
        @canguro_norte_id,
        'Canguro del Norte',
        'El canguro rojo del norte es una subespecie de canguro rojo que habita en el norte de Australia, conocido por su capacidad de saltar.',
        'Sabanas del norte de Australia',
        '85',
        'mamiferos',
        'assets/images/canguro-norte.jpeg'
    ),
    (
        @koala_victoria_id,
        'Koala de Victoria',
        'El koala de Victoria es una subespecie de koala que habita en el estado de Victoria, Australia, conocido por su dieta a base de hojas de eucalipto.',
        'Bosques de eucaliptos de Victoria',
        '14',
        'mamiferos',
        'assets/images/koala-victoria.jpeg'
    ),
    (
        @koala_queensland_id,
        'Koala de Queensland',
        'El koala de Queensland es una subespecie de koala que habita en el estado de Queensland, Australia, conocido por su dieta a base de hojas de eucalipto.',
        'Bosques de eucaliptos de Queensland',
        '14',
        'mamiferos',
        'assets/images/koala-queensland.jpeg'
    ),
    (
        @panda_sichuan_id,
        'Panda de Sichuan',
        'El panda gigante de Sichuan es una subespecie de panda gigante que habita en la provincia de Sichuan, China, conocido por su dieta a base de bambú.',
        'Bosques de bambú de Sichuan',
        '120',
        'mamiferos',
        'assets/images/panda-sichuan.jpeg'
    ),
    (
        @panda_shaanxi_id,
        'Panda de Shaanxi',
        'El panda gigante de Qinling es una subespecie de panda gigante que habita en las montañas Qinling, China, conocido por su dieta a base de bambú.',
        'Bosques de bambú de Shaanxi',
        '120',
        'mamiferos',
        'assets/images/panda-shaanxi.jpeg'
    ),
    (
        @oso_polar_occidental_id,
        'Oso Polar Occidental',
        'El oso polar occidental es una subespecie de oso polar que habita en el archipiélago ártico canadiense, adaptado a la vida en el hielo.',
        'Hielo ártico de Canadá',
        '450',
        'mamiferos',
        'assets/images/oso-polar-occidental.jpeg'
    ),
    (
        @oso_polar_oriental_id,
        'Oso Polar Oriental',
        'El oso polar oriental es una subespecie de oso polar que habita en el archipiélago de Svalbard, adaptado a la vida en el hielo.',
        'Hielo ártico de Svalbard',
        '450',
        'mamiferos',
        'assets/images/oso-polar-oriental.jpeg'
    ),
    (
        @delfin_pacifico_id,
        'Delfín del Pacífico',
        'El delfín mular del Pacífico es una subespecie de delfín mular que habita en el océano Pacífico, conocido por su inteligencia y sociabilidad.',
        'Océano Pacífico',
        '300',
        'mamiferos',
        'assets/images/delfin-pacifico.jpeg'
    ),
    (
        @delfin_atlantico_id,
        'Delfín del Atlántico',
        'El delfín mular del Atlántico es una subespecie de delfín mular que habita en el océano Atlántico, conocido por su inteligencia y sociabilidad.',
        'Océano Atlántico',
        '300',
        'mamiferos',
        'assets/images/delfin-atlantico.jpeg'
    ),
    (
        @pulpo_id,
        'Pulpo Común',
        'El pulpo común es una especie de molusco cefalópodo que habita en los océanos, conocido por su inteligencia y su capacidad para cambiar de color.',
        'Océanos',
        '3',
        'mamiferos',
        'assets/images/pulpo-común.jpeg'
    ),
    -- AVES
    (
        @aguila_europea_id,
        'Águila Real Europea',
        'El águila real europea es una subespecie de águila real que habita en Europa, conocida por su envergadura y su capacidad de vuelo.',
        'Montañas de Europa',
        '6',
        'aves',
        'assets/images/aguila-europea.jpeg'
    ),
    (
        @aguila_americana_id,
        'Águila Real Americana',
        'El águila real americana es una subespecie de águila real que habita en América del Norte, conocida por su envergadura y su capacidad de vuelo.',
        'Montañas de América del Norte',
        '6',
        'aves',
        'assets/images/aguila-americana.jpeg'
    ),
    (
        @flamenco_menor_id,
        'Flamenco Menor',
        'El flamenco menor es una especie de ave que habita en África y Asia, conocida por su plumaje rosa pálido y su comportamiento gregario.',
        'Humedales africanos',
        '2.5',
        'aves',
        'assets/images/flamenco-menor.jpeg'
    ),
    (
        @flamenco_mayor_id,
        'Flamenco Mayor',
        'El flamenco mayor es una especie de ave que habita en África, Asia y Europa, conocida por su plumaje rosa intenso y su comportamiento gregario.',
        'Humedales mediterráneos',
        '3.0',
        'aves',
        'assets/images/flamenco-mayor.jpeg'
    ),
    (
        @flamenco_rosa_id,
        'Flamenco Rosa',
        'El flamenco rosa es una especie de ave que habita en América, conocida por su plumaje rosa y su comportamiento gregario.',
        'Humedales americanos',
        '2.8',
        'aves',
        'assets/images/flamenco-rosa.jpeg'
    ),
    (
        @pinguino_emperador_id,
        'Pingüino Emperador',
        'El pingüino emperador es la especie más grande de pingüino, conocida por su capacidad para sobrevivir en condiciones extremas.',
        'Antártida',
        '30',
        'aves',
        'assets/images/pinguino-emperador.jpeg'
    ),
    (
        @pinguino_weddell_id,
        'Pingüino de Weddell',
        'El pingüino emperador de Weddell es una subespecie de pingüino emperador que habita en el mar de Weddell, conocido por su capacidad para sobrevivir en condiciones extremas.',
        'Mar de Weddell',
        '30',
        'aves',
        'assets/images/pinguino-weddell.jpeg'
    ),
    (
        @pinguino_ross_id,
        'Pingüino de Ross',
        'El pingüino emperador de Ross es una subespecie de pingüino emperador que habita en el mar de Ross, conocido por su capacidad para sobrevivir en condiciones extremas.',
        'Mar de Ross',
        '30',
        'aves',
        'assets/images/pinguino-ross.jpeg'
    ),
    -- REPTILES
    (
        @cocodrilo_nilo_id,
        'Cocodrilo del Nilo',
        'El cocodrilo del Nilo es una especie de cocodrilo que habita en África, conocido por su tamaño y su comportamiento territorial.',
        'Ríos y lagos de África',
        '500',
        'reptiles',
        'assets/images/cocodrilo-nilo.jpeg'
    ),
    (
        @cocodrilo_occidental_id,
        'Cocodrilo Occidental',
        'El cocodrilo del Nilo occidental es una subespecie de cocodrilo del Nilo que habita en África occidental, conocido por su tamaño y su comportamiento territorial.',
        'Ríos y lagos de África Occidental',
        '500',
        'reptiles',
        'assets/images/cocodrilo-occidental.jpeg'
    ),
    (
        @cocodrilo_oriental_id,
        'Cocodrilo Oriental',
        'El cocodrilo del Nilo oriental es una subespecie de cocodrilo del Nilo que habita en África oriental, conocido por su tamaño y su comportamiento territorial.',
        'Ríos y lagos de África Oriental',
        '500',
        'reptiles',
        'assets/images/cocodrilo-oriental.jpeg'
    ),
    (
        @tortuga_boba_id,
        'Tortuga Boba',
        'La tortuga boba es una especie de tortuga marina que habita en los océanos Atlántico, Índico y Pacífico, conocida por su longevidad y su capacidad para migrar.',
        'Océanos',
        '100',
        'reptiles',
        'assets/images/tortuga-boba.jpeg'
    ),
    (
        @tortuga_pacifico_id,
        'Tortuga del Pacífico',
        'La tortuga boba del Pacífico es una subespecie de tortuga boba que habita en el océano Pacífico, conocida por su longevidad y su capacidad para migrar.',
        'Océano Pacífico',
        '100',
        'reptiles',
        'assets/images/tortuga-pacifico.jpeg'
    ),
    (
        @tortuga_atlantico_id,
        'Tortuga del Atlántico',
        'La tortuga boba del Atlántico es una subespecie de tortuga boba que habita en el océano Atlántico, conocida por su longevidad y su capacidad para migrar.',
        'Océano Atlántico',
        '100',
        'reptiles',
        'assets/images/tortuga-atlantico.jpeg'
    ),
    (
        @dragon_komodo_id,
        'Dragón de Komodo',
        'El dragón de Komodo es el lagarto más grande del mundo, endémico de Indonesia, conocido por su veneno y su comportamiento territorial.',
        'Islas de Indonesia',
        '70',
        'reptiles',
        'assets/images/dragon-komodo.jpeg'
    ),
    (
        @piton_reticulada_id,
        'Pitón Reticulada',
        'La pitón reticulada es una de las serpientes más largas del mundo, conocida por su patrón de escamas y su comportamiento territorial.',
        'Selvas del sudeste asiático',
        '75',
        'reptiles',
        'assets/images/piton-reticulada.jpeg'
    ),
    -- ANFIBIOS
    (
        @ajolote_id,
        'Ajolote',
        'El ajolote es una especie de salamandra que habita en México, conocido por su capacidad de regeneración y su aspecto único.',
        'Lagos de México',
        '0.3',
        'anfibios',
        'assets/images/ajolote.jpeg'
    ),
    (
        @proteo_id,
        'Proteo',
        'El proteo es una especie de salamandra que habita en cuevas de Europa, conocido por su adaptación a la vida en la oscuridad.',
        'Cuevas de Europa',
        '0.2',
        'anfibios',
        'assets/images/proteo.jpeg'
    ),
    (
        @rana_bermeja_id,
        'Rana Bermeja',
        'La rana bermeja es una especie de rana que habita en Europa, conocida por su coloración y su comportamiento territorial.',
        'Humedales de Europa',
        '0.1',
        'anfibios',
        'assets/images/rana-bermeja.jpeg'
    ),
    (
        @ranita_san_antonio_id,
        'Ranita de San Antonio',
        'La ranita de San Antonio es una especie de rana que habita en Europa, conocida por su capacidad para trepar y su comportamiento territorial.',
        'Bosques de Europa',
        '0.05',
        'anfibios',
        'assets/images/ranita-sanAntonio.jpeg'
    ),
    (
        @triton_crestado_id,
        'Tritón Crestado',
        'El tritón crestado es una especie de tritón que habita en Europa, conocido por su cresta y su comportamiento territorial.',
        'Humedales de Europa',
        '0.1',
        'anfibios',
        'assets/images/triton-crestado.jpeg'
    ),
    (
        @sapo_comun_id,
        'Sapo Común',
        'El sapo común es una especie de sapo que habita en Europa, conocido por su piel verrugosa y su comportamiento territorial.',
        'Humedales de Europa',
        '0.2',
        'anfibios',
        'assets/images/sapo-comun.jpeg'
    ),
    (
        @salamandra_comun_id,
        'Salamandra Común',
        'La salamandra común es una especie de salamandra que habita en Europa, conocida por su coloración y su comportamiento territorial.',
        'Bosques de Europa',
        '0.1',
        'anfibios',
        'assets/images/salamandra-comun.jpeg'
    ),
    (
        @rana_azul_id,
        'Rana Azul',
        'La rana azul es una especie de rana venenosa que habita en Sudamérica, conocida por su coloración y su veneno.',
        'Selvas de Sudamérica',
        '0.05',
        'anfibios',
        'assets/images/rana-azul.jpeg'
    ),
    -- PECES
    (
        @tiburon_ballena_id,
        'Tiburón Ballena',
        'El tiburón ballena es el pez más grande del mundo, conocido por su tamaño y su comportamiento pacífico.',
        'Océanos tropicales',
        '18000',
        'peces',
        'assets/images/tiburon-ballena.jpeg'
    ),
    (
        @manta_gigante_id,
        'Manta Gigante',
        'La manta gigante es una de las rayas más grandes del mundo, conocida por su tamaño y su comportamiento pacífico.',
        'Océanos tropicales',
        '2000',
        'peces',
        'assets/images/manta-gigante.jpeg'
    ),
    (
        @pez_payaso_id,
        'Pez Payaso',
        'El pez payaso es conocido por su relación simbiótica con las anémonas y su brillante coloración naranja y blanca.',
        'Arrecifes de coral',
        '0.2',
        'peces',
        'assets/images/pez-payaso.jpeg'
    ),
    (
        @caballito_mar_id,
        'Caballito de Mar',
        'El caballito de mar es conocido por su forma única y su reproducción, donde el macho lleva los huevos.',
        'Arrecifes de coral',
        '0.1',
        'peces',
        'assets/images/caballito-mar.jpeg'
    ),
    (
        @cirujano_azul_id,
        'Cirujano Azul',
        'El pez cirujano azul es conocido por su brillante coloración azul y su dieta de algas.',
        'Arrecifes de coral',
        '0.5',
        'peces',
        'assets/images/cirujano-azul.jpeg'
    ),
    (
        @pez_betta_id,
        'Pez Betta',
        'El pez betta es conocido por su agresividad y sus impresionantes aletas coloridas.',
        'Agua dulce tropical',
        '0.1',
        'peces',
        'assets/images/pez-betta.jpeg'
    ),
    (
        @pez_angel_id,
        'Pez Ángel',
        'El pez ángel emperador es conocido por su coloración juvenil y adulta distintiva.',
        'Arrecifes de coral',
        '0.3',
        'peces',
        'assets/images/pez-angel.jpeg'
    );
SET FOREIGN_KEY_CHECKS = 1;