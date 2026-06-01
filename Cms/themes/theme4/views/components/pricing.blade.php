@php
    $pricing_heading_section = getContent('pricing_heading_section.content', true);

    // basic plan
    $basic_package_plan = getContent('basic_package_plan.content', true);
    $basic_package_plan_features = getTranslatedSlides($basic_package_plan, 'slides');

    // standard plan
    $standard_package_plan = getContent('standard_package_plan.content', true);
    $standard_package_plan_features = getTranslatedSlides($standard_package_plan, 'slides');

    // standard plan
    $cooperate_package_plan = getContent('cooperate_package_plan.content', true);
    $cooperate_package_plan_features = getTranslatedSlides($cooperate_package_plan, 'slides');

@endphp

<!-- tg-pricing-area-start -->
<div class="tg-pricing-area tg-pricing-su-wrap pb-100 pt-130 p-relative z-index-1">
    <img class="tg-pricing-su-shape d-none d-md-block p-absolute" src="{{ asset('frontend/assets/img/shape/tower.png') }}"
        alt="">
    <img class="tg-pricing-su-shape-2 p-absolute d-none d-md-block"
        src="{{ asset('frontend/assets/img/shape/parasut.png') }}" alt="">
    <div class="container">
        <div class="row">

            @if ($pricing_heading_section)
                <div class="col-lg-12">
                    <div class="tg-pricing-section-title-wrap text-center mb-40">
                        <h5 class="tg-section-su-subtitle su-subtitle-2 mb-15 wow fadeInUp" data-wow-delay=".4s"
                            data-wow-duration=".9s">{{ getTranslatedValue($pricing_heading_section, 'sub_title') }}</h5>
                        <h2 class="tg-section-su-title text-capitalize wow fadeInUp mb-15" data-wow-delay=".5s"
                            data-wow-duration=".9s">
                            {!! strip_tags(clean(getTranslatedValue($pricing_heading_section, 'title')), '<br>') !!}
                        </h2>
                    </div>
                </div>
            @endif

            @if ($basic_package_plan)
                <div class="col-lg-4 col-md-6">
                    <div class="tg-pricing-wrap mb-30 wow fadeInUp" data-wow-delay=".3s" data-wow-duration=".9s">
                        <div class="tg-pricing-head">
                            <h4 class="tg-pricing-title mb-15">
                                {{ getTranslatedValue($basic_package_plan, 'title') }}
                            </h4>
                            <p class="mb-25">
                                {{ getTranslatedValue($basic_package_plan, 'short_description') }}
                            </p>
                        </div>
                        <div class="tg-pricing-price mb-25">
                            <h2><span>$</span>{{ getTranslatedValue($basic_package_plan, 'price') }}
                            </h2>
                            <span class="dates">{{ getTranslatedValue($basic_package_plan, 'time_period') }}</span>
                        </div>
                        <div class="tg-pricing-btns mb-40">
                            <a class="tg-btn text-center w-100"
                                href="{{ getTranslatedValue($basic_package_plan, 'button_url') }}">
                                {{ getTranslatedValue($basic_package_plan, 'button_text') }}
                            </a>
                        </div>
                        <div class="tg-pricing-list">
                            <ul>
                                @foreach ($basic_package_plan_features as $key => $feature)
                                    <li>
                                        <span class="icon">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17 8.26858V9.00458C16.999 10.7297 16.4404 12.4083 15.4075 13.79C14.3745 15.1718 12.9226 16.1826 11.2683 16.6717C9.61394 17.1608 7.8458 17.1021 6.22757 16.5042C4.60934 15.9064 3.22772 14.8015 2.28877 13.3542C1.34981 11.907 0.903833 10.195 1.01734 8.47363C1.13085 6.75223 1.79777 5.11364 2.91862 3.80224C4.03948 2.49083 5.55423 1.57688 7.23695 1.1967C8.91967 0.816507 10.6802 0.990449 12.256 1.69258M17 2.60458L9 10.6126L6.6 8.21258"
                                                    stroke="#C62828" stroke-width="1.8" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span>
                                            {{ $feature['title'] }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if ($standard_package_plan)
                <div class="col-lg-4 col-md-6">
                    <div class="tg-pricing-wrap br-none mb-30 wow fadeInUp" data-wow-delay=".5s"
                        data-wow-duration=".9s">
                        <div class="tg-pricing-head">
                            <h4 class="tg-pricing-title mb-15">
                                {{ getTranslatedValue($standard_package_plan, 'title') }}
                            </h4>
                            <p class="mb-25">
                                {{ getTranslatedValue($standard_package_plan, 'short_description') }}
                            </p>
                        </div>
                        <div class="tg-pricing-price mb-25">
                            <h2><span>$</span>{{ getTranslatedValue($standard_package_plan, 'price') }}</h2>
                            <span class="dates">{{ getTranslatedValue($standard_package_plan, 'time_period') }}</span>
                        </div>
                        <div class="tg-pricing-btns mb-40">
                            <a class="tg-btn text-center w-100"
                                href="{{ getTranslatedValue($standard_package_plan, 'button_url') }}">
                                {{ getTranslatedValue($standard_package_plan, 'button_text') }}
                            </a>
                        </div>
                        <div class="tg-pricing-list">
                            <ul>
                                @foreach ($standard_package_plan_features as $key => $feature)
                                    <li>
                                        <span class="icon">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17 8.26858V9.00458C16.999 10.7297 16.4404 12.4083 15.4075 13.79C14.3745 15.1718 12.9226 16.1826 11.2683 16.6717C9.61394 17.1608 7.8458 17.1021 6.22757 16.5042C4.60934 15.9064 3.22772 14.8015 2.28877 13.3542C1.34981 11.907 0.903833 10.195 1.01734 8.47363C1.13085 6.75223 1.79777 5.11364 2.91862 3.80224C4.03948 2.49083 5.55423 1.57688 7.23695 1.1967C8.91967 0.816507 10.6802 0.990449 12.256 1.69258M17 2.60458L9 10.6126L6.6 8.21258"
                                                    stroke="#C62828" stroke-width="1.8" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span>
                                            {{ $feature['title'] }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if ($cooperate_package_plan)
                <div class="col-lg-4 col-md-6">
                    <div class="tg-pricing-wrap mb-30 wow fadeInUp" data-wow-delay=".7s" data-wow-duration=".9s">
                        <div class="tg-pricing-head">
                            <h4 class="tg-pricing-title mb-15">
                                {{ getTranslatedValue($cooperate_package_plan, 'title') }}</h4>
                            <p class="mb-25">
                                {{ getTranslatedValue($cooperate_package_plan, 'short_description') }}
                            </p>
                        </div>
                        <div class="tg-pricing-price mb-25">
                            <h2><span>$</span>{{ getTranslatedValue($cooperate_package_plan, 'price') }}</h2>
                            <span
                                class="dates">{{ getTranslatedValue($cooperate_package_plan, 'time_period') }}</span>
                        </div>
                        <div class="tg-pricing-btns mb-40">
                            <a class="tg-btn text-center w-100"
                                href="{{ getTranslatedValue($cooperate_package_plan, 'button_url') }}">{{ getTranslatedValue($cooperate_package_plan, 'button_text') }}</a>
                        </div>
                        <div class="tg-pricing-list">
                            <ul>
                                @foreach ($cooperate_package_plan_features as $key => $feature)
                                    <li>
                                        <span class="icon">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M17 8.26858V9.00458C16.999 10.7297 16.4404 12.4083 15.4075 13.79C14.3745 15.1718 12.9226 16.1826 11.2683 16.6717C9.61394 17.1608 7.8458 17.1021 6.22757 16.5042C4.60934 15.9064 3.22772 14.8015 2.28877 13.3542C1.34981 11.907 0.903833 10.195 1.01734 8.47363C1.13085 6.75223 1.79777 5.11364 2.91862 3.80224C4.03948 2.49083 5.55423 1.57688 7.23695 1.1967C8.91967 0.816507 10.6802 0.990449 12.256 1.69258M17 2.60458L9 10.6126L6.6 8.21258"
                                                    stroke="#C62828" stroke-width="1.8" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span>
                                            {{ $feature['title'] }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- tg-pricing-area-end -->
