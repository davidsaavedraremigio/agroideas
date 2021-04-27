<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">


        <img src="{!! asset('img/AdminLTELogo.png') !!}"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{!!Gravatar::get(Auth::user()->email)!!}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->nombres }}</a>
            </div>
        </div>
        <!-- Menú dinámico -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach ($menus as $key => $item)
                    @if ($item['parent'] != 0)
                        @break
                    @endif
                    @include('layouts.menu-item', ['item' => $item])
                @endforeach
            </ul>
        </nav>
        <!-- Menú dinámico -->
    </div>
</aside>