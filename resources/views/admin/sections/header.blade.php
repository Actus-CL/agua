<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                       aria-expanded="false">
                        <img src="{{ auth()->user()->avatar }}" alt="">{{ auth()->user()->name }}
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li>
                            <a href="{{ route('logout') }}">
                                <i class="fa fa-sign-out pull-right"></i> {{ __('views.backend.section.header.menu_0') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        @php
                            $mensajes=auth()->user()->alerta_entrega_sistema->where('entregado',0);
                        @endphp
                        <span class="badge bg-green">{{ $mensajes->count() }}</span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        @foreach($mensajes as $mensaje)
                        <li>
                            <a >


                                <span>
                                    <span>{{$mensaje->alerta->titulo}}:</span>

                                    @php

                                    @endphp

                                    <span class="time">3 mins ago  {{$mensaje->alerta->fechaForHumans()}}  </span>
                                </span>
                                <span class="message">
                                    {{$mensaje->alerta->mensaje}}
                                </span>


                            </a>
                        </li>
                        @endforeach
                        {{--<li>--}}
                            {{--<div class="text-center">--}}
                                {{--<a>--}}
                                    {{--<strong>Ver todas las alertas</strong>--}}
                                    {{--<i class="fa fa-angle-right"></i>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>