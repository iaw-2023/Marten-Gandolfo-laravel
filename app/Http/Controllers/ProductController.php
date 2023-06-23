<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

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
        if(Product::where('name', 'ilike', $request->get('name'))->first())
            return redirect()->back()->withErrors(['El nombre ya está siendo utilizado.'])->withInput();
        $request->validate($this->getValidationRules(), $this->getValidationErrorMessages());

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
        
        if(Product::where('name', 'ilike', $request->get('name'))->where('id', '<>', $id)->first())
            return redirect()->back()->withErrors(['El nombre ya está siendo utilizado.'])->withInput();
        
        $request->validate($this->getValidationRules(), $this->getValidationErrorMessages());

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

    private function getValidationRules(){
        return [
            'category_id' => 'required|integer|exists:categories,id',
            'name' => ['required', 'string', 'max:255'],
            'description' => 'required|max:1000',
            'brand' => 'required|max:255',
            'price' => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
            'official_site' => 'required|max:255',
            'image' => 'required',
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
        if($product->orderDetails()->exists())
            $product->delete();
        else
            $product->forceDelete();
        return redirect('/products');
    }

    /**
    * @OA\Get(
    *     path="/products",
    *     operationId="getProducts",
    *     tags={"products"},
    *     summary="Get all available products",
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Page number",
    *         @OA\Schema(
    *             type="integer",
    *             default=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="perPage",
    *         in="query",
    *         description="Number of items per page",
    *         @OA\Schema(
    *             type="integer",
    *             default=10
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/PaginatedProducts")
    *         )
    *     )
    * )
    */
    public function indexApi(Request $request){
        //$products = Product::select('id', 'name', 'price', 'product_image')->get();
        //return response()->json($products);

        $perPage = $request->query('perPage', 12); // Number of items per page, default is 10
        $products = Product::select('id', 'name', 'price', 'product_image')
            ->paginate($perPage);
        //if($request->isSecure())
        if(strpos($request->path(), 'https:') !== false)
            $products->setPath($this->replaceHttpWithHttps($products->path()));
        return response()->json($products);
    }

    private function replaceHttpWithHttps($url){
        $pos = strpos($url, 'http:');
        if ($pos !== false) {
            return substr_replace($url, 'https:', $pos, strlen('http:'));
        }
        else{
            return $url;
        }
    }

    public function randomIndexApi($quantity){
        if(!ctype_digit($quantity) || $quantity < 1)
            return response()->json([
                'message' => 'Invalid qunatity'
            ], 400);

        $products = Product::inRandomOrder()->take($quantity)->select('id', 'name', 'price', 'product_image')->get();
        return response()->json($products);
    }

    /**
    * @OA\Get(
    *     path="/products/{id}",
    *     operationId="getProductById",
    *     tags={"products"},
    *     summary="Get product by ID",
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID of product to return",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             example=1
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Product")
    *     ),
    *     @OA\Response(
    *         response="400",
    *         description="Invalid ID supplied"
    *     ),
    *     @OA\Response(
    *         response="404",
    *         description="Product not found"
    *     )
    * )
    */
    public function showApi($id){
        if(!ctype_digit($id))
            return response()->json([
                'message' => 'Invalid ID'
            ], 400);
        $product = Product::select('id', 'category_ID', 'name', 'description', 'brand', 'price', 'product_official_site', 'product_image')->find($id);
        if(!$product){
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
        return response()->json($product);
    }

    /**
    * @OA\Get(
    *     path="/products/search/{name}",
    *     operationId="getProductsByName",
    *     tags={"products"},
    *     summary="Search products by name",
    *     @OA\Parameter(
    *         name="name",
    *         in="path",
    *         description="Name of product to search",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             example="rtx"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Page number",
    *         @OA\Schema(
    *             type="integer",
    *             default=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="perPage",
    *         in="query",
    *         description="Number of items per page",
    *         @OA\Schema(
    *             type="integer",
    *             default=10
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/PaginatedProducts")
    *         )
    *     )
    * )
    */
    public function searchApi($name, Request $request){
        $perPage = $request->query('perPage', 12);
        $products = Product::where('name', 'ilike', '%' . $name . '%')
                            ->select('id', 'name', 'price', 'product_image')
                            ->paginate($perPage);
        //if($request->isSecure())
        if(strpos($request->path(), 'https:') !== false)
            $products->setPath($this->replaceHttpWithHttps($products->path()));
        return response()->json($products);
    }

    /**
    * @OA\Get(
    *     path="/products/category/{categoryId}",
    *     operationId="getProductsByCategory",
    *     tags={"products"},
    *     summary="Search products by category",
    *     @OA\Parameter(
    *         name="categoryId",
    *         in="path",
    *         description="Category of products to search",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             example=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Page number",
    *         @OA\Schema(
    *             type="integer",
    *             default=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="perPage",
    *         in="query",
    *         description="Number of items per page",
    *         @OA\Schema(
    *             type="integer",
    *             default=10
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/PaginatedProducts")
    *         )
    *     ),
    *     @OA\Response(
    *         response="400",
    *         description="Invalid category ID supplied"
    *     )
    * )
    */
    public function searchByCategoryApi($categoryId, Request $request){
        if(!ctype_digit($categoryId))
            return response()->json([
                'message' => 'Invalid category ID'
            ], 400);

        $perPage = $request->query('perPage', 12);
        $products = Product::whereHas('category', function ($query) use ($categoryId) {
                $query->where('id', $categoryId);
            })
                            ->select('id', 'name', 'price', 'product_image')
                            ->paginate($perPage);
        //if($request->isSecure())
        if(strpos($request->path(), 'https:') !== false)
            $products->setPath($this->replaceHttpWithHttps($products->path()));
        return response()->json($products);
    }

    /**
    * @OA\Get(
    *     path="/products/search/{name}/category/{categoryId}",
    *     operationId="getProductsByNameAndCategory",
    *     tags={"products"},
    *     summary="Search products by name and category",
    *     @OA\Parameter(
    *         name="name",
    *         in="path",
    *         description="Name of product to search",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             example="g"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="categoryId",
    *         in="path",
    *         description="Category of products to search",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             example=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Page number",
    *         @OA\Schema(
    *             type="integer",
    *             default=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="perPage",
    *         in="query",
    *         description="Number of items per page",
    *         @OA\Schema(
    *             type="integer",
    *             default=10
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/PaginatedProducts")
    *         )
    *     )
    * )
    */
    public function searchByNameAndCategoryApi($name, $categoryId, Request $request){
        if(!ctype_digit($categoryId))
            return response()->json([
                'message' => 'Invalid category ID'
            ], 400);

        $perPage = $request->query('perPage', 12);
        $products = Product::query()
                    ->where('name', 'ilike', '%' . $name . '%')
                    ->whereHas('category', fn ($query) => $query->where('id', $categoryId))
                    ->select('id', 'name', 'price', 'product_image')
                    ->paginate($perPage);
        //if($request->isSecure())
        if(strpos($request->path(), 'https:') !== false)
            $products->setPath($this->replaceHttpWithHttps($products->path()));
        return response()->json($products);
    }

    /**
    * @OA\Get(
    *     path="/products/search/{name}/category/{categoryId}/order/{order}",
    *     operationId="searchByNameCategoryAndOrderApi",
    *     tags={"products"},
    *     summary="Order the products according to their price and filter by search and category",
    *     @OA\Parameter(
    *         name="name",
    *         in="path",
    *         description="Name of product to search",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             example="g"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="categoryId",
    *         in="path",
    *         description="Category of products to search",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             example=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="order",
    *         in="path",
    *         description="Desired order type (ascending/descending)",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             example="desc"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Page number",
    *         @OA\Schema(
    *             type="integer",
    *             default=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="perPage",
    *         in="query",
    *         description="Number of items per page",
    *         @OA\Schema(
    *             type="integer",
    *             default=10
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/PaginatedProducts")
    *         )
    *     )
    * )
    */
    public function searchByNameCategoryAndOrderApi($name, $categoryId, $order, Request $request){
        if(!ctype_digit($categoryId))
            return response()->json([
                'message' => 'Invalid category ID'
            ], 400);

        $perPage = $request->query('perPage', 12);
        $products = Product::query()
                        -> where('name', 'ilike', '%' . $name . '%');
        
        if($categoryId != -1)
            $products = $products 
                        -> whereHas('category', fn ($query) => $query -> where('id', $categoryId));
        
        $products = $products
                        -> select('id', 'name', 'price', 'product_image')
                        -> orderBy('price', $order)
                        -> paginate($perPage);
        //if($request->isSecure())
        if(strpos($request->path(), 'https:') !== false)
            $products->setPath($this->replaceHttpWithHttps($products->path()));
        return response()->json($products);
    }

    /**
    * @OA\Get(
    *     path="/products/search/{name}/order/{order}",
    *     operationId="searchByNameAndOrderApi",
    *     tags={"products"},
    *     summary="Order the products according to their price and filter by search",
    *     @OA\Parameter(
    *         name="name",
    *         in="path",
    *         description="Name of product to search",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             example="g"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="order",
    *         in="path",
    *         description="Desired order type (ascending/descending)",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             example="desc"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Page number",
    *         @OA\Schema(
    *             type="integer",
    *             default=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="perPage",
    *         in="query",
    *         description="Number of items per page",
    *         @OA\Schema(
    *             type="integer",
    *             default=10
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/PaginatedProducts")
    *         )
    *     )
    * )
    */
    public function searchByNameAndOrderApi($name, $order, Request $request){
        $perPage = $request->query('perPage', 12);
        $products = Product::query()
                        -> where('name', 'ilike', '%' . $name . '%')
                        -> select('id', 'name', 'price', 'product_image')
                        -> orderBy('price', $order)
                        -> paginate($perPage);
        //if($request->isSecure())
        if(strpos($request->path(), 'https:') !== false)
            $products->setPath($this->replaceHttpWithHttps($products->path()));
        return response()->json($products);
    }

    /**
    * @OA\Get(
    *     path="/products/category/{categoryId}/order/{order}",
    *     operationId="searchByCategoryAndOrderApi",
    *     tags={"products"},
    *     summary="Order the products according to their price and filter by category",
    *     @OA\Parameter(
    *         name="categoryId",
    *         in="path",
    *         description="Category of products to search",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             example=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="order",
    *         in="path",
    *         description="Desired order type (ascending/descending)",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             example="desc"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Page number",
    *         @OA\Schema(
    *             type="integer",
    *             default=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="perPage",
    *         in="query",
    *         description="Number of items per page",
    *         @OA\Schema(
    *             type="integer",
    *             default=10
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/PaginatedProducts")
    *         )
    *     )
    * )
    */
    public function searchByCategoryAndOrderApi($categoryId, $order, Request $request){
        $perPage = $request->query('perPage', 12);
        $products = Product::query()
                        -> orderBy('price', $order);
        
        if($categoryId != -1)
            $products = $products 
                        -> whereHas('category', fn ($query) => $query -> where('id', $categoryId));
        
        $products = $products
                        -> select('id', 'name', 'price', 'product_image')
                        -> paginate($perPage);
        //if($request->isSecure())
        if(strpos($request->path(), 'https:') !== false)
            $products->setPath($this->replaceHttpWithHttps($products->path()));
        return response()->json($products);
    }

    /**
    * @OA\Get(
    *     path="/products/order/{order}",
    *     operationId="searchByOrderApi",
    *     tags={"products"},
    *     summary="Order the products according to their price",
    *     @OA\Parameter(
    *         name="order",
    *         in="path",
    *         description="Desired order type (ascending/descending)",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             example="desc"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="Page number",
    *         @OA\Schema(
    *             type="integer",
    *             default=1
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="perPage",
    *         in="query",
    *         description="Number of items per page",
    *         @OA\Schema(
    *             type="integer",
    *             default=10
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/PaginatedProducts")
    *         )
    *     )
    * )
    */
    public function searchByOrderApi($order, Request $request){
        $perPage = $request->query('perPage', 12);
        $products = Product::query()
                        -> select('id', 'name', 'price', 'product_image')
                        -> orderBy('price', $order)
                        -> paginate($perPage);
        //if($request->isSecure())
        if(strpos($request->path(), 'https:') !== false)
            $products->setPath($this->replaceHttpWithHttps($products->path()));
        return response()->json($products);
    }
}
