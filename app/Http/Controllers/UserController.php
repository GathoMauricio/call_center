<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UserRequest;

use App\User;

use App\UserAssignment;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'ASC')->paginate(15);
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
            'color' => $request->color,
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
        $assignments = UserAssignment::where('user_id', $user->id)->get();
        return view('edit_user',compact('user','assignments'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->name = $request->name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->color = $request->color;
        $user->user_rol_id = $request->user_rol_id;
        if($user->save())
        {
            if($user->status == 'archived')
            {
                $assignments = UserAssignment::where('user_id', $user->id)->get();
                $users = User::where('user_rol_id', 2)->where('status','active')->get();
                $counterUser = 0;
                foreach($assignments as $assignment)
                {
                    $assignment->user_id = $users[$counterUser]->id;
                    $assignment->save();
                    $counterUser++;
                    if($counterUser >= count(User::where('user_rol_id', 2)->where('status','active')->get())) $counterUser = 0;
                }
            }
            return redirect()->back()->with(['class' => 'success','message' => 'El usuario se actualizó con éxito.']);
        }else{
            return redirect()->back()->with(['class' => 'warning','message' => 'Ocurrió un error.']);
        }
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $assignments = UserAssignment::where('user_id', $user->id)->delete();
        if($user->delete())
        {
            return redirect()->route('users')->with(['class' => 'success','message' => 'El usuario se eliminó con éxito.']);
        }else{
            return redirect()->back()->with(['class' => 'warning','message' => 'Ocurrió un error.']);
        }
    }
}