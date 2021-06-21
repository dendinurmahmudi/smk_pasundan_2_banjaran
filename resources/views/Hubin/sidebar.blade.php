@section('sidebar')
<div class="navbar-default sidebar" role="navigation" id="side">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
            <ul class="nav m-t-5" id="side-menu">
                <li> <a href="/hubin" class="waves-effect {{$warna[0]}} m-l-10"><i class="fa fa-dashboard fa-fw" data-icon="v"></i> Dashboard</a> 
                </li>
                <li> <a href="/dataalumni" class="waves-effect {{$warna[1]}} m-l-10"><i class="icon-people fa-fw" data-icon="v"></i> Alumni</a> 
                </li>
                <li> <a href="/datalamaran" class="waves-effect {{$warna[2]}} m-l-10"><i class="ti-email fa-fw" data-icon="v"></i> Apply lamaran</a> 
                </li>
                <li> <a href="/addinformasi" class="waves-effect {{$warna[3]}} m-l-10"><i class="ti-bell fa-fw" data-icon="v"></i> Informasi</a> 
                </li>
                <li> <a href="/datapenelusuran" class="waves-effect {{$warna[4]}} m-l-10"><i class="ti-clipboard fa-fw" data-icon="v"></i> Penelusuran</a> 
                </li>
                <li> <a href="/dataperusahaan" class="waves-effect {{$warna[5]}} m-l-10"><i class="fa fa-building-o fa-fw" data-icon="v"></i> Perusahaan</a> 
                </li>
                <li><a href="/logout" class="waves-effect m-l-10"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Log out</span></a></li>
                <li class="devider"></li>
            </ul>
        </div>
    </div>

    @endsection
