# E-Commerce Admin — Panel de gestión de pedidos

Panel de administración para una tienda en línea, construido con **Laravel 12** y **Filament 3**. Permite gestionar pedidos, productos, categorías, clientes y proveedores, y muestra en el tablero los ingresos totales, el estado de los pedidos y los productos más vendidos.

> Proyecto académico — Ingeniería de Software II, UAGRM (2025).

## Funcionalidades

- **Pedidos**: crear, editar, ver detalle (con sus líneas de pedido) y listar.
- **Productos** y **categorías**.
- **Clientes** y **proveedores**.
- **Tablero** con widgets:
  - Ingresos totales
  - Resumen de pedidos
  - Productos más vendidos

## Tecnologías

- PHP 8.2, Laravel 12
- Filament 3 (panel de administración)
- Vite + Tailwind CSS
- SQLite por defecto (también funciona con MySQL / MariaDB)

## Requisitos

- PHP 8.2 o superior
- Composer
- Node.js y npm

## Instalación

```bash
composer install
npm install
npm run build

cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed        # opcional: datos de prueba
```

Para usar MySQL, cambia `DB_CONNECTION` y los datos de conexión en `.env`.

Crear un usuario administrador:

```bash
php artisan make:filament-user
```

## Uso

```bash
php artisan serve
```

Panel de administración: `http://localhost:8000/admin`

## Estructura

```
app/
├── Models/                    # Categoria, Cliente, Pedido, DetallePedido, Producto, Proveedor
├── Filament/Resources/        # CRUD de cada entidad en el panel
│   └── Widgets/               # Ingresos, pedidos y productos más vendidos
└── Providers/Filament/        # Configuración del panel /admin
database/migrations/           # Tablas de la base de datos
routes/                        # Rutas web
```

## Licencia

[MIT](https://opensource.org/licenses/MIT)
