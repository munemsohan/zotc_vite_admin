<div class="row">
    <div class="col-md-6 mx-auto">
        @include('partials.fraud_checker.table', compact('orderguardData'))
    </div>
</div>

@include('partials.fraud_checker.comments', compact('steadfastData'))