@php
    use Modules\Blog\App\Models\Blog;
    use Illuminate\Support\Str;

    $theme6_blog = getContent('theme6_blog.content', true);
    $blogs = Blog::with('translate:id,blog_id,lang_code,title,reading_time,description')
        ->where('status', true)
        ->latest()
        ->take(3)
        ->get();
@endphp

<!-- blog-area-start -->
<div class="tg-blog-area pt-130 pb-110 include-bg p-relative z-index-1"
    data-background="{{ asset('frontend/assets/img/shape/blog-shape-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tg-location-section-title text-center mb-30">
                    <h5 class="tg-section-subtitle mb-15 wow fadeInUp" data-wow-delay=".3s" data-wow-duration=".9s">
                        {{ getTranslatedValue($theme6_blog, 'sub_title') }}
                    </h5>
                    <h2 class="mb-15 text-capitalize wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".9s">
                        {!! strip_tags(clean(getTranslatedValue($theme6_blog, 'title')), '<br>') !!}
                    </h2>
                    <p class="text-capitalize wow fadeInUp" data-wow-delay=".5s" data-wow-duration=".9s">
                        {!! strip_tags(clean(getTranslatedValue($theme6_blog, 'description')), '<br>') !!}
                    </p>
                </div>
            </div>

            @if ($blogs->count() > 0)
                @foreach ($blogs as $key => $blog)
                    @php
                        if ($key == 0) {
                            $animation = 'fadeInLeft';
                        } elseif ($key == 1) {
                            $animation = 'fadeInUp';
                        } elseif ($key == 2) {
                            $animation = 'fadeInRight';
                        } else {
                            $animation = 'fadeInUp';
                        }
                    @endphp

                    <div class="col-xl-4 col-lg-6 col-md-6 wow {{ $animation }}" data-wow-delay=".4s"
                        data-wow-duration=".9s">
                        <div class="tg-blog-item tg-blog-2-item mb-25">
                            <div class="tg-blog-thumb p-relative fix mb-20">
                                <a href="{{ route('blog', ['slug' => $blog->slug]) }}">
                                    <img class="w-100" src="{{ asset($blog->image) }}"
                                        alt="{{ $blog?->translate?->title }}">
                                </a>
                                <span class="tg-blog-tag p-absolute">{{ $blog?->category?->name }}</span>
                            </div>
                            <div class="tg-blog-content  p-relative">
                                <h3 class="tg-blog-title">
                                    <a href="{{ route('blog', ['slug' => $blog->slug]) }}">
                                        {{ $blog?->translate?->title }}
                                    </a>
                                </h3>
                                <div class="tg-blog-date mb-10">
                                    <span class="mr-20"><i class="fa-light fa-calendar"></i>
                                        {{ $blog->created_at->format('jS M, Y') }}</span>

                                    @if ($blog?->translate?->reading_time)
                                        <span><i class="fa-regular fa-clock"></i>
                                            {{ $blog?->translate?->reading_time }} </span>
                                    @endif
                                </div>
                                <p class="tg-blog-text mb-0">
                                    {!! Str::limit($blog?->translate?->description, 100) !!}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12 wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".9s">
                    <div class="tg-blog-bottom text-center pt-15">
                        <p> {{ __('translate.Want to see our Recent News & Updates.') }} <a
                                href="{{ route('blogs') }}">{{ __('translate.Click here to View More') }}</a>
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- blog-area-end -->
@push('style_section')
    <style>
        .tg-blog-thumb.p-relative.fix.mb-20 img {
            height: 220px;
        }
    </style>
@endpush
