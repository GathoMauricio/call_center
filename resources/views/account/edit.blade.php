@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Editar número de cuenta {{ $account->account }}</h3>
                </div>
                <div class="card-body">
                    <form class="form" action="{{ route('update_account',$account->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" >Nombre</label>
                                        <input type="text" name="name" value="{{ $account->name}}" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" >Teléfono</label>
                                        <input type="text" name="phone" value="{{ $account->phone}}" class="form-control" required/>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold" >Mensaje</label>
                                        <textarea type="text" name="message"class="form-control" required>{{ $account->message}}</textarea>
                                    </div>
                                </div>
                            </div>
                            -->
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary float-right" value="Actualizar">
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