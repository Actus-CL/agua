@extends('layouts.welcome')

@section('content')
    <div class="title m-b-md">
        Area de clientes
    </div>
    <div class="m-b-md">
        @if($valid)
            Bienvenido XXXXX
            <br/>
            Acá podrá:
            <ul>
                <li>Visualizar el estado de su cuenta</li>
                <li>Ver el historial de su cuenta</li>
                <li>Realizar pago</li>
            </ul>
        @else
            Tu cuenta está suspendida
        @endif


    </div>
@endsection
