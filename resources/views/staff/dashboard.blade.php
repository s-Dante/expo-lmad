<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
</head>
<body>

    <h1>Este es el dashoboard del staff</h1>
    <p>Bienvenido {{ Auth::user()->nombre }}</p>
    <p>Correo {{ Auth::user()->email }}</p>
    
</body>
</html>