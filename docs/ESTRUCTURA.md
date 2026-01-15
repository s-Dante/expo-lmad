[🏠 Inicio](../README.md) / [🧬 Estructura]

# Estructura del Proyecto


En este documento se describe la estructura del proyecto y lo que se espera en cada parte de este

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/           # Gestión de eventos, profesores, staff
│   │   ├── Student/         # QR, Proyectos, Edición
│   │   ├── Teacher/         # Generar asiento de proyectos, Edicion de proyectos
│   │   ├── Staff/           # Escaneo de QR, Asistencias
│   │   ├── SuperAdmin/      # Gestión total, Auditoría de proyectos
│   │   └── Auth/            # Login/Logout
│   └── Requests/            # Validaciones (FormRequests)
├── Models/                  # Modelos con Accessors, Mutators y Scopes
├── Repositories/            # Lógica de base de datos (Eloquent)
└── Services/                # Lógica de negocio compleja (Ej: Procesamiento de QR)
resources/
├── css/
│   ├── pages/               # CSS específico por vista compleja (Basicamente estructura de carpetas como en views/)
│   └── app.css              # Tailwind base  (Basicamente estructura de carpetas como en views/)
└── views/
    ├── layouts/             # app.blade.php y otros
    ├── components/          # <x-button />, <x-card />
    ├── admin/               # Vistas del rol Admin
    ├── student/             # Vistas del rol Estudiante
    ├── staff/               # Vistas del rol Staff
    ├── superadmin/          # Vistas del rol SuperAdmin
    └── guest/               # Landing, Portfolio, Mapa (Público)
```


Agregar explicacion de lo que se espera que este dentro de cada apartado