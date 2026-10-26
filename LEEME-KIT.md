# Kit Laravel + Docker — empezar de cero

Todo se hace en la terminal de **Ubuntu (WSL)**. No hace falta tener PHP, Composer ni MySQL instalados.

## Antes de empezar
- Docker Desktop abierto y en *Engine running*.
- `docker run hello-world` funciona.
- Los puertos 8080 y 3308 libres: si tenés otro proyecto levantado, `docker compose down` en esa carpeta.

## Paso 1 · Preparar la carpeta y el kit
```bash
mkdir -p ~/proyectos
cd ~/proyectos
cp /mnt/c/Users/TU_USUARIO/Downloads/kit-laravel.zip .
unzip kit-laravel.zip
```
(Si dice `unzip: command not found`: `sudo apt update && sudo apt install -y unzip`)

## Paso 2 · Crear un Laravel nuevo (sin PHP instalado)
```bash
cd ~/proyectos
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd)":/app -w /app composer:2 create-project laravel/laravel tienda
cd tienda
```

## Paso 3 · Copiar el kit dentro del proyecto
```bash
cp -r ~/proyectos/kit-laravel/. .
ls -a
```

## Paso 4 · Configurar la base en el .env
```bash
sed -i '/^#\? *DB_/d' .env
cat env-docker.txt >> .env
grep DB_ .env
```

## Paso 5 · Levantar
```bash
docker compose up -d --build
docker compose ps
chmod -R 777 storage bootstrap/cache
```

## Paso 6 · Crear las tablas (esperar ~30 s a que arranque MySQL)
```bash
docker compose exec app php artisan migrate
```

## Paso 7 · Probar
- Navegador: http://localhost:8080
- SQLyog: host `127.0.0.1`, puerto `3308`, usuario `root`, clave `secreto`, base `laravel`

## Día a día
| Antes (XAMPP) | Ahora (Docker) |
| --- | --- |
| `php artisan migrate` | `docker compose exec app php artisan migrate` |
| `php artisan make:model Producto -mcrs` | `docker compose exec app php artisan make:model Producto -mcrs` |
| `php artisan db:seed` | `docker compose exec app php artisan db:seed` |
| `composer require paquete` | `docker compose exec app composer require paquete` |

Archivos creados con artisan quedan a nombre de root: `sudo chown -R $USER:$USER .`

Volver otro día: `cd ~/proyectos/tienda` y `docker compose up -d` · Apagar: `docker compose down`

## Si algo falla
| Síntoma | Solución |
| --- | --- |
| Error 500 / `Permission denied` | `chmod -R 777 storage bootstrap/cache` |
| `Connection refused` / `[2002]` al migrar | MySQL todavía arranca: esperar 30 s y repetir |
| El contenedor `db` se reinicia | Revisar `DB_PASSWORD=secreto` en el `.env` |
| `port is already allocated` | `docker ps` y `docker rm -f NOMBRE`, o `docker compose down` en la otra carpeta |
| `Composer detected issues in your platform` | En el Dockerfile cambiar `php:8.4-apache` por `php:8.5-apache` y `docker compose up -d --build` |
| `No application encryption key` | `docker compose exec app php artisan key:generate` |
