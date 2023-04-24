@include('components.error-message')

@include('components.product-form', ['action' => '/products', 'categories' => $categories, 'title' => 'Crear Producto'])