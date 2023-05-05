<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

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
        if (Category::where('name', 'ilike', $request->input('name'))->first()) {
            return redirect()->back()->withErrors(['El nombre ya está siendo utilizado.'])->withInput();
        }
        $request->validate($this->getValidationRules(), $this->getValidationErrorMessages());
        $category = new Category();
        $category->name = $request->get('name');
        $category->save();
        return redirect('/categories');
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
            return redirect('/categories')->withErrors(['Identificador inválido.']);
        $category = Category::find($id);
        if(!$category)
            return redirect('/categories')->withErrors(['La categoría no existe.']);

        return view('category.edit')->with('category',$category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!ctype_digit($id))
            return redirect('/categories')->withErrors(['Identificador inválido.']);
        $category = Category::find($id);
        if(!$category)
            return redirect('/categories')->withErrors(['La categoría fue eliminada.']);
        if (Category::where('name', 'ilike', $request->input('name'))->where('id', '<>', $id)->first()) {
            return redirect()->back()->withErrors(['El nombre ya está siendo utilizado.'])->withInput();
        }
        
        $request->validate($this->getValidationRules(), $this->getValidationErrorMessages());
        $category->name = $request->get('name');
        $category->save();

        return redirect('/categories');
    }

    private function getValidationRules(){
        return [
            'name' => ['required', 'string', 'max:255']
        ];
    }

    private function getValidationErrorMessages(){
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de caracteres.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!ctype_digit($id))
            return redirect('/categories')->withErrors(['Identificador inválido.']);
        $category = Category::find($id);
        if(!$category)
            return redirect()->back()->withErrors(['La categoría ya fue eliminada']);
        if(!$category->products->isEmpty())
            return redirect()->back()->withErrors(['No es posible eliminar categorías con productos asociados']);
        $category->delete();
        return redirect('/categories');
    }
    
    public function indexApi(){
        $categories = Category::select('id', 'name')->get();
        return response()->json($categories);
    }
}
