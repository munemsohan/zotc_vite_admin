<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Zotc') }}</h5>

            <label class="aiz-switch aiz-switch-success mb-0">
                <input type="checkbox" onchange='updateSettings(this, "zotc")'
                    @if ($otp_configuration->value == 1) checked @endif>
                <span class="slider round"></span>
            </label>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('zotc_settings.update') }}" method="POST">
                <input type="hidden" name="otp_method" value="zotc">
                @csrf
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="zotc_sms_type">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('SMS TYPE') }}</label>
                    </div>
                    <div class="col-lg-8">
                        <select name="zotc_sms_type" class="form-control aiz-selectpicker">
                            <option value="sms" {{ get_zotc_setting('zotc_sms_type') === 'sms' ? 'selected' : '' }}>
                                SMS
                            </option>
                            <option value="whatsapp"
                                {{ get_zotc_setting('zotc_sms_type') === 'whatsapp' ? 'selected' : '' }}>
                                WhatsApp</option>
                            <option value="both" {{ get_zotc_setting('zotc_sms_type') === 'both' ? 'selected' : '' }}>
                                BOTH
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-2 d-flex justify-content-between">
                    <h5>Balance:
                        {{ get_zotc_setting('currency') == 'BDT' ? '৳' . get_zotc_setting('sms_balance_bdt') : '$' . get_zotc_setting('sms_balance_usd') }}
                    </h5>

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
