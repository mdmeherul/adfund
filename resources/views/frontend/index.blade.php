@extends('frontend.layouts.master')

@php
    $defualt = get_default_language_code()??'en';
    // $default_lng = 'en';
    $default_lng = App\Constants\LanguageConst::NOT_REMOVABLE;
    $about_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::ABOUT_SECTION);
    $about = App\Models\Admin\SiteSections::getData( $about_slug)->first();
    $download_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::DOWNLOAD_SECTION);
    $download = App\Models\Admin\SiteSections::getData( $download_slug)->first();
    $video_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::VIDEO_SECTION);
    $video = App\Models\Admin\SiteSections::getData( $video_slug)->first();
    $app_settings = App\Models\Admin\AppSettings::first();

@endphp
@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="banner-section">
    <div class="banner-bg">
        <img src="{{ get_image(@$homeBanner->value->images->banner_image,'site-section') }}" alt="banner">
    </div>
    <div class="banner-shape">
        <img src="{{ asset('public/frontend/') }}/images/map.jpg" alt="banner-shape">
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-7 col-lg-7 col-md-12">
                <div class="banner-content">
                    <h1 class="title">{{__( @$homeBanner->value->language->$defualt->heading ?? @$homeBanner->value->language->$default_lng->heading ) }}</h1>
                    <p>{{ __(@$homeBanner->value->language->$defualt->sub_heading ?? @$homeBanner->value->language->$default_lng->sub_heading) }}</p>
                    <div class="banner-btn">
                        <a href="{{ url($homeBanner->value->language->$defualt->button_link ?? '') }}" class="btn--base"><i class="las la-heart"></i> {{ __(@$homeBanner->value->language->$defualt->button_name) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start About
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="about-section ptb-120">
    <div class="about-shape">
        <img src="{{ asset('public/frontend/') }}/images/about/right-shape.png" alt="shape">
    </div>
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="about-thumb">
                    <img src="{{ get_image(@$about->value->images->first_section_image,'site-section') }}" alt="about">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="about-content">
                    <div class="sub-title">{{ __(@$about->value->language->$defualt->fitst_section_title ?? @$about->value->language->$default_lng->fitst_section_title) }}</div>
                    <h2 class="title">{{ __(@$about->value->language->$defualt->fitst_section_heading ?? @$about->value->language->$default_lng->fitst_section_heading) }}</h2>
                    <p>{{ __(@$about->value->language->$defualt->first_section_sub_heading ??@$about->value->language->$default_lng->first_section_sub_heading ) }}</p>
                    <div class="about-btn">
                        <a href="{{ $about->value->language->$default_lng->first_section_button_link ?? '' }}" class="btn--base">{{ $about->value->language->$defualt->first_section_button_name ?? $about->value->language->$default_lng->first_section_button_name}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End About
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start app
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="app-section bg--gray ptb-120">
    <div class="app-element-one">
        <img src="{{ get_image(@$download->value->images->home_image,'site-section') }}" style="-webkit-mask-box-image: url('{{ asset('public/frontend/') }}/images/app/maskshape.png'); mask: url('{{ asset('public/frontend/') }}/images/app/maskshape.png');" alt="app">
    </div>

    <div class="container">
        <div class="row justify-content-end">
            <div class="col-xxl-6 col-xl-12 col-lg-12">
                <div class="app-content">
                    <span class="sub-title">{{ __(@$download->value->language->$defualt->title ?? @$download->value->language->$default_lng->title) }}</span>
                    <h2 class="title">{{ __(@$download->value->language->$defualt->heading ?? @$download->value->language->$default_lng->heading) }}</h2>
                    <p>{{ __(@$download->value->language->$defualt->sub_heading ?? @$download->value->language->$default_lng->sub_heading) }}</p>

                    <div class="app-btn">
                        <a href="{{  @$app_settings->android_url  }}" target="_blank"><img src="{{ get_image(@$download->value->images->google_play,'site-section') }}" alt="app"></a>
                        <a href="{{ @$app_settings->iso_url }}" target="_blank"><img src="{{ get_image(@$download->value->images->app_store,'site-section') }}" alt="app"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End app
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Campaign
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.partials.campaigns', ['campaigns' => $campaigns])
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Campaign
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Gallery
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="gallery-section pt-120">
    <div class="container-fluid p-0">
        <div class="row g-0">
            @if(isset($gallery->value->items))
                @php
                    $count = 0;
                @endphp
                @foreach($gallery->value->items ?? [] as $key => $item)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <div class="thumb">
                            <img src="{{ get_image(@$item->image,'site-section') }}" alt="gallery">
                            <div class="gallery-shape">
                                <img src="{{ asset('public/frontend/') }}/images/gallery/gallery-shape.png" alt="shape">
                            </div>
                            <div class="content">
                                <h2 class="title">{{ @$item->language->$defualt->title ?? @$item->language->$default_lng->title }}</h2>
                                <div class="gallery-btn">
                                    <a href="javascript:void()">#{{ @$item->language->$defualt->tag ?? @$item->language->$default_lng->tag }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $count++;
                    if ($count == 3) {
                        break;
                    }
                @endphp
                @endforeach
            @endif
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Gallery
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Testimonial
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.partials.testimonial')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Testimonial
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Video
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="video-section pt-120">
    <div class="video-shape">
        <img src="{{ asset('public/frontend/') }}/images/map.jpg" alt="shape">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 text-center">
                <div class="video-content">
                    @php
                        $viewInfo = explode(' ', @$video->value->language->$defualt->view_info ?? @$video->value->language->$default_lng->view_info);
                    @endphp
                    <h2 class="title"><span class="number">@isset($viewInfo[0]){{ $viewInfo[0] }}@endisset</span> <span class="text"> @isset($viewInfo[1])
                    {{ $viewInfo[1] }}
                    @endisset</span></h2>
                    <h3 class="sub-title"> {{ __(@$video->value->language->$defualt->heading ?? @$video->value->language->$default_lng->heading) }}</h3>
                    <div class="video-area">
                        <a class="video-icon" data-rel="lightcase:myCollection" href="{{ @$video->value->language->$default_lng->video_link }}">
                            <img src="{{ asset('public/frontend/') }}/images/play-button.png" alt="play">
                        </a>
                        <span>{{ __("Watch Video") }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Video
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section pt-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 text-center">
                <div class="section-header">
                    @php
                        $header = explode('|', @$event_head_data->value->language->$defualt->heading ?? @$event_head_data->value->language->$default_lng->heading);
                    @endphp
                    <span class="section-sub-title">{{ $event_head_data->value->language->$defualt->title ?? 'Events' }}</span>
                    <h2 class="section-title">@isset($header[0]) {{ $header[0] }} @endisset <span>@isset($header[1]) {{ $header[1] }} @endisset</span></h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-30-none">
            @foreach ($recent_events as $item)
            <div class="col-xl-6 col-lg-6 col-md-6 mb-30">
                <div class="blog-item">
                    <div class="blog-thumb">
                        <a href="{{ setRoute('events.details',[$item->id, $item->slug])}}"><img src="{{ get_image($item->image,'events') }}" alt="{{ @$item->title->language->$defualt->title }}"></a>
                    </div>
                    <div class="blog-content">
                        <div class="blog-date">
                            <h6 class="title">{{ dateFormat('d M',$item->created_at) }}</h6>
                            <span class="sub-title">{{ dateFormat('Y',$item->created_at) }}</span>
                        </div>
                        <span class="category">{{ $item->category->name }}</span>
                        <h3 class="title"><a href="{{ setRoute('events.details',[$item->id, $item->slug])}}">{{ @$item->title->language->$defualt->title ?? @$item->title->language->$default_lng->title }}</a></h3>
                        <p>{!! Str::limit(@$item->details->language->$defualt->details ?? @$item->details->language->$default_lng->details, 150); !!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Brand
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.partials.brand')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Brand
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



@endsection


@push("script")

@endpush
