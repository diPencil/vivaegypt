@extends('layout_inner_page')

@section('title')
    <title>{{ __('translate.Sign Up') }}</title>
@endsection

@section('front-content')
    @include('breadcrumb')

    <!-- login-area-start -->
    <div class="tg-login-area pt-130 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="tg-login-wrapper">
                        <div class="tg-login-top text-center mb-30">
                            <h2>{{ __('translate.Register Now!') }}</h2>
                            <p>{{ __('translate.You can signup with you social account below') }}</p>
                        </div>
                        <div class="tg-login-form">
                            <div class="tg-tour-about-review-form">
                                <form method="POST" action="{{ route('user.store-register') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 mb-25">
                                            <input class="input" name="name" type="text"
                                                placeholder="{{ __('translate.Name') }} *" value="{{ old('name') }}">
                                        </div>
                                        <div class="col-lg-12 mb-25">
                                            <input class="input" name="username" type="text"
                                                placeholder="{{ __('translate.Username') }} *" value="{{ old('username') }}">
                                        </div>
                                        <div class="col-lg-12 mb-25">
                                            <input class="input" type="email" placeholder="{{ __('translate.Email') }} *"
                                                name="email" value="{{ old('email') }}">
                                        </div>
                                        <div class="col-lg-6 mb-25">
                                            <input class="input" name="phone" type="text"
                                                placeholder="{{ __('translate.Phone') }} *" value="{{ old('phone') }}">
                                        </div>
                                        <div class="col-lg-6 mb-25">
                                            <select class="form-select input" name="gender" style="height: 60px; border-radius: 10px; border: 1px solid #ddd; padding: 0 20px;">
                                                <option value="">{{ __('translate.Select Gender') }} *</option>
                                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>{{ __('translate.Male') }}</option>
                                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>{{ __('translate.Female') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 mb-25">
                                            @php
                                                $countries = array("Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Côte d'Ivoire", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czechia", "Democratic Republic of the Congo", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Holy See", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Palestine State", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe");
                                            @endphp
                                            <select name="country" class="form-select input" style="height: 60px; border-radius: 10px; border: 1px solid #ddd; padding: 0 20px;">
                                                <option value="">{{ __('translate.Select Country') }} *</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country }}" {{ old('country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-12 mb-25">
                                            <input class="input" type="password"
                                                placeholder="{{ __('translate.Password') }} *" name="password">
                                        </div>
                                        <div class="col-lg-12 mb-25">
                                            <input class="input" type="password"
                                                placeholder="{{ __('translate.Confirm Password') }} *"
                                                name="password_confirmation">
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="review-checkbox d-flex align-items-center mb-25">
                                                    <input class="tg-checkbox" type="checkbox" id="australia">
                                                    <label for="australia"
                                                        class="tg-label">{{ __('translate.Remember me') }}</label>
                                                </div>
                                                <div class="tg-login-navigate mb-25">
                                                    <a href="{{ route('user.login') }}">{{ __('translate.Login') }}</a>
                                                </div>
                                            </div>

                                            @if ($general_setting->recaptcha_status == 1)
                                                <div class="td_mb_10">
                                                    <div class="g-recaptcha"
                                                        data-sitekey="{{ $general_setting->recaptcha_site_key }}"></div>
                                                </div>
                                            @endif

                                            <button type="submit"
                                                class="tg-btn w-100">{{ __('translate.Sign Up') }}</button>

                                            <div class="d-flex gap-3 justify-content-center align-items-center mt-4">
                                                <div class="edc-line-sperator"></div>
                                                <p class="td_fs_20 mb-0 td_medium td_heading_color">
                                                    {{ __('translate.or sign up with') }}</p>
                                                <div class="edc-line-sperator"></div>
                                            </div>

                                            <div class="mt-20 gap-4 d-flex justify-content-center">

                                                @if ($general_setting->is_gmail == 1)
                                                    <a href="{{ route('user.login-google') }}" class="td_center">
                                                        <i class="fa-brands fa-google"></i>
                                                    </a>
                                                @endif

                                                @if ($general_setting->is_facebook == 1)
                                                    <a href="{{ route('user.login-facebook') }}" class="td_center">
                                                        <i class="fa-brands fa-facebook-f"></i>
                                                    </a>
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login-area-end -->
@endsection

@push('js_section')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
