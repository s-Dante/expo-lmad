[🏠 Inicio](../README.md) / [📏 Convenciones]

# Convenciones del Proyecto

Para mantener la calidad, legibilidad y consistencia del código en **Pag EXPO-LMAD**, todos los desarrolladores deben seguir las siguientes convenciones.

---

## 🌳 1. Git Flow simplificado

Utilizamos un flujo de trabajo basado en ramas para organizar el desarrollo y evitar conflictos.

* **`main`**: Rama de producción. Contiene únicamente código estable y desplegable.
* **`develop`**: Rama de integración. Aquí se combinan las funcionalidades ya terminadas.
* **`feature/[nombre]/[tarea]`**: Ramas temporales para el desarrollo de nuevas funcionalidades.

  * *Ejemplo:* `feature/juan/registro-estudiantes`
* **`release`**: Rama opcional para preparación de despliegue y pruebas finales.

**A TOMAR EN CUENTA:**
Nunca se debe hacer commit directo a `main` ni a `develop`. Todo cambio debe pasar por un **Pull Request (PR)**.

---

## 💬 2. Mensajes de commit

Usamos el estándar **Conventional Commits**, lo que permite un historial claro, consistente y automatizable.

**Formato:**

```
<tipo>: <descripción en minúsculas>
```

### Tipos permitidos

* `feat:` Nueva funcionalidad.
* `fix:` Corrección de errores.
* `docs:` Cambios en documentación.
* `style:` Cambios de formato (espacios, indentación, puntos y coma) que no afectan la lógica.
* `refactor:` Refactorización de código sin agregar funcionalidades ni corregir errores.

> 💡 **Tip:** Se recomienda instalar la extensión de VS Code: **Conventional Commits** para facilitar la escritura de mensajes consistentes.

---

## 💻 3. Estándares de código (PHP 8.2+)

### Tipado estricto

Todo archivo PHP debe comenzar obligatoriamente con la declaración de tipos estrictos para prevenir errores de lógica.

```php
<?php

declare(strict_types=1);

namespace App\Services;
```

### Nombrado (naming)

Para evitar conflictos con caracteres especiales (ñ, acentos), se establecen las siguientes reglas:

* **Clases y archivos:** `PascalCase` en español
  *Ejemplos:* `UsuarioRepository.php`, `ProyectoService.php`
* **Métodos y variables:** `camelCase` en español
  *Ejemplos:* `obtenerListado()`, `$usuarioId`
* **Tablas de base de datos:** `snake_case` en plural
  *Ejemplos:* `usuarios`, `proyectos_estudiantes`
* **Vistas:** `kebab-case`
  *Ejemplo:* `lista-proyectos.blade.php`

---

## 🏗️ 4. Estructura de clases

Cada clase debe cumplir con el **Principio de Responsabilidad Única (SRP)**.

* **Controladores:**

  * No deberá de ser muy largo.
  * No contienen lógica de negocio.
  * Solo delegan llamadas a servicios o repositorios.

* **Repositorios:**

  * Encargados exclusivamente del acceso a datos.
  * Contienen consultas Eloquent o interacciones con la base de datos.

* **Servicios:**

  * Contienen la lógica de negocio.
  * Manejan cálculos, validaciones complejas y procesos externos.

---

[🏠 Volver al inicio](../README.md)
