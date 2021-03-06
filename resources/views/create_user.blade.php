@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('users') }}" class="float-right">Usuarios</a>
                    <h3>Crear usuario</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('store_user') }}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="font-weight-bold">
                                            Nombre
                                        </label>
                                        <input name="name" type="text" class="form-control">
                                        @if($errors->has('name'))
                                        <small class="font-weight-bold" style="color:red;">
                                            {{ $errors->first('name') }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="middle_name" class="font-weight-bold">
                                            A. Paterno
                                        </label>
                                        <input name="middle_name" type="text" class="form-control">
                                        @if($errors->has('middle_name'))
                                        <small class="font-weight-bold" style="color:red;">
                                            {{ $errors->first('middle_name') }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="last_name" class="font-weight-bold">
                                            A. materno
                                        </label>
                                        <input name="last_name" type="text" class="form-control">
                                        @if($errors->has('last_name'))
                                        <small class="font-weight-bold" style="color:red;">
                                            {{ $errors->first('last_name') }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email" class="font-weight-bold">
                                            Rol
                                        </label>
                                        <select name="user_rol_id" class="form-control">
                                            <option value="2">Operador</option>
                                            <option value="1">Administrador</option>
                                        </select>
                                        @if($errors->has('user_rol_id'))
                                        <small class="font-weight-bold" style="color:red;">
                                            {{ $errors->first('user_rol_id') }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email" class="font-weight-bold">
                                            Email
                                        </label>
                                        <input name="email" type="email" class="form-control">
                                        @if($errors->has('email'))
                                        <small class="font-weight-bold" style="color:red;">
                                            {{ $errors->first('email') }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="color" class="font-weight-bold">
                                            Color
                                        </label>
                                        <input name="color" type="color" class="form-control">
                                        @if($errors->has('color'))
                                        <small class="font-weight-bold" style="color:red;">
                                            {{ $errors->first('color') }}
                                        </small>
                                        @endif
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
