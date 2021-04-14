@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Recordatorios de hoy</h3>
                </div>
                <div class="card-body">
                     <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Cuenta</th>
                                <th>Contenido</th>
                                <th></th>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($reminders as $reminder)
                            <tr>
                                <td>{{ $reminder->date }}</td>
                                <td><a href="{{ route('search_account',$reminder->account['account']) }}">{{ $reminder->account['account'] }}</a></td>
                                <td>{{ $reminder->body }}</td>
                                <th></th>
                            </tr>
                            @endforeach
                            @if(count($reminders) <= 0)
                            <tr>
                                <td colspan="4" class="text-center">
                                    No hay recordatorios el día de hoy
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection