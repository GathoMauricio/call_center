@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('goals') }}" class="float-right">Metas</a>
                    <br>
                    <a href="{{ route('sales') }}" class="float-right">Ventas</a>
                    <h3>Editar venta</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('update_sale',$sale->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="amount" class="font-weight-bold">
                                            Monto de la venta
                                        </label>
                                        <input name="amount" type="number" value="{{ $sale->amount }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="font-weight-bold">
                                            Descripción
                                        </label>
                                        <textarea name="description" class="form-control" required>{{ $sale->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <br>
                                        <input type="submit" class="btn btn-primary" value="Actualizar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
