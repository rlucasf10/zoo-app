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
zoo-app/
├── assets/                 # Recursos estáticos
│   ├── css/               # Archivos CSS
│   │   ├── index.css      # Estilos globales
│   │   ├── inicio.css     # Estilos para la página de inicio
│   │   ├── animales.css   # Estilos para la página de animales
│   │   ├── itinerarios.css # Estilos para la página de itinerarios
│   │   ├── reservas.css   # Estilos para la página de reservas
│   │   ├── conocer-mas.css # Estilos para la página conocer más
│   │   ├── login_register.css # Estilos para login y registro
│   │   ├── user_dashboard.css # Estilos para el dashboard de usuario
│   │   └── admin/         # Estilos para el panel de administración
│   │       ├── admin_dashboard.css # Estilos para el dashboard de admin
│   │       ├── especies/  # Estilos para gestión de especies
│   │       ├── animales/  # Estilos para gestión de animales
│   │       ├── itinerarios/ # Estilos para gestión de itinerarios
│   │       ├── reservas/  # Estilos para gestión de reservas
│   │       └── usuarios/  # Estilos para gestión de usuarios
│   ├── js/                # Archivos JavaScript
│   │   ├── script.js      # Script principal
│   │   ├── itinerarios.js
│   │   └── reservas.js
│   └── images/            # Imágenes del proyecto
├── config/                # Configuraciones
│   ├── composer.json     # Configuración de dependencias de Composer
│   ├── composer.lock     # Versiones exactas de dependencias
│   ├── config.php       # Configuración general de la aplicación
│   └── sql/             # Scripts SQL y configuración de base de datos
│       ├── zoo-app.sql   # Script principal de la base de datos
│       ├── select_delete.sql
│       ├── inserts.sql   # Datos iniciales
│       ├── database.php  # Configuración de conexión
│       ├── zoo-app.mwb   # Modelo Workbench
│       ├── zoo-app.png   # Diagrama de la base de datos
│       └── relacionesBD.txt
├── controllers/           # Controladores de la aplicación
│   ├── AdminController.php
│   ├── AnimalController.php
│   ├── AuthController.php
│   ├── EspeciesController.php
│   ├── GoogleAuthController.php
│   ├── ItinerarioController.php
│   └── ReservaController.php
├── doc/                   # Documentación del proyecto
│   ├── estructura.txt     # Estructura detallada del proyecto
│   └── requirements.txt   # Requisitos del sistema
├── Kubernetes/           # Configuración de Kubernetes
│   ├── app-config-configmap.yaml        # ConfigMap para la aplicación
│   ├── mysql-configmaps.yaml            # ConfigMaps de MySQL
│   ├── mysql-credentials-secret.yaml     # Secretos de MySQL
│   ├── mysql-deployment-service.yaml     # Deployment y Service de MySQL
│   ├── ngrok-ingress-zoo-app.yaml       # Ingress para ngrok
│   ├── phpmyadmin-deployment-service.yaml # Deployment y Service de phpMyAdmin
│   └── web-app-deployment-service.yaml   # Deployment y Service de la aplicación web
├── vendor/               # Dependencias de Composer
├── views/                # Vistas de la aplicación
│   ├── admin/           # Vistas del panel de administración
│   │   ├── admin_dashboard.php
│   │   ├── animales/    # Gestión de animales
│   │   ├── especies/    # Gestión de especies
│   │   ├── itinerarios/ # Gestión de itinerarios
│   │   ├── reservas/    # Gestión de reservas
│   │   └── usuarios/    # Gestión de usuarios
│   ├── login_register/  # Vistas de autenticación
│   │   ├── login.php
│   │   ├── register.php
│   │   └── logout.php
│   ├── plantillas/      # Plantillas reutilizables
│   │   ├── header.php
│   │   └── footer.php
│   ├── footer/          # Componentes del pie de página
│   │   ├── contacto.php
│   │   ├── politica_privacidad.php
│   │   └── terminos_de_servicio.php
│   ├── animales.php
│   ├── conocer-mas.php
│   ├── inicio.php
│   ├── itinerarios.php
│   └── reservas.php
├── .env                  # Variables de entorno
├── .gitignore           # Archivos ignorados por Git
├── index.php            # Punto de entrada principal
├── README.md            # Documentación principal
├── LICENSE              # Archivo de licencia MIT
├── Dockerfile          # Configuración para construcción de imagen Docker
├── docker-compose.yml  # Configuración de servicios Docker
├── docker-compose.yml.example # Ejemplo de configuración Docker
├── robots.txt         # Configuración para crawlers
├── sitemap.xml       # Mapa del sitio para SEO
└── google55aafcb360aa39fd.html # Verificación de Google Search Console
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

Para instalar todos los requisitos, consulta el archivo `requirements.txt` en la carpeta doc/requirements.txt de la raíz del proyecto.

## 🔧 Instalación
1. Clonar el repositorio:
```bash
git clone https://github.com/rlucasf10/zoo-app.git
cd zoo-app
```

2. Configurar el archivo de entorno:
```bash

3. Configurar la base de datos:
- Importar el archivo `config/sql/01-zoo-app.sql` en MySQL
- Importar el archivo `config/sql/02-inserts.sql` en MySQL
- Copiar/Mover el archivo `.env.example` a `.env` en la raiz del proyecto
- Configurar las credenciales en `.env`
- Para que funcione el Login con Google, debes crear una credencial OAuth 2.0 en Google Cloud Console

4. Configurar el servidor web:
- Asegurar que Apache está configurado para usar el directorio `public` como raíz
- Verificar que mod_rewrite está habilitado

5. Acceder a la aplicación:
- Abrir `http://localhost/zoo-app/public` en el navegador

## 🐳 Instalación con Docker
1. Clonar el repositorio:
```bash
git clone https://github.com/rlucasf10/zoo-app.git
cd zoo-app
```

2. Construir y levantar los contenedores:
```bash
docker-compose up --build
```

3. Crear secreto de Kubernetes a partir del '.env' modifcado
```bash
kubectl create secret generic zoo-app-env-file --from-file=.env
```
3. Acceder a la aplicación:
- Abrir `http://localhost` en el navegador
- phpMyAdmin: `http://localhost:8080` (usuario: root, contraseña: root)

## 🔐 Credenciales de Prueba
### Administrador
- Usuario: admin@zooapp.com
- Contraseña: password

### Usuario Normal
- Crearlo desde el dashboard de administrador en la interfaz web

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
- 📧 Email: r.lucasf10@gmail.com
- 🐙 GitHub: https://github.com/rlucasf10
- 🔗 LinkedIn: linkedin.com/in/rlucasf10
