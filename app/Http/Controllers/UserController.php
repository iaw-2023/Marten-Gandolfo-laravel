<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('user.index')->with('users', $this->fromatUsersList($users));
    }

    private function fromatUsersList($users) {
        return $users->map(function ($user) {
            return $this->formatUser($user);
        });
    }

    private function formatUser($user){
        return [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'roles' => $user->roles->map(function($role) {
                return $role->name;
            })
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->getStoreValidationRules(), $this->getValidationErrorMessages());
        if (User::where('email', 'like', $request->input('email'))->first()) {
            return redirect()->back()->withErrors(['El email ya está siendo utilizado.'])->withInput();
        }
        if (User::where('username', 'like', $request->input('username'))->first()) {
            return redirect()->back()->withErrors(['El nombre de usuario ya está siendo utilizado.'])->withInput();
        }
        if($request->get('password') != $request->get('passwordconfirmation')) {
            return redirect()->back()->withErrors(['Las contraseñas no coinciden.'])->withInput();
        }

        $user = new User();
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->save();
        $this->setRoles($user, $request->get('superadmin'));
        
        return redirect('/users');
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
            return redirect('/users')->withErrors(['Identificador inválido.']);
        $user = User::with('roles')->find($id);
        if(!$user)
            return redirect('/users')->withErrors(['El usuario no existe.']);
        return view('user.edit')->with('user', $this->formatUser($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!ctype_digit($id))
            return redirect('/users')->withErrors(['Identificador inválido.']);
        $request->validate($this->getUpdateValidationRules(), $this->getValidationErrorMessages());
        $user = User::find($id);
        if(!$user)
            return redirect('/users')->withErrors(['El usuario no existe.']);
        if (User::where('username', 'like', $request->input('username'))->where('id', '<>', $id)->first()) {
            return redirect()->back()->withErrors(['El nombre de usuario ya está siendo utilizado.'])->withInput();
        }
        if($user == auth()->user() && !$request->get('superadmin'))
            return redirect('/users')->withErrors(['No puede modificar sus propios permisos.']);

        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->save();
        $this->setRoles($user, $request->get('superadmin'));
        
        return redirect('users');
    }

    private function getStoreValidationRules() {
        return [
            'email' => 'required|email',
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'required|min:4|max:40',
            'passwordconfirmation' => 'required|min:4|max:40',
        ];
    }

    private function getUpdateValidationRules() {
        return [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
        ];
    }

    private function getValidationErrorMessages() {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ña dirección de correo electrónico es inválida.',
            'name.required' => 'El  nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.max' => 'El nombre de usuario no debe exceder los 255 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres.',
            'password.max' => 'La contraseña no debe exceder los 40 caracteres.',
            'passwordconfirmation.required' => 'La confirmación de contraseña es obligatoria.',
            'passwordconfirmation.min' => 'La confirmación de contraseña debe tener al menos 4 caracteres.',
            'passwordconfirmation.max' => 'La confirmación de contraseña no debe exceder los 40 caracteres.',
        ];
    }

    private function setRoles($user, $superadmin){
        $adminRole = Role::where('name', 'Admin')->first();
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if(!$user->hasRole('Admin'))
            $user->roles()->attach($adminRole);

        if($superadmin && !$user->hasRole('Super Admin'))
            $user->roles()->attach($superAdminRole);
        else if(!$superadmin && $user->hasRole('Super Admin'))
            $user->roles()->detach($superAdminRole);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!ctype_digit($id))
            return redirect('/users')->withErrors(['Identificador inválido.']);
        $user = User::find($id);
        if(!$user)
            return redirect('/users')->withErrors(['El usuario ya fue eliminado.']);
        if($user == auth()->user())
            return redirect('/users')->withErrors(['No puede eliminarse a si mismo.']);
        $user->delete();
        return redirect('/users');
    }
}
