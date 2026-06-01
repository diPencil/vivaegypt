@extends('theme::layouts.app')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
@endsection
@section('front-content')
    {{-- Hero + booking as one stack (overlap + card like reference) --}}
    <div class="theme2-home-hero-stack">
        @include('theme::components.hero')
        @include('theme::components.booking-form')
    </div>

    {{-- partner section --}}
    @include('theme::components.partner')

    {{-- destination section --}}
    @include('theme::components.destination')

    {{-- banner section --}}
    @include('theme::components.banner')

    {{-- package section --}}
    @include('theme::components.package')

    {{-- why choose section --}}
    @include('theme::components.why-choose')

    {{-- counter section --}}
    @include('theme::components.counter')

    {{-- testimonial section --}}
    @include('theme::components.testimonial')

    {{-- blog section --}}
    @include('theme::components.blog')

    {{-- cta section --}}
    @include('theme::components.cta')
@endsection
