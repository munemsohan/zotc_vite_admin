@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            API List
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                <li class="my-2">
                    <a target="_blank" href="{{ route('api.navbar') }}">
                        <h6>{{ route('api.navbar') }}</h6>
                    </a>
                </li>
                <li class="my-2">
                    <a target="_blank" href="{{ route('api.homepage') }}">
                        <h6>{{ route('api.homepage') }}</h6>
                    </a>
                </li>
                <li class="my-2">
                    <a target="_blank" href="{{ route('api.landing', ['slug' => 'landing-page-1']) }}">
                        <h6>{{ route('api.landing', ['slug' => 'landing-page-1']) }}</h6>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection
