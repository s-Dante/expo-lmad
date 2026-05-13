# Guía de Despliegue — Expo LMAD

---

## 1. Lo que necesitas recibir

| Archivo | Descripción |
|---|---|
| `expo-lmad-codigo.zip` | Código fuente del proyecto (sin .git, vendor ni node_modules) |
| `expo_lmad_bd_FECHA.sql` | Dump completo de la base de datos |
| `storage_backup_FECHA.zip` | Imágenes y archivos subidos por usuarios |
| `.env.server` | Variables de entorno pre-configuradas para el servidor |

---

## 2. Requisitos del servidor

- **PHP 8.2 o superior** con las extensiones:
  `bcmath, ctype, curl, dom, fileinfo, gd, json, mbstring, openssl, pcre, pdo, pdo_mysql, tokenizer, xml, zip`
- **MySQL 8.0+** o **MariaDB 10.6+** (Preferiblemente MySQL 8.0+)
- **Composer 2.x**
- **Node.js 18+** y **npm**
- **Apache 2.4+** o **Nginx** configurado para apuntar al directorio `public/`

---

## 3. Pasos de instalación

### 3.1 Descomprimir el código
```bash
unzip expo-lmad-codigo.zip -d /var/www/expo-lmad
cd /var/www/expo-lmad
```

### 3.2 Instalar dependencias PHP
```bash
composer install --no-dev --optimize-autoloader
```

### 3.3 Instalar dependencias JS y compilar assets
```bash
npm install
npm run build
```

### 3.4 Configurar variables de entorno
```bash
cp .env.server .env
# Editar .env con los datos del servidor (ver Sección 4)
```

### 3.5 Generar clave de aplicación
```bash
php artisan key:generate
```

### 3.6 Crear la base de datos e importar datos
```sql
CREATE DATABASE expo_lmad CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
```bash
mysql -u USUARIO -p expo_lmad < expo_lmad_bd_FECHA.sql
```

### 3.7 Crear enlace simbólico de storage
```bash
php artisan storage:link
```

### 3.8 Copiar archivos de imágenes
```bash
unzip storage_backup_FECHA.zip -d /tmp/storage_backup
cp -r /tmp/storage_backup/storage/* storage/app/public/
```

### 3.9 Ajustar permisos
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
# (Reemplazar www-data por el usuario de Apache/Nginx en el servidor)
```

### 3.10 Verificar instalación
```bash
php artisan about
php artisan route:list | head -20
```

---

## 4. Variables de entorno (.env)

```env
APP_NAME="Expo LMAD"
APP_ENV=production
APP_KEY=          ← Se genera con php artisan key:generate
APP_DEBUG=false
APP_URL=http://TU-DOMINIO-O-IP

LOG_CHANNEL=stack
LOG_LEVEL=error

# ── Base de datos ─────────────────────────────────────
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expo_lmad
DB_USERNAME=TU_USUARIO_MYSQL
DB_PASSWORD=TU_PASSWORD_MYSQL

# ── Sesiones y caché ──────────────────────────────────
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file

# ── Storage de imágenes (local, sin S3) ──────────────
FILESYSTEM_DISK=public
MEDIA_DRIVER=local
# No se necesita ninguna variable AWS_* en servidor local

# ── Correo electrónico ────────────────────────────────
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=tu-correo@gmail.com
MAIL_PASSWORD="tu-app-password-de-gmail"
MAIL_FROM_ADDRESS=tu-correo@gmail.com
MAIL_FROM_NAME="EXPO LMAD"

# ── API externa (opcional) ────────────────────────────
EXTERNAL_API_TOKEN=un-token-secreto-largo

VITE_APP_NAME="${APP_NAME}"
```

> **Nota sobre el correo Gmail:** Necesitas crear una "Contraseña de aplicación" en tu cuenta Google:
> Cuenta Google → Seguridad → Verificación en 2 pasos (activar) → Contraseñas de aplicación → Generar

---

## 5. Configuración del servidor web

### Apache (`.htaccess` ya está incluido en `/public`)
```apache
<VirtualHost *:80>
    ServerName tu-dominio.com
    DocumentRoot /var/www/expo-lmad/public

    <Directory /var/www/expo-lmad/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/expo-lmad-error.log
    CustomLog ${APACHE_LOG_DIR}/expo-lmad-access.log combined
</VirtualHost>
```
Activar mod_rewrite: `a2enmod rewrite && systemctl restart apache2`

### Nginx
```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /var/www/expo-lmad/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

## 6. Usuarios administradores por defecto

Tras importar el SQL, los usuarios administradores ya estarán en la base de datos con sus contraseñas.

Si necesitas crear usuarios desde cero:
```bash
php artisan db:seed --class=UserSeeder --force
```
