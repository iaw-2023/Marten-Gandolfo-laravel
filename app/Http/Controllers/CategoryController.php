<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function allCategories(){
        $categories = Category::all();
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
        $category = Category::where('name', 'ilike', $request->input('name'))
                            ->first();
    
        if ($category) {
            return redirect()->back()->withErrors(['name' => 'Ya existe una categoría con ese nombre']);
        } else {
            $category = new Category();
            $category->name = $request->get('name');
            $category->save();
        }
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
        $thisCategory = Category::find($id);
        $sameNameCategory = Category::where('name', 'ilike', $request->input('name'))
                            ->where('id', '<>', $id)
                            ->first();
    
        if ($sameNameCategory) {
            return redirect()->back()->withErrors(['name' => 'Ya existe una categoría con ese nombre']);
        }
        $thisCategory->name = $request->get('name');
        $thisCategory->save();

        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if(!$category)
            return redirect()->back()->withErrors(['category' => 'La categoría ya fue eliminada']);
        if(!$category->products->isEmpty())
            return redirect()->back()->withErrors(['category' => 'No es posible eliminar categorías con productos asociados']);
        $category->delete();
        return redirect('/categories');
    }
    
    public function indexApi(){
        $categories = Category::all();
        return response()->json($categories);
    }
}
