@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('users') }}" class="float-right">Usuarios</a>
                    <h3>Editar usuario</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('update_user',$user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="container">
                        <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="font-weight-bold">
                                            Estatus
                                        </label>
                                        <select name="status" onchange="archiveUser(this.value)" class="form-control">
                                        @if($user->status == 'active')
                                            <option value="active" selected>Activo</option>
                                            <option value="archived">Archivado</option>
                                        @else
                                            <option value="active">Activo</option>
                                            <option value="archived" selected>Archivado</option>
                                        @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="font-weight-bold">
                                            Nombre
                                        </label>
                                        <input name="name" type="text" value="{{ $user->name }}" class="form-control">
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
                                        <input name="middle_name" type="text" value="{{ $user->middle_name }}" class="form-control">
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
                                        <input name="last_name" type="text" value="{{ $user->last_name }}" class="form-control">
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
                                            @if($user->user_rol_id == 1)
                                            <option value="2">Operador</option>
                                            <option value="1" selected>Administrador</option>
                                            @else
                                            <option value="2" selected>Operador</option>
                                            <option value="1">Administrador</option>
                                            @endif
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
                                        <input name="email" type="email" value="{{ $user->email }}" class="form-control" readonly>
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
                                        <input name="color" type="color" value="{{ $user->color }}" class="form-control">
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
                                        <input type="submit" class="btn btn-primary" value="Actualizar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Cuenta</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Monto</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignments as $account)
                            <tr>
                                <td>{{ onlyDate($account->created_at) }}</td>
                                <td>{{ $account->account->account }}</td>
                                <td>{{ $account->account->name }}</td>
                                <td>{{ $account->account->phone }}</td>
                                <td>{{ $account->account->amount }}</td>
                                <td>
                                    <a href="#" onclick="openAccountFollows({{ $account->account->id }});">
                                    Seguimientos 
                                    (
                                        <span id="span_count_follows_{{ $account->account->id }}">
                                        {{ count(App\AccountFollow::where('account_id',$account->account->id)->orderBy('created_at','ASC')->get()) }}
                                        </span>
                                    )
                                    </a>
                                    @if(Auth::user()->user_rol_id == 1)
                                    <br>
                                    <a href="#" onclick="reasignAccount({{ $account->id }})">Reasignar</a>
                                    <!--
                                    <br>
                                    <a href="#">Eliminar</a>
                                    -->
                                    <br>
                                    <small id="small_operator_assigned_{{ $account->id }}" style="color: #808B96">Asignado a: {{ $account->user['name'] }} {{ $account->user['middle_name'] }}</small>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
.comment-box-modal{
    background:url({{ asset('img/bg.jpg')}});
    width: 100%;
    height: 400px;
    overflow: hidden;
    overflow-y:scroll;
}
.comment-box-modal::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px $prymary_sys;
    border-radius: 10px;
    background-color: #F5F5F5;
}

.comment-box-modal::-webkit-scrollbar {
    width: 12px;
    background-color: #F5F5F5;
}

.comment-box-modal::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
    background-color: #F5F5F5;
}
.comment-item{
    width: 100%;
    background-color: white;
    border-radius: 5px;
    padding:10px;
    opacity: 0.9;
}
</style>
@include('account.follow_modal')
@include('account.reasign_account_modal')
@endsection
