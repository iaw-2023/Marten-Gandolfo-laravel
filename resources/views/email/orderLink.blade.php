<!doctype html>
<html>

    <body>
        <div>
            <div>
                <p>Muchas gracias por su compra en Master Gaming!</p>
                <p>A continuacion se le brinda un <b>TOKEN</b> relacionado a su pedido.</p>
                <h2>{{ $order->token }}</h2>
                <p>Puede utilizarlo en nuestra pagina web, o bien ir directamente visualizar su compra en el siguiente enlace.</p>
                <a href="https://mastergaming-iaw2023.vercel.app/orders/{{ $order->token }}/details">Presione aqui para ver su compra</a>
                <p></p>
            </div>

            <div>
                Equipo de Master Gaming
            </div>
        </div>
    </body>

</html>