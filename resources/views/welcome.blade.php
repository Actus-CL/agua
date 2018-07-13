@extends('front.welcome')

@section('content')

    <div class="m-b-md">
        <h2>Bienvenido al portal de clientes</h2>
        @if (Route::has('login'))


            @if (!Auth::check())
                <p>Ingrese sus datos de acceso  </p>


            @else
                <p>Ha ingresado al portal de clientes</p>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            @endif

        @else

            Usuarios para prueba:<br/>
            Admin: rinostrozareb@gmail.com / password: admin<br/>
            Cliente: cliente@actus.cl / password: demo
        @endif
    </div>
@endsection