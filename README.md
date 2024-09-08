# TwitterDupe - Proyecto de Prueba Técnica

## Descripción

Este proyecto es una prueba técnica que demuestra mis capacidades utilizando PHPy Base de datos Mysql. Consiste en dos servicios, un POST y un PUT.

## Requisitos

Antes de ejecutar el software, asegúrate de tener instalados los siguientes requisitos:

- PHP 8.2.18
- MySql 8.3.0
- MariaDB 11.3.2

Se recompienda descargar wampserver de su página oficial (https://wampserver.aviatechno.net/)

## Instalación

Sigue estos pasos para instalar y configurar el proyecto en tu entorno local.

### 1. Clonar el repositorio dentro de la carpeta wamp64/www

```bash
git clone https://github.com/emilioapa016/kanban.git
```
### 2. Importar la base de datos presente en el archivo kanban.sql

Cuenta con tablas adicionales para su funcionamiento con la versión en Laravel

### 3. Las configuraciones para la BD se encuentran al inicio del archivo boards.php

### 4. La forma de acceder a los servicios es la siguiente:

POST: localhost/kanban/boards
PUT: localhost/kanban/boards/{id}