<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    @switch(Auth::user()->codRol)
        {{-- Rol Usuario Administrador--}}
        @case(100)
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-toolbox"></i> <p>Configuración <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("modulo.index")}}" class="nav-link"> <i class="nav-icon fab fa-buromobelexperte"></i><p>Módulos</p></a></li>
                    <li class="nav-item"><a href="{{route("proceso.index")}}" class="nav-link"> <i class="nav-icon fas fa-random"></i><p>Procesos</p></a></li>
                    <li class="nav-item"><a href="{{route("tabla.index")}}" class="nav-link"> <i class="nav-icon fas fa-table"></i><p>Tablas del sistema</p></a></li>
                    <li class="nav-item"><a href="{{route("tabla-valor.index")}}" class="nav-link"> <i class="nav-icon fas fa-database"></i><p>Valores</p></a></li>
                    <li class="nav-item"><a href="{{route("etapa-compromiso.index")}}" class="nav-link"> <i class="nav-icon fas fa-random"></i><p>Etapas de un compromisos</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-user-cog"></i><p>Usuarios <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("area.index")}}" class="nav-link"> <i class="nav-icon fas fa-user-tag"></i><p>Áreas del PCC</p></a></li>
                    <li class="nav-item"><a href="{{route("cargo.index")}}" class="nav-link"> <i class="nav-icon fas fa-user-tie"></i><p>Cargos de usuario</p></a></li>
                    <li class="nav-item"><a href="{{route("staff.index")}}" class="nav-link"> <i class="nav-icon fas fa-users"></i><p>Staff</p></a></li>
                    <li class="nav-item"><a href="{{route("usuario.index")}}" class="nav-link"> <i class="nav-icon fas fa-users-cog"></i><p>Configurar usuario</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-globe-americas"></i> <p>Ámbito geográfico <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("ubigeo.index")}}" class="nav-link"> <i class="nav-icon fas fa-drafting-compass"></i><p>Ubigeo nacional</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-leaf"></i> <p>Cultivos <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("sector.index")}}" class="nav-link"> <i class="nav-icon fas fa-tractor"></i><p>Sectores productivos</p></a></li>
                    <li class="nav-item"><a href="{{route("linea.index")}}" class="nav-link"> <i class="nav-icon fas fa-tractor"></i><p>Lineas productivas</p></a></li>
                    <li class="nav-item"><a href="{{route("cadena.index")}}" class="nav-link"> <i class="nav-icon fas fa-tractor"></i><p>Cadenas productivas</p></a></li>
                    <li class="nav-item"><a href="{{route("producto.index")}}" class="nav-link"> <i class="nav-icon fas fa-tractor"></i><p>Productos</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-chart-line"></i> <p>Indicadores <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("indicador-resultado.index")}}" class="nav-link"> <i class="nav-icon fas fa-thumbtack"></i><p>Indicadores de resultado</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-archway"></i> <p>Entidades <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("opa.index")}}" class="nav-link"><i class="nav-icon fas fa-house-user"></i><p>Módulo organizaciones</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-calendar-day"></i> <p>Eventos/Compromisos <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("evento.index")}}" class="nav-link"><i class="nav-icon fas fa-calendar"></i><p>Módulo compromisos</p></a></li>
                    <li class="nav-item"><a href="{{route("evento.visor")}}" class="nav-link"><i class="nav-icon fas fa-chart-line"></i><p>Dashboard compromisos</p></a></li>
                    <li class="nav-item"><a href="{{route("compromiso-reporte.index")}}" class="nav-link"><i class="nav-icon fab fa-font-awesome-flag"></i><p>Estado situacional</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-chalkboard-teacher"></i><p>Capacitaciones <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("capacitacion.index")}}" class="nav-link"><i class="nav-icon fas fa-calendar-plus"></i><p>Programación</p></a></li>
                    <li class="nav-item"><a href="{{route("pivot-capacitacion.index")}}" class="nav-link"><i class="nav-icon fas fa-database"></i><p>Formato SERVIAGRO</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-bullhorn"></i><p>Promoción y difusión <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("difusion.index")}}" class="nav-link"><i class="nav-icon fas fa-calendar-plus"></i><p>Programación</p></a></li>
                    <li class="nav-item"><a href="{{route("difusion-implementacion.index")}}" class="nav-link"><i class="nav-icon fas fa-calendar-check"></i><p>Implementación</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-id-card-alt"></i><p>Convenios <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{ config('app.url') }}/de/convenio" class="nav-link"><i class="nav-icon far fa-id-card"></i><p>Módulo convenios</p></a></li> 
                    <li class="nav-item"><a href="{{route("convenio-reporte.index")}}" class="nav-link"><i class="nav-icon fas fa-table"></i><p>Consolidado UPFP</p></a></li> 
                    <li class="nav-item"><a href="{{route("convenio-seguimiento.index")}}" class="nav-link"><i class="nav-icon fas fa-chart-bar"></i><p>Reporte de seguimiento</p></a></li> 
                    <li class="nav-item"><a href="{{route("convenio-consolidado.index")}}" class="nav-link"><i class="nav-icon fas fa-table"></i><p>Relación de convenios</p></a></li>  
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-tractor"></i><p>Reconversión productiva <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("prp.index")}}" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Organizaciones y productores</p></a></li> 
                    <li class="nav-item"><a href="{{route("cartera-prp.index")}}" class="nav-link"><i class="nav-icon fas fa-archive"></i></i><p>Cartera</p></a></li> 
                    <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-tasks"></i><p>Calificación <i class="right fa fa-angle-left right"></i></p></a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href="{{route("ur.index")}}" class="nav-link"><i class="nav-icon fas fa-tasks"></i><p>Evaluación documentaria</p></a></li>
                            <li class="nav-item"><a href="{{route("upfp.index")}}" class="nav-link"><i class="nav-icon fas fa-tasks"></i><p>Evaluación técnica</p></a></li> 
                        </ul>
                    </li> 
                    <li class="nav-item"><a href="{{route("formulacion.index")}}" class="nav-link"><i class="nav-icon fas fa-id-card"></i><p>Formulación del PRPA</p></a></li> 
                    <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon far fa-list-alt"></i><p>Evaluación del PRPA <i class="right fa fa-angle-left right"></i></p></a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href="{{route("un.index")}}" class="nav-link"><i class="nav-icon fas fa-tasks"></i><p>UN - Evaluar expediente</p></a></li>
                            <li class="nav-item"><a href="{{route("uaj.index")}}" class="nav-link"><i class="nav-icon fas fa-tasks"></i><p>UAJ - Evaluar expediente</p></a></li>
                        </ul>
                    </li> 
                    <li class="nav-item"><a href="{{route("rm.index")}}" class="nav-link"><i class="nav-icon far fa-id-card"></i><p>Resoluciones ministeriales</p></a></li> 
                    <li class="nav-item"><a href="{{ config('app.url') }}/iniciativa/convenio" class="nav-link"><i class="nav-icon fas fa-handshake"></i><p>Convenios</p></a></li> 
                    <li class="nav-item"><a href="{{route("mantenimiento.index")}}" class="nav-link"><i class="nav-icon fas fa-tools"></i><p>Mantenimiento de expedientes</p></a></li> 
                    <li class="nav-item"><a href="{{route("proyecto-prpa.index")}}" class="nav-link"><i class="nav-icon far fa-id-card"></i><p>Información general</p></a></li> 
                    <li class="nav-item"><a href="{{route("admision.visor")}}" class="nav-link"><i class="nav-icon fas fa-chart-line"></i><p>Dashboard PRPA</p></a></li> 
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-tractor"></i><p>Solicitudes de apoyo <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("sda.index")}}" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Organizaciones y productores</p></a></li> 
                    <li class="nav-item"><a href="{{route("admision.index")}}" class="nav-link"><i class="nav-icon far fa-address-card"></i><p>Admisión</p></a></li> 
                    <li class="nav-item"><a href="{{route("evaluacion.index")}}" class="nav-link"><i class="nav-icon fas fa-tasks"></i><p>Evaluación</p></a></li> 
                    <li class="nav-item"><a href="{{route("cd.index")}}" class="nav-link"><i class="nav-icon far fa-folder"></i><p>Consejo directivo</p></a></li> 
                    <li class="nav-item"><a href="{{ config('app.url') }}/sda/convenio" class="nav-link"><i class="nav-icon fas fa-handshake"></i><p>Convenios</p></a></li> 
                    <li class="nav-item"><a href="{{route("import-sda.index")}}" class="nav-link"><i class="nav-icon fas fa-money-check-alt"></i><p>Desembolsos</p></a></li> 
                    <li class="nav-item"><a href="{{route("proyecto.index")}}" class="nav-link"><i class="nav-icon fab fa-leanpub"></i><p>Información general</p></a></li> 
                    <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-chart-line"></i><p>Dashboard SDA</p></a></li> 
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-flag-checkered"></i><p>Matriz de resultados <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("ml.index")}}" class="nav-link"><i class="nav-icon far fa-list-alt"></i><p>Marco Lógico</p></a></li> 
                </ul>
            </li>
        @break
        {{-- Rol Unidades Regionales --}}
        @case(1)
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-archway"></i> <p>Entidades <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("opa.index")}}" class="nav-link"><i class="nav-icon fas fa-house-user"></i><p>Módulo organizaciones</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-calendar-day"></i> <p>Eventos/Compromisos <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("evento.index")}}" class="nav-link"><i class="nav-icon fas fa-calendar"></i><p>Módulo compromisos</p></a></li>
                    <li class="nav-item"><a href="{{route("evento.visor")}}" class="nav-link"><i class="nav-icon fas fa-chart-line"></i><p>Dashboard compromisos</p></a></li>
                    <li class="nav-item"><a href="{{route("compromiso-reporte.index")}}" class="nav-link"><i class="nav-icon fab fa-font-awesome-flag"></i><p>Estado situacional</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-chalkboard-teacher"></i><p>Capacitaciones <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("capacitacion.index")}}" class="nav-link"><i class="nav-icon fas fa-calendar-plus"></i><p>Programación</p></a></li>
                    <li class="nav-item"><a href="{{route("pivot-capacitacion.index")}}" class="nav-link"><i class="nav-icon fas fa-database"></i><p>Formato SERVIAGRO</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-bullhorn"></i><p>Promoción y difusión <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("difusion.index")}}" class="nav-link"><i class="nav-icon fas fa-calendar-plus"></i><p>Programación</p></a></li>
                    <li class="nav-item"><a href="{{route("difusion-implementacion.index")}}" class="nav-link"><i class="nav-icon fas fa-calendar-check"></i><p>Implementación</p></a></li>
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-tractor"></i><p>Reconversión productiva <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("prp.index")}}" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Organizaciones y productores</p></a></li> 
                    <li class="nav-item"><a href="{{route("ur.index")}}" class="nav-link"><i class="nav-icon fas fa-tasks"></i><p>Evaluación documentaria</p></a></li>
                    <li class="nav-item"><a href="{{route("admision.visor")}}" class="nav-link"><i class="nav-icon fas fa-chart-line"></i><p>Dashboard PRPA</p></a></li> 
                </ul>
            </li>
            <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-tractor"></i><p>Solicitudes de apoyo <i class="right fa fa-angle-left right"></i></p></a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"><a href="{{route("sda.index")}}" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Organizaciones y productores</p></a></li> 
                    <li class="nav-item"><a href="{{route("admision.index")}}" class="nav-link"><i class="nav-icon far fa-address-card"></i><p>Admisión</p></a></li> 
                    <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-chart-line"></i><p>Dashboard SDA</p></a></li> 
                </ul>
            </li>
        @break
        {{-- Rol Unidad de Monitoreo --}}
        @case(4)
            <li class="nav-item"><a href="{{route("nobjecion.index")}}" class="nav-link" title="Proceso de no objeción"><i class="nav-icon fas fa-mail-bulk"></i><p>Proceso de No objeción</p></a></li>
            <li class="nav-item"><a href="{{route("solicitud.index")}}" class="nav-link" title="Proceso de solicitud de desembolso"><i class="nav-icon fas fa-cash-register"></i><p>Solicitud de Desembolso</p></a></li>
        @break

        @default
            
    @endswitch
</ul>