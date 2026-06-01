@extends('theme::layouts.app')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
@endsection
@section('front-content')


    {{-- hero section --}}
    @include('theme::components.hero')

    {{-- ads section --}}
    @include('theme::components.ads')

    {{-- tour package section --}}
    @include('theme::components.tour-package')

    {{-- why choose section --}}
    @include('theme::components.why-choose')

    {{-- banner section --}}
    @include('theme::components.banner')

    {{-- destination section --}}
    @include('theme::components.destination')

    {{-- banner 2 section --}}
    @include('theme::components.banner-two')

    {{-- counter section --}}
    @include('theme::components.counter')

    {{-- cta section --}}
    @include('theme::components.cta')

    {{-- testimonial section --}}
    @include('theme::components.testimonial')

    {{-- partner section --}}
    @include('theme::components.partner')

    {{-- blog section --}}
    @include('theme::components.blog')
@endsection
