<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('MIMSMS') }}</h5>

            <label class="aiz-switch aiz-switch-success mb-0">
                <input type="checkbox" onchange='updateSettings(this, "mimsms")'
                    @if ($otp_configuration->value == 1) checked @endif>
                <span class="slider round"></span>
            </label>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('update_credentials') }}" method="POST">
                <input type="hidden" name="otp_method" value="mimsms">
                @csrf
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="MIM_API_KEY">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('MIM_API_KEY') }}</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="MIM_API_KEY" value="{{ env('MIM_API_KEY') }}"
                            placeholder="MIM_API_KEY" required>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="MIM_SENDER_ID">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('MIM_SENDER_ID') }}</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="MIM_SENDER_ID"
                            value="{{ env('MIM_SENDER_ID') }}" placeholder="MIM_SENDER_ID" required>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="MIM_BASE_URL">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('MIM_BASE_URL') }}</label>
                    </div>
                    <div class="col-lg-6">
                        <input type="text" class="form-control" name="MIM_BASE_URL" value="{{ env('MIM_BASE_URL') }}"
                            placeholder="MIM_BASE_URL" required>
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
