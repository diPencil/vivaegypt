@php
    use Modules\Blog\App\Models\Blog;
    use Illuminate\Support\Str;

    $theme5_blog = getContent('theme5_blog.content', true);
    $blogs = Blog::with('translate:id,blog_id,lang_code,title,reading_time,description')
        ->where('status', true)
        ->latest()
        ->take(3)
        ->get();
@endphp

<!-- blog-area-start -->
<div class="tg-blog-area pt-135 pb-105">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tg-location-section-title text-center mb-30">
                    <h5 class="tg-section-subtitle mb-15 wow fadeInUp" data-wow-delay=".3s" data-wow-duration=".9s">
                        {{ getTranslatedValue($theme5_blog, 'sub_title') }}
                    </h5>
                    <h2 class="mb-15 text-capitalize wow fadeInUp" data-wow-delay=".4s" data-wow-duration=".9s">
                        {!! strip_tags(clean(getTranslatedValue($theme5_blog, 'title')), '<br>') !!}
                    </h2>
                    <p class="text-capitalize wow fadeInUp" data-wow-delay=".5s" data-wow-duration=".9s">
                        {!! strip_tags(clean(getTranslatedValue($theme5_blog, 'description')), '<br>') !!}
                    </p>
                </div>
            </div>

            @if ($blogs->count() > 0)
                @php
                    $firstBlog = $blogs->get(0);
                    $restBlogs = $blogs->slice(1);
                @endphp
                <div class="col-lg-5 wow fadeInLeft" data-wow-delay=".4s" data-wow-duration=".9s">
                    <div class="tg-blog-item mb-25">
                        <div class="tg-blog-thumb fix left-side-img">
                            <a href="{{ route('blog', ['slug' => $firstBlog->slug]) }}">
                                <img class="w-100" src="{{ asset($firstBlog->image) }}"
                                    alt="{{ $firstBlog?->translate?->title }}">
                            </a>
                        </div>
                        <div class="tg-blog-content  p-relative">
                            <span class="tg-blog-tag p-absolute">{{ $firstBlog?->category?->name }}</span>
                            <h3 class="tg-blog-title">
                                <a href="{{ route('blog', ['slug' => $firstBlog->slug]) }}">
                                    {{ $firstBlog?->translate?->title }}
                                </a>
                            </h3>
                            <div class="tg-blog-date">
                                <span class="mr-20"><i class="fa-light fa-calendar"></i>
                                    {{ $firstBlog->created_at->format('jS M, Y') }}</span>
                                @if ($firstBlog?->translate?->reading_time)
                                    <span><i class="fa-regular fa-clock"></i>
                                        {{ $firstBlog?->translate?->reading_time }} </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row">
                        @foreach ($restBlogs as $i => $blog)
                            <div class="col-12 wow fadeInRight" data-wow-delay=".{{ $i + 4 }}s"
                                data-wow-duration=".9s">
                                <div class="tg-blog-item mb-20">
                                    <div class="row align-items-center">
                                        <div class="col-lg-5">
                                            <div class="tg-blog-thumb fix right-side-img">
                                                <a href="{{ route('blog', ['slug' => $blog->slug]) }}"><img
                                                        class="w-100" src="{{ asset($blog->image) }}"
                                                        alt="{{ $blog?->translate?->title }}"></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="tg-blog-contents">
                                                <span
                                                    class="tg-blog-tag d-inline-block mb-10">{{ $blog?->category?->name }}</span>
                                                <h3 class="tg-blog-title title-2 mb-0">
                                                    <a href="{{ route('blog', ['slug' => $blog->slug]) }}">
                                                        {{ $blog?->translate?->title }}
                                                    </a>
                                                </h3>
                                                <div class="tg-blog-date">
                                                    <span class="mr-20"><i class="fa-light fa-calendar"></i>
                                                        {{ $blog->created_at->format('jS M, Y') }}</span>
                                                    @if ($blog?->translate?->reading_time)
                                                        <span><i class="fa-regular fa-clock"></i>
                                                            {{ $blog?->translate?->reading_time }} </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- blog-area-end -->
@push('style_section')
    <style>
        .tg-blog-thumb.fix.left-side-img img {
            height: 260px;
        }

        .tg-blog-thumb.fix.right-side-img img {
            height: 167px;
        }
    </style>
@endpush
