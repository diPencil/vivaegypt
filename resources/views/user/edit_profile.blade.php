@extends('user.master_layout')
@section('title')
    <title>{{ __('translate.My Profile') }}</title>
@endsection
@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Edit Profile') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Edit Profile') }}</p>
@endsection
@section('body-content')
    <!-- crancy Dashboard -->
    <section class="crancy-adashboard crancy-show">
        <div class="container container__bscreen">
            <div class="row">
                <div class="col-12">
                    <div class="crancy-body">
                        <!-- Dashboard Inner -->
                        <div class="crancy-dsinner">
                            <form action="{{ route('user.update-profile') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12 mg-top-30">
                                        <!-- Product Card -->
                                        <div class="crancy-product-card">
                                            <h4 class="crancy-product-card__title">{{ __('translate.Basic Information') }}</h4>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="crancy__item-form--group mg-top-25 w-100">
                                                        <div class="crancy-product-card__upload crancy-product-card__upload--border">
                                                            <input type="file" class="btn-check" name="image" id="input-img1" autocomplete="off" onchange="reviewImage(event)">
                                                            <label class="crancy-image-video-upload__label" for="input-img1">
                                                                @if ($user->image)
                                                                <img id="view_img" src="{{ asset($user->image) }}">
                                                                @else
                                                                <img id="view_img" src="{{ asset($general_setting->placeholder_image) }}">
                                                                @endif

                                                                <h4 class="crancy-image-video-upload__title">{{ __('translate.Click here to') }} <span class="crancy-primary-color">{{ __('translate.Choose File') }}</span> {{ __('translate.and upload') }} </h4>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.UserID') }}</label>
                                                <input class="crancy__item-input" type="text" value="{{ $user->user_id_number }}" readonly>
                                            </div>

                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Name') }} *</label>
                                                <input class="crancy__item-input" type="text" name="name" value="{{ html_decode($user->name) }}">
                                            </div>

                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Username') }}</label>
                                                <input class="crancy__item-input" type="text" value="{{ html_decode($user->username) }}" readonly autocomplete="off">
                                            </div>


                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Email') }} *</label>
                                                <input class="crancy__item-input" type="email" name="email" value="{{ html_decode($user->email) }}" readonly>
                                            </div>


                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Phone') }} *</label>
                                                <input class="crancy__item-input" type="text" name="phone" value="{{ html_decode($user->phone) }}">
                                            </div>

                                            <div class="crancy__item-form--group mg-top-form-20">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Gender') }} * </label>
                                                <select class="form-select crancy__item-input" name="gender">
                                                    <option value="">{{ __('translate.Select') }}</option>
                                                    <option {{ $user->gender == 'Male' ? 'selected' : '' }} value="Male">{{ __('translate.Male') }}</option>
                                                    <option {{ $user->gender == 'Female' ? 'selected' : '' }} value="Female">{{ __('translate.Female') }}</option>
                                                    <option {{ $user->gender == 'Others' ? 'selected' : '' }} value="Others">{{ __('translate.Others') }}</option>

                                                </select>
                                            </div>

                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Country') }} *</label>
                                                @php
                                                    $countries = array("Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Côte d'Ivoire", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czechia", "Democratic Republic of the Congo", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Holy See", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Palestine State", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe");
                                                @endphp
                                                <select name="country" class="form-select crancy__item-input">
                                                    <option value="">{{ __('translate.Select') }}</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country }}" {{ $user->country == $country ? 'selected' : '' }}>{{ $country }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="crancy__item-form--group mg-top-25">
                                                <label class="crancy__item-label crancy__item-label-product">{{ __('translate.Address') }}</label>
                                                <input class="crancy__item-input" type="text" name="address" value="{{ html_decode($user->address) }}">
                                            </div>


                                            <button class="crancy-btn mg-top-25" type="submit">{{ __('translate.Update') }}</button>

                                        </div>
                                        <!-- End Product Card -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End Dashboard Inner -->
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End crancy Dashboard -->
@endsection

@push('js_section')
    <script>
        "use strict";

        function reviewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('view_img');
                output.src = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
@endpush
