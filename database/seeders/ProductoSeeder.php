<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['nombre' => 'Cocido', 'precio' => 5000],
            ['nombre' => 'Chipa', 'precio' => 10000],
            ['nombre' => 'Mbejú', 'precio' => 3000],
            ['nombre' => 'Sopa paraguaya', 'precio' => 8000],
            ['nombre' => 'Tereré', 'precio' => 6000],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}