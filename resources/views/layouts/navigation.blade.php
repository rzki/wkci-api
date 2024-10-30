<ul class="nav flex-column pt-3 pt-md-0">
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center">
            <span class="mt-1 ms-1 sidebar-text">
                JADE 2024
            </span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="nav-link" wire:navigate>
            <span class="sidebar-icon me-3">
                <i class="fas fa-chart-area"></i>
            </span>
            <span class="sidebar-text">{{ __('Dashboard') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('products.index') ? 'active' : '' }}" >
        <a href="{{ route('products.index') }}" class="nav-link" wire:navigate>
            <span class="sidebar-icon me-3">
                <i class="fas fa-boxes"></i>
            </span>
            <span class="sidebar-text">{{ __('Products') }}</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('forms.index') || request()->routeIs('forms.participant.index') ? 'active' : '' }}">
        <span class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
              data-bs-target="#forms">
            <span>
                <span class="sidebar-icon me-3">
                    <i class="fas fa-list-check"></i>
                </span>
                <span class="sidebar-text">{{ __('Forms') }}</span>
            </span>
            <span class="link-arrow">
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </span>
        </span>
        <div class="multi-level collapse" role="list" id="forms" aria-expanded="false">
            <ul class="flex-column nav">
                <li class="nav-item {{ request()->routeIs('forms.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('forms.index') }}" wire:navigate>
                        <span class="sidebar-text">{{ __('Hands-On & Seminar') }}</span>
                    </a>
                </li>
                <li class="nav-item  {{ request()->routeIs('forms.participant.index') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('forms.participant.index') }}" wire:navigate>
                        <span class="sidebar-text">{{ __('Participant') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
        <a href="{{ route('transactions.index') }}" class="nav-link" wire:navigate>
            <span class="sidebar-icon me-3">
                <i class="fas fa-rectangle-list"></i>
            </span>
            <span class="sidebar-text">{{ __('Transactions') }}</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}" class="nav-link" wire:navigate>
            <span class="sidebar-icon me-3">
                <i class="fas fa-user-alt fa-fw"></i>
            </span>
            <span class="sidebar-text">{{ __('Users') }}</span>
        </a>
    </li>


</ul>

