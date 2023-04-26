<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return view('product.index')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->getValidationRules(null), $this->getValidationErrorMessages());

        $products = new Product();
        $products->category_ID = $request->get('category_id');
        $products->name = $request->get('name');
        $products->description = $request->get('description');
        $products->brand = $request->get('brand');
        $products->price = $request->get('price');
        $products->product_official_site = $request->get('official_site');
        $products->product_image = $request->get('image');

        $products->save();

        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(!ctype_digit($id))
            return redirect('/products')->withErrors(['Identificador inválido.']);
        $product = Product::find($id);
        if(!$product)
            return redirect('/products')->withErrors(['El producto no existe.']);
        $categories = Category::all();

        return view('product.edit')->with('product',$product)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!ctype_digit($id))
            return redirect('/products')->withErrors(['Identificador inválido.']);
        $product = Product::find($id);
        if(!$product)
            return redirect('/products')->withErrors(['El producto fue eliminado.']);
        $request->validate($this->getValidationRules($id), $this->getValidationErrorMessages());

        $product = Product::find($id);
        $product->category_ID = $request->get('category_id');
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->brand = $request->get('brand');
        $product->price = $request->get('price');
        $product->product_official_site = $request->get('official_site');
        $product->product_image = $request->get('image');

        $product->save();

        return redirect('/products');
    }

    private function getValidationRules($id){
        return [
            'category_id' => 'required|integer|exists:categories,id',
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($id ?? null)],
            'description' => 'required|max:1000',
            'brand' => 'required|max:255',
            'price' => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
            'official_site' => 'required|max:255',
            'image' => 'required|max:255',
        ];
    }

    private function getValidationErrorMessages(){
        return [
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.integer' => 'El identificador de categoría debe ser un número entero.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de caracteres.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'name.unique' => 'El nombre ya está siendo utilizado.',
            'description.required' => 'La descripción es obligatoria.',
            'description.max' => 'La descripción no puede tener más de 1000 caracteres.',
            'brand.required' => 'La marca es obligatoria.',
            'brand.max' => 'La marca no puede tener más de 255 caracteres.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'price.min' => 'El precio debe ser mayor a 0.',
            'price.regex' => 'El precio debe ser un número con hasta 2 decimales.',
            'official_site.required' => 'El sitio oficial es obligatorio.',
            'official_site.max' => 'El sitio oficial no puede tener más de 255 caracteres.',
            'image.required' => 'La imagen es obligatoria.',
            'image.max' => 'La imagen no puede tener más de 255 caracteres.',
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!ctype_digit($id))
            return redirect('/products')->withErrors(['Identificador inválido.']);
        $product = Product::find($id);
        if(!$product)
            return redirect('/products')->withErrors(['El producto ya fue eliminado.']);
        $product->delete();
        return redirect('/products');
    }

    public function indexApi(){
        $products = Product::select('id', 'name', 'price', 'product_image')->get();
        return response()->json($products);
    }

    public function showApi($id){
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
        return response()->json($product);
    }

    public function searchApi($name){
        if(is_string($name) && !empty($name))
            $products = Product::where('name', 'ilike', '%' . $name . '%')->select('id', 'name', 'price', 'product_image')->get();
        else
            $products = Product::all();
        return response()->json($products);
    }

    public function searchByCategoryApi($categoryId){
        if(!ctype_digit($categoryId))
            return response()->json([
                'message' => 'Invalid category ID'
            ], 400);
        $products = Product::whereHas('category', function($query) use ($categoryId){
            $query->where('id', $categoryId);
        })->select('id', 'name', 'price', 'product_image')->get();
        return response()->json($products);
    }
}
