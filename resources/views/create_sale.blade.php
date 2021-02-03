@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('sales') }}" class="float-right">Ventas</a>
                    <br>
                    <a href="{{ route('goals') }}" class="float-right">Metas</a>
                    <h3>Crear venta</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('store_sale') }}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="amount" class="font-weight-bold">
                                            Monto de la venta
                                        </label>
                                        <input name="amount" type="number" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="font-weight-bold">
                                            Descripción
                                        </label>
                                        <textarea name="description" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-right">
                                        <br>
                                        <input type="submit" class="btn btn-primary" value="Guardar">
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
