@include('components.error-message')

@include('components.product-form', ['action' => '/products/'.$product->id, 'product' => $product, 'categories' => $categories, 'method' => 'PUT', 'title' => 'Editar Producto'])