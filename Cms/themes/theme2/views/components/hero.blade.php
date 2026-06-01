@php
    $home2_hero = getContent('theme2_hero.content', true);
@endphp

@if ($home2_hero)
    <!-- tg-hero-area-start -->
    {{-- Full-bleed hero: no container/grid — edge-to-edge via custom.css --}}
    <div class="tg-hero-area tg-grey-bg theme2-hero--fullwidth">
        <div class="tg-hero-2-content include-bg text-center"
            style="min-height: 60vh !important; padding-top: 140px !important; padding-bottom: 180px !important;"
            data-background="{{ asset(getSingleImage($home2_hero, 'background_image')) }}">
            <h2 class="tg-hero-2-title mb-0" style="margin-bottom: -10px !important;">
                {{ getTranslatedValue($home2_hero, 'title') }}
            </h2>
            @if (getTranslatedValue($home2_hero, 'description'))
                <p class="tg-hero-2-description theme2-hero-subline mt-0 mx-auto" style="color: var(--tg-common-white); font-size: 54px; font-weight: 600; text-transform: capitalize; max-width: 900px; text-shadow: 0 2px 5px rgba(0,0,0,0.4); line-height: 1.2;">
                    {{ strip_tags(getTranslatedValue($home2_hero, 'description')) }}
                </p>
            @endif
        </div>
    </div>
    <!-- tg-hero-area-end -->
@endif
