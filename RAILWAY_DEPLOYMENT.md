# 🚀 Guía para Desplegar Backend Laravel en Railway

## Paso 1: Preparar el Backend para Producción

### Variables de entorno para Railway:

```bash
APP_NAME=CinefilosAPP
APP_ENV=production
APP_KEY=base64:tu_app_key_aqui
APP_DEBUG=false
APP_URL=https://tu-backend.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password_de_gmail
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME=CinefilosAPP

FRONTEND_URL=https://tu-frontend.vercel.app

CORS_ALLOWED_ORIGINS=https://tu-frontend.vercel.app,http://localhost:4200
```

## Paso 2: Configurar en Railway

1. **Ir a Railway:**
   - railway.app
   - Conectar GitHub

2. **Crear Proyecto:**
   - "New Project" → "Deploy from GitHub repo"
   - Seleccionar tu repositorio
   - **IMPORTANTE:** En "Root Directory" poner `backend-laravel`

3. **Agregar Base de Datos:**
   - En tu proyecto de Railway, hacer clic en "+ New"
   - Seleccionar "Database" → "MySQL"
   - Railway creará automáticamente las variables de entorno

4. **Configurar Variables de Entorno:**
   - Ve a la pestaña "Variables"
   - Agrega todas las variables de arriba
   - La APP_KEY la generaremos después

## Paso 3: Generar APP_KEY

Una vez desplegado, ejecuta en Railway Terminal:
```bash
php artisan key:generate --show
```

Copia el resultado y agrégalo a las variables de entorno.

## Paso 4: Migrar Base de Datos

En Railway Terminal:
```bash
php artisan migrate --force
php artisan db:seed --force
```

## Paso 5: Configurar CORS

El backend ya debería tener CORS configurado, pero verifica que en `config/cors.php` esté:

```php
'allowed_origins' => [
    env('FRONTEND_URL', 'http://localhost:4200'),
    'https://tu-frontend.vercel.app',
],
```

## Paso 6: Actualizar Frontend

Una vez que tengas la URL de Railway, actualiza:

`frontend-angular/src/environments/environment.prod.ts`:
```typescript
export const environment = {
  production: true,
  apiUrl: 'https://tu-backend.railway.app/api'
};
```

¡Y listo! Tu aplicación estará desplegada completamente.
