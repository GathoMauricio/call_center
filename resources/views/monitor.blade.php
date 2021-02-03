@extends('layouts.app')

@section('content')
<div class="slide">
    <h1 class="text-center">
        Meta {{ formatDateMonth(date('Y-m-d')) }}
        <br>
        Objetivo: $21332412 &nbsp;&nbsp;&nbsp; Ventas: $53445&nbsp;&nbsp;&nbsp; Alcanzado: 34%
    </h1>
</div>
<style>
    .slide
    {
        width: 100%;
        height: 100vh;
        background-color: #EEFFAA;
    }
</style>
@endsection
