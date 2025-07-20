# Curso de Desarrollo de Aplicaciones Móviles
### Integrantes del equipo
- Wilfredo Cano
- Reggie Guevara
- Jeremiah Kurmaty
- Daniel Maestre
- Allan Vega

# My Notes
Este proyecto es una **aplicación de notas minimalista** donde su API fue construida por Laravel y se proyectará en Android. Su principal objetivo es permitir a los usuarios **crear notas de forma rápida y sencilla**, sin distracciones, enfocándose en la productividad.

## Funcionalidades
- Crear, editar y eliminar notas
- Marcar notas como favoritas
- Buscar y filtrar notas por contenido
- Interfaz y experiencia centradas en la simplicidad y velocidad
- Login / Registro
- Edición de perfil

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
- (Donde estan los numerales # poner la IP de tu PC). Para que funcione las llamadas a la API desde el celular
