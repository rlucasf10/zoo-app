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
│   │   ├── style.css      # Estilos globales
│   │   ├── itinerarios.css
│   │   ├── reservas.css
│   │   ├── animales.css
│   │   ├── conocer-mas.css
│   │   ├── login_register.css
│   │   └── dashboard.css
│   ├── js/                # Archivos JavaScript
│   │   ├── script.js      # Script principal
│   │   ├── itinerarios.js
│   │   └── reservas.js
│   └── images/            # Imágenes del proyecto
├── config/                # Configuraciones
│   └── sql/              # Scripts SQL y configuración de base de datos
│       ├── zoo-app.sql    # Script principal de la base de datos
│       ├── select_delete.sql
│       ├── inserts.sql    # Datos iniciales
│       ├── database.php   # Configuración de conexión
│       ├── zoo-app.mwb    # Modelo Workbench
│       ├── zoo-app.png    # Diagrama de la base de datos
│       └── relacionesBD.txt
├── controllers/           # Controladores de la aplicación
│   ├── AdminController.php
│   ├── AnimalController.php
│   ├── AuthController.php
│   ├── EspeciesController.php
│   ├── GoogleAuthController.php
│   ├── ItinerarioController.php
│   ├── ReservaController.php
│   └── test_*.php         # Archivos de prueba
├── doc/                   # Documentación del proyecto
│   ├── estructura.txt     # Estructura detallada del proyecto
│   └── requirements.txt   # Requisitos del sistema
├── models/                # Modelos de datos
│   ├── animal.php
│   ├── especie.php
│   ├── itinerario.php
│   ├── reserva.php
│   └── usuario.php
├── scripts/              # Scripts de utilidad
│   └── subir_github.py   # Script para subir a GitHub
├── vendor/               # Dependencias de Composer
├── views/                # Vistas de la aplicación
│   ├── admin/           # Vistas del panel de administración
│   │   ├── dashboard.php
│   │   ├── reservas.php
│   │   ├── itinerarios.php
│   │   ├── especies.php
│   │   ├── animales.php
│   │   └── usuarios.php
│   ├── login_register/  # Vistas de autenticación
│   │   ├── login.php
│   │   └── registro.php
│   ├── plantillas/      # Plantillas reutilizables
│   │   ├── header.php
│   │   └── footer.php
│   ├── footer/          # Componentes del pie de página
│   │   ├── contacto.php
│   │   ├── politica_privacidad.php
│   │   └── terminos_de_servicio.php
│   ├── animales.php
│   ├── conocer-mas.php
│   ├── dashboard.php
│   ├── itinerarios.php
│   └── reservas.php
├── .env                  # Variables de entorno
├── .gitignore           # Archivos ignorados por Git
├── index.php            # Punto de entrada principal
└── README.md            # Documentación principal
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
git clone https://github.com/rlucasf10/zoo-app.git
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
