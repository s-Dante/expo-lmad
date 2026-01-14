[🏠 Inicio](../README.md) / [📏 Convenciones]

# Convenciones del Proyecto

Para mantener la calidad y consistencia del código en **Pag EXPO-LMAD**, todos los desarrolladores deben seguir estas reglas.

---

## 🌳 1. Git Flow Simplificado
Utilizaremos un flujo de trabajo basado en ramas para organizar el desarrollo:

* **`main`**: Rama de producción. Solo código estable.
* **`develop`**: Rama de integración. Aquí se mezclan las funcionalidades terminadas.
* **`feature/[nombre]/[tarea]`**: Ramas temporales para nuevas funciones.
    * *Ejemplo:* `feature/juan/registro-estudiantes`
* **`release`**: Rama de preparación para despliegue (opcional, para pruebas finales).

**Regla de Oro:** Nunca se hace commit directo a `main` o `develop`. Todo pasa por un Pull Request (PR).

---

## 💬 2. Mensajes de Commit
Usamos **Conventional Commits**. Esto hace que el historial sea legible y automatizable.

**Formato:** `<tipo>: <descripción en minúsculas>`

* `feat:` Una nueva característica.
* `fix:` Solución a un error.
* `docs:` Cambios en la documentación.
* `style:` Cambios de formato (espacios, puntos y coma) no afectan el código.
* `refactor:` Cambio de código que no corrige error ni añade función.

> 💡 **Tip:** Se recomienda instalar la extensión de VSCode: [Conventional Commits](https://marketplace.visualstudio.com/items?itemName=vivaxy.vscode-conventional-commits).

---

## 💻 3. Estándares de Código (PHP 8.2+)

### Tipado Estricto
Todo archivo PHP debe comenzar obligatoriamente con la declaración de tipos estrictos para evitar errores de lógica:

```php
<?php

declare(strict_types=1);

namespace App\Services;
```

### Nombrado (Naming)
Para evitar conflictos con caracteres especiales (ñ, acentos), seguiremos estas reglas:

<ul>
    <li>Clases y Archivos: `PascalCase` en español (ej: `UsuarioRepository.php`, `ProyectoService.php`).</li>
    <li>Métodos y Variables: `camelCase` en español (ej: `obtenerListado()`, `$usuarioId`).</li>
    <li>Tablas de BD: `snake_case` en plural (ej: `usuarios`, `proyectos_estudiantes`).</li>
    <li>Vistas: `kebab-case` (ej: `lista-proyectos.blade.php`).</li>
</ul>


## 🏗️ 4. Estructura de Clases
Cada clase debe tener una responsabilidad única (SRP).

<ul>
    <li>Controladores: Máximo 3-5 líneas por método. Solo llaman al Repositorio o Servicio.</li>
    <li>Repositorios: Solo consultas a la base de datos (Eloquent).</li>
    <li>Servicios: Lógica de negocio compleja (cálculos, validaciones externas, procesos).</li>
</ul>