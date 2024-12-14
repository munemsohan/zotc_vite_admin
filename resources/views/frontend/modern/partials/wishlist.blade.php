<a href="{{ route('wishlists.index') }}" class="d-flex align-items-center text-secondary" data-toggle="tooltip" data-title="{{ translate('Wishlist') }}" data-placement="top">
    <span class="position-relative d-inline-block">
        <i class="la la-heart fs-20" aria-label="wishlist"></i>
        @if(Auth::check() && count(Auth::user()->wishlists)>0)
            <span class="badge badge-primary badge-inline badge-pill absolute-top-right--10px">{{ count(Auth::user()->wishlists)}}</span>
        @endif
    </span>
</a>
