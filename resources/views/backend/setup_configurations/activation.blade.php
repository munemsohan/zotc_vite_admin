<div class="row">
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="d-flex justify-content-between p-2">
                <h5 class="mb-0 h6 text-center">{{ translate('HTTPS Activation') }}</h5>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'FORCE_HTTPS')" <?php if (env('FORCE_HTTPS') == 'On') {
                        echo 'checked';
                    } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Disable image encoding?') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'disable_image_optimization')"
                        <?php if (get_business_setting('disable_image_optimization') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Classified Product') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'classified_product')"
                        <?php if (get_business_setting('classified_product') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Coupon System Activation') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'coupon_system')" <?php if (get_business_setting('coupon_system') == 1) {
                        echo 'checked';
                    } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Conversation Activation') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'conversation_system')"
                        <?php if (get_business_setting('conversation_system') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Admin Approval On Seller Product') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'product_approve_by_admin')"
                        <?php if (\App\Models\BusinessSetting::where('type', 'product_approve_by_admin')->first() && get_business_setting('product_approve_by_admin') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Product Query Activation') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'product_query_activation')"
                        <?php if (get_business_setting('product_query_activation') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Auction Product for Seller') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'seller_auction_product')"
                        <?php if (get_business_setting('seller_auction_product') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Google login') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'google_login')" <?php if (get_business_setting('google_login') == 1) {
                        echo 'checked';
                    } ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h5 class="mb-0 h6">{{ translate('POS Activation for Seller') }}</h5>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'pos_activation_for_seller')"
                        @if (get_business_setting('pos_activation_for_seller') == 1) checked @endif>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h5 class="mb-0 h6">{{ translate('POS Thermal Printer Size') }}</h5>
                <form id="thermal_printer_form" class="form-horizontal"
                    action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group row mb-0">
                        <input type="hidden" name="types[]" value="print_width">
                        <div class="input-group mx-2">
                            <select name="print_width" id="print_width" class="form-control">
                                <option value="60"
                                    {{ get_business_setting('print_width') == 60 ? 'selected' : '' }}>60 mm
                                </option>
                                <option value="80"
                                    {{ get_business_setting('print_width') == 80 ? 'selected' : '' }}>80 mm
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="px-2">
                <form id="minimum_order_form" action="{{ route('business_settings.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <input type="hidden" name="types[]" value="minimum_order_amount">

                        <h5 class="mb-0 h6">{{ translate('Minimum Order Amount') }}</h5>

                        <input type="number" min="0" step="0.01" class="form-control" style="width: 150px"
                            name="minimum_order_amount" value="{{ get_business_setting('minimum_order_amount') }}"
                            placeholder="{{ translate('Minimum Order Amount') }}" required>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Left Floating Buttons') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'left_floating_buttons')"
                        {{ get_business_setting('left_floating_buttons') == 1 ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Cart Floating Button') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'cart_floating_button')"
                        {{ get_business_setting('cart_floating_button') == 1 ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="px-2 py-1 mt-2">
                <form id="phone_number_after_buy_now_form" action="{{ route('business_settings.update') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <input type="hidden" name="types[]" value="phone_number_after_buy_now">

                        <h5 class="mb-0 h6">{{ translate('Phone Number After Buy Now') }}</h5>

                        <input type="text" class="form-control" style="width: 150px"
                            name="phone_number_after_buy_now"
                            value="{{ get_business_setting('phone_number_after_buy_now') }}" placeholder="+8801...."
                            required>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Maintenance Mode Activation') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'maintenance_mode')"
                        <?php if (get_business_setting('maintenance_mode') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Vendor System Activation') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'vendor_system_activation')"
                        <?php if (get_business_setting('vendor_system_activation') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Wallet System Activation') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'wallet_system')"
                        <?php if (get_business_setting('wallet_system') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Pickup Point Activation') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'pickup_point')"
                        <?php if (get_business_setting('pickup_point') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Seller Product Manage By Admin') }}</h3>
                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'product_manage_by_admin')"
                        <?php if (\App\Models\BusinessSetting::where('type', 'product_manage_by_admin')->first() && get_business_setting('product_manage_by_admin') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Email Otp Verification') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'email_verification')"
                        <?php if (get_business_setting('email_verification') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Wholesale Product for Seller') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'seller_wholesale_product')"
                        <?php if (get_business_setting('seller_wholesale_product') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Facebook login') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'facebook_login')"
                        <?php if (get_business_setting('facebook_login') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h3 class="mb-0 h6 text-center">{{ translate('Twitter login') }}</h3>

                <label class="aiz-switch aiz-switch-success mb-0">
                    <input type="checkbox" onchange="updateFeatureSettings(this, 'twitter_login')"
                        <?php if (get_business_setting('twitter_login') == 1) {
                            echo 'checked';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <div class="d-flex justify-content-between p-2">
                <h5 class="mb-0 h6">{{ translate('Order Minimum Pay Type') }}</h5>
                <form id="order_minimum_pay_type_form" class="form-horizontal"
                    action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group row mb-0">
                        <input type="hidden" name="types[]" value="order_minimum_pay_type">
                        <div class="input-group mx-2">
                            <select name="order_minimum_pay_type" id="order_minimum_pay_type" class="form-control">
                                <option value=""
                                    {{ get_business_setting('order_minimum_pay_type') == '' ? 'selected' : '' }}>Full
                                    Payment
                                </option>
                                <option value="minimum_payment"
                                    {{ get_business_setting('order_minimum_pay_type') == 'minimum_payment' ? 'selected' : '' }}>
                                    Minimum Payment
                                </option>
                                <option value="minimum_payment_with_shipping"
                                    {{ get_business_setting('order_minimum_pay_type') == 'minimum_payment_with_shipping' ? 'selected' : '' }}>
                                    Minimum Payment With Shipping
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-between px-2">
                <h5 class="mb-0 h6">{{ translate('Order Minimum Pay Amount') }}</h5>
                <form id="order_minimum_payment_amount_form" class="form-horizontal"
                    action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="order_minimum_payment_amount">
                        <div class="input-group mx-2">
                            <input type="text" class="form-control" name="order_minimum_payment_amount"
                                style="width: 150px" placeholder="Order Minimum Pay Amount"
                                value="{{ get_business_setting('order_minimum_payment_amount') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="target" class="d-flex justify-content-between px-2">
                <h5 class="mb-0 h6">{{ translate('Monthly Sales target') }}</h5>
                <form id="monthly_sales_form" class="form-horizontal"
                    action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="monthly_sales_target">
                        <div class="input-group mx-2">
                            <input type="text" class="form-control" name="monthly_sales_target"
                                style="width: 150px" placeholder="Monthly Sales target"
                                value="{{ get_business_setting('monthly_sales_target') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-between px-2">
                <h5 class="mb-0 h6">{{ translate('Monthly Order target') }}</h5>
                <form id="monthly_order_form" class="form-horizontal"
                    action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="monthly_order_target">
                        <div class="input-group mx-2">
                            <input type="text" class="form-control" name="monthly_order_target"
                                style="width: 150px" placeholder="Monthly Order target"
                                value="{{ get_business_setting('monthly_order_target') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-between px-2">
                <h5 class="mb-0 h6">{{ translate('Yearly Sales Target') }}</h5>
                <form id="yearly_sales_form" class="form-horizontal"
                    action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="yearly_sales_target">
                        <div class="input-group mx-2">
                            <input type="text" class="form-control" name="yearly_sales_target"
                                style="width: 150px" placeholder="Yearly Sales Target"
                                value="{{ get_business_setting('yearly_sales_target') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-between px-2">
                <h5 class="mb-0 h6">{{ translate('Yearly Order Target') }}</h5>
                <form id="yearly_order_form" class="form-horizontal"
                    action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="yearly_order_target">
                        <div class="input-group mx-2">
                            <input type="text" class="form-control" name="yearly_order_target"
                                style="width: 150px" placeholder="Yearly Order Target"
                                value="{{ get_business_setting('yearly_order_target') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- <h4 class="text-center text-muted mt-4">{{ translate('Business Related') }}</h4> --}}
{{-- <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body text-center">
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('After activate this option Cash On Delivery of Seller product will be managed by Admin') }}.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body text-center">
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('After activate this option, Admin approval need to seller product') }}.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body text-center">
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure SMTP correctly to enable this feature.') }} <a
                            href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
            </div>
        </div>
        @if (addon_is_activated('wholesale'))
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        
                    </div>
                </div>
            </div>
        @endif
        @if (addon_is_activated('auction'))
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        
                    </div>
                </div>
            </div>
        @endif
    </div>

    <h4 class="text-center text-muted mt-4">{{ translate('Social Media Login') }}</h4>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body text-center">
                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure Facebook Client correctly to enable this feature') }}. <a
                            href="{{ route('social_login.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body text-center">

                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure Google Client correctly to enable this feature') }}. <a
                            href="{{ route('social_login.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body text-center">

                    <div class="alert"
                        style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                        {{ translate('You need to configure Twitter Client correctly to enable this feature') }}. <a
                            href="{{ route('social_login.index') }}">{{ translate('Configure Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body text-center">
                    
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
                
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body text-center">
                    
                </div>
            </div>
        </div>
    </div> --}}
