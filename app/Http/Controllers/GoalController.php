<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Goal;

class GoalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $goals = Goal::orderBy('date','DESC')->paginate(10);
        return view('goals',compact('goals'));
    }
    public function create()
    {
        return view('create_goal');
    }
    public function store(Request $request)
    {
        $checkGoal = Goal::where('date',$request->date.'-01')->first();
        if($checkGoal)
        {
            return redirect()->back()->with(['class' => 'warning','message' => 'La meta de este mes ya existe.']);
        }else{
            Goal::create([
                'objetive' => $request->objetive,
                'date' => $request->date.'-01'
            ]);
            return redirect()->back()->with(['class' => 'success','message' => 'La meta para '.$request->date.' se almacenó con éxito.']);
        }
    }
    public function edit($id)
    {
        $goal = Goal::findOrFail($id);
        return view('edit_goal',compact('goal'));
    }
    public function update(Request $request, $id)
    {
        $goal = Goal::findOrFail($id);
        $goal->objetive = $request->objetive;
        if($goal->save())
        {
            return redirect()->back()->with(['class' => 'success','message' => 'La meta de '.formatDateMonth($goal->date).' se actualizó con éxito.']);
        }else{
            return redirect()->back()->with(['class' => 'warning','message' => 'Error al actualizar el registro']);
        }
    }
}