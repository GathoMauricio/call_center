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
                    <span class="float-right">{{ $accounts->links() }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Cuenta</th>
                                <th>Nombre</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $account)
                            <tr>
                                <td>{{ $account->account }}</td>
                                <td>{{ $account->name }}</td>
                                <td>
                                    <a href="#">Seguimientos (0)</a>
                                    <br>
                                    <a href="{{ route('edit_account',$account->id) }}">Editar</a>
                                    @if(Auth::user()->user_rol_id == 1)
                                    <br>
                                    <a href="#">Eliminar</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <span class="float-right">{{ $accounts->links() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="txt_delete_sale_route" value="{{ route('delete_sale') }}">
@endsection