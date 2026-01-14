[🏠 Inicio](../README.md) / [🗄️ Base de Datos]

# Diccionario de Datos, Versionado y Relaciones ER

Este documento amplía la documentación de base de datos de **Pag EXPO-LMAD** e incluye:

* Diccionario de datos **detallado por tabla**.
* Política oficial de **versionado de migraciones**.
* Documentación de **relaciones entidad–relación (ER)**.

---

## 📘 Diccionario de datos detallado

### 🧑‍💻 Módulo de usuarios

#### `tbl_usuarios`

Maneja la autenticación y autorización del sistema.

| Campo                   | Tipo      | Restricciones    | Descripción                                |
| ----------------------- | --------- | ---------------- | ------------------------------------------ |
| id                      | BIGINT    | PK               | Identificador único                        |
| nombre                  | STRING    | NOT NULL         | Nombre(s) del usuario                      |
| apellido_paterno        | STRING    | NOT NULL         | Apellido paterno                           |
| apellido_materno        | STRING    | NOT NULL         | Apellido materno                           |
| correo                  | STRING    | UNIQUE, NOT NULL | Credencial de acceso                       |
| password                | STRING    | NOT NULL         | Hash generado **en PHP** usando `bcrypt`   |
| rol                     | ENUM      | NOT NULL         | master, admin, profesor, estudiante, staff |
| estatus                 | BOOLEAN   | DEFAULT true     | Usuario activo/inactivo                    |
| created_at / updated_at | TIMESTAMP |                  | Control de cambios                         |

---

#### `tbl_estudiantes`

Padrón académico independiente del acceso al sistema.

| Campo              | Tipo      | Restricciones | Descripción               |
| ------------------ | --------- | ------------- | ------------------------- |
| id                 | BIGINT    | PK            | Identificador             |
| matricula          | STRING    | UNIQUE        | Matrícula institucional   |
| nombre             | STRING    | NOT NULL      | Nombre del estudiante     |
| apellido_paterno   | STRING    | NOT NULL      | Apellido paterno          |
| apellido_materno   | STRING    | NULLABLE      | Apellido materno          |
| programa_academico | STRING    | NOT NULL      | Carrera (LMAD, LCC, etc.) |
| semestre           | INTEGER   | NOT NULL      | Semestre actual           |
| id_usuario         | BIGINT    | FK, NULLABLE  | Enlace con tbl_usuarios   |
| deleted_at         | TIMESTAMP | SoftDeletes   | Eliminación lógica        |

---

#### `tbl_profesores`

Catálogo institucional de profesores.

| Campo            | Tipo      | Restricciones | Descripción          |
| ---------------- | --------- | ------------- | -------------------- |
| id               | BIGINT    | PK            | Identificador        |
| numero_empleado  | STRING    | UNIQUE        | Número institucional |
| nombre           | STRING    | NOT NULL      | Nombre               |
| apellido_paterno | STRING    | NOT NULL      | Apellido paterno     |
| apellido_materno | STRING    | NOT NULL      | Apellido materno     |
| correo           | STRING    | NOT NULL      | Correo institucional |
| id_usuario       | BIGINT    | FK, NULLABLE  | Acceso al sistema    |
| deleted_at       | TIMESTAMP | SoftDeletes   |                      |

---

### 🎓 Módulo académico

#### `tbl_planesAcademicos`

| Campo   | Tipo    | Descripción                        |
| ------- | ------- | ---------------------------------- |
| id      | BIGINT  | PK                                 |
| nombre  | STRING  | Identificador del plan (420, 2025) |
| estatus | BOOLEAN | Vigente o no                       |

---

#### `tbl_materias`

| Campo            | Tipo      | Descripción            |
| ---------------- | --------- | ---------------------- |
| id               | BIGINT    | PK                     |
| nombre           | STRING    | Nombre de la materia   |
| semestre         | INTEGER   | Semestre recomendado   |
| id_planAcademico | BIGINT    | FK → planes académicos |
| deleted_at       | TIMESTAMP | SoftDeletes            |

---

### 🚀 Módulo de proyectos

#### `tbl_proyectos`

| Campo                   | Tipo   | Descripción                            |
| ----------------------- | ------ | -------------------------------------- |
| id                      | BIGINT | PK                                     |
| titulo                  | STRING | Editable por alumno                    |
| descripcion             | TEXT   | Información del proyecto               |
| slug                    | STRING | UNIQUE, SEO                            |
| estatus                 | ENUM   | borrador, enviado, aprobado, rechazado |
| codigo_acceso           | STRING | INDEX, token de reclamo                |
| id_materia              | BIGINT | FK                                     |
| id_profesor             | BIGINT | FK                                     |
| periodo_semestral       | STRING | Ej: Ago-Dic 2025                       |
| timestamps / deleted_at |        |                                        |

---

#### `tbl_autoresProyecto`

Tabla pivote alumnos–proyectos.

| Campo       | Tipo    | Descripción           |
| ----------- | ------- | --------------------- |
| id_proyecto | BIGINT  | FK                    |
| id_alumno   | BIGINT  | FK → estudiantes      |
| lider       | BOOLEAN | Responsable principal |

---

#### `tbl_multimediaProyecto`

| Campo       | Tipo    | Descripción                             |
| ----------- | ------- | --------------------------------------- |
| id          | BIGINT  | PK                                      |
| id_proyecto | BIGINT  | FK                                      |
| tipo        | ENUM    | image, youtube, drive, github, document |
| url         | STRING  | Recurso externo                         |
| titulo      | STRING  | Descripción                             |
| portada     | BOOLEAN | Imagen principal                        |

---

### 📅 Módulo de eventos

#### `tbl_conferencistas`

| Campo            | Tipo   | Descripción      |
| ---------------- | ------ | ---------------- |
| id               | BIGINT | PK               |
| nombre           | STRING |                  |
| apellido_paterno | STRING |                  |
| apellido_materno | STRING |                  |
| nickname         | STRING | Nombre artístico |
| bio              | TEXT   |                  |
| empresa          | STRING |                  |
| avatar_url       | STRING |                  |

---

#### `tbl_eventos`

| Campo       | Tipo     | Descripción                 |
| ----------- | -------- | --------------------------- |
| id          | BIGINT   | PK                          |
| titulo      | STRING   |                             |
| slug        | STRING   |                             |
| tipo        | ENUM     | conference, workshop, panel |
| hora_inicio | DATETIME |                             |
| hora_fin    | DATETIME |                             |
| lugar       | STRING   |                             |
| capacidad   | INTEGER  |                             |
| poster      | STRING   | URL                         |

---

#### `tbl_asistenciasEvento`

| Campo         | Tipo      | Descripción  |
| ------------- | --------- | ------------ |
| id            | BIGINT    | PK           |
| id_evento     | BIGINT    | FK           |
| id_estudiante | BIGINT    | NULLABLE     |
| id_visitante  | BIGINT    | NULLABLE     |
| asistencia    | BOOLEAN   | Confirmación |
| registered_at | TIMESTAMP |              |

---

### 🧾 Módulo de visitantes

#### `tbl_visitantes`

| Campo       | Tipo   | Descripción              |
| ----------- | ------ | ------------------------ |
| id          | BIGINT | PK                       |
| uuid        | UUID   | INDEX, QR                |
| tipo        | ENUM   | student_uanl, external   |
| matricula   | STRING | Nullable                 |
| dependencia | STRING | Nullable                 |
| genero      | ENUM   | M, F, NB, X              |
| rango_edad  | ENUM   | 15-18, 19-24, 25-30, 30+ |
| timestamps  |        |                          |

---

### 🤝 Módulo de patrocinadores

#### `tbl_patrocinadores`

| Campo       | Tipo    | Descripción            |
| ----------- | ------- | ---------------------- |
| id          | BIGINT  | PK                     |
| nombre      | STRING  |                        |
| tier        | ENUM    | pro, ultra, superultra |
| logo_url    | STRING  |                        |
| website_url | STRING  |                        |
| contratando | BOOLEAN |                        |

---

## 🔁 Política de versionado de migraciones

1. **Nunca se edita una migración ya compartida**.
2. Todo cambio estructural se hace mediante una **nueva migración incremental**.
3. Las migraciones deben ser:

   * Atómicas (un solo cambio lógico).
   * Reversibles (`down()` obligatorio).
4. `migrate:fresh` solo está permitido en **desarrollo local individual**.
5. Las migraciones en `develop` y `main` deben ser **lineales y acumulativas**.

---

[🏠 Volver al inicio](../README.md)
