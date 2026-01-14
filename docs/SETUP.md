[🏠 Inicio](../README.md) / [⚙️ Setup]

# Configuración del Entorno (Setup)

Este documento describe los pasos para crear el proyecto y el flujo de trabajo recomendado para nuevos desarrolladores.

---

## 📋 Requisitos previos

Antes de comenzar, asegúrate de tener instalado:

* **XAMPP** (con **PHP 8.2+**).
* **Composer** (última versión estable).
* **Node.js v24** y **npm**.
* **Git**.

---

## 🛠️ 1. Historial de creación (referencia)

> Esta sección es solo informativa y documenta cómo se inicializó el proyecto base.

1. Instalación del instalador de Laravel:

   ```bash
   composer global require laravel/installer
   ```
2. Creación del proyecto:

   ```bash
   laravel new expo-lmad
   ```

   * **Starter Kit:** Ninguno (instalación limpia).
   * **Testing Framework:** Pest.
   * **Laravel Boost:** No.
   * **Motor de base de datos:** MySQL.
3. Instalación y compilación inicial de dependencias frontend:

   ```bash
   npm install && npm run build
   ```

---

## 🚀 2. Instalación para desarrolladores

Sigue estos pasos para levantar el proyecto en tu entorno local.

### Paso 1: Clonar el repositorio

```bash
git clone https://github.com/s-Dante/expo-lmad.git
cd expo-lmad
```

### Paso 2: Inicialización automática

Se creó un comando de Composer para automatizar el setup del proyecto (instalación de dependencias, copia del archivo `.env`, generación de la llave de la aplicación y migraciones):

```bash
composer run setup-dev
```

### Paso 3: Configuración de la base de datos

El comando anterior intentará configurar la base de datos automáticamente. Si ocurre algún error, revisa tu archivo `.env`:

* Verifica que `DB_DATABASE` coincida con el nombre de tu base de datos en MySQL (XAMPP).
* Si realizas cambios en el archivo `.env`, ejecuta nuevamente:

  ```bash
  php artisan migrate:fresh --seed
  ```

### Paso 4: Compilación de assets

Este paso normalmente **no es necesario**, ya que el script del *Paso 2* lo realiza automáticamente. Sin embargo, si necesitas recompilar los assets manualmente, ejecuta:

```bash
npm install
npm run dev
```

---

## ⚒️ Comandos útiles

* `php artisan serve` — Levanta el servidor de desarrollo local.
* `npm run build` — Compila los assets para un entorno de "producción" local.
* `php artisan migrate:fresh` — Limpia y reconstruye la base de datos (**usar solo en desarrollo**).


---

[🏠 Volver al inicio](../README.md)