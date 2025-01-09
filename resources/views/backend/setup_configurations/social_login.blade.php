<style>
    #map {
        width: 100%;
        height: 250px;
    }
</style>


<div class="row">
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Google Login Credential') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="GOOGLE_CLIENT_ID">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Client ID') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="GOOGLE_CLIENT_ID"
                                value="{{ env('GOOGLE_CLIENT_ID') }}" placeholder="{{ translate('Google Client ID') }}"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="GOOGLE_CLIENT_SECRET">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Client Secret') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="GOOGLE_CLIENT_SECRET"
                                value="{{ env('GOOGLE_CLIENT_SECRET') }}"
                                placeholder="{{ translate('Google Client Secret') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Facebook Login Credential') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="FACEBOOK_CLIENT_ID">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('App ID') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="FACEBOOK_CLIENT_ID"
                                value="{{ env('FACEBOOK_CLIENT_ID') }}"
                                placeholder="{{ translate('Facebook Client ID') }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="FACEBOOK_CLIENT_SECRET">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('App Secret') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="FACEBOOK_CLIENT_SECRET"
                                value="{{ env('FACEBOOK_CLIENT_SECRET') }}"
                                placeholder="{{ translate('Facebook Client Secret') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Twitter Login Credential') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="TWITTER_CLIENT_ID">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Client ID') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="TWITTER_CLIENT_ID"
                                value="{{ env('TWITTER_CLIENT_ID') }}"
                                placeholder="{{ translate('Twitter Client ID') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="TWITTER_CLIENT_SECRET">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Client Secret') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="TWITTER_CLIENT_SECRET"
                                value="{{ env('TWITTER_CLIENT_SECRET') }}"
                                placeholder="{{ translate('Twitter Client Secret') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Apple Login Credential') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="types[]" value="SIGN_IN_WITH_APPLE_LOGIN">
                    <input type="hidden" name="SIGN_IN_WITH_APPLE_LOGIN" value="{{ url('/users/login') }}"
                        required>
                    <input type="hidden" name="types[]" value="SIGN_IN_WITH_APPLE_REDIRECT">
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="SIGN_IN_WITH_APPLE_REDIRECT">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Callback URL') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="SIGN_IN_WITH_APPLE_REDIRECT"
                                value="{{ url('/apple-callback') }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="SIGN_IN_WITH_APPLE_CLIENT_ID">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Client ID') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="SIGN_IN_WITH_APPLE_CLIENT_ID"
                                value="{{ env('SIGN_IN_WITH_APPLE_CLIENT_ID') }}"
                                placeholder="{{ translate('Apple Client ID') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="SIGN_IN_WITH_APPLE_CLIENT_SECRET">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Client Secret') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="SIGN_IN_WITH_APPLE_CLIENT_SECRET"
                                value="{{ env('SIGN_IN_WITH_APPLE_CLIENT_SECRET') }}"
                                placeholder="{{ translate('Apple Client Secret') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- facebook chat --}}
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Facebook Chat Setting') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('facebook_chat.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-from-label">{{ translate('Facebook Chat') }}</label>
                        </div>
                        <div class="col-md-7">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" name="facebook_chat" type="checkbox"
                                    @if (get_business_setting('facebook_chat') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="FACEBOOK_PAGE_ID">
                        <div class="col-md-3">
                            <label class="col-from-label">{{ translate('Facebook Page ID') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="FACEBOOK_PAGE_ID"
                                value="{{ env('FACEBOOK_PAGE_ID') }}"
                                placeholder="{{ translate('Facebook Page ID') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-gray-light">
            <div class="card-header">
                <h5 class="mb-0 h6">
                    {{ translate('Please be carefull when you are configuring Facebook chat. For incorrect configuration you will not get messenger icon on your user-end site.') }}
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group mar-no">
                    <li class="list-group-item text-dark">1. {{ translate('Login into your facebook page') }}</li>
                    <li class="list-group-item text-dark">2.
                        {{ translate('Find the About option of your facebook page') }}.</li>
                    <li class="list-group-item text-dark">3.
                        {{ translate('At the very bottom, you can find the “Facebook Page ID”') }}.</li>
                    <li class="list-group-item text-dark">4.
                        {{ translate('Go to Settings of your page and find the option of "Advance Messaging"') }}.</li>
                    <li class="list-group-item text-dark">5.
                        {{ translate('Scroll down that page and you will get "white listed domain"') }}.</li>
                    <li class="list-group-item text-dark">6. {{ translate('Set your website domain name') }}.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Tawk Settings --}}
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Tawk Setting') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('tawk_chat.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-from-label">{{ translate('Tawk Chat') }}</label>
                        </div>
                        <div class="col-md-7">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" name="tawk_chat" type="checkbox"
                                    @if (get_business_setting('tawk_chat') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="TAWK_ID">
                        <div class="col-md-3">
                            <label class="col-from-label">{{ translate('Tawk ID') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="TAWK_ID" value="{{ env('TAWK_ID') }}"
                                placeholder="{{ translate('Tawk ID Link') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Whatsapp Settings --}}
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('whatsapp_setting') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('whatsapp.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-from-label">{{ translate('Whatsapp Chat') }}</label>
                        </div>
                        <div class="col-md-7">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" name="whatsapp" type="checkbox"
                                    @if (get_business_setting('whatsapp') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="WHATSAPP_NUMBER">
                        <div class="col-md-3">
                            <label class="col-from-label">{{ translate('Whatsapp Number') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="WHATSAPP_NUMBER"
                                value="{{ env('WHATSAPP_NUMBER') }}"
                                placeholder="{{ translate('Whatsapp Number') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- Help line number -->
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Helpline Number') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('business_settings.update') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="helpline_number">
                        <div class="col-md-3">
                            <label class="col-from-label">{{ translate('Helpline Number') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control"
                                placeholder="{{ translate('Help line number') }}" name="helpline_number"
                                value="{{ get_business_setting('helpline_number') }}">
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- facebook comment --}}
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Facebook Comment Setting') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('facebook-comment.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-5">
                            <label class="col-from-label">{{ translate('Facebook Comment') }}</label>
                        </div>
                        <div class="col-md-7">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                @php
                                    $facebook_comment_data = \App\Models\BusinessSetting::where(
                                        'type',
                                        'facebook_comment',
                                    )->first();
                                @endphp
                                <input value="1" name="facebook_comment" type="checkbox"
                                    @if ($facebook_comment_data && $facebook_comment_data->value == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="FACEBOOK_APP_ID">
                        <div class="col-md-5">
                            <label class="col-from-label">{{ translate('Facebook App ID') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="FACEBOOK_APP_ID"
                                value="{{ env('FACEBOOK_APP_ID') }}"
                                placeholder="{{ translate('Facebook App ID') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-gray-light">
            <div class="card-header">
                <h5 class="mb-0 h6">
                    {{ translate('Please be carefull when you are configuring Facebook Comment. For incorrect configuration you will not get comment section on your user-end site.') }}
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group mar-no">
                    <li class="list-group-item text-dark">
                        1. {{ translate('Login into your facebook page') }}
                    </li>
                    <li class="list-group-item text-dark">
                        2. {{ translate('After then go to this URL https://developers.facebook.com/apps/') }}.
                    </li>
                    <li class="list-group-item text-dark">
                        3. {{ translate('Create Your App') }}.
                    </li>
                    <li class="list-group-item text-dark">
                        4. {{ translate('In Dashboard page you will get your App ID') }}.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Facebook Pixel --}}
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Facebook Pixel Setting') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('facebook_pixel.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Facebook Pixel') }}</label>
                        </div>
                        <div class="col-md-7">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" name="facebook_pixel" type="checkbox"
                                    @if (get_business_setting('facebook_pixel') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="FACEBOOK_PIXEL_ID">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Facebook Pixel ID') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="FACEBOOK_PIXEL_ID"
                                value="{{ env('FACEBOOK_PIXEL_ID') }}"
                                placeholder="{{ translate('Facebook Pixel ID') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="FACEBOOK_ACCESS_TOKEN">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Facebook Access Token') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="FACEBOOK_ACCESS_TOKEN"
                                value="{{ env('FACEBOOK_ACCESS_TOKEN') }}"
                                placeholder="{{ translate('Facebook Pixel Access Token') . ' (optional)' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="FACEBOOK_TEST_EVENT_CODE">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Facebook Test Event Code') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="FACEBOOK_TEST_EVENT_CODE"
                                value="{{ env('FACEBOOK_TEST_EVENT_CODE') }}"
                                placeholder="{{ translate('Facebook Test Event Code') . ' (optional)' }}">
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-gray-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Please be carefull when you are configuring Facebook pixel.') }}
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group mar-no">
                    <li class="list-group-item text-dark">1.
                        {{ translate('Log in to Facebook and go to your Ads Manager account') }}.</li>
                    <li class="list-group-item text-dark">2.
                        {{ translate('Open the Navigation Bar and select Events Manager') }}.</li>
                    <li class="list-group-item text-dark">3.
                        {{ translate('Copy your Pixel ID from underneath your Site Name and paste the number into Facebook Pixel ID field') }}.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Facebook Domain Verification --}}
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Facebook Domain Verification') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('facebook_domain_verification.update') }}"
                    method="POST">
                    @csrf
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="FACEBOOK_DOMAIN_VERIFICATION">
                        <div class="col-lg-12">
                            <label class="col-from-label">{{ translate('Content ') }}</label>
                        </div>
                        <div class="col-md-12">
                            <textarea type="text" class="form-control" name="FACEBOOK_DOMAIN_VERIFICATION"
                                placeholder="test*****************************" required>{{ env('FACEBOOK_DOMAIN_VERIFICATION') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">
                    {{ translate('Facebook Domain Verification Meta Sample') }}
                </h5>
            </div>
            <div class="card-body">
                <h>
                    &lt;meta name="facebook-domain-verification" content="test*****************************" /&gt;
                    </p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('G-tag Setting') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('gtag.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('G-tag') }}</label>
                        </div>
                        <div class="col-md-7">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" name="gtag" type="checkbox"
                                    @if (get_business_setting('gtag') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="GTAG_ID">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('G-Tag ID') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="GTAG_ID" value="{{ env('GTAG_ID') }}"
                                placeholder="{{ translate('G-Tag ID eg: GTM-N3541234') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- google analytics  --}}
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Google Analytics Setting') }}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('google_analytics.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Google Analytics') }}</label>
                        </div>
                        <div class="col-md-7">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" name="google_analytics" type="checkbox"
                                    @if (get_business_setting('google_analytics') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="TRACKING_ID">
                        <div class="col-lg-3">
                            <label class="col-from-label">{{ translate('Tracking ID') }}</label>
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="TRACKING_ID"
                                value="{{ env('TRACKING_ID') }}" placeholder="{{ translate('Tracking ID') }}"
                                required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- google firebase --}}
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h3 class="mb-0 h6">{{ translate('Google Firebase Setting') }}</h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('google-firebase.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="control-label">{{ translate('Google Firebase') }}</label>
                        </div>
                        <div class="col-md-8">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" name="google_firebase" type="checkbox"
                                    @if (get_business_setting('google_firebase') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="FCM_SERVER_KEY">
                        <div class="col-md-4">
                            <label class="control-label">{{ translate('FCM SERVER KEY') }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="FCM_SERVER_KEY"
                                value="{{ env('FCM_SERVER_KEY') }}"
                                placeholder="{{ translate('FCM SERVER KEY') }}">
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- google recaptcha --}}
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h3 class="mb-0 h6">{{ translate('Google reCAPTCHA Setting') }}</h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('google_recaptcha.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="control-label">{{ translate('Google reCAPTCHA') }}</label>
                        </div>
                        <div class="col-md-8">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" name="google_recaptcha" type="checkbox"
                                    @if (get_business_setting('google_recaptcha') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="CAPTCHA_KEY">
                        <div class="col-md-4">
                            <label class="control-label">{{ translate('Site KEY') }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="CAPTCHA_KEY"
                                value="{{ env('CAPTCHA_KEY') }}" placeholder="{{ translate('Site KEY') }}"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="RECAPTCHA_SECRET_KEY">
                        <div class="col-md-4">
                            <label class="control-label">{{ translate('SECRET KEY') }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="RECAPTCHA_SECRET_KEY"
                                value="{{ env('RECAPTCHA_SECRET_KEY') }}"
                                placeholder="{{ translate('SECRET KEY') }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- google map --}}
    <div class="col-md-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h3 class="mb-0 h6">{{ translate('Google Map Setting') }}</h3>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('google-map.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="control-label">{{ translate('Google Map') }}</label>
                        </div>
                        <div class="col-md-8">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input value="1" name="google_map" type="checkbox"
                                    @if (get_business_setting('google_map') == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="MAP_API_KEY">
                        <div class="col-md-4">
                            <label class="control-label">{{ translate('Map API KEY') }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="MAP_API_KEY"
                                value="{{ env('MAP_API_KEY') }}" placeholder="{{ translate('Map API KEY') }}">
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0 h6">{{ translate('Google Map Configuration Notes') }}</h3>
            </div>
            <div class="card-body">
                <ul class="list-group mb-2">
                    <li class="list-group-item text-dark">
                        1. {{ translate('Enable Google map ') }}
                    </li>
                    <li class="list-group-item text-dark">
                        2. {{ translate('Set the google map API key') }}.
                    </li>
                    <li class="list-group-item text-dark">
                        2. {{ translate('After then you will find the google map option to set default location') }}.
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @if (get_business_setting('google_map') == 1)
        <div class="col-md-8 mx-auto">
            <div class="card shadow-none bg-light">
                <div class="card-header">
                    <h3 class="mb-0 h6">{{ translate('Default Location Setting') }}</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('business_settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div id="map"></div>
                            <ul id="geoData">
                                <li style="display: none;">Full Address: <span id="location"></span></li>
                                <li style="display: none;">Postal Code: <span id="postal_code"></span></li>
                                <li style="display: none;">Country: <span id="country"></span></li>
                                <li style="display: none;">Latitude: <span id="lat"></span></li>
                                <li style="display: none;">Longitude: <span id="lon"></span></li>
                            </ul>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2" id="">
                                <label for="exampleInputuname">Longitude</label>
                            </div>
                            <div class="col-md-10" id="">
                                <input type="hidden" name="types[]" value="google_map_longtitude">
                                <input type="text" class="form-control mb-3" id="longitude"
                                    name="google_map_longtitude"
                                    value="{{ get_business_setting('google_map_longtitude') }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2" id="">
                                <label for="exampleInputuname">Latitude</label>
                            </div>
                            <div class="col-md-10" id="">
                                <input type="hidden" name="types[]" value="google_map_latitude">
                                <input type="text" class="form-control mb-3" id="latitude"
                                    name="google_map_latitude"
                                    value="{{ get_business_setting('google_map_latitude') }}" readonly>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

@if (get_business_setting('google_map') == 1)
    @include('frontend.' . get_business_setting('homepage_select') . '.partials.google_map')
@endif
