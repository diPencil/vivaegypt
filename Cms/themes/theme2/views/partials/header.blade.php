
{{-- <header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/">
                @if(isset($header_content->logo))
                    <img src="{{ asset($header_content->logo) }}" alt="{{ $seo_setting->site_name ?? 'VivaEgyptTravel' }}" height="40">
                @else
                    {{ $seo_setting->site_name ?? 'VivaEgyptTravel' }}
                @endif
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @foreach(app('Theme\Theme1\Services\Theme1Service')->getNavigation() as $item)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->url() == $item['url'] ? 'active' : '' }}" href="{{ $item['url'] }}">
                                <i class="{{ $item['icon'] }} me-1"></i>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach

                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('user.login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> {{ __('translate.Login') }} </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <img src="{{ auth()->user()->avatar ?? asset('backend/images/avatar.png') }}"
                                     alt="{{ auth()->user()->name }}"
                                     class="rounded-circle me-1"
                                     width="30">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-1"></i> {{ __('translate.Dashboard') }} </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                                        <i class="fas fa-user me-1"></i> {{ __('translate.Profile') }} </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-1"></i> {{ __('translate.Logout') }} </a>
                                </li>
                            </ul>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header> --}}

@push('styles')
<style>
    .site-header {
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .navbar-brand img {
        max-height: 40px;
        width: auto;
    }

    .nav-item .nav-link {
        padding: 0.5rem 1rem;
        color: var(--dark-color);
        transition: color 0.3s ease;
    }

    .nav-item .nav-link:hover,
    .nav-item .nav-link.active {
        color: var(--primary-color);
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
        color: var(--dark-color);
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: var(--light-color);
        color: var(--primary-color);
    }
</style>
@endpush
