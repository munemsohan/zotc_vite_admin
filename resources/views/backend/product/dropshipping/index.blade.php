@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">

            <form id="category-form" action="{{ route('upload-dropshop-products') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <!-- Input for Shipper Domain -->
                        <div class="form-group">
                            <label for="commission_amount">{{ translate('Shipper Domain') }}</label>
                            <input type="text" class="form-control" id="commission_amount" name="commission_amount"
                                step="0.01" value="0" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success mt-3">{{ translate('Fetch Products') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script></script>
@endsection
