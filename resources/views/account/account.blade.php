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
                    <h3>Cuentas</h3>
                    <span class="float-right">{{ $assignments->links() }}</span>
                </div>
                <div class="card-body">
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
                                    <!--
                                    <br>
                                    <a href="{{ route('edit_account',$account->id) }}">Editar</a>
                                    <br>
                                    <a href="#">Eliminar</a>
                                    -->
                                    <br>
                                    <small style="color: #808B96">Asignado a: {{ $account->user['name'] }} {{ $account->user['middle_name'] }}</small>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <span class="float-right">{{ $assignments->links() }}</span>
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
@endsection