<!-- Footer Widget -->
<div class="row gutters-10">
    <!-- Footer Info -->
    <div class="col-lg-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="mb-0">{{ translate('Footer') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Select Footer -->
                    {{-- <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('footer_top_bar') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="footer_top_bar">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="updateSettings(this, 'footer_top_bar')"
                                    {{ get_business_setting('footer_top_bar') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div> --}}

                    <!-- Select Footer -->
                    <div class="form-group row">
                        <label class="col-md-4 col-from-label mt-2">{{ translate('Select Footer') }}</label>
                        <div class="col-md-5">
                            <input type="hidden" name="types[]" value="homepage_footer">
                            <select class="form-control aiz-selectpicker" name="homepage_footer">
                                <option value="footer"
                                    {{ get_business_setting('homepage_footer') == 'footer' ? 'selected' : '' }}>
                                    Footer 1
                                </option>
                                <option value="footer2"
                                    {{ get_business_setting('homepage_footer') == 'footer2' ? 'selected' : '' }}>
                                    Footer 2
                                </option>
                                <option value="footer3"
                                    {{ get_business_setting('homepage_footer') == 'footer3' ? 'selected' : '' }}>
                                    Footer 3
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <!-- Update Button -->
                            <button type="submit"
                                class="btn btn-success btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                        </div>
                    </div>

                    <!-- Bottom Navbar -->
                    <div class="form-group row">
                        <label class="col-md-4 col-from-label mt-2">{{ translate('Bottom Navbar') }} <br> (Mobile & Tab
                            Screen)</label>
                        <div class="col-md-5">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="updateBusinessSettings(this, 'bottom_navbar')"
                                    {{ get_business_setting('bottom_navbar') == 1 ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Title -->
                    {{-- <div class="form-group">
                        <label>{{ translate('Title') }} ({{ translate('Translatable') }})</label>
                        <input type="hidden" name="types[][{{ $lang }}]" value="footer_title">
                        <input type="text" class="form-control" placeholder="Footer title" name="footer_title"
                            value="{{ get_business_setting('footer_title', null, $lang) }}">
                    </div> --}}
                    <!-- About description -->
                    {{-- <div class="form-group">
                        <label>{{ translate('Footer description') }} ({{ translate('Translatable') }})</label>
                        <input type="hidden" name="types[][{{ $lang }}]" value="footer_description">
                        <textarea class="form-control" name="footer_description" rows="6" placeholder="Type..">{{ get_business_setting('footer_description', null, $lang) }}</textarea>
                    </div> --}}

                </form>
            </div>
        </div>

        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="mb-0">{{ translate('Contact Info Widget') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Contact address -->
                    <div class="form-group">
                        <label>{{ translate('Contact address') }} ({{ translate('Translatable') }})</label>
                        <input type="hidden" name="types[][{{ $lang }}]" value="contact_address">
                        <input type="text" class="form-control" placeholder="{{ translate('Address') }}"
                            name="contact_address" value="{{ get_business_setting('contact_address', null, $lang) }}">
                    </div>
                    <!-- Contact phone -->
                    <div class="form-group">
                        <label>{{ translate('Contact phone') }}</label>
                        <input type="hidden" name="types[]" value="contact_phone">
                        <input type="text" class="form-control" placeholder="{{ translate('Phone') }}"
                            name="contact_phone" value="{{ get_business_setting('contact_phone') }}">
                    </div>
                    <!-- Contact email -->
                    <div class="form-group">
                        <label>{{ translate('Contact email') }}</label>
                        <input type="hidden" name="types[]" value="contact_email">
                        <input type="text" class="form-control" placeholder="{{ translate('Email') }}"
                            name="contact_email" value="{{ get_business_setting('contact_email') }}">
                    </div>
                    <!-- Update Button -->
                    <div class="mt-4 mb-2 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- About Widget -->
    <div class="col-lg-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="mb-0">{{ translate('About Widget') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Footer Logo -->
                    <div class="form-group">
                        <label class="form-label" for="signinSrEmail">{{ translate('Footer Logo') }}</label>
                        <div class="input-group " data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                    {{ translate('Browse') }}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="types[]" value="footer_logo">
                            <input type="hidden" name="footer_logo" class="selected-files"
                                value="{{ get_business_setting('footer_logo') }}">
                        </div>
                        <div class="file-preview"></div>
                    </div>
                    <!-- About description -->
                    <div class="form-group">
                        <label>{{ translate('About description') }} ({{ translate('Translatable') }})</label>
                        <input type="hidden" name="types[][{{ $lang }}]" value="about_us_description">
                        <textarea class="aiz-text-editor form-control" name="about_us_description"
                            data-buttons='[["font", ["bold", "underline", "italic"]],["para", ["ul", "ol"]],["view", ["undo","redo"]]]'
                            placeholder="Type.." data-min-height="50">
                                        {!! get_business_setting('about_us_description', null, $lang) !!}
                                    </textarea>
                    </div>
                    <!-- Play Store Link -->
                    <div class="form-group">
                        <label>{{ translate('Play Store Link') }}</label>
                        <input type="hidden" name="types[]" value="play_store_link">
                        <input type="text" class="form-control" placeholder="http://" name="play_store_link"
                            value="{{ get_business_setting('play_store_link') }}">
                    </div>
                    <!-- App Store Link -->
                    <div class="form-group">
                        <label>{{ translate('App Store Link') }}</label>
                        <input type="hidden" name="types[]" value="app_store_link">
                        <input type="text" class="form-control" placeholder="http://" name="app_store_link"
                            value="{{ get_business_setting('app_store_link') }}">
                    </div>
                    <!-- Update Button -->
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Link Widget One -->
    <div class="col-lg-12">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="mb-0">{{ translate('Link Widget One') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Title -->
                    <div class="form-group">
                        <label>{{ translate('Title') }} ({{ translate('Translatable') }})</label>
                        <input type="hidden" name="types[][{{ $lang }}]" value="widget_one">
                        <input type="text" class="form-control" placeholder="Widget title" name="widget_one"
                            value="{{ get_business_setting('widget_one', null, $lang) }}">
                    </div>
                    <!-- Links -->
                    <div class="form-group">
                        <label>{{ translate('Links') }} - ({{ translate('Translatable') }}
                            {{ translate('Label') }})</label>
                        <div class="w3-links-target">
                            <input type="hidden" name="types[][{{ $lang }}]" value="widget_one_labels">
                            <input type="hidden" name="types[]" value="widget_one_links">
                            @if (get_business_setting('widget_one_labels', null, $lang) != null)
                                @foreach (json_decode(get_business_setting('widget_one_labels', null, $lang), true) as $key => $value)
                                    @php
                                        $widget_one_links = '';
                                        if (isset(json_decode(get_business_setting('widget_one_links'), true)[$key])) {
                                            $widget_one_links = json_decode(
                                                get_business_setting('widget_one_links'),
                                                true,
                                            )[$key];
                                        }
                                    @endphp
                                    <div class="row gutters-5">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    placeholder="{{ translate('Label') }}" name="widget_one_labels[]"
                                                    value="{{ $value }}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="http://"
                                                    name="widget_one_links[]" value="{{ $widget_one_links }}">
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button"
                                                class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"
                                                data-toggle="remove-parent" data-parent=".row">
                                                <i class="las la-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-soft-secondary btn-sm" data-toggle="add-more"
                            data-content='<div class="row gutters-5">
    										<div class="col-4">
    											<div class="form-group">
    												<input type="text" class="form-control" placeholder="{{ translate('Label') }}" name="widget_one_labels[]">
    											</div>
    										</div>
    										<div class="col">
    											<div class="form-group">
    												<input type="text" class="form-control" placeholder="http://" name="widget_one_links[]">
    											</div>
    										</div>
    										<div class="col-auto">
    											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
    												<i class="las la-times"></i>
    											</button>
    										</div>
    									</div>'
                            data-target=".w3-links-target">
                            {{ translate('Add New') }}
                        </button>
                    </div>
                    <!-- Update Button -->
                    <div class="my-4 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer Bottom -->
<div class="card">
    <div class="card-header">
        <h6 class="fw-600 mb-0">{{ translate('Footer Bottom') }}</h6>
    </div>
    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <!-- Social Link Widget -->
            <div class="card shadow-none bg-light">
                <div class="card-header">
                    <h6 class="mb-0">{{ translate('Social Link Widget ') }}</h6>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-from-label">{{ translate('Show Social Links?') }}</label>
                        <div class="col-md-9">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="hidden" name="types[]" value="show_social_links">
                                <input type="checkbox" name="show_social_links"
                                    @if (get_business_setting('show_social_links') == 'on') checked @endif>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ translate('Social Links') }}</label>
                        <!-- Facebook Link -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="lab la-facebook-f"></i></span>
                            </div>
                            <input type="hidden" name="types[]" value="facebook_link">
                            <input type="text" class="form-control" placeholder="http://" name="facebook_link"
                                value="{{ get_business_setting('facebook_link') }}">
                        </div>
                        <!-- Twitter Link -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="lab la-twitter"></i></span>
                            </div>
                            <input type="hidden" name="types[]" value="twitter_link">
                            <input type="text" class="form-control" placeholder="http://" name="twitter_link"
                                value="{{ get_business_setting('twitter_link') }}">
                        </div>
                        <!-- Instagram Link -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="lab la-instagram"></i></span>
                            </div>
                            <input type="hidden" name="types[]" value="instagram_link">
                            <input type="text" class="form-control" placeholder="http://" name="instagram_link"
                                value="{{ get_business_setting('instagram_link') }}">
                        </div>
                        <!-- Youtube Link -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="lab la-youtube"></i></span>
                            </div>
                            <input type="hidden" name="types[]" value="youtube_link">
                            <input type="text" class="form-control" placeholder="http://" name="youtube_link"
                                value="{{ get_business_setting('youtube_link') }}">
                        </div>
                        <!-- Linkedin Link -->
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="lab la-linkedin-in"></i></span>
                            </div>
                            <input type="hidden" name="types[]" value="linkedin_link">
                            <input type="text" class="form-control" placeholder="http://" name="linkedin_link"
                                value="{{ get_business_setting('linkedin_link') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Download App Link -->
            @if (get_business_setting('vendor_system_activation') == 1 || addon_is_activated('delivery_boy'))
                <div class="card shadow-none bg-light">
                    <div class="card-header">
                        <h6 class="mb-0">{{ translate('Download App Link') }}</h6>
                    </div>
                    <div class="card-body">
                        <!-- Seller App Link -->
                        @if (get_business_setting('vendor_system_activation') == 1)
                            <div class="form-group">
                                <label>{{ translate('Seller App Link') }}</label>
                                <div class="input-group form-group">
                                    <input type="hidden" name="types[]" value="seller_app_link">
                                    <input type="text" class="form-control" placeholder="http://"
                                        name="seller_app_link" value="{{ get_business_setting('seller_app_link') }}">
                                </div>
                            </div>
                        @endif
                        <!-- Delivery Boy App Link -->
                        @if (addon_is_activated('delivery_boy'))
                            <div class="form-group">
                                <label>{{ translate('Delivery Boy App Link') }}</label>
                                <div class="input-group form-group">
                                    <input type="hidden" name="types[]" value="delivery_boy_app_link">
                                    <input type="text" class="form-control" placeholder="http://"
                                        name="delivery_boy_app_link"
                                        value="{{ get_business_setting('delivery_boy_app_link') }}">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Payment Methods Widget -->
            <div class="card shadow-none bg-light">
                <div class="card-header">
                    <h6 class="mb-0">{{ translate('Payment Methods Widget ') }}</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>{{ translate('Payment Methods') }}</label>
                        <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                    {{ translate('Browse') }}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="types[]" value="payment_method_images">
                            <input type="hidden" name="payment_method_images" class="selected-files"
                                value="{{ get_business_setting('payment_method_images') }}">
                        </div>
                        <div class="file-preview box sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Button -->
            <div class="my-4 text-right">
                <button type="submit"
                    class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
            </div>
        </div>
    </form>
</div>
