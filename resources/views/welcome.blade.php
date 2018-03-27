@extends('front.welcome')

@section('content')
    <div class="title m-b-md">
        {{ config('app.name') }}
    </div>
    <div class="m-b-md">
        Usuarios para prueba:<br/>
        Admin: rinostrozareb@gmail.com / password: admin<br/>
        Cliente: cliente@actus.cl / password: demo
    </div>
@endsection