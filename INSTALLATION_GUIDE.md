# Guía de Instalación del Proyecto

Este documento describe los pasos necesarios para instalar y configurar el proyecto en tu máquina local.

## Requisitos Previos

1. **Sistema Operativo**: Windows, macOS o Linux.
2. **PHP**: Versión 8.1 o superior.
3. **Composer**: Administrador de dependencias para PHP.
4. **Node.js**: Versión 16 o superior.
5. **SQLite**: Base de datos utilizada por el proyecto.
6. **Git**: Para clonar el repositorio.

## Pasos de Instalación

### 1. Clonar el Repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
cd <NOMBRE_DEL_PROYECTO>
```

### 2. Instalar Dependencias de PHP

Ejecuta el siguiente comando para instalar las dependencias de PHP:

```bash
composer install
```

### 3. Instalar Dependencias de Node.js

Ejecuta el siguiente comando para instalar las dependencias de Node.js:

```bash
npm install
```

### 4. Configurar el Archivo `.env`

Copia el archivo `.env.example` y renómbralo como `.env`:

```bash
cp .env.example .env
```

Edita el archivo `.env` para configurar las variables de entorno según tus necesidades. Asegúrate de configurar la conexión a la base de datos SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database.sqlite
```

### 5. Crear la Base de Datos

Crea un archivo `database.sqlite` en la carpeta `database`:

```bash
touch database/database.sqlite
```

### 6. Ejecutar Migraciones y Seeders

Ejecuta las migraciones para crear las tablas en la base de datos:

```bash
php artisan migrate
```

Ejecuta los seeders para poblar la base de datos con datos iniciales:

```bash
php artisan db:seed
```

### 7. Compilar Recursos Frontend

Compila los recursos frontend utilizando Vite:

```bash
npm run dev
```

### 8. Iniciar el Servidor

Inicia el servidor de desarrollo:

```bash
php artisan serve
```

Accede al proyecto en tu navegador en la dirección `http://127.0.0.1:8000`.

## Comandos Útiles

- **Iniciar el servidor completo**:
  ```bash
  composer dev
  ```
- **Ejecutar pruebas**:
  ```bash
  php artisan test
  ```
- **Compilar para producción**:
  ```bash
  npm run build
  ```

## Notas

- Asegúrate de tener todas las dependencias instaladas antes de ejecutar el proyecto.
- Si encuentras algún problema, revisa los logs en la carpeta `storage/logs`.

---

¡Disfruta trabajando con el proyecto!
