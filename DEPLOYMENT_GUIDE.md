# Guía de Despliegue CinefilosAPP

## ⚠️ IMPORTANTE: Repositorio Monorepo
Tu proyecto tiene ambas carpetas (frontend y backend) en el mismo repositorio. Esta configuración ya está optimizada para esto.

## Despliegue del Frontend en Vercel

### Prerequisitos
1. Cuenta en [Vercel](https://vercel.com)
2. Repositorio en GitHub con el código

### Pasos para desplegar:

1. **Conectar el repositorio:**
   - Ve a [vercel.com](https://vercel.com)
   - Haz clic en "New Project"
   - Conecta tu repositorio de GitHub completo

2. **Configuración del proyecto (MUY IMPORTANTE):**
   - **Root Directory:** Déjalo vacío (usar la raíz del repositorio)
   - **Framework Preset:** Other (no selecciones Angular)
   - **Build Command:** `npm run build` (Vercel detectará automáticamente el package.json de la raíz)
   - **Output Directory:** `frontend-angular/dist/frontend-angular`
   - **Install Command:** `npm install` (automático)

3. **Variables de entorno (DESPUÉS del primer deploy):**
   - En el dashboard de Vercel, ve a Settings > Environment Variables
   - Agrega: `NODE_ENV` = `production`

4. **Deploy:**
   - Haz clic en "Deploy"
   - Vercel automáticamente detectará los cambios en tu rama principal

## Despliegue del Backend Laravel

### Opción 1: Railway (Recomendado)

1. **Crear cuenta en Railway:**
   - Ve a [railway.app](https://railway.app)
   - Conecta tu cuenta de GitHub

2. **Crear nuevo proyecto:**
   - Selecciona "Deploy from GitHub repo"
   - Elige tu repositorio completo
   - **Root Path:** `backend-laravel` (MUY IMPORTANTE)
   - Railway detectará automáticamente que es Laravel

3. **Configurar variables de entorno:**
   ```
   APP_NAME=CinefilosAPP
   APP_ENV=production
   APP_KEY=base64:tu_app_key_aqui
   APP_DEBUG=false
   APP_URL=https://tu-proyecto.railway.app
   
   DB_CONNECTION=mysql
   DB_HOST=tu_host_de_bd
   DB_PORT=3306
   DB_DATABASE=tu_bd
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_password
   
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=tu_email@gmail.com
   MAIL_PASSWORD=tu_app_password
   MAIL_ENCRYPTION=tls
   
   FRONTEND_URL=https://tu-frontend.vercel.app
   ```

4. **Configurar base de datos:**
   - Railway incluye PostgreSQL gratuito
   - O conecta una base de datos MySQL externa

### Opción 2: Heroku

1. **Instalar Heroku CLI**
2. **Preparar el proyecto:**
   ```bash
   cd backend-laravel
   echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile
   ```
3. **Crear aplicación:**
   ```bash
   heroku create tu-app-name
   heroku addons:create cleardb:ignite
   heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)
   ```

## Configuración CORS

Asegúrate de que tu backend Laravel tenga configurado CORS para aceptar peticiones desde tu dominio de Vercel:

En `config/cors.php`:
```php
'allowed_origins' => [
    'https://tu-frontend.vercel.app',
    'http://localhost:4200', // para desarrollo
],
```

## URLs de Producción

Una vez desplegado, actualiza el archivo `environment.prod.ts` con la URL real de tu backend:

```typescript
export const environment = {
  production: true,
  apiUrl: 'https://tu-backend.railway.app/api'
};
```

## Comandos útiles

### Para el frontend:
```bash
# Instalar dependencias
npm install

# Construir para producción
npm run build:vercel

# Servir localmente
npm start
```

### Para el backend:
```bash
# Instalar dependencias
composer install

# Generar key de aplicación
php artisan key:generate

# Migrar base de datos
php artisan migrate

# Seed de datos iniciales
php artisan db:seed
```

## Notas importantes

1. **Seguridad:** Nunca expongas las credenciales de base de datos o API keys en el código
2. **HTTPS:** Ambos servicios (frontend y backend) deben usar HTTPS en producción
3. **Dominio personalizado:** Puedes configurar un dominio personalizado tanto en Vercel como en Railway
4. **Monitoreo:** Configura logs y monitoreo para detectar errores en producción

## Troubleshooting

### Error de CORS:
- Verifica la configuración de CORS en Laravel
- Asegúrate de que las URLs estén correctas

### Error 404 en rutas:
- Verifica que el archivo `vercel.json` esté configurado correctamente
- Asegúrate de que Angular esté configurado para usar el historial HTML5

### Errores de base de datos:
- Verifica las credenciales de conexión
- Ejecuta las migraciones en producción
