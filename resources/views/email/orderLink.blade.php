<!DOCTYPE html>
<html>
<head>
    <title>Token de compra Master Gaming</title>
</head>
<body>
    <h1>Hola {{ $order->client->email }},</h1>
    <p>Este correo electronico contiene el token para acceder a la informacion de su pedido.</p>
    <p>Token: {{ $order->token }}</p>
    <p>Puede consultar con atencion al cliente con el token anterior o bien verlo usted mismo desde el siguiente enlace.</p>
    <a href="http://localhost:3000/orders/{{ $order->token }}/details" class="btn btn-primary" role="button">Orden</a>
</body>
</html>