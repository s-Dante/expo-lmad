[🏠 Inicio](../README.md) / [⚙️ Setup]

# Configuración del Entorno (Setup)

Este documento detalla los pasos seguidos para la creación del proyecto y el flujo de trabajo para nuevos desarrolladores.

## 📋 Requisitos Previos
Antes de comenzar, asegúrate de tener instalado:
* **XAMPP** (con PHP 8.2+).
* **Composer** (Última versión estable).
* **Node.js v24** y npm.
* **Git**.

---

## 🛠 1. Historial de Creación (Referencia)
Para fines de documentacion, así se inicializó el proyecto base:
1. `composer global require laravel/installer`
2. `laravel new expo-lmad`
   - **Starter Kit:** Ninguno (Clean install).
   - **Testing Framework:** Pest.
   - **Laravel Boost:** No.
   - **DB Engine:** MySQL.
3. `npm install && npm run build`

---

## 🚀 2. Instalación para Desarrolladores
Sigue estos pasos para levantar el proyecto en tu máquina local:

### Paso 1: Clonar el repositorio
```bash
git clone <url-del-repo>
cd expo-lmad
```

### Paso 2: Inicializacion automatica
Se creo un comando de Composer para automatizar el setup (instalación de dependencias, copiado de .env, generación de llave y migración):

```bash
composer run setup-dev
```

### Paso 3: Configuracion de la BD
El comando anterior intentará configurar la base de datos. Si falla, verifica tu archivo `.env`:

<ul>
    <li>Asegúrate de que `DB_DATABASE` coincida con el nombre de tu esquema en MySQL (XAMPP).</li>
    <li>Si cambias algo en el .env, corre: php artisan migrate:fresh --seed.</li>
</ul>

### Paso 4: Compilacion de assets
Este paso no es del todo necesario pues el script de composer del *Paso 2* lo hace, sin embargo i por alguna razon llegase a ser requerido el volver a hacerlo solo es cuestion de correr los comandos:

```bash
npm install
npm run dev
```

---

## ⚒️ Comandos utiles

<ul>
    <li>`php artisan serve`: Levantar el servidor local.</li>
    <li>`npm run build`: Compilar assets para "producción" local.</li>
    <li>`php artisan migrate:fresh`: Limpiar y reconstruir la base de datos (Usar solo en desarrollo).<li>
</ul>
