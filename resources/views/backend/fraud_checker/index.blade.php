@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ translate('Fraud Checker') }} (Checked {{ get_zotc_setting('fraud_checker_count') ?? 0 }} times)
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="input-group">
                            <input class="form-control" type="number" id="fraud_check_number" placeholder="Phone Number">
                            <button class="btn btn-danger btn-sm" onclick="fraudCheck()">Check</button>
                        </div>
                    </div>
                </div>

                <div class="row mx-auto mt-5" id="fraud_checker_image">
                    <div class="col-md-6 mx-auto">
                        <img class="img-fluid" src="{{ get_cdn_url() . 'uploads/all/fraud_checker.webp' }}" alt="">
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div class="text-center mt-3" id="loading" style="display: none;">
                    <div class="spinner-border text-danger" role="status"></div>
                    <p>Checking, please wait...</p>
                </div>

                <div class="mt-5" id="fraud_div"></div>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            function fraudCheck() {
                $('#fraud_div').empty();
                let fraud_check_number = $('#fraud_check_number').val().trim();

                if (fraud_check_number.length >= 11) {
                    fraud_check_number = fraud_check_number.slice(-11);

                    // Show loading indicator and hide fraud checker image
                    $('#loading').show();
                    $('#fraud_checker_image').hide();

                    $.ajax({
                        url: '{{ route('fraud_checker.check') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            phone: fraud_check_number
                        },
                        success: function(response) {
                            $('#fraud_div').html(response);
                        },
                        error: function(xhr) {
                            alert('An error occurred. Please try again.');
                        },
                        complete: function() {
                            // Hide loading indicator after response
                            $('#loading').hide();
                        }
                    });
                } else {
                    alert('Please enter a valid phone number with at least 11 digits.');
                }
            }
        </script>
    @endsection
