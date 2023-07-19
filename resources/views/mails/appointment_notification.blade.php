<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Asignacion de cita</title>
</head>
<body>
    <p>Hola! Se ha agendado una nueva cita de atención psicológica para el día {{$fecha}} en el horario de {{$hora}}.</p>

    <p>Le invitamos a unirse a la videollamada através del siguiente link: </p>
    {{$apiResponse['join_url']}}
</body>
</html>