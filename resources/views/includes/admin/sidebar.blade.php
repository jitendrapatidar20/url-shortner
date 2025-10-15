<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow"/>
      <span class="brand-text fw-light">URL Shortner</span>
    </a>
  </div>
  <!--end::Sidebar Brand-->

  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
        
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Clients: Only visible for SuperAdmin -->
        @if(auth()->user()->hasRole('superAdmin'))
        <li class="nav-item {{ request()->is('admin/companies*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/companies*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-building"></i>
            <p>
              Clients
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.companies.index') }}" class="nav-link {{ request()->routeIs('admin.companies.index') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Clients List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.companies.create') }}" class="nav-link {{ request()->routeIs('admin.companies.create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Add Client</p>
              </a>
            </li>
          </ul>
        </li>
        @endif

        <!-- Short URLs -->
        <li class="nav-item {{ request()->is('admin/short-urls*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/short-urls*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-link-45deg"></i>
            <p>
              Short URLs
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.short_urls.index') }}" class="nav-link {{ request()->routeIs('admin.short_urls.index') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Short URL List</p>
              </a>
            </li>
            
            <!-- Create Short URL: Hidden for SuperAdmin -->
            @if(!auth()->user()->hasRole('SuperAdmin'))
            <li class="nav-item">
              <a href="{{ route('admin.short_urls.create') }}" class="nav-link {{ request()->routeIs('admin.short_urls.create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Create Short URL</p>
              </a>
            </li>
            @endif
          </ul>
        </li>

        <!-- Invitations -->
        <li class="nav-item {{ request()->is('admin/invitations*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/invitations*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-envelope"></i>
            <p>
              Invitations
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.invitations.index') }}" class="nav-link {{ request()->routeIs('admin.invitations.index') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Invitations List</p>
              </a>
            </li>


            @if(auth()->user()->hasRole('SuperAdmin') || auth()->user()->hasRole('Admin'))
            <li class="nav-item">
              <a href="{{ route('admin.invitations.create') }}" class="nav-link {{ request()->routeIs('admin.invitations.create') ? 'active' : '' }}">
                <i class="nav-icon bi bi-circle"></i>
                <p>Create Invitation</p>
              </a>
            </li>
            @endif
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</aside>
<!--end::Sidebar-->
