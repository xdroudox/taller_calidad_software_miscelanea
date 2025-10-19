# taller_calidad_software_miscelanea

Este proyecto es una aplicación web desarrollada con Laravel que permite la gestión integral de una miscelánea, incluyendo autenticación de usuarios, control de productos, categorías y Dashboard. El sistema está diseñado para facilitar las operaciones diarias de una miscelánea, optimizando los procesos de registro, consulta y mantenimiento de información comercial.

## Tecnologías Utilizadas

**Lenguajes y Frameworks:**
- PHP 8.2.12
- Laravel 10+ (Laravel Installer 5.17.0)
- JavaScript (ES6)
- CSS3
- XML / YAML (para configuración y documentación)
- MySQL (base de datos principal)

**Librerías y Paquetes:**
- Kitloong Laravel Migration Generator: Generación automática de migraciones desde una base de datos existente.
- Reliese ORM: Generador de modelos Eloquent a partir del esquema de la base de datos.
- Laravel Breeze: Sistema de autenticación rápido y liviano.

**Herramientas de Desarrollo:**
- Visual Studio Code (IDE principal)
- GitHub Desktop (control de versiones)
- MySQL Workbench (modelado y gestión de base de datos)
- XAMPP (servidor local para PHP y MySQL)
- Composer 2.8.11 (gestor de dependencias PHP)
- Node.js y NPM (para Vite y dependencias front-end)

## Características Principales

- Sistema de autenticación (registro, inicio y cierre de sesión)
- CRUD completo de productos
- CRUD de categorías de productos
- CRUD de usuarios
- Panel de administración (Dashboard)
- Interfaz limpia y adaptable
- Conexión directa con base de datos MySQL
- Código estructurado bajo el patrón MVC (Modelo–Vista–Controlador)

## Guía de Instalación

### 1. Clonar el repositorio
```
git clone https://github.com/tu-usuario/miscelanea.git
cd miscelanea
```

### 2. Instalar dependencias de PHP (Composer)
```
composer install
```

### 3. Instalar dependencias de Node.js (para Vite y frontend)
```
npm install
```

### 4. Configurar el entorno
```
cp .env.example .env
```
Luego, configure su conexión a la base de datos en el archivo `.env`:

```
APP_NAME="Miscelanea"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=miscelanea
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generar la clave de la aplicación
```
php artisan key:generate
```

### 6. Ejecutar migraciones
```
php artisan migrate
```

### 7. Compilar los recursos front-end con Vite
```
npm run dev
```

### 8. Iniciar el servidor local de Laravel
```
php artisan serve
```
El proyecto estará disponible en:
```
http://localhost:8000
```

## Recomendaciones

- Asegúrese de que los puertos 3306 (MySQL) y 8000 (PHP Artisan) estén disponibles.
- En caso de errores de caché o dependencias:
```
composer dump-autoload
php artisan optimize:clear
```
- Para generar los recursos en modo producción:
```
npm run build
```

## Licencia

Este proyecto fue desarrollado con fines académicos y de práctica profesional dentro del marco del curso de Calidad de Software. Puede modificarse o adaptarse libremente citando al autor original.

## Autor

**Javier Coba C.**  
Desarrollador Backend y Full Stack en formación  
Correo electrónico: javi2005coba@gmail.com  
Colombia

## Estado del Proyecto

En desarrollo activo  
Última actualización: Octubre 2025  
Versión: 1.0.0

## Integración Continua (CI/CD)

El proyecto incluye configuración para SonarCloud mediante GitHub Actions (archivo `.github/workflows/sonarcloud.yml`), utilizada para el análisis de calidad del código, métricas de cobertura y revisión automatizada de buenas prácticas en desarrollo.
