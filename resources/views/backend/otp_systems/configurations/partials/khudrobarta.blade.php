<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Khudro Barta') }}</h5>
            <label class="aiz-switch aiz-switch-success mb-0">
                <input type="checkbox" onchange='updateSettings(this, "khudrobarta")'
                    @if ($otp_configuration->value == 1) checked @endif>
                <span class="slider round"></span>
            </label>
        </div>
        <div class="card-body">
            <form class="form-horizontal" action="{{ route('update_credentials') }}" method="POST">
                <input type="hidden" name="otp_method" value="khudrobarta">
                @csrf
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="khudrobarta_api_key">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('API KEY') }}</label>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="khudrobarta_api_key" id="khudrobarta_api_key"
                            value="{{ get_zotc_setting('khudrobarta_api_key') }}" placeholder="190|EQav......." required>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="khudrobarta_sender_id">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('SENDER ID') }}</label>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="khudrobarta_sender_id"
                            value="{{ get_zotc_setting('khudrobarta_sender_id') }}" placeholder="sms" required>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="khudrobarta_language">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('LANGUAGE ') }}</label>
                    </div>
                    <div class="col-lg-8">
                        <select name="khudrobarta_language" class="form-control aiz-selectpicker">
                            <option value="english" {{ get_zotc_setting('khudrobarta_language') === 'english' ? 'selected' : '' }}>
                                ENGLISH</option>
                            <option value="unicode" {{ get_zotc_setting('khudrobarta_language') === 'unicode' ? 'selected' : '' }}>
                                UNICODE</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" name="types[]" value="khudrobarta_sms_type">
                    <div class="col-lg-3">
                        <label class="col-from-label">{{ translate('SMS TYPE') }}</label>
                    </div>
                    <div class="col-lg-8">
                        <select name="khudrobarta_sms_type" class="form-control aiz-selectpicker">
                            <option value="sms" {{ get_zotc_setting('khudrobarta_sms_type') === 'sms' ? 'selected' : '' }}>SMS
                            </option>
                            <option value="whatsapp"
                                {{ get_zotc_setting('khudrobarta_sms_type') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                            <option value="both" {{ get_zotc_setting('khudrobarta_sms_type') === 'both' ? 'selected' : '' }}>BOTH
                            </option>
                        </select>
                        <small>
                            Sign Up from <a target="_blank" href="https://khudrobarta.com/">Khudro Barta</a> & Get <a
                                target="_blank" href="https://sms.one9.one/developers">Sender id and API KEY</a>
                        </small>
                    </div>
                </div>
                <div class="form-group mb-2 d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-success" id="khudrobartaBalanceCheck">Check
                        balance</button>
                    <h5 id="balance_tag" style="display: none">Balance: ৳<span id="balance">0</span></h5>
                    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    function updateSettings(el, type) {
        var value = $(el).is(':checked') ? 1 : 0;

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

    $('#khudrobartaBalanceCheck').click(function() {
        var api_key = $('#khudrobarta_api_key').val();
        var $button = $('#khudrobartaBalanceCheck');

        if (api_key) {
            $.ajax({
                type: 'GET',
                url: "{{ url('check-balance/khudrobarta') }}/" + api_key,
                success: function(response) {
                    var jsonResponse = JSON.parse(response);

                    if (jsonResponse.status === 'success') {
                        $('#balance').html(jsonResponse.balance);
                        $('#balance_tag').show();
                        $button.prop('disabled', true).text('Balance Checked');
                    } else {
                        $button.text('Try Again!');
                        AIZ.plugins.notify('danger', jsonResponse.message ||
                            'Failed to check balance');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    AIZ.plugins.notify('danger', 'An error occurred while checking the balance');
                }
            });
        } else {
            AIZ.plugins.notify('danger', 'Please Provide Khudrobarta API KEY');
        }
    });
</script>
