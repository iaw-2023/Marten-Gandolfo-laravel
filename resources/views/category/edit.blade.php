@include('components.error-message')

@include('components.category-form', ['action' => '/categories/'.$category->id, 'method' => 'PUT', 'name' => $category->name, 'title' => 'Editar Categoria'])