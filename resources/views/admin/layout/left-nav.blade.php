<style>
    .thirdSubMenu{
        text-indent: 8px;
    }
</style>
<nav class="pcoded-navbar" pcoded-header-position="relative">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <img class="img-40" src="{{asset('admin/assets/images/user.png')}}" alt="User-Profile-Image">
                <div class="user-details">
                    <span>{{auth()->user()->name}}</span>
                    {{--<span id="more-details">UX Designer<i class="ti-angle-down"></i></span>--}}
                </div>
            </div>

            <div class="main-menu-content">
                <ul>
                    <li class="more-details">
                        {{--<a href="user-profile.html"><i class="ti-user"></i>View Profile</a>--}}
                        {{--<a href="#!"><i class="ti-settings"></i>Settings</a>--}}
                        <a href="javascript:void(0)" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="ti-layout-sidebar-left"></i>Logout</a>

                        <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation" menu-title-theme="theme5">Navigation</div>

        <ul class="pcoded-item pcoded-left-item">
            <li class="pcoded-hasmenu" dropdown-icon="style3" subitem-icon="style6">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.page_layout.main">Setting</span>
                    <span class="pcoded-badge label label-warning">NEW</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    {{--Sub Menu--}}
                    <li class="pcoded-hasmenu "  dropdown-icon="style3" subitem-icon="style6">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Vertical</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu thirdSubMenu">
                            {{--third subMenu--}}
                            <li class=" ">
                                <a href="menu-static.html" data-i18n="nav.page_layout.vertical.static-layout">
                                    <span class="pcoded-micon"><i class="icon-chart"></i></span>
                                    <span class="pcoded-mtext">Static Layout</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    {{--Sub Menu--}}
                    <li class=" ">
                        <a href="menu-rtl.html" target="_blank" data-i18n="nav.page_layout.rtl">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">RTL</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                </ul>
            </li>
            {{--Main Menu--}}
            <li class="pcoded-hasmenu" dropdown-icon="style3" subitem-icon="style6">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.page_layout.main">Setting</span>
                    <span class="pcoded-badge label label-warning">NEW</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    {{--Sub Menu--}}
                    <li class="pcoded-hasmenu "  dropdown-icon="style3" subitem-icon="style6">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Vertical</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu thirdSubMenu">
                            {{--third subMenu--}}
                            <li class=" ">
                                <a href="menu-static.html" data-i18n="nav.page_layout.vertical.static-layout">
                                    <span class="pcoded-micon"><i class="icon-chart"></i></span>
                                    <span class="pcoded-mtext">Static Layout</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    {{--Sub Menu--}}
                    <li class=" ">
                        <a href="menu-rtl.html" target="_blank" data-i18n="nav.page_layout.rtl">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">RTL</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                </ul>
            </li>

        </ul>

    </div>
</nav>