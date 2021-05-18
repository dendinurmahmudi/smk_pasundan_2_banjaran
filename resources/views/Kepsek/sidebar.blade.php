@section('sidebar')
<div class="navbar-default sidebar" role="navigation" id="side">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
            <ul class="nav m-t-5" id="side-menu">
                <li> <a href="/kepsek" class="waves-effect {{$warna[0]}}"><i class="fa fa-dashboard fa-fw" data-icon="v"></i> Dashboard</a> 
                </li>
                <li> <a href="/dataalumni1" class="waves-effect {{$warna[1]}}"><i class="icon-people fa-fw" data-icon="v"></i>Data Alumni</a> 
                </li>
                <li> <a href="/datapenelusuran1" class="waves-effect {{$warna[2]}}"><i class="ti-clipboard fa-fw" data-icon="v"></i>Data Penelusuran</a> 
                </li>
                <li> <a href="/dataperusahaan1" class="waves-effect {{$warna[3]}}"><i class="fa fa-building-o fa-fw" data-icon="v"></i>Data Perusahaan</a> 
                </li>
                <li><a href="/logout" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Log out</span></a></li>
                <li class="devider"></li>
            </ul>
        </div>
    </div>

    @endsection
