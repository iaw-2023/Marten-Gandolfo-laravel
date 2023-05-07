# ETAPA 2

En esta etapa se implemento la aplicación para administradores de la tienda de hardware 'Master Gaming' y la API que será utilizada por la futura aplicación para los clientes de la tienda. La aplicación está disponible en vercel en el siguiente link: https://marten-gandolfo-laravel.vercel.app/

Un usuario administrador puede iniciar sesión utilizando las credenciales indicadas por la cátedra. Luego podrá realizar operaciones de ABM sobre los productos y las categorías de la tienda y podrá obtener reportes sobre los clientes y los pedidos realizados.

Con respecto a la API, su documentación puede encontrarse en https://marten-gandolfo-laravel.vercel.app/_api/documentation en donde además pueden probarse todos los endpoints facilmente con la funcionalidad 'Try it out' de Swagger. 

# ETAPA 1

## Idea a implementar

La idea es implementar un conjunto de aplicaciones que permitan a una tienda de productos informáticos ofrecer sus productos a través de la web, permitiendo a los empleados de la tienda mantener actualizados los productos disponibles y visualizar los pedidos realizados por los clientes y permitiendo a los clientes consultar información de los productos a la venta, buscar productos por alguna de sus características y realizar pedidos.

## Diagrama ER

![image](https://user-images.githubusercontent.com/54592648/236690727-b27f0277-74c8-48b9-83c6-109ae6ec426f.png)


## PHP - Laravel

¿Qué entidades se podrán actualizar?
- Categorías
- Productos

¿Qué reportes se podrán generar o visualizar?
- Listar pedidos, productos y categorías

¿Qué entidades se podrán obtener por API?
- Categorías
- Productos
- Pedidos
- Detalles de pedido

¿Qué entidades se podrán modificar por API?
- Pedidos
- Detalles de pedido
- Clientes

## Javascript - React/Vue

¿Qué información podrá ver el usuario?
- Lista de productos y categorías
- Sus pedidos realizados

¿Qué acciones podrá realizar el usuario?
- Ver productos
- Filtrar productos por categoría
- Buscar productos
- Agregar productos al carrito de compra
- Eliminar productos del carrito de compras
- Comprar los productos del carrito de compras
- Ver sus pedidos
