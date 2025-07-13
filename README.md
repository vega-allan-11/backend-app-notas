
## Requisitos para correr el backend

- [Git](https://git-scm.com/downloads)
- [Composer](https://getcomposer.org/download/)
- [PHP](https://www.php.net/downloads.php) >= 7.3
- [Node.js y npm](https://nodejs.org/en/download/) 
- [Laravel](https://laravel.com/docs/installation) v.12

## Instalación y configuración

### 1. Clonar este repositorio

### 2. Instalar dependencias
- composer install
- npm install
- npm run build

### 3. preparar el environment
- cp .env.example .env
- php artisan key:generate
- php artisan migrate

### 4. Ejecutar servidor
- php artisan serve --host=##.##.##.## --port=8000
  (Donde estan los numerales # poner la IP de tu PC). Para que funcione las llamadas a la API desde el celular
