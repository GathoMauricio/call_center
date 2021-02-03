<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UserRequest;

use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'ASC')->get();
        return view('users',compact('users'));
    }
    public function create()
    { 
        return view('create_user');
    }
    public function store(UserRequest $request)
    {
        $user = User::create([
            'user_rol_id' => $request->user_rol_id,
            'name' => $request->name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->email)
        ]);
        if($user)
        {
            return redirect()->route('users')->with(['class' => 'success','message' => 'El usuario se creó con éxito.']);
        }else{
            return redirect()->back()->with(['class' => 'warning','message' => 'Ocurrió un error.']);
        }
    }
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('edit_user',compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->user_rol_id = $request->user_rol_id;
        if($user->save())
        {
            return redirect()->back()->with(['class' => 'success','message' => 'El usuario se actualizó con éxito.']);
        }else{
            return redirect()->back()->with(['class' => 'warning','message' => 'Ocurrió un error.']);
        }
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->delete())
        {
            return redirect()->route('users')->with(['class' => 'success','message' => 'El usuario se eliminó con éxito.']);
        }else{
            return redirect()->back()->with(['class' => 'warning','message' => 'Ocurrió un error.']);
        }
    }
}