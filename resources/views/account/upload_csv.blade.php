@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Subir CSV</h3>
                </div>
                <form action="{{ route('store_csv') }}" method="post" enctype="multipart/form-data" class="form">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="file" name="file" class="form-control" accept=".csv" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <input type="submit" class="btn btn-primary float-right" value="Subir"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <br/><br/>
    <form action="{{ route('update_credentials') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" style="font-weight:bold">
                                Usuario
                            </label>
                            <input type="text" name="user" value="{{ $credentials->user }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" style="font-weight:bold">
                                Contraseña
                            </label>
                            <input type="text" name="password"  value="{{ $credentials->password }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <br>
                            <input type="submit" value="Actualizar credenciales"  class="btn btn-warning" style="float:right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection