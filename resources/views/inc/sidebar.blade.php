@php
$segment1 = Request::segment(1);
$segment2 = Request::segment(2);
@endphp
 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo">
                <img src="{{ asset('storage/avatars/Final-Logo0.png') }}" alt="Agent Avatar" class="agent-avatar">

              </span>
              <span class="app-brand-text demo menu-text fw-bold ms-2">SavTech Digital</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item {{ $segment1 === 'dashboard' ? 'active open' : null }}">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Dashboards">Dashboards</div>
                <span class="badge rounded-pill bg-danger ms-auto">5</span>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ $segment1 === 'dashboard' && $segment2 === null ? 'active' : null }} {{ $segment1 === 'dashboard' && $segment2 != null ? 'active' : null }}">
                    <a href="{{ url('dashboard') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Analytics">Analytics</div>
                  </a>
                </li>
          
              </ul>
            </li>

            <!-- Layouts -->
            {{-- <li class="menu-item">
              <a href="{{ url('stores') }}" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div class="text-truncate" data-i18n="Layouts">Store</div>
              </a>

              <ul class="menu-sub">
               
                <li class="menu-item">
                  <a href="{{ url('stores') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Blank">Blank</div>
                  </a>
                </li>
              </ul>
            </li> --}}
            <li class="menu-item {{ $segment1 === 'stores' ? 'active' : null }}">
              <a
                href="{{ url('stores') }}"
                {{-- target="_blank" --}}
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                {{-- <i class="menu-icon tf-icons bx bx-envelope"></i> --}}
                <div class="text-truncate" data-i18n="Email">Store</div>
                {{-- <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div> --}}
              </a>
            </li>
            <li class="menu-item {{ $segment1 === 'brands' ? 'active' : null }}">
              <a
                href="{{ url('brands') }}"
                {{-- target="_blank" --}}
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                {{-- <i class="menu-icon tf-icons bx bx-envelope"></i> --}}
                <div class="text-truncate" data-i18n="Email">Brand</div>
                {{-- <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div> --}}
              </a>
            </li>
            @if (auth()->user()->hasAnyRole(['SuperAdmin','SuperVisor']))


            <!-- Apps & Pages -->
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Roles &amp; Permissions</span>
            </li>
            
        
            <!-- Pages -->
            <li class="menu-item {{ in_array($segment1, ['roles', 'permissions']) ? 'active open' : null }}">
              <a href="{{ url('dashboard') }}" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div class="text-truncate" data-i18n="Account Settings">Management</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ $segment1 === 'roles' ? 'active' : null }}">
                  <a href="{{ url('roles') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Role</div>
                  </a>
                </li>
                <li class="menu-item {{ $segment1 === 'permissions' ? 'active' : null }}">
                  <a href="{{ url('permissions') }}" class="menu-link">
                    <div class="text-truncate" data-i18n="Notifications">Permission</div>
                  </a>
                </li>
              </ul>
            </li>
            
            @endif
             <!-- Apps & Pages -->
             <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Track &amp; Records</span>
            </li>
            
            <li class="menu-item {{ $segment1 === 'orders' ? 'active' : null }}">
              <a
                href="{{ url('orders') }}"
                {{-- target="_blank" --}}
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                {{-- <i class="menu-icon tf-icons bx bx-envelope"></i> --}}
                <div class="text-truncate" data-i18n="Email">Order</div>
                {{-- <div class="badge rounded-pill bg-label-primary text-uppercase fs-tiny ms-auto">Pro</div> --}}
              </a>
            </li>
            </li>
           
          </ul>
        </aside>