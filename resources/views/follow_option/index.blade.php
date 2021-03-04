@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('follow_option_create') }}" class="float-right">Crear codificación</a>
                    <h3>Codificaciones</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Codificación</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($options as $option)
                            <tr>
                                <td>{{ $option->option }}</td>
                                <td>
                                    <a href="{{ route('follow_option_edit', $option->id) }}">Editar</a>
                                </td>
                            </tr>
                            @endforeach
                            @if(count($options) <= 0)
                            <tr><td colspan="2" style="text-align: center;">Sin contenido</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection