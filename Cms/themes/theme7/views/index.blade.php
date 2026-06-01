@extends('theme::layouts.app')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
@endsection
@section('front-content')

    {{-- hero section --}}
    @include('theme::components.hero')

    {{-- food category section --}}
    @include('theme::components.food-category')

    {{-- tour package section --}}
    @include('theme::components.tour-package')

    {{-- banner section --}}
    @include('theme::components.banner')

    {{-- counter section --}}
    @include('theme::components.counter')

    {{-- why choose section --}}
    @include('theme::components.why-choose')

    {{-- destination section --}}
    @include('theme::components.destination')

    {{-- testimonial section --}}
    @include('theme::components.testimonial')

    {{-- partner section --}}
    @include('theme::components.partner')

    {{-- blog section --}}
    @include('theme::components.blog')

    {{-- cta section --}}
    @include('theme::components.cta')

@endsection
