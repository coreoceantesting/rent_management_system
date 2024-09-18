<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('admin/images/Group 1 copy 2.png') }}" alt="" height="22" />
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/images/sidebarlogo3.png') }}" alt="" height="17" />
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('admin/images/Group 1 copy 2.png') }}" alt="" height="35" />
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/images/sidebarlogo3.png') }}" alt="" height="35" />
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title">
                    <span data-key="t-menu">Menu</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}" >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                @canany(['wards.view', 'wards.create'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarLayoutsOne" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                            <i class="ri-layout-3-line"></i>
                            <span data-key="t-layouts">Masters</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarLayoutsOne">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('regions.index') }}" class="nav-link" data-key="t-horizontal">Regions</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('wards.index') }}" class="nav-link" data-key="t-horizontal">Wards</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan


                @canany(['users.view', 'roles.view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarLayoutsTwo" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="bx bx-user-circle"></i>
                        <span data-key="t-layouts">User Management</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLayoutsTwo">
                        <ul class="nav nav-sm flex-column">
                            @can('users.view')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link" data-key="t-horizontal">Users</a>
                                </li>
                            @endcan
                            @can('roles.view')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link" data-key="t-horizontal">Roles</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @can('SchemeDetails.list')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('schemes.index') }}" >
                            <i class="ri-stack-fill"></i>
                            <span data-key="t-dashboards">Scheme Details</span>
                        </a>
                    </li>
                @endcan

                @can('TenantsDetails.list')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('getTenantsList') }}" >
                            <i class="ri-list-check"></i>
                            <span data-key="t-dashboards">Tenants List</span>
                        </a>
                    </li> 

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('tenants.index') }}" >
                            <i class="ri-file-list-fill"></i>
                            <span data-key="t-dashboards">Tenants Details</span>
                        </a>
                    </li>                    
                @endcan
                
                @can('HOD.rentApporval')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('getRentHistoryList') }}" >
                            <i class="ri-task-line"></i>
                            <span data-key="t-dashboards">Rent List For Approval</span>
                        </a>
                    </li>
                @endcan
                    
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>


<div class="vertical-overlay"></div>
