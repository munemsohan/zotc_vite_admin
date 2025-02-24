<div class="row">
    @if(count($steadfastData ?? []) > 0)
        @foreach ($steadfastData ?? [] as $comment)
            <div class="col-md-12 card px-0 mb-3">
                <div class="card-header bg-secondary text-white d-flex justify-content-between">
                    <span>{{ $comment['name'] ?? 'Unknown' }}</span>
                    <span>{{ $comment['date'] ?? '-' }}</span>
                </div>
                <div class="card-body py-2">
                    <p class="mb-0">{{ $comment['details'] ?? 'No details available' }}</p>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12">
            <p class="text-center text-danger">No comments found.</p>
        </div>
    @endif
</div>

