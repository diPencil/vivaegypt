{{-- Thin top bar: location + email (left), phone + login (right). Uses footer contact fields. --}}
<div class="tg-header-top tg-header-top-space tg-primary-bg d-none d-lg-block">
    <div class="container-fluid container-1860">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                @if ($footer->address || $footer->email)
                    <div class="tg-header-top-info d-flex align-items-center flex-nowrap">
                        @if ($footer->address)
                            <a class="tg-topbar-address" href="{{ $footer->address_url ?: '#' }}"><i
                                    class="mr-5 fa-regular fa-location-dot"></i> {{ __('brand.office_hurghada') }}</a>
                        @endif
                        @if ($footer->address && $footer->email)
                            <span class="tg-header-dvdr mr-20 ml-20"></span>
                        @endif
                        @if ($footer->email)
                            <a class="tg-topbar-email" href="mailto:{{ $footer->email }}"><i class="mr-5 fa-regular fa-envelope"></i>
                                {{ $footer->email }}</a>
                        @endif
                    </div>
                @endif
            </div>
            <div>
                <div class="tg-header-top-info d-flex align-items-center justify-content-end flex-nowrap">
                    @if ($footer->phone)
                        <a class="tg-topbar-phone" href="tel:{{ $footer->phone }}"><i class="fa-sharp fa-regular fa-phone"></i>
                            {{ $footer->phone }}</a>
                    @endif
                    <span class="tg-header-dvdr mr-10 ml-10"></span>
                    @guest('web')
                        <a class="tg-topbar-login" href="{{ route('user.login') }}"><i class="fa-regular fa-user"></i>
                            {{ __('translate.Login') }}</a>
                    @else
                        @php($authUser = Auth::guard('web')->user())
                        <a class="tg-topbar-login"
                            href="{{ $authUser?->isStaff() ? route('staff.dashboard') : ($authUser->is_seller == 1 ? route('agent.dashboard') : route('user.dashboard')) }}"><i
                                class="fa-regular fa-user"></i> {{ __('translate.Dashboard') }}</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>
