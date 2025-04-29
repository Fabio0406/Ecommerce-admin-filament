# Sistema de Gestión de Pedidos

Sistema de administración para gestionar pedidos, productos, clientes y proveedores desarrollado con Laravel y Filament.

## Requisitos

- PHP 8.1 o superior
- Composer
- MySQL o MariaDB
- Node.js y NPM

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/tu-usuario/nombre-repositorio.git
cd nombre-repositorio
```

2. Instalar dependencias de PHP:
```bash
composer install
```

3. Instalar dependencias de JavaScript:
```bash
npm install
npm run build
```

4. Copiar el archivo de entorno:
```bash
cp .env.example .env
```

5. Configurar el archivo .env con tus credenciales de base de datos y otras configuraciones.

6. Generar la clave de la aplicación:
```bash
php artisan key:generate
```

7. Ejecutar las migraciones:
```bash
php artisan migrate
```

8. (Opcional) Ejecutar los seeders para datos de prueba:
```bash
php artisan db:seed
```

## Características

- Gestión de pedidos
- Catálogo de productos
- Gestión de clientes
- Gestión de proveedores
- Panel de administración con Filament
- Reportes de ingresos

## Uso

Para iniciar el servidor de desarrollo:
```bash
php artisan serve
```

Acceso al panel de administración:
- URL: http://localhost:8000/admin
- Usuario: admin@example.com
- Contraseña: password (cambiar en producción)

## Estructura del proyecto

- `app/` - Contiene los modelos, controladores y lógica de la aplicación
- `app/Filament/` - Recursos y configuraciones de Filament
- `resources/` - Vistas, archivos CSS/JS y otros recursos
- `database/` - Migraciones y seeders
- `routes/` - Definición de rutas

## Licencia

[MIT](https://opensource.org/licenses/MIT)