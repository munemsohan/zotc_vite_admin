@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 h6">{{ translate('Cash Payment') }}</h5>
                        <img class="ml-2" src="{{ static_asset('assets/img/cards/cod.png') }}" height="30">
                    </div>

                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                        <input type="checkbox" onchange="updateSettings(this, 'cash_payment')" <?php if (get_business_setting('cash_payment') == 1) {
                            echo 'checked';
                        } ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0">Online payment</h6>

                    <button class="btn btn-sm btn-primary" id="togglecardbody">Show</button>
                </div>
                <div class="card-body" id="online_payment_card_body" style="display: none">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Bkash') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/bkash.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'bkash')" <?php if (get_business_setting('bkash') == 1) {
                                            echo 'checked';
                                        } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="bkash_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="bkash">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="BKASH_CHECKOUT_APP_KEY">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('BKASH CHECKOUT APP KEY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="BKASH_CHECKOUT_APP_KEY"
                                                    value="{{ env('BKASH_CHECKOUT_APP_KEY') }}"
                                                    placeholder="{{ translate('BKASH CHECKOUT APP KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="BKASH_CHECKOUT_APP_SECRET">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('BKASH CHECKOUT APP SECRET') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="BKASH_CHECKOUT_APP_SECRET"
                                                    value="{{ env('BKASH_CHECKOUT_APP_SECRET') }}"
                                                    placeholder="{{ translate('BKASH CHECKOUT APP SECRET') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="BKASH_CHECKOUT_USER_NAME">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('BKASH CHECKOUT USER NAME') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="BKASH_CHECKOUT_USER_NAME"
                                                    value="{{ env('BKASH_CHECKOUT_USER_NAME') }}"
                                                    placeholder="{{ translate('BKASH CHECKOUT USER NAME') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="BKASH_CHECKOUT_PASSWORD">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('BKASH CHECKOUT PASSWORD') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="BKASH_CHECKOUT_PASSWORD"
                                                    value="{{ env('BKASH_CHECKOUT_PASSWORD') }}"
                                                    placeholder="{{ translate('BKASH CHECKOUT PASSWORD') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('Bkash Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="bkash_sandbox" type="checkbox"
                                                        @if (get_business_setting('bkash_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Nagad') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/nagad.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'nagad')"
                                            <?php if (get_business_setting('nagad') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="nagad_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="nagad">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="NAGAD_MODE">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('NAGAD MODE') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="NAGAD_MODE"
                                                    value="{{ env('NAGAD_MODE') }}"
                                                    placeholder="{{ translate('NAGAD MODE') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="NAGAD_MERCHANT_ID">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('NAGAD MERCHANT ID') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="NAGAD_MERCHANT_ID"
                                                    value="{{ env('NAGAD_MERCHANT_ID') }}"
                                                    placeholder="{{ translate('NAGAD MERCHANT ID') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="NAGAD_MERCHANT_NUMBER">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('NAGAD MERCHANT NUMBER') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="NAGAD_MERCHANT_NUMBER"
                                                    value="{{ env('NAGAD_MERCHANT_NUMBER') }}"
                                                    placeholder="{{ translate('NAGAD MERCHANT NUMBER') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="NAGAD_PG_PUBLIC_KEY">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('NAGAD PG PUBLIC KEY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="NAGAD_PG_PUBLIC_KEY"
                                                    value="{{ env('NAGAD_PG_PUBLIC_KEY') }}"
                                                    placeholder="{{ translate('NAGAD PG PUBLIC KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="NAGAD_MERCHANT_PRIVATE_KEY">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('NAGAD MERCHANT PRIVATE KEY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control"
                                                    name="NAGAD_MERCHANT_PRIVATE_KEY"
                                                    value="{{ env('NAGAD_MERCHANT_PRIVATE_KEY') }}"
                                                    placeholder="{{ translate('NAGAD MERCHANT PRIVATE KEY') }}">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header ">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Sslcommerz') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/sslcommerz.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'sslcommerz_payment')"
                                            <?php if (get_business_setting('sslcommerz_payment') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="sslcommerz_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="sslcommerz">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="SSLCZ_STORE_ID">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('Sslcz Store Id') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="SSLCZ_STORE_ID"
                                                    value="{{ env('SSLCZ_STORE_ID') }}"
                                                    placeholder="{{ translate('Sslcz Store Id') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="SSLCZ_STORE_PASSWD">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('Sslcz store password') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="SSLCZ_STORE_PASSWD"
                                                    value="{{ env('SSLCZ_STORE_PASSWD') }}"
                                                    placeholder="{{ translate('Sslcz store password') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('Sslcommerz Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="sslcommerz_sandbox" type="checkbox"
                                                        @if (get_business_setting('sslcommerz_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header ">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Aamarpay') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/aamarpay.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'aamarpay')"
                                            <?php if (get_business_setting('aamarpay') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="aamarpay_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="aamarpay">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="AAMARPAY_STORE_ID">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('Aamarpay Store Id') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="AAMARPAY_STORE_ID"
                                                    value="{{ env('AAMARPAY_STORE_ID') }}"
                                                    placeholder="{{ translate('Aamarpay Store Id') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="AAMARPAY_SIGNATURE_KEY">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('Aamarpay signature key') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="AAMARPAY_SIGNATURE_KEY"
                                                    value="{{ env('AAMARPAY_SIGNATURE_KEY') }}"
                                                    placeholder="{{ translate('Aamarpay signature key') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('Aamarpay Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="aamarpay_sandbox" type="checkbox"
                                                        @if (get_business_setting('aamarpay_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('UddoktaPay') }}</h5>
                                        <img class="ml-2"
                                            src="{{ static_asset('assets/img/cards/uddoktapay_logo.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'uddoktapay_payment')"
                                            <?php if (get_business_setting('uddoktapay_payment') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="uddoktapay_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        <input type="hidden" name="payment_method" value="uddoktapay">
                                        @csrf
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="UDDOKTAPAY_API_KEY">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('UddoktaPay API KEY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="UDDOKTAPAY_API_KEY"
                                                    value="{{ env('UDDOKTAPAY_API_KEY') }}"
                                                    placeholder="{{ translate('UddoktaPay API KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="UDDOKTAPAY_API_URL">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('UddoktaPay API URL') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="UDDOKTAPAY_API_URL"
                                                    value="{{ env('UDDOKTAPAY_API_URL') }}"
                                                    placeholder="{{ translate('UddoktaPay API URL') }}">
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Paypal') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/paypal.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'paypal_payment')"
                                            <?php if (get_business_setting('paypal_payment') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="paypal_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        <input type="hidden" name="payment_method" value="paypal">
                                        @csrf
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('Paypal Client Id') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="PAYPAL_CLIENT_ID"
                                                    value="{{ env('PAYPAL_CLIENT_ID') }}"
                                                    placeholder="{{ translate('Paypal Client ID') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('Paypal Client Secret') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="PAYPAL_CLIENT_SECRET"
                                                    value="{{ env('PAYPAL_CLIENT_SECRET') }}"
                                                    placeholder="{{ translate('Paypal Client Secret') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('Paypal Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="paypal_sandbox" type="checkbox"
                                                        @if (get_business_setting('paypal_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Stripe') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/stripe.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'stripe_payment')"
                                            <?php if (get_business_setting('stripe_payment') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="stripe_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="stripe">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="STRIPE_KEY">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('Stripe Key') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="STRIPE_KEY"
                                                    value="{{ env('STRIPE_KEY') }}"
                                                    placeholder="{{ translate('STRIPE KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="STRIPE_SECRET">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('Stripe Secret') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="STRIPE_SECRET"
                                                    value="{{ env('STRIPE_SECRET') }}"
                                                    placeholder="{{ translate('STRIPE SECRET') }}">
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Mercadopago') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/mercadopago.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'mercadopago_payment')"
                                            <?php if (get_business_setting('mercadopago_payment') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="mercadopago_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        <input type="hidden" name="payment_method" value="mercadopago">
                                        @csrf
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="MERCADOPAGO_KEY">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('Mercadopago Key') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="MERCADOPAGO_KEY"
                                                    value="{{ env('MERCADOPAGO_KEY') }}"
                                                    placeholder="{{ translate('Mercadopago Key') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="MERCADOPAGO_ACCESS">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('Mercadopago Access') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="MERCADOPAGO_ACCESS"
                                                    value="{{ env('MERCADOPAGO_ACCESS') }}"
                                                    placeholder="{{ translate('Mercadopago Access') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="MERCADOPAGO_CURRENCY">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('MERCADOPAGO CURRENCY') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="MERCADOPAGO_CURRENCY"
                                                    value="{{ env('MERCADOPAGO_CURRENCY') }}"
                                                    placeholder="{{ translate('MERCADOPAGO CURRENCY') }}">
                                                <br>
                                                <div class="alert alert-primary" role="alert">
                                                    Currency must be <b>es-AR</b> or <b>es-CL</b> or <b>es-CO</b> or
                                                    <b>es-MX</b> or
                                                    <b>es-VE</b> or <b>es-UY</b> or <b>es-PE</b> or <b>pt-BR</b><br>
                                                    If kept empty, <b>en-US</b> will be used automatically
                                                </div>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Iyzico') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/iyzico.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'iyzico')"
                                            <?php if (get_business_setting('iyzico') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="iyzico_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="iyzico">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="IYZICO_API_KEY">
                                            <div class="col-lg-4">
                                                <label class="col-from-label">{{ translate('IYZICO_API_KEY') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="IYZICO_API_KEY"
                                                    value="{{ env('IYZICO_API_KEY') }}"
                                                    placeholder="{{ translate('IYZICO API KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="IYZICO_SECRET_KEY">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('IYZICO_SECRET_KEY') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="IYZICO_SECRET_KEY"
                                                    value="{{ env('IYZICO_SECRET_KEY') }}"
                                                    placeholder="{{ translate('IYZICO SECRET KEY') }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('IYZICO Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="iyzico_sandbox" type="checkbox"
                                                        @if (get_business_setting('iyzico_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Instamojo') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/instamojo.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'instamojo_payment')"
                                            <?php if (get_business_setting('instamojo_payment') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="instamojo_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="instamojo">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="IM_API_KEY">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('API KEY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="IM_API_KEY"
                                                    value="{{ env('IM_API_KEY') }}"
                                                    placeholder="{{ translate('IM API KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="IM_AUTH_TOKEN">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('AUTH TOKEN') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="IM_AUTH_TOKEN"
                                                    value="{{ env('IM_AUTH_TOKEN') }}"
                                                    placeholder="{{ translate('IM AUTH TOKEN') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('Instamojo Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="instamojo_sandbox" type="checkbox"
                                                        @if (get_business_setting('instamojo_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('PayStack') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/paystack.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'paystack')"
                                            <?php if (get_business_setting('paystack') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="paystack_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="paystack">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYSTACK_PUBLIC_KEY">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('PUBLIC KEY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="PAYSTACK_PUBLIC_KEY"
                                                    value="{{ env('PAYSTACK_PUBLIC_KEY') }}"
                                                    placeholder="{{ translate('PUBLIC KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYSTACK_SECRET_KEY">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('SECRET KEY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="PAYSTACK_SECRET_KEY"
                                                    value="{{ env('PAYSTACK_SECRET_KEY') }}"
                                                    placeholder="{{ translate('SECRET KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="MERCHANT_EMAIL">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('MERCHANT EMAIL') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="MERCHANT_EMAIL"
                                                    value="{{ env('MERCHANT_EMAIL') }}"
                                                    placeholder="{{ translate('MERCHANT EMAIL') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYSTACK_CURRENCY_CODE">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('PAYSTACK CURRENCY CODE') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="PAYSTACK_CURRENCY_CODE"
                                                    value="{{ env('PAYSTACK_CURRENCY_CODE') }}"
                                                    placeholder="{{ translate('PAYSTACK CURRENCY CODE') }}">
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Payhere') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/payhere.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'payhere')"
                                            <?php if (get_business_setting('payhere') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="payhere_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="payhere">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYHERE_MERCHANT_ID">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('PAYHERE MERCHANT ID') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="PAYHERE_MERCHANT_ID"
                                                    value="{{ env('PAYHERE_MERCHANT_ID') }}"
                                                    placeholder="{{ translate('PAYHERE MERCHANT ID') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYHERE_SECRET">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('PAYHERE SECRET') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="PAYHERE_SECRET"
                                                    value="{{ env('PAYHERE_SECRET') }}"
                                                    placeholder="{{ translate('PAYHERE SECRET') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYHERE_CURRENCY">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('PAYHERE CURRENCY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="PAYHERE_CURRENCY"
                                                    value="{{ env('PAYHERE_CURRENCY') }}"
                                                    placeholder="{{ translate('PAYHERE CURRENCY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('Payhere Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="payhere_sandbox" type="checkbox"
                                                        @if (get_business_setting('payhere_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Ngenius') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/ngenius.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'ngenius')"
                                            <?php if (get_business_setting('ngenius') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="ngenius_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="ngenius">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="NGENIUS_OUTLET_ID">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('NGENIUS OUTLET ID') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="NGENIUS_OUTLET_ID"
                                                    value="{{ env('NGENIUS_OUTLET_ID') }}"
                                                    placeholder="{{ translate('NGENIUS OUTLET ID') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="NGENIUS_API_KEY">
                                            <div class="col-lg-4">
                                                <label class="col-from-label">{{ translate('NGENIUS API KEY') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="NGENIUS_API_KEY"
                                                    value="{{ env('NGENIUS_API_KEY') }}"
                                                    placeholder="{{ translate('NGENIUS API KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="NGENIUS_CURRENCY">
                                            <div class="col-lg-4">
                                                <label class="col-from-label">{{ translate('NGENIUS CURRENCY') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="NGENIUS_CURRENCY"
                                                    value="{{ env('NGENIUS_CURRENCY') }}"
                                                    placeholder="{{ translate('NGENIUS CURRENCY') }}">
                                                <br>
                                                <div class="alert alert-primary" role="alert">
                                                    Currency must be <b>AED</b> or <b>USD</b> or <b>EUR</b><br>
                                                    If kept empty, <b>AED</b> will be used automatically
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('VoguePay') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/vogue.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'voguepay')"
                                            <?php if (get_business_setting('voguepay') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="voguepay_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="voguepay">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="VOGUE_MERCHANT_ID">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('MERCHANT ID') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="VOGUE_MERCHANT_ID"
                                                    value="{{ env('VOGUE_MERCHANT_ID') }}"
                                                    placeholder="{{ translate('MERCHANT ID') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="voguepay_sandbox" type="checkbox"
                                                        @if (get_business_setting('voguepay_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('RazorPay') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/rozarpay.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'razorpay')"
                                            <?php if (get_business_setting('razorpay') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="razorpay_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="razorpay">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="RAZOR_KEY">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('RAZOR KEY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="RAZOR_KEY"
                                                    value="{{ env('RAZOR_KEY') }}"
                                                    placeholder="{{ translate('RAZOR KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="RAZOR_SECRET">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('RAZOR SECRET') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="RAZOR_SECRET"
                                                    value="{{ env('RAZOR_SECRET') }}"
                                                    placeholder="{{ translate('RAZOR SECRET') }}">
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Authorize Net') }}</h5>
                                        <img class="ml-2"
                                            src="{{ static_asset('assets/img/cards/authorizenet.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'authorizenet')"
                                            <?php if (get_business_setting('authorizenet') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="authorizenet_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="authorizenet">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="MERCHANT_LOGIN_ID">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('MERCHANT_LOGIN_ID') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="MERCHANT_LOGIN_ID"
                                                    value="{{ env('MERCHANT_LOGIN_ID') }}"
                                                    placeholder="{{ translate('MERCHANT LOGIN ID') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="MERCHANT_TRANSACTION_KEY">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('MERCHANT_TRANSACTION_KEY') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control"
                                                    name="MERCHANT_TRANSACTION_KEY"
                                                    value="{{ env('MERCHANT_TRANSACTION_KEY') }}"
                                                    placeholder="{{ translate('MERCHANT TRANSACTION KEY') }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('Authorize Net Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="authorizenet_sandbox" type="checkbox"
                                                        @if (get_business_setting('authorizenet_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Payku') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/payku.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'payku')"
                                            <?php if (get_business_setting('payku') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="payku_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="payku">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYKU_BASE_URL">
                                            <div class="col-lg-4">
                                                <label class="col-from-label">{{ translate('PAYKU_BASE_URL') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="PAYKU_BASE_URL"
                                                    value="{{ env('PAYKU_BASE_URL') }}"
                                                    placeholder="{{ translate('PAYKU_BASE_URL') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYKU_PUBLIC_TOKEN">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('PAYKU_PUBLIC_TOKEN') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="PAYKU_PUBLIC_TOKEN"
                                                    value="{{ env('PAYKU_PUBLIC_TOKEN') }}"
                                                    placeholder="{{ translate('PAYKU_PUBLIC_TOKEN') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYKU_PRIVATE_TOKEN">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('PAYKU_PRIVATE_TOKEN') }}</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" name="PAYKU_PRIVATE_TOKEN"
                                                    value="{{ env('PAYKU_PRIVATE_TOKEN') }}"
                                                    placeholder="{{ translate('PAYKU_PRIVATE_TOKEN') }}">
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Proxy Pay') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/proxypay.png') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'proxypay')"
                                            <?php if (get_business_setting('proxypay') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0 h6 text-center">{{translate('MyFatoorah  Activation')}}</h3>
                                </div>
                                <div class="card-body text-center">
                                    <div class="clearfix">
                                        <img class="float-left" src="{{ static_asset('assets/img/cards/myfatoorah.png') }}" height="30">
                                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                            <input type="checkbox" onchange="updateSettings(this, 'myfatoorah')" <?php if (get_business_setting('myfatoorah') == 1) {
                                                echo 'checked';
                                            } ?>>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                                        {{ translate('You need to configure myfatoorah correctly to enable this feature') }}. <a href="{{ route('payment_method.index') }}">{{ translate('Configure Now') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('Paytm') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/paytm.jpg') }}"
                                            height="30">
                                    </div>

                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'paytm_payment')"
                                            <?php if (\App\Models\BusinessSetting::where('type', 'paytm_payment')->first()->value == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="paytm_form" class="form-horizontal"
                                        action="{{ route('paytm.update_credentials') }}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYTM_ENVIRONMENT">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('PAYTM ENVIRONMENT') }}</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="PAYTM_ENVIRONMENT"
                                                    value="{{ env('PAYTM_ENVIRONMENT') }}"
                                                    placeholder="local or production">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYTM_MERCHANT_ID">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('PAYTM MERCHANT ID') }}</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="PAYTM_MERCHANT_ID"
                                                    value="{{ env('PAYTM_MERCHANT_ID') }}"
                                                    placeholder="PAYTM MERCHANT ID">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYTM_MERCHANT_KEY">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('PAYTM MERCHANT KEY') }}</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="PAYTM_MERCHANT_KEY"
                                                    value="{{ env('PAYTM_MERCHANT_KEY') }}"
                                                    placeholder="PAYTM MERCHANT KEY">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYTM_MERCHANT_WEBSITE">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('PAYTM MERCHANT WEBSITE') }}</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control"
                                                    name="PAYTM_MERCHANT_WEBSITE"
                                                    value="{{ env('PAYTM_MERCHANT_WEBSITE') }}"
                                                    placeholder="PAYTM MERCHANT WEBSITE">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYTM_CHANNEL">
                                            <div class="col-lg-4">
                                                <label class="col-from-label">{{ translate('PAYTM CHANNEL') }}</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="PAYTM_CHANNEL"
                                                    value="{{ env('PAYTM_CHANNEL') }}" placeholder="PAYTM CHANNEL">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="PAYTM_INDUSTRY_TYPE">
                                            <div class="col-lg-4">
                                                <label
                                                    class="col-from-label">{{ translate('PAYTM INDUSTRY TYPE') }}</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="PAYTM_INDUSTRY_TYPE"
                                                    value="{{ env('PAYTM_INDUSTRY_TYPE') }}"
                                                    placeholder="PAYTM INDUSTRY TYPE">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6">{{ translate('ToyyibPay') }}</h5>
                                        <img class="ml-2" src="{{ static_asset('assets/img/cards/toyyibpay.png') }}"
                                            height="30">
                                    </div>
                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'toyyibpay_payment')"
                                            <?php if (\App\Models\BusinessSetting::where('type', 'toyyibpay_payment')->first()->value == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="toyyibpay_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="toyyibpay">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="TOYYIBPAY_KEY">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('TOYYIBPAY KEY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="TOYYIBPAY_KEY"
                                                    value="{{ env('TOYYIBPAY_KEY') }}"
                                                    placeholder="{{ translate('TOYYIBPAY KEY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="TOYYIBPAY_CATEGORY">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('TOYYIBPAY CATEGORY') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="TOYYIBPAY_CATEGORY"
                                                    value="{{ env('TOYYIBPAY_CATEGORY') }}"
                                                    placeholder="{{ translate('TOYYIBPAY CATEGORY') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('ToyyibPay Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="toyyibpay_sandbox" type="checkbox"
                                                        @if (get_business_setting('toyyibpay_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 h6 ">{{ translate('MyFatoorah') }}</h5>
                                        <img class="ml-2"
                                            src="{{ static_asset('assets/img/cards/myfatoorah.png') }}"
                                            height="30">
                                    </div>
                                    <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                        <input type="checkbox" onchange="updateSettings(this, 'myfatoorah')"
                                            <?php if (get_business_setting('myfatoorah') == 1) {
                                                echo 'checked';
                                            } ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="card-body">
                                    <form id="myfatoorah_form" class="form-horizontal"
                                        action="{{ route('payment_method.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="myfatoorah">
                                        <div class="form-group row">
                                            <input type="hidden" name="types[]" value="MYFATOORAH_TOKEN">
                                            <div class="col-md-4">
                                                <label
                                                    class="col-from-label">{{ translate('MYFATOORAH TOKEN') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="MYFATOORAH_TOKEN"
                                                    value="{{ env('MYFATOORAH_TOKEN') }}"
                                                    placeholder="{{ translate('MYFATOORAH TOKEN') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="col-from-label">{{ translate('Sandbox Mode') }}</label>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input value="1" name="myfatoorah_sandbox" type="checkbox"
                                                        @if (get_business_setting('myfatoorah_sandbox') == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if (addon_is_activated('african_pg'))
                            @if (get_business_setting('mpesa') == 1)
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex align-items-center">
                                                <h5 class="mb-0 h6">{{ translate('Mpesa Credential') }}</h5>
                                                <img class="float-left"
                                                    src="{{ static_asset('assets/img/cards/mpesa.png') }}"
                                                    height="30">
                                            </div>
                                            <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                                <input type="checkbox" onchange="updateSettings(this, 'mpesa')"
                                                    @if (get_business_setting('mpesa') == 1) checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="card-body">
                                            <form class="form-horizontal"
                                                action="{{ route('payment_method.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="payment_method" value="mpesa">
                                                <div class="form-group row">
                                                    <input type="hidden" name="types[]" value="MPESA_CONSUMER_KEY">
                                                    <div class="col-lg-4">
                                                        <label
                                                            class="col-from-label">{{ translate('MPESA CONSUMER KEY') }}</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            name="MPESA_CONSUMER_KEY"
                                                            value="{{ env('MPESA_CONSUMER_KEY') }}"
                                                            placeholder="{{ translate('MPESA_CONSUMER_KEY') }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <input type="hidden" name="types[]"
                                                        value="MPESA_CONSUMER_SECRET">
                                                    <div class="col-lg-4">
                                                        <label
                                                            class="col-from-label">{{ translate('MPESA CONSUMER SECRET') }}</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            name="MPESA_CONSUMER_SECRET"
                                                            value="{{ env('MPESA_CONSUMER_SECRET') }}"
                                                            placeholder="{{ translate('MPESA_CONSUMER_SECRET') }}"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <input type="hidden" name="types[]" value="MPESA_SHORT_CODE">
                                                    <div class="col-lg-4">
                                                        <label
                                                            class="col-from-label">{{ translate('MPESA SHORT CODE') }}</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            name="MPESA_SHORT_CODE"
                                                            value="{{ env('MPESA_SHORT_CODE') }}"
                                                            placeholder="{{ translate('MPESA_SHORT_CODE') }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <input type="hidden" name="types[]" value="MPESA_USERNAME">
                                                    <div class="col-lg-4">
                                                        <label
                                                            class="col-from-label">{{ translate('MPESA USERNAME') }}</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            name="MPESA_USERNAME" value="{{ env('MPESA_USERNAME') }}"
                                                            placeholder="{{ translate('MPESA_USERNAME') }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <input type="hidden" name="types[]" value="MPESA_PASSWORD">
                                                    <div class="col-lg-4">
                                                        <label
                                                            class="col-from-label">{{ translate('MPESA PASSWORD') }}</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            name="MPESA_PASSWORD" value="{{ env('MPESA_PASSWORD') }}"
                                                            placeholder="{{ translate('MPESA_PASSWORD') }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <input type="hidden" name="types[]" value="MPESA_PASSKEY">
                                                    <div class="col-lg-4">
                                                        <label
                                                            class="col-from-label">{{ translate('MPESA PASSKEY') }}</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control"
                                                            name="MPESA_PASSKEY" value="{{ env('MPESA_PASSKEY') }}"
                                                            placeholder="{{ translate('MPESA_PASSKEY') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <input type="hidden" name="types[]" value="MPESA_ENV">
                                                    <div class="col-lg-4">
                                                        <label
                                                            class="col-from-label">{{ translate('MPESA SANDBOX ACTIVATION') }}</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <select name="MPESA_ENV" class="form-control aiz-selectpicker"
                                                            required>
                                                            <option value="live"
                                                                @if (env('MPESA_ENV') == 'live') selected @endif>
                                                                {{ translate('Live') }}</option>
                                                            <option value="sandbox"
                                                                @if (env('MPESA_ENV') == 'sandbox') selected @endif>
                                                                {{ translate('Sandbox') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0 text-right">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h3 class="mb-0 h6">{{ translate('Flutterwave Credential') }}</h3>
                                            <img class="ml-2"
                                                src="{{ static_asset('assets/img/cards/flutterwave.png') }}"
                                                height="30">
                                        </div>
                                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                            <input type="checkbox" onchange="updateSettings(this, 'flutterwave')"
                                                @if (get_business_setting('flutterwave') == 1) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="card-body">
                                        <form id="flutterwave_form" class="form-horizontal"
                                            action="{{ route('payment_method.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="payment_method" value="flutterwave">
                                            <div class="form-group row">
                                                <input type="hidden" name="types[]" value="FLW_PUBLIC_KEY">
                                                <div class="col-lg-4">
                                                    <label
                                                        class="col-from-label">{{ translate('FLW_PUBLIC_KEY') }}</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="FLW_PUBLIC_KEY"
                                                        value="{{ env('FLW_PUBLIC_KEY') }}"
                                                        placeholder="{{ translate('FLW_PUBLIC_KEY') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <input type="hidden" name="types[]" value="FLW_SECRET_KEY">
                                                <div class="col-lg-4">
                                                    <label
                                                        class="col-from-label">{{ translate('FLW_SECRET_KEY') }}</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="FLW_SECRET_KEY"
                                                        value="{{ env('FLW_SECRET_KEY') }}"
                                                        placeholder="{{ translate('FLW_SECRET_KEY') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <input type="hidden" name="types[]" value="FLW_SECRET_HASH">
                                                <div class="col-lg-4">
                                                    <label
                                                        class="col-from-label">{{ translate('FLW_SECRET_HASH') }}</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="FLW_SECRET_HASH"
                                                        value="{{ env('FLW_SECRET_HASH') }}"
                                                        placeholder="{{ translate('FLW_SECRET_HASH') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <input type="hidden" name="types[]"
                                                    value="FLW_PAYMENT_CURRENCY_CODE">
                                                <div class="col-lg-4">
                                                    <label
                                                        class="col-from-label">{{ translate('FLW_PAYMENT_CURRENCY_CODE') }}</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control"
                                                        name="FLW_PAYMENT_CURRENCY_CODE"
                                                        value="{{ env('FLW_PAYMENT_CURRENCY_CODE') }}"
                                                        placeholder="{{ translate('FLW_PAYMENT_CURRENCY_CODE') }}"
                                                        required>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h3 class="mb-0 h6">{{ translate('PAYFAST Credential') }}</h3>
                                            <img class="ml-2"
                                                src="{{ static_asset('assets/img/cards/payfast.png') }}"
                                                height="30">
                                        </div>

                                        <label class="aiz-switch aiz-switch-success mb-0 float-right">
                                            <input type="checkbox" onchange="updateSettings(this, 'payfast')"
                                                @if (get_business_setting('payfast') == 1) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="card-body">
                                        <form id="payfast_form" class="form-horizontal"
                                            action="{{ route('payment_method.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="payment_method" value="payfast">
                                            <div class="form-group row">
                                                <input type="hidden" name="types[]" value="PAYFAST_MERCHANT_ID">
                                                <div class="col-lg-4">
                                                    <label
                                                        class="col-from-label">{{ translate('PAYFAST_MERCHANT_ID') }}</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control"
                                                        name="PAYFAST_MERCHANT_ID"
                                                        value="{{ env('PAYFAST_MERCHANT_ID') }}"
                                                        placeholder="{{ translate('PAYFAST_MERCHANT_ID') }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <input type="hidden" name="types[]" value="PAYFAST_MERCHANT_KEY">
                                                <div class="col-lg-4">
                                                    <label
                                                        class="col-from-label">{{ translate('PAYFAST_MERCHANT_KEY') }}</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control"
                                                        name="PAYFAST_MERCHANT_KEY"
                                                        value="{{ env('PAYFAST_MERCHANT_KEY') }}"
                                                        placeholder="{{ translate('PAYFAST_MERCHANT_KEY') }}" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label
                                                        class="col-from-label">{{ translate('PAYFAST Sandbox Mode') }}</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="aiz-switch aiz-switch-success mb-0">
                                                        <input value="1" name="payfast_sandbox" type="checkbox"
                                                            @if (get_business_setting('payfast_sandbox') == 1) checked @endif>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (addon_is_activated('offline_payment'))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0">Manual payment</h6>

                        <button class="btn btn-sm btn-primary" id="toggleManualcardbody">Show</button>
                    </div>
                    <div class="card-body" id="manual_payment_card_body" style="display: none">
                        @can('add_manual_payment_method')
                            <div class="aiz-titlebar mt-2 mb-3">
                                <div class="text-md-right">
                                    <a href="{{ route('manual_payment_methods.create') }}"
                                        class="btn btn-circle btn-info">
                                        <span>{{ translate('Add New Payment Method') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endcan

                        {{-- <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{translate('Manual Payment Method')}}</h5>
                    </div>
                    <div class="card-body"> --}}
                        <table class="table aiz-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate('Heading') }}</th>
                                    <th>{{ translate('Logo') }}</th>
                                    <th width="10%" class="text-right">{{ translate('Options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (get_all_manual_payment_methods() as $key => $manual_payment_method)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ str_replace('_manual', '', $manual_payment_method->heading) }}</td>
                                        <td><img class="w-50px"
                                                src="{{ uploaded_asset($manual_payment_method->photo) }}"
                                                alt="Logo"></td>
                                        <td class="text-right">
                                            @can('edit_manual_payment_method')
                                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                    href="{{ route('manual_payment_methods.edit', encrypt($manual_payment_method->id)) }}"
                                                    title="{{ translate('Edit') }}">
                                                    <i class="las la-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete_manual_payment_method')
                                                <a href="#"
                                                    class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                    data-href="{{ route('manual_payment_methods.destroy', $manual_payment_method->id) }}"
                                                    title="{{ translate('Delete') }}">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- </div>
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 h6">{{ translate('Link Payment') }}</h5>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button class="btn btn-sm btn-primary ml-2" id="toggleLinkcardbody">Show</button>
                        </div>
                    </div>
                    <div class="card-body" id="link_payment_card_body" style="display: none">
                        {{-- @can('add_link_payment_method') --}}
                        <div class="aiz-titlebar mt-2 mb-3">
                            <div class="text-md-right">
                                <a href="{{ route('link_payment_methods.create') }}" class="btn btn-circle btn-info">
                                    <span>{{ translate('Add New Payment Method') }}</span>
                                </a>
                            </div>
                        </div>
                        {{-- @endcan --}}

                        <table class="table aiz-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate('Heading') }}</th>
                                    <th>{{ translate('Logo') }}</th>
                                    <th width="10%" class="text-right">{{ translate('Options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (get_all_link_payment_methods() as $key => $manual_payment_method)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ str_replace('_link', '', $manual_payment_method->heading) }}</td>
                                        <td><img class="w-50px"
                                                src="{{ uploaded_asset($manual_payment_method->photo) }}"
                                                alt="Logo"></td>
                                        <td class="text-right">
                                            @can('edit_manual_payment_method')
                                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                    href="{{ route('link_payment_methods.edit', encrypt($manual_payment_method->id)) }}"
                                                    title="{{ translate('Edit') }}">
                                                    <i class="las la-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete_manual_payment_method')
                                                <a href="#"
                                                    class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                                    data-href="{{ route('manual_payment_methods.destroy', $manual_payment_method->id) }}"
                                                    title="{{ translate('Delete') }}">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var formIds = [
                '#bkash_form',
                '#nagad_form',
                '#sslcommerz_form',
                '#aamarpay_form',
                '#uddoktapay_form',
                '#paypal_form',
                '#stripe_form',
                '#mercadopago_form',
                '#iyzico_form',
                '#instamojo_form',
                '#paystack_form',
                '#payhere_form',
                '#ngenius_form',
                '#voguepay_form',
                '#razorpay_form',
                '#authorizenet_form',
                '#payku_form',
                '#paytm_form',
                '#toyyibpay_form',
                '#myfatoorah_form',
                '#flutterwave_form',
                '#payfast_form'
            ];

            formIds.forEach(function(formId) {
                $(formId + ' input').change(function(event) {
                    handleFormSubmission(formId);
                });
            });
        });

        $("#togglecardbody").on("click", function() {
            $("#online_payment_card_body").slideToggle(300);
            const buttonText = $(this).text() === "Show" ? "Hide" : "Show";
            $(this).text(buttonText);
        });

        $("#toggleManualcardbody").on("click", function() {
            $("#manual_payment_card_body").slideToggle(300);
            const buttonText = $(this).text() === "Show" ? "Hide" : "Show";
            $(this).text(buttonText);
        });

        $("#toggleLinkcardbody").on("click", function() {
            $("#link_payment_card_body").slideToggle(300);
            const buttonText = $(this).text() === "Show" ? "Hide" : "Show";
            $(this).text(buttonText);
        });

        function handleFormSubmission(formId) {
            var formData = $(formId).serialize();

            $.ajax({
                url: $(formId).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    AIZ.plugins.notify('success',
                        '{{ translate('Settings updated successfully') }}');
                },
                error: function(xhr, status, error) {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }

        function updateSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }

            $.post('{{ route('business_settings.update.activation') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function(data) {
                if (data == '1') {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
