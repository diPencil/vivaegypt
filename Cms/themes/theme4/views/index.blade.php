@extends('theme::layouts.app')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
    <meta name="title" content="{{ $seo_setting->seo_title }}">
    <meta name="description" content="{!! strip_tags(clean($seo_setting->seo_description)) !!}">
@endsection
@section('front-content')
    {{-- hero section --}}
    @include('theme::components.hero')

    {{-- tour package section --}}
    @include('theme::components.tour-package')

    {{-- why choose section --}}
    @include('theme::components.why-choose')

    {{-- destination section --}}
    @include('theme::components.destination')

    {{-- work process section --}}
    @include('theme::components.work-process')

    {{-- pricing section --}}
    @include('theme::components.pricing')

    {{-- counter section --}}
    @include('theme::components.counter')

    {{-- cta section --}}
    @include('theme::components.cta')

    {{-- testimonial section --}}
    @include('theme::components.testimonial')

    {{-- blog section --}}
    @include('theme::components.blog')


@endsection
