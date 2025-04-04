# 🦁 ZooApp - Sistema de Gestión para Zoológicos

## 📌 Descripción
ZooApp es una aplicación web moderna diseñada para la gestión eficiente de zoológicos. Permite la administración de usuarios, especies, animales, itinerarios y reservas de visitas. Incluye un panel de control intuitivo para administradores y usuarios, con un enfoque en la experiencia del usuario y la seguridad.

## 🚀 Características Principales
- ✅ Sistema de autenticación seguro con roles de usuario
- ✅ Gestión completa de animales y especies
- ✅ Sistema de reservas de visitas
- ✅ Panel de administración con estadísticas
- ✅ Galería de animales interactiva
- ✅ Sistema de notificaciones
- ✅ Diseño responsivo y accesible

## 🛠️ Stack Tecnológico
### Frontend
- HTML5
- CSS3 (con Bootstrap 5)
- JavaScript (Vanilla)
- AJAX para peticiones asíncronas

### Backend
- PHP 8.x
- MySQL 5.7+
- PDO para conexiones seguras
- Sesiones PHP para autenticación

### Servidor
- Apache 2.4+
- XAMPP/LAMP/WAMP
- Mod_rewrite habilitado

## 📂 Estructura del Proyecto
```
/zoo-app
├── /assets                 # Recursos estáticos
│   ├── /css               # Estilos CSS
│   │   ├── style.css      # Estilos principales
│   │   ├── login_register.css  # Estilos de login y registro
│   │   └── dashboard.css  # Estilos del panel de control (vacío)
│   ├── /js                # Scripts JavaScript
│   │   └── script.js      # Script principal
│   └── /images            # Imágenes públicas
│       ├── hero-bg.jpg    # Imagen de fondo del héroe
│       ├── hero-bg.webp   # Versión webp de la imagen de fondo
│       ├── tigre.png      # Imagen del tigre
│       ├── oso.png        # Imagen del oso
│       ├── loro.png       # Imagen del loro
│       └── *.jpeg         # Imágenes de animales (bengala, jirafa, tigre, mono, león, cebra, búfalo, elefante)
├── /config                # Configuraciones
│   ├── database.php       # Configuración de la base de datos
│   ├── zoo-app.sql        # Esquema de la base de datos
│   ├── checks.sql         # Scripts de verificación
│   ├── zoo-app.mwb        # Modelo de base de datos
│   ├── zoo-app.png        # Diagrama de la base de datos
│   └── relacionesBD.txt   # Documentación de relaciones
├── /controllers           # Controladores de la aplicación
│   ├── AdminController.php
│   ├── AnimalController.php
│   ├── AuthController.php
│   ├── EspeciesController.php
│   ├── ItinerarioController.php
│   ├── ReservaController.php
│   └── test_*.php         # Archivos de prueba
├── /docs                  # Documentación
│   └── estructura.txt     # Estructura del proyecto
├── /models                # Modelos de la base de datos
│   ├── animal.php         # Modelo de animales (vacío)
│   ├── especie.php        # Modelo de especies (vacío)
│   ├── itinerario.php     # Modelo de itinerarios (vacío)
│   ├── reserva.php        # Modelo de reservas (vacío)
│   └── usuario.php        # Modelo de usuarios (vacío)
├── /scripts               # Scripts de utilidad
│   └── subir_github.py    # Script para subir a GitHub
├── /views                 # Vistas de la aplicación
│   ├── /admin            # Vistas del panel de administración
│   │   ├── dashboard.php  # Panel de control (vacío)
│   │   ├── reservas.php   # Gestión de reservas (vacío)
│   │   ├── itinerario.php # Gestión de itinerarios (vacío)
│   │   ├── especies.php   # Gestión de especies (vacío)
│   │   ├── animales.php   # Gestión de animales (vacío)
│   │   └── usuarios.php   # Gestión de usuarios (vacío)
│   ├── /plantillas       # Plantillas reutilizables
│   │   ├── header.php     # Encabezado común
│   │   └── footer.php     # Pie de página común
│   ├── animales.php      # Vista de animales (vacío)
│   ├── contacto.php      # Página de contacto
│   ├── dashboard.php     # Panel de control (vacío)
│   ├── itinerario.php    # Vista de itinerarios (vacío)
│   ├── login.php         # Vista de inicio de sesión
│   ├── politica_privacidad.php
│   ├── register.php      # Vista de registro
│   ├── reservas.php      # Vista de reservas (vacío)
│   └── terminos_de_servicio.php
├── index.php             # Punto de entrada principal
├── requirements.txt      # Requisitos del sistema
└── README.md            # Documentación del proyecto
```

## 📦 Requisitos del Sistema
Los requisitos detallados del sistema se encuentran en el archivo [requirements.txt](requirements.txt). A continuación, un resumen de los requisitos principales:

### Servidor Web
- Apache 2.4 o superior
- Mod_rewrite habilitado
- Mod_php habilitado

### PHP
- PHP 8.0 o superior
- Extensiones PHP requeridas:
  - PDO
  - PDO_MySQL
  - JSON
  - Session
  - mbstring
  - fileinfo

### Base de Datos
- MySQL 5.7 o superior
- MySQL Client

### Dependencias del Proyecto
- Composer
- Git

Para instalar todos los requisitos, consulta el archivo `requirements.txt` en la raíz del proyecto.

## 🔧 Instalación
1. Clonar el repositorio:
```bash
git clone https://github.com/tu-usuario/zoo-app.git
cd zoo-app
```

2. Configurar la base de datos:
- Importar el archivo `config/zoo-app.sql` en MySQL
- Configurar las credenciales en `config/database.php`

3. Configurar el servidor web:
- Asegurar que Apache está configurado para usar el directorio `public` como raíz
- Verificar que mod_rewrite está habilitado

4. Acceder a la aplicación:
- Abrir `http://localhost/zoo-app/public` en el navegador

## 🔐 Credenciales de Prueba
### Administrador
- Usuario: admin@zooapp.com
- Contraseña: admin123

### Usuario Normal
- Usuario: usuario@zooapp.com
- Contraseña: user123

## 🤝 Contribuciones
Las contribuciones son bienvenidas. Por favor, sigue estos pasos:
1. Fork del repositorio
2. Crear una rama (`git checkout -b feature/nueva-caracteristica`)
3. Commit de cambios (`git commit -m 'Añadir nueva característica'`)
4. Push a la rama (`git push origin feature/nueva-caracteristica`)
5. Abrir un Pull Request

## 📄 Licencia
Este proyecto está bajo la licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 📬 Contacto
Para consultas o sugerencias:
- 📧 Email: tu-email@example.com
- 🐙 GitHub: github.com/tu-usuario
- 🔗 LinkedIn: linkedin.com/in/tu-perfil
