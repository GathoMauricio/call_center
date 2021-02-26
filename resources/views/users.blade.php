@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('create_user') }}" class="float-right">Crear usuario</a>
                    <h3>Usuarios</h3>
                    <span class="float-right">{{ $users->links() }}</span>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rol</th>
                                <th>Estatus</th>
                                <th>Nombre</th>
                                <th>A. Paterno</th>
                                <th>A. Materno</th>
                                <th>Email</th>
                                <th>Color</th>
                                @if(Auth::user()->user_rol_id ==1)
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->rol['name'] }}</td>
                                <td>
                                    @if($user->status == 'active')
                                    <label class="font-weight-bold" style="color:#58D68D;">Activo</label>
                                    @else
                                    <label class="font-weight-bold" style="color:#FFC300;">Archivado</label>
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->middle_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><div style="width:100%;height:20px;background-color:{{ $user->color }}"></div></td>
                                @if(Auth::user()->user_rol_id ==1)
                                <td>
                                    <a href="{{ route('edit_user',$user->id) }}">Editar</a>
                                    <br>
                                    <a href="#" style="color:red" onclick="deleteUser({{ $user->id }});">Eliminar</a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <span class="float-right">{{ $users->links() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="txt_delete_user_route" value="{{ route('delete_user') }}">
@endsection
