@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Crear codificación</h3>
                </div>
                <form action="{{ route('follow_option_store') }}" method="post"class="form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="option" class="font-weight-bold">
                                        Codificación
                                    </label>
                                    <input type="text" name="option" class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="amount" class="font-weight-bold">
                                        Color
                                    </label>
                                    <input name="color" type="color"  class="form-control" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <input type="submit" class="btn btn-primary float-right" value="Agregar"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection