# Proyecto Fútbol (PHP)

Una aplicación web sencilla desarrollada en PHP para gestionar y mostrar información sobre equipos de fútbol y sus partidos, siguiendo una arquitectura DAO.

---

## Tabla de Contenidos
- [Descripción](#descripción)
- [Características Principales](#características-principales)
- [Stack Tecnológico](#stack-tecnológico)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Guía de Instalación y Puesta en Marcha](#guía-de-instalación-y-puesta-en-marcha)
  - [1. Prerrequisitos](#1-prerrequisitos)
  - [2. Obtener el Código](#2-obtener-el-código)
  - [3. Configuración de la Base de Datos](#3-configuración-de-la-base-de-datos)
  - [4. Configuración de Credenciales](#4-configuración-de-credenciales)
  - [5. Ejecutar la Aplicación](#5-ejecutar-la-aplicación)

---

## Descripción

Este proyecto es una aplicación web que permite consultar una base de datos de fútbol. Muestra listas de equipos y los partidos programados, utilizando una arquitectura PHP estructurada con un patrón de diseño DAO (Data Access Object) para la persistencia de datos.

La aplicación se encarga de conectar con una base de datos MySQL para obtener y mostrar una lista de todos los equipos y partidos. El frontend está construido con Bootstrap 5, lo que la hace responsiva y visualmente limpia.

---

## Características Principales

- **Listado de Equipos:** Muestra información clave de los equipos (nombre, ciudad, año, estadio).
- **Listado de Partidos:** Muestra los detalles de cada partido (equipos, fecha, resultado).
- **Arquitectura DAO:** Separa la lógica de negocio de la lógica de acceso a datos.
- **Gestión de Conexión:** Utiliza un PersistentManager para gestionar la conexión a la BD.

---

## Stack Tecnológico

- **Backend:** PHP (Programación Orientada a Objetos)
- **Frontend:** HTML, CSS, Bootstrap 5
- **Base de Datos:** MySQL
- **Patrón de Diseño:** DAO (Data Access Object)

---

## Estructura del Proyecto

```
├── app/
│   ├── Equipos.php         # Modelo (POPO) para los Equipos
│   ├── Partidos.php        # Modelo (POPO) para los Partidos
│   └── PartidosEquipo.php  # Modelo/ViewModel para vistas combinadas
├── assets/
│   ├── bootstrap/          # Archivos CSS y JS de Bootstrap
│   └── images/
│       └── ball_icon.png   # Icono de la aplicación
├── persistence/
│   ├── conf/
│   │   ├── PersistentManager.php # Gestiona la conexión a la BD
│   │   └── credentials.json      # (Importante) Credenciales de la BD
│   ├── DAO/
│   │   ├── EquipoDAO.php       # DAO para la entidad Equipo
│   │   ├── GenericDAO.php      # Clase DAO genérica (base)
│   │   └── PartidoDAO.php      # DAO para la entidad Partido
│   └── scripts/
│       └── query_futbol_db.sql # Script SQL para crear la BD y tablas
├── templates/
│   ├── footer.php          # Pie de página HTML
│   └── header.php          # Cabecera HTML (incluye assets)
├── utils/
│   └── GestorSesion.php    # Clase de utilidad para manejar sesiones
└── index.php               # Punto de entrada principal de la aplicación
```

---

## Guía de Instalación y Puesta en Marcha

Sigue estos pasos para configurar y ejecutar el proyecto en tu entorno de desarrollo local.

### 1. Prerrequisitos

Asegúrate de tener instalado el siguiente software en tu sistema:

- Un entorno de desarrollo PHP completo.

  **Recomendado:** XAMPP, WAMP (para Windows), MAMP (para macOS) o un setup manual que incluya:
  - Servidor Web (Apache o Nginx)
  - PHP 7.4 o superior
  - Servidor de Base de Datos (MySQL o MariaDB)

- Un cliente de base de datos (Opcional pero recomendado):
  - phpMyAdmin (generalmente incluido en XAMPP/WAMP/MAMP)
  - MySQL Workbench
  - DBeaver

- Un editor de código o IDE:
  - Este proyecto se desarrolló utilizando Visual Studio Code y se recomienda para una mejor experiencia. Sin embargo, se puede utilizar cualquier otro editor o IDE compatible con PHP, como PhpStorm.

---

### 2. Obtener el Código

#### Opción A: Clonar con Git (Recomendado)
Abre una terminal y navega al directorio donde alojarás tus proyectos web (ej. `C:\xampp\htdocs` en XAMPP).
Clona el repositorio:

```bash
# Reemplaza la URL por la URL de tu repositorio
git clone https://github.com/tu_usuario/tu_repositorio.git
cd tu_repositorio
```

#### Opción B: Descarga Manual

1. Descarga el archivo ZIP del repositorio desde GitHub.
2. Descomprímelo en tu directorio de proyectos web (ej. `C:\xampp\htdocs`).
3. Renombra la carpeta si es necesario (ej. a `proyecto-futbol`).

---

### 3. Configuración de la Base de Datos

1. Inicia los servicios de Apache y MySQL desde tu panel de control (ej. XAMPP).
2. Abre tu cliente de base de datos (ej. [http://localhost/phpmyadmin](http://localhost/phpmyadmin)).
3. Crea la BBDD e importa la estructura y los datos ejecutando el script SQL que se encuentra en:  
   `persistence/scripts/query_futbol_db.sql`  
   (En phpMyAdmin, esto se hace desde la pestaña "Importar").

---

### 4. Configuración de Credenciales

La aplicación necesita saber cómo conectarse a tu base de datos.

1. Localiza el archivo: `persistence/conf/credentials.json`.
2. Edita este archivo con las credenciales de tu servidor MySQL local.

```json
{
  "host": "localhost",
  "db": "futbol_db",
  "user": "tu_usuario_mysql",
  "pass": "tu_contraseña_mysql"
}
```

- `"host"`: Déjalo como `"localhost"` o `"127.0.0.1"`.
- `"db"`: El nombre de la base de datos (ej. `futbol_db`).
- `"user"`: Tu usuario de MySQL. (En XAMPP por defecto es `root`).
- `"pass"`: La contraseña de tu usuario de MySQL. (En XAMPP por defecto está vacía: `""`).

---

### 5. Ejecutar la Aplicación

Existen dos formas principales de ejecutar el proyecto:

#### Opción A: Usando un servidor local (XAMPP, WAMP, etc.)

1. Asegúrate de que tu servidor Apache y MySQL estén corriendo.
2. Verifica que la carpeta del proyecto esté dentro del directorio `htdocs` (o `www`).
3. Abre tu navegador y visita:  
   `http://localhost/nombre-de-tu-carpeta/`  
   (Ej: `http://localhost/proyecto-futbol/`)

#### Opción B: Usando el servidor integrado de PHP (Para desarrollo rápido)

1. Abre una terminal y navega hasta la carpeta raíz de tu proyecto.
2. Ejecuta el siguiente comando:

   ```bash
   php -S localhost:8000
   ```

3. Abre tu navegador y visita:  
   [http://localhost:8000](http://localhost:8000)

---

¡Listo! Ahora puedes gestionar y visualizar equipos y partidos de fútbol desde tu aplicación web en PHP.
