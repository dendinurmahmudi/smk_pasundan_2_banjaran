@section('sidebar')
<div class="navbar-default sidebar" role="navigation" id="side">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
            <ul class="nav" id="side-menu">
                <li> <a href="/kepsek" class="waves-effect"><i class="ti-dashboard fa-fw" data-icon="v"></i> Dashboard</a> 
                </li>
                <li> <a href="/dataperusahaan" class="waves-effect"><i class="ti-direction fa-fw" data-icon="v"></i> Perusahaan</a> 
                </li>
                <li><a href="/logout" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Log out</span></a></li>
                <li class="devider"></li>
            </ul>
        </div>
    </div>

    @endsection
