{!! $landingPage->page_header !!}

<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>

<main>
    {!! $landingPage->page_body !!}
</main>

@include('frontend.landing_page_order')

@include('frontend.landing_page_footer')
