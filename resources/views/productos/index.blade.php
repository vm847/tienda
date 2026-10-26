<!DOCTYPE html>
<html lang="es">
<head> 
<meta charset="UTF-8">
 <title>Productos</title>
</head>
<body> 
    <h1>Lista de productos</h1> 
    <ul> 
        @foreach ($productos as $producto) 
            <li> {{ $producto->nombre }} - Gs. {{ number_format($producto->precio, 0, ',', '.') }} 
            </li> 
        @endforeach 
    </ul>
</body>
</html>