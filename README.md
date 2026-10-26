# Tienda

Proyecto Laravel con Docker (PHP 8.4 + Apache y MySQL 8). Lista de productos en guaraníes.

## Levantar el proyecto

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

Si `migrate` dice `Connection refused`, esperá 30 segundos a que arranque MySQL y repetí el comando.

## Direcciones

- Tienda: http://localhost:8080/productos
- phpMyAdmin: http://localhost:8081 (usuario `root`, clave `secreto`)
- MySQL desde SQLyog: `127.0.0.1`, puerto `3308`

## Comandos útiles

```bash
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan route:list
docker compose exec app tail -n 30 storage/logs/laravel.log
docker compose down
```
