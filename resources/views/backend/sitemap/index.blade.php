@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-center align-items-center">
            <h3 class="card-title">{{ translate('Generate Sitemap') }}</h3>
        </div>
        <div class="card-body text-center">
            <a class="btn btn-primary mb-3" href="{{ route('sitemap.generate') }}">{{ translate('Generate') }}</a>

            <br>
            {{-- show the sitemap link --}}
            @foreach ($sitemapLinks as $link)
                <a style="background: #eeeeee" class="btn text-muted w-50 btn-md rounded-2 fs-14 fw-700 mb-1"
                    href="{{ $link }}" target="_blank">{{ $link }}</a>
                <br>
            @endforeach

            <br>
        </div>
    </div>
@endsection
