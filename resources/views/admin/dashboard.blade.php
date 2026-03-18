<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    @vite([
        'resources/css/guest/template.css',
        'resources/css/admin/dashboard.css'
    ]);

</head>

<body>

    <x-sidebar />

    <main>
        <h1>Dashboard</h1>
    </main>    

    <!--
    <h1>Este es el dashoboard del admin</h1>
    <p>Bienvenido {{ Auth::user()->nombre }}</p>
    <p>Correo {{ Auth::user()->email }}</p>
    -->

</body>

</html>