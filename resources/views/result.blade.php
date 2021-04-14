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
                    <h3>Cuenta de {{ $account->name }}</h3>
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
                            <tr>
                                <td>{{ $account->account }}</td>
                                <td>{{ $account->name }}</td>
                                <td>
                                    <a href="#" onclick="openAccountFollows({{ $account->id }});">
                                    Seguimientos 
                                    (
                                        <span id="span_count_follows_{{ $account->id }}">
                                        {{ count(App\AccountFollow::where('account_id',$account->id)->orderBy('created_at','ASC')->get()) }}
                                        </span>
                                    )
                                    </a>
                                </td>
                            </tr>
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
<input type="hidden" id="txt_archive_account_route" value="{{ route('archive_account') }}" />
<input type="hidden" id="txt_account_by_codification_route" value="{{ route('account_by_codification') }}" />
<input type="hidden" id="txt_account_route" value="{{ route('account') }}" />
@endsection