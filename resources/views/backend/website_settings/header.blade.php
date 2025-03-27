<div class="row">
    <div class="col-md-12">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="mb-0">{{ translate('Header Setting') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Select Top Bar -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Select Homepage Topbar') }}</label>
                                <div class="col-md-8">
                                    <input type="hidden" name="types[]" value="homepage_topbar">
                                    <select class="form-control aiz-selectpicker" name="homepage_topbar">
                                        <option value="nav"
                                            {{ get_business_setting('homepage_topbar') == 'nav' ? 'selected' : '' }}>
                                            Topbar
                                            1
                                        </option>
                                        <option value="nav2"
                                            {{ get_business_setting('homepage_topbar') == 'nav2' ? 'selected' : '' }}>
                                            Topbar
                                            2
                                        </option>
                                        <option value="nav3"
                                            {{ get_business_setting('homepage_topbar') == 'nav3' ? 'selected' : '' }}>
                                            Topbar
                                            3
                                        </option>
                                        <option value="nav4"
                                            {{ get_business_setting('homepage_topbar') == 'nav4' ? 'selected' : '' }}>
                                            Topbar
                                            4
                                        </option>
                                        <option value="nav5"
                                            {{ get_business_setting('homepage_topbar') == 'nav5' ? 'selected' : '' }}>
                                            Topbar
                                            5
                                        </option>
                                        <option value="nav6"
                                            {{ get_business_setting('homepage_topbar') == 'nav6' ? 'selected' : '' }}>
                                            Topbar
                                            6
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- Show Language Switcher -->
                            <div class="form-group row">
                                <label
                                    class="col-md-3 col-from-label">{{ translate('Show Language Switcher?') }}</label>
                                <div class="col-md-8">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="hidden" name="types[]" value="show_language_switcher">
                                        <input type="checkbox" name="show_language_switcher"
                                            @if (get_business_setting('show_language_switcher') == 'on') checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <!-- Show Currency Switcher -->
                            <div class="form-group row">
                                <label
                                    class="col-md-3 col-from-label">{{ translate('Show Currency Switcher?') }}</label>
                                <div class="col-md-8">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="hidden" name="types[]" value="show_currency_switcher">
                                        <input type="checkbox" name="show_currency_switcher"
                                            @if (get_business_setting('show_currency_switcher') == 'on') checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <!-- Enable stikcy header -->
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Enable stikcy header?') }}</label>
                                <div class="col-md-8">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="hidden" name="types[]" value="header_stikcy">
                                        <input type="checkbox" name="header_stikcy"
                                            @if (get_business_setting('header_stikcy') == 'on') checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="border-top pt-3">
                                <!-- Topbar Banner Large -->
                                <div class="form-group row">
                                    <label
                                        class="col-md-3 col-from-label">{{ translate('Topbar Banner Large') }}</label>
                                    <div class="col-md-8">
                                        <div class=" input-group " data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    {{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="types[]" value="topbar_banner">
                                            <input type="hidden" name="topbar_banner" class="selected-files"
                                                value="{{ get_business_setting('topbar_banner') }}">
                                        </div>
                                        <div class="file-preview"></div>
                                        <small>{{ translate('Will be shown in large device') }}</small>
                                    </div>
                                </div>
                                <!-- Topbar Banner Medium -->
                                <div class="form-group row">
                                    <label
                                        class="col-md-3 col-from-label">{{ translate('Topbar Banner Medium') }}</label>
                                    <div class="col-md-8">
                                        <div class=" input-group " data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    {{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="types[]" value="topbar_banner_medium">
                                            <input type="hidden" name="topbar_banner_medium" class="selected-files"
                                                value="{{ get_business_setting('topbar_banner_medium') }}">
                                        </div>
                                        <div class="file-preview"></div>
                                        <small>{{ translate('Will be shown in medium device') }}</small>
                                    </div>
                                </div>
                                <!-- Topbar Banner Small -->
                                <div class="form-group row">
                                    <label
                                        class="col-md-3 col-from-label">{{ translate('Topbar Banner Small') }}</label>
                                    <div class="col-md-8">
                                        <div class=" input-group " data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    {{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="types[]" value="topbar_banner_small">
                                            <input type="hidden" name="topbar_banner_small" class="selected-files"
                                                value="{{ get_business_setting('topbar_banner_small') }}">
                                        </div>
                                        <div class="file-preview"></div>
                                        <small>{{ translate('Will be shown in small device') }}</small>
                                    </div>
                                </div>
                                <!-- Topbar Banner Link -->
                                <div class="form-group row">
                                    <label
                                        class="col-md-3 col-from-label">{{ translate('Topbar Banner Link') }}</label>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="hidden" name="types[]" value="topbar_banner_link">
                                            <input type="text" class="form-control"
                                                placeholder="{{ translate('Link with') }} http:// {{ translate('or') }} https://"
                                                name="topbar_banner_link"
                                                value="{{ get_business_setting('topbar_banner_link') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Header Nav Menu Text Color -->
                            <div class="form-group row">
                                <label
                                    class="col-md-3 col-from-label mb-md-0">{{ translate('Header Nav Menu Text Color') }}</label>
                                <div class="col-md-8 d-flex">
                                    <input type="hidden" name="types[]" value="header_nav_menu_text">
                                    <div class="radio mar-btm mr-3 d-flex align-items-center">
                                        <input id="header_nav_menu_text_light" class="magic-radio" type="radio"
                                            name="header_nav_menu_text" value="light"
                                            @if (get_business_setting('header_nav_menu_text') == 'light' || get_business_setting('header_nav_menu_text') == null) checked @endif>
                                        <label for="header_nav_menu_text_light"
                                            class="mb-0 ml-2">{{ translate('Light') }}</label>
                                    </div>
                                    <div class="radio mar-btm mr-3 d-flex align-items-center">
                                        <input id="header_nav_menu_text_dark" class="magic-radio" type="radio"
                                            name="header_nav_menu_text" value="dark"
                                            @if (get_business_setting('header_nav_menu_text') == 'dark') checked @endif>
                                        <label for="header_nav_menu_text_dark"
                                            class="mb-0 ml-2">{{ translate('Dark') }}</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Header Nav Menus -->
                            <label class="">{{ translate('Header Nav Menu') }}</label>
                            <div class="header-nav-menu">
                                <input type="hidden" name="types[]" value="header_menu_labels">
                                <input type="hidden" name="types[]" value="header_menu_links">
                                @if (get_business_setting('header_menu_labels') != null)
                                    @foreach (json_decode(get_business_setting('header_menu_labels'), true) as $key => $value)
                                        <div class="row gutters-5">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="{{ translate('Label') }}"
                                                        name="header_menu_labels[]" value="{{ $value }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="{{ translate('Link with') }} http:// {{ translate('or') }} https://"
                                                        name="header_menu_links[]"
                                                        value="{{ json_decode(App\Models\BusinessSetting::where('type', 'header_menu_links')->first()->value, true)[$key] }}">
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
										<input type="text" class="form-control" placeholder="{{ translate('Label') }}" name="header_menu_labels[]">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<input type="text" class="form-control" placeholder="{{ translate('Link with') }} http:// {{ translate('or') }} https://" name="header_menu_links[]">
									</div>
								</div>
								<div class="col-auto">
									<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
										<i class="las la-times"></i>
									</button>
								</div>
							    </div>'
                                data-target=".header-nav-menu">
                                {{ translate('Add New') }}
                            </button>
                        </div>
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
</div>
