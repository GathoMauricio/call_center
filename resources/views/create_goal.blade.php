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
                    <h3>Agregar meta</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('store_goal') }}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="objetive" class="font-weight-bold">
                                            Objetivo
                                        </label>
                                        <input name="objetive" type="number" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date" class="font-weight-bold">
                                            Mes
                                        </label>
                                        <input name="date" type="month" class="form-control" required>
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
