<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <h1>Control de despacho</h1>

    <p><b>Hola {{ $grocer['name'] }}</b></p>
    <p>Le fue creado un usuario para el control de despachos el con la siguiente informacion:</p>
    <ul>
        <li>Usuario: {{ $grocer['username'] }}</li>
        <li>Contraseña: {{ $password }}</li>
    </ul>

    <div class="text-center">
        <p>Correo generado automaticamente</p>
    </div>

</body>
</html>
