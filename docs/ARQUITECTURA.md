[🏠 Inicio](../README.md) / [🏗️ Arquitectura]

# Arquitectura y Estructura del Sistema

Este proyecto sigue el patrón **MVC (Modelo–Vista–Controlador)** reforzado con una **Capa de Servicios** y **Repositorios**, con el objetivo de mantener un código modular, escalable y fácil de mantener.

---

## 🏗️ Diagrama de flujo de datos

El flujo de una petición dentro del sistema sigue el siguiente orden **estricto**:

```
Ruta
  → Request (validación)
    → Controlador
      → Servicio (lógica de negocio)
        → Repositorio (acceso a datos)
          → Vista
```

Este flujo garantiza la separación de responsabilidades y evita la mezcla de lógica entre capas.

---

## 📁 Estructura principal de carpetas

### 1. Backend (`app/`)

Para mantener el orden y la claridad, la lógica de negocio se separa de la infraestructura propia de Laravel.

* **`app/Http/Controllers/`**
  Controladores *skinny*. Solo reciben la petición y delegan la lógica al servicio correspondiente.

* **`app/Http/Requests/`**
  Clases de validación. **Ningún controlador debe validar datos manualmente**.

* **`app/Models/`**
  Modelos Eloquent. Contienen relaciones, scopes y accessors.

* **`app/Services/`** *(Capa de lógica)*
  Aquí vive el *qué hace* el sistema.
  *Ejemplo:* `InscribirEstudianteService.php`.

* **`app/Repositories/`** *(Capa de datos)*
  Aquí vive el *cómo se guarda*.
  **Solo en esta capa se realizan consultas a la base de datos**.

---

### 2. Base de datos (`database/`)

* **`migrations/`**
  Definición de tablas y cambios de esquema.
  🚫 Prohibido hacer cambios manuales en la base de datos; todo debe hacerse mediante migraciones.

* **`seeders/`**
  Datos iniciales y de prueba.

* **`factories/`**
  Generadores de datos aleatorios para pruebas y testing.

---

### 3. Frontend y assets (`resources/`)

Para mantener coherencia entre vistas y estilos, se utiliza una **convención de nombres espejo**.

* **`views/`**
  Archivos `.blade.php` organizados por módulos.
  *Ejemplos:* `admin/`, `estudiante/`, `invitado/`.

* **`css/`** y **`js/`**
  Archivos específicos por vista, siguiendo la misma estructura de carpetas que `views/`.

**Convención:**
Si la vista es:

```
resources/views/admin/lista-proyectos.blade.php
```

Su CSS correspondiente debe ser:

```
resources/css/admin/lista-proyectos.css
```

* Se deben utilizar **componentes Blade** (`<x-layout>`, `<x-navbar>`, etc.) para evitar duplicación de HTML.

---

## 📜 Reglas de oro de la arquitectura

* **Controladores delgados**
  Un método de controlador no debe exceder **5–10 líneas**.

* **No consultas en vistas**
  Las vistas solo muestran datos. Nunca deben ejecutar consultas como `Model::all()`.

* **Encapsulamiento**
  Si una lógica de base de datos se reutiliza en más de un lugar, **debe vivir en un repositorio**.
w
---

[🏠 Volver al inicio](../README.md)
