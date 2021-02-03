<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sale;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if(\Auth::user()->id == 1)
        {
            $sales = Sale::orderBy('created_at', 'DESC')->paginate(15);
        }else{
            $sales = Sale::where('author_id',\Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(15);
        }
        return view('sales',compact('sales'));
    }
    public function create()
    {
        return view('create_sale');
    }
    public function store(Request $request)
    {
        $sale = Sale::create($request->all());
        if($request)
        {
            return redirect()->back()->with(['class' => 'success','message' => 'La venta se almacenó con éxito.']);
        }else{
            return redirect()->back()->with(['class' => 'warning','message' => 'Ocurrió un error.']);
        }
    }
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('edit_sale', compact('sale'));
    }
    public function update(Request $request, $id){
        $sale = Sale::findOrFail($id);
        $sale->amount = $request->amount;
        $sale->description = $request->description;
        if($sale->save())
        {
            return redirect()->back()->with(['class' => 'success','message' => 'La venta se actualizó con éxito.']);
        }else{
            return redirect()->back()->with(['class' => 'warning','message' => 'Ocurrió un error.']);
        }
    }
    public function destroy($id){
        $sale = Sale::findOrFail($id);
        if($sale->delete())
        {
            return redirect()->route('sales')->with(['class' => 'success','message' => 'La venta se elimino con éxito.']);
        }else{
            return redirect()->back()->with(['class' => 'warning','message' => 'Ocurrió un error.']);
        }
    }
}
