@extends('frontend.layouts.app')

@section('content')
    <div class="position-relative">
        <div class="position-absolute" id="particles-js"></div>
        <div class="position-relative container">
            <!-- Breadcrumb -->
            <section class="pt-4 mb-4">
                <div class="row">
                    <div class="col-lg-6 text-center text-lg-left">
                        <h1 class="fw-700 fs-20 fs-md-24 text-dark">{{ translate('Landing Pages') }}</h1>
                    </div>
                    <div class="col-lg-6">
                        <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                            <li class="breadcrumb-item has-transition opacity-60 hov-opacity-100">
                                <a class="text-reset" href="{{ route('home') }}">
                                    {{ translate('Home') }}
                                </a>
                            </li>
                            <li class="text-dark fw-600 breadcrumb-item">
                                "{{ translate('Landing Pages') }}"
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- All flash deals -->
            <section class="mb-4">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-6 gutters-16">
                    @foreach ($all_landing_pages as $landing)
                        <div class="col-md-1 py-3 h-200px h-xl-475px">
                            <a href="{{ route('landing-pages.show_landing_page', $landing->slug) }}" target="_blank"
                                rel="noopener noreferrer">
                                <div class="h-100 w-100 position-relative hov-scale-img">
                                    <div class="position-absolute overflow-hidden h-100 w-100 ">
                                        {{-- Display the thumbnail of the first product associated with the landing page --}}
                                        @if ($landing->landingPageProducts->isNotEmpty())
                                            @php
                                                $thumbnail = isset($landing->landingPageProducts->first()->product->thumbnail)
                                                    ? my_asset(
                                                        $landing->landingPageProducts->first()->product->thumbnail
                                                            ->thumbnail,
                                                    )
                                                    : static_asset('assets/img/placeholderx200.webp');
                                            @endphp
                                            <img src="{{ $thumbnail }}" class="img-fluid">
                                            <h4 class="text-center">{{ $landing->title }}</h4>
                                        @endif

                                    </div>
                                </div>

                            </a>
                        </div>
                    @endforeach

                </div>
            </section>
        </div>
    </div>
@endsection
