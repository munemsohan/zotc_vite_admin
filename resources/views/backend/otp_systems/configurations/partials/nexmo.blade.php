<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Nexmo') }}</h5>

            <label class="aiz-switch aiz-switch-success mb-0">
                <input type="checkbox" onchange='updateSettings(this, "nexmo")'
                    @if ($otp_configuration->value == 1) checked @endif>
                <span class="slider round"></span>
            </label>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('update_credentials') }}" method="POST">
                <input type="hidden" name="otp_method" value="nexmo">
                @csrf
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="NEXMO_KEY">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('NEXMO KEY') }}</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="NEXMO_KEY" value="{{ env('NEXMO_KEY') }}"
                            placeholder="NEXMO KEY" required>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="NEXMO_SECRET">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('NEXMO SECRET') }}</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="NEXMO_SECRET" value="{{ env('NEXMO_SECRET') }}"
                            placeholder="NEXMO SECRET" required>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="NEXMO_SENDER_ID">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('NEXMO SENDER ID') }}</label>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="NEXMO_SENDER_ID"
                            value="{{ env('NEXMO_SENDER_ID') }}" placeholder="NEXMO SENDER ID" required>
                        <small>
                            {{ translate('Please check this URL for') }}
                            <a
                                href="https://developer.vonage.com/en/messaging/sms/guides/custom-sender-id?source=messaging">Sender
                                Identity</a>
                            {{ translate('before setting the sender ID') }}
                        </small>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript">
        function updateSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }
            $.post('{{ route('otp_configurations.update.activation') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
