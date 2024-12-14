<a href="{{ route('compare') }}" class="d-flex align-items-center text-secondary" data-toggle="tooltip"
    data-title="{{ translate('Compare') }}" data-placement="top">
    <span class="position-relative d-inline-block">
        <i class="la la-retweet fs-20" aria-label="compare"></i>
        @if (Session::has('compare'))
            <span
                class="badge badge-primary badge-inline badge-pill absolute-top-right--10px">{{ count(Session::get('compare')) }}</span>
        @endif
    </span>
</a>
