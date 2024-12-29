@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Cart Settings') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between p-2">
                        <h5 class="mb-0 h6 text-center">{{ translate('Name') }}</h5>

                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateCartSettings(this, 'name')"
                                {{ get_cart_setting('name') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-between p-2">
                        <h5 class="mb-0 h6 text-center">{{ translate('Email') }}</h5>

                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateCartSettings(this, 'email')"
                                {{ get_cart_setting('email') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-between p-2">
                        <h5 class="mb-0 h6 text-center">{{ translate('Phone') }}</h5>

                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateCartSettings(this, 'phone')"
                                {{ get_cart_setting('phone') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-between p-2">
                        <h5 class="mb-0 h6 text-center">{{ translate('Address') }}</h5>

                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateCartSettings(this, 'address')"
                                {{ get_cart_setting('address') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-between p-2">
                        <h5 class="mb-0 h6 text-center">{{ translate('Postal Code') }}</h5>

                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateCartSettings(this, 'code')"
                                {{ get_cart_setting('code') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="d-flex justify-content-between p-2">
                        <h5 class="mb-0 h6 text-center">{{ translate('Country') }}</h5>

                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateCartSettings(this, 'country')"
                                {{ get_cart_setting('country') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-between p-2">
                        <h5 class="mb-0 h6 text-center">{{ translate('State/City') }}</h5>

                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateCartSettings(this, 'state')"
                                {{ get_cart_setting('state') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-between p-2">
                        <h5 class="mb-0 h6 text-center">{{ translate('City/Thana') }}</h5>

                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateCartSettings(this, 'city')"
                                {{ get_cart_setting('city') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-between p-2">
                        <h5 class="mb-0 h6 text-center">{{ translate('Additional Info') }}</h5>

                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateCartSettings(this, 'additional_info')"
                                {{ get_cart_setting('additional_info') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-between p-2">
                        <h5 class="mb-0 h6 text-center">{{ translate('Custom Field') }}</h5>

                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" id="customFieldToggle" onchange="toggleCustomField(this)"
                                {{ get_cart_setting('custom_field') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div id="customFieldSettings"
                        class="{{ get_cart_setting('custom_field') == 1 ? 'd-block' : 'd-none' }} mb-2">
                        <form class="form-horizontal row g-3 border p-1"
                            action="{{ route('business_settings.cart.custom_field.update') }}" method="POST">
                            @csrf
                            <!-- Label Input -->
                            <div class="col-md-7">
                                <label for="label" class="form-label fw-bold">{{ translate('Input Field') }}</label>
                                <input type="text" class="form-control" id="label" name="types[custom_field_label]"
                                    value="{{ get_business_setting('custom_field_label') }}"
                                    placeholder="{{ translate('Example: NID, Birth certificate Number') }}">
                            </div>
                            <!-- Label Required Toggle -->
                            <div class="col-md-3 d-flex align-items-center pt-3">
                                <label for="labelRequired"
                                    class="form-label fw-bold me-2 mb-0">{{ translate('Required') }}</label>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <!-- Hidden input to ensure a value of 0 is sent if unchecked -->
                                    <input type="hidden" name="types[custom_field_required]" value="0">
                                    <input type="checkbox" id="labelRequired" name="types[custom_field_required]"
                                        value="1"
                                        {{ get_business_setting('custom_field_required') == '1' ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <!-- Save Button -->
                            <div class="col-md-2 d-flex align-items-center">
                                <button type="submit"
                                    class="btn btn-primary btn-sm w-100">{{ translate('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function updateCartSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }
            $.post('{{ route('cart.settings.update') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Cart Settings updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function toggleCustomField(el) {
            if ($(el).is(':checked')) {
                $('#customFieldSettings').removeClass('d-none');
                $('#customFieldSettings').addClass('d-block');
                updateCartSettings(el, 'custom_field');
            } else {
                $('#customFieldSettings').removeClass('d-block');
                $('#customFieldSettings').addClass('d-none');
                updateCartSettings(el, 'custom_field');
            }
        }
    </script>
@endsection
