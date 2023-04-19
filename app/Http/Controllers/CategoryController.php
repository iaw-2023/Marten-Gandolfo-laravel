<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function allCategories(){
        $categories = Category::withTrashed()->get();
        foreach($categories as $category){
            echo $category . "<br>";
            $products = $category->products()->get();
            echo $products . "<br><br>";
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.index')->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //TODO tirar error si el nombre es duplicado o esta vacio
        $categories = new Category();
        $categories->name = $request->get('name');

        $categories->save();

        return redirect('/categories');
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
        $category = Category::find($id);

        return view('category.edit')->with('category',$category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //TODO tirar error si el nombre es duplicado o esta vacio
        $category = Category::find($id);
        $category->name = $request->get('name');

        $category->save();

        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //TODO tirar error si existen productos disponibles bajo esa categoria
        $category = Category::find($id);
        $category->delete();
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function testdestroy()
    {
        //TODO ELIMINAR
        $category = Category::find('1');
        $category->delete();
    }
    
    public function indexApi(){
        $categories = Category::all();
        return response()->json($categories);
    }
}
