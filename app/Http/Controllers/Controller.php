<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Master Gaming API",
 *     version="1.0.11"
 * )
 *
 * @OA\Server(
 *     url="https://marten-gandolfo-laravel.vercel.app/_api/"
 * )
 *
 * @OA\Tag(
 *     name="products",
 *     description="Info about available products"
 * )
 *
 * @OA\Tag(
 *     name="categories",
 *     description="Info about available categories"
 * )
 *
 * @OA\Tag(
 *     name="orders",
 *     description="Info and creation of orders"
 * )
 * 
 * @OA\Schema(
 *     schema="ProductSummary",
 *     title="Product Summary",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="MX MECHANICAL"),
 *     @OA\Property(property="price", type="number", format="double", example=1999.99),
 *     @OA\Property(property="product_image", type="string", example="https://resource.logitech.com/w_1600,c_limit,q_auto,f_auto,dpr_1.0/d_transparent.gif/content/dam/logitech/en/products/keyboards/mx-mechanical/gallery/mx-mechanical-keyboard-top-view-graphite-us.png?v=1")
 * )
 * 
 * @OA\Schema(
 *     schema="PaginatedProducts",
 *     title="Paginated Products",
 *     type="object",
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProductSummary")
 *     ),
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="first_page_url", type="string", example="http://127.0.0.1:8000/_api/products?page=1"),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=3),
 *     @OA\Property(property="last_page_url", type="string", example="http://127.0.0.1:8000/_api/products?page=3"),
 *     @OA\Property(
 *         property="links",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="url", type="string", example="http://127.0.0.1:8000/_api/products?page=1"),
 *             @OA\Property(property="label", type="string", example="1"),
 *             @OA\Property(property="active", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Property(property="next_page_url", type="string", example="http://127.0.0.1:8000/_api/products?page=2"),
 *     @OA\Property(property="path", type="string", example="http://127.0.0.1:8000/_api/products"),
 *     @OA\Property(property="per_page", type="integer", example=10),
 *     @OA\Property(property="prev_page_url", type="string", example=null),
 *     @OA\Property(property="to", type="integer", example=10),
 *     @OA\Property(property="total", type="integer", example=29)
 * )
 *
 * @OA\Schema(
 *     schema="Product",
 *     title="Product",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="category_ID", type="integer", example=2),
 *     @OA\Property(property="name", type="string", example="MX MECHANICAL"),
 *     @OA\Property(property="description", type="string", example="Teclado inalambrico iluminado de alto desempeño."),
 *     @OA\Property(property="brand", type="string", example="Logitech"),
 *     @OA\Property(property="price", type="number", format="double", example=1999.99),
 *     @OA\Property(property="product_official_site", type="string", example="https://www.logitech.com/es-ar/products/keyboards/mx-mechanical.html"),
 *     @OA\Property(property="product_image", type="string", example="https://resource.logitech.com/w_1600,c_limit,q_auto,f_auto,dpr_1.0/d_transparent.gif/content/dam/logitech/en/products/keyboards/mx-mechanical/gallery/mx-mechanical-keyboard-top-view-graphite-us.png?v=1")
 * )
 *
 * @OA\Schema(
 *     schema="Category",
 *     title="Category",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=3),
 *     @OA\Property(property="name", type="string", example="Teclado")
 * )
 *
 * @OA\Schema(
 *     schema="NewOrder",
 *     title="New Order",
 *     type="object",
 *     @OA\Property(property="email", type="string", example="juan@gmail.com"),
 *     @OA\Property(
 *         property="products",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProductOrder")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ProductOrder",
 *     title="Product Order",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=4),
 *     @OA\Property(property="units", type="integer", example=5)
 * )
 * 
 * @OA\Schema(
 *     schema="Order",
 *     title="Order",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=6),
 *     @OA\Property(
 *         property="client",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=7),
 *         @OA\Property(property="email", type="string", example="matias@gmail.com")
 *     ),
 *     @OA\Property(property="order_date", type="string", example="2023-01-03 12:00:00"),
 *     @OA\Property(property="price", type="number", format="double", example=1999.99),
 *     @OA\Property(
 *         property="order_details",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProductOrderDetail")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ProductOrderDetail",
 *     title="Product Order Detail",
 *     type="object",
 *     @OA\Property(
 *         property="product",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=8),
 *         @OA\Property(property="name", type="string", example="MX MECHANICAL"),
 *         @OA\Property(property="product_image", type="string", example="https://resource.logitech.com/w_1600,c_limit,q_auto,f_auto,dpr_1.0/d_transparent.gif/content/dam/logitech/en/products/keyboards/mx-mechanical/gallery/mx-mechanical-keyboard-top-view-graphite-us.png?v=1")
 *     ),
 *     @OA\Property(property="units", type="integer", example=3),
 *     @OA\Property(property="subtotal", type="number", format="double", example=999.99)
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
