<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function allProducts(){
        $products = Product::withTrashed()->get();
        foreach($products as $product){
            echo $product->category()->get() . "<br>";
            echo $product . "<br>";
            echo $product->orderDetails()->get() . "<br><br>";
        }
    }
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
        $errors = [];
        if(!Category::find($request->get('category_id')))
            $errors[] = 'La categoría seleccionada ya no existe.';
        if(Product::where('name', 'ilike', $request->get('name'))->first())
            $errors[] = 'Ya existe un producto con este nombre.';
        if(!empty($errors))
            return redirect()->back()->withErrors($errors);
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
        //
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
            return redirect('/categories')->withErrors(['El producto fue eliminado.']);
        $errors = [];
        if(!Category::find($request->get('category_id')))
            $errors[] = 'La categoría seleccionada ya no existe.';
        if(Product::where('name', 'ilike', $request->get('name'))->where('id', '<>', $id)->first())
            $errors[] = 'Ya existe un producto con este nombre.';
        if(!empty($errors))
            return redirect()->back()->withErrors($errors);
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
