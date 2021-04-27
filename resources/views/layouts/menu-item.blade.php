@if ($item['submenu'] == [])
    <li class="nav-item">
            <a href="{{url($item['nombre'])}}" title="{{$item['descripcion']}}" class="nav-link">
            <i class="nav-icon fas {{$item['icono']}}"></i>
            <p>{{$item['nombre']}}</p>
        </a>
    </li>
@else
    <li class="nav-item has-treeview">
        <a href="{{url($item['nombre'])}}" title="{{$item['descripcion']}}" class="nav-link">
            <i class="nav-icon fas {{$item['icono']}}"></i>
            <p>{{$item['nombre']}}<i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav nav-treeview">
            @foreach ($item['submenu'] as $submenu)
                @if ($submenu['submenu'] == [])
                    <li class="nav-item">
                        <a href="{{ url($submenu['ruta']) }}" title="{{$submenu['descripcion']}}" class="nav-link">
                            <i class="fas {{$submenu['icono']}}"></i>
                            <p>{{$submenu['nombre']}}</p>
                        </a>
                  </li>
                @else
                    @include('layouts.menu-item', [ 'item' => $submenu ])
                @endif
            @endforeach
        </ul>
    </li>
@endif