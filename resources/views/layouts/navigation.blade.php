<ul class="nav flex-column pt-3 pt-md-0">
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center">
            <span class="mt-1 ms-1 sidebar-text">
                JADE 2024
            </span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="nav-link"wire:navigate>
            <span class="sidebar-icon me-3">
                <i class="fas fa-chart-area"></i>
            </span>
            <span class="sidebar-text">{{ __('Dashboard') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('products.index') ? 'active' : '' }}" >
        <a href="{{ route('products.index') }}" class="nav-link"wire:navigate>
            <span class="sidebar-icon me-3">
                <i class="fas fa-boxes"></i>
            </span>
            <span class="sidebar-text">{{ __('Products') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('forms.index') ? 'active' : '' }}">
        <a href="{{ route('forms.index') }}" class="nav-link"wire:navigate>
            <span class="sidebar-icon me-3">
                <i class="fas fa-list-check"></i>
            </span>
            <span class="sidebar-text">{{ __('Form') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-user-alt fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Users') }}</span>
        </a>
    </li>

    <li class="nav-item">
        <span class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            data-bs-target="#submenu-app">
            <span>
                <span class="sidebar-icon me-3">
                    <i class="fas fa-circle fa-fw"></i>
                </span>
                <span class="sidebar-text">Two-level menu</span>
            </span>
            <span class="link-arrow">
                <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd">
                    </path>
                </svg>
            </span>
        </span>
        <div class="multi-level collapse" role="list" id="submenu-app" aria-expanded="false">
            <ul class="flex-column nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="sidebar-icon">
                            <i class="fas fa-circle"></i>
                        </span>
                        <span class="sidebar-text">Child menu</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
</ul>

