<style>
    .show_div {
        padding: 2px 10px;
        margin-left: 10px;
    }

    /* Add SVG icon inside the button using ::before */
    .show_div::before {
        content: "";
        display: inline-block;
        width: 12px;
        height: 8px;
        background-image: url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2250%22%20height%3D%2250%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22M4%208l8%208%208-8%22%20%2F%3E%3C%2Fsvg%3E');
        background-size: cover;
    }

    /* Style for the Hide button */
    .hide_div {
        padding: 2px 10px;
        margin-left: 10px;
    }

    /* Add SVG icon inside the button using ::before */
    .hide_div::before {
        content: "";
        display: inline-block;
        width: 12px;
        height: 8px;
        background-image: url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22M19%2015l-7-7-7%207%22%20%2F%3E%3C%2Fsvg%3E');
        background-size: cover;
    }
</style>

<div class="page-content">
    <div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem border-bottom border-gray">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">{{ translate('Homepage Settings (Classic)') }}</h1>
            </div>
            {{-- <div class="col text-right">
					<a class="btn has-transition btn-xs p-0 hov-svg-danger" href="{{ route('home') }}" 
						target="_blank" data-toggle="tooltip" data-placement="top" data-title="{{ translate('View Tutorial Video') }}">
						<svg xmlns="http://www.w3.org/2000/svg" width="19.887" height="16" viewBox="0 0 19.887 16">
							<path id="_42fbab5a39cb8436403668a76e5a774b" data-name="42fbab5a39cb8436403668a76e5a774b" d="M18.723,8H5.5A3.333,3.333,0,0,0,2.17,11.333v9.333A3.333,3.333,0,0,0,5.5,24h13.22a3.333,3.333,0,0,0,3.333-3.333V11.333A3.333,3.333,0,0,0,18.723,8Zm-3.04,8.88-5.47,2.933a1,1,0,0,1-1.473-.88V13.067a1,1,0,0,1,1.473-.88l5.47,2.933a1,1,0,0,1,0,1.76Zm-5.61-3.257L14.5,16l-4.43,2.377Z" transform="translate(-2.17 -8)" fill="#9da3ae"/>
						</svg>
					</a>
				</div> --}}
        </div>
    </div>
</div>

@php
    $sectionOrder = get_business_setting('homepage_section_order');

    $sections = [
        'marquee',
        'fourElements',
        'flashSale',
        'todaysSale',
        'featuredCategory',
        'banner',
        'bestSelling',
        'newProducts',
        'homeCategory',
        'brand',
    ];

    if ($sectionOrder) {
        $sections = json_decode($sectionOrder, true);
    }
@endphp

<!-- Language Bar -->
<ul class="nav nav-tabs nav-fill border-light language-bar">
    @foreach (get_all_active_language() as $key => $language)
        <li class="nav-item">
            <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                href="{{ route('website-setup', ['lang' => $language->code]) }}">
                <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}" height="11"
                    class="mr-1">
                <span>{{ $language->name }}</span>
            </a>
        </li>
    @endforeach
</ul>

<!-- Category Slider Section -->
<div class="border p-2 align-items-center mt-2" id="category_slider_section">
    <div class="d-flex justify-content-between">
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <h3 class="mb-0 h6 text-center ml-2 text-center ml-2">
                    {{ translate('Show Categories and Sliders') }}</h3>
            </div>

            <button data-div="sliders_div" class="div_toggle_btn btn btn-soft-blue btn-sm show_div"></button>

        </div>
        <label class="aiz-switch aiz-switch-success mb-0">
            <input type="checkbox" onchange="updateSettings(this, 'show_categories_sliders')"
                onclick="checkCategoryStatus(this)"
                {{ get_business_setting('show_categories_sliders') == 1 ? 'checked' : '' }}>
            <span class="slider round"></span>
        </label>
    </div>


    <div id="full_slider_div"
        class="{{ get_business_setting('show_categories_sliders') ? 'd-flex justify-content-between align-items-center' : 'd-none' }} ">
        <div class="d-flex align-items-center">
            <h3 class="mb-0 h6 text-center ml-2 text-center ml-2">{{ translate('Show Full Sliders') }}</h3>
        </div>
        <label class="aiz-switch aiz-switch-success mb-0">
            <input type="checkbox" onchange="updateSettings(this, 'show_full_sliders')"
                {{ get_business_setting('show_full_sliders') == 1 ? 'checked' : '' }}>
            <span class="slider round"></span>
        </label>
    </div>
</div>

<div id="sliders_div" class="d-none border">
    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tab" value="home_slider">
        <input type="hidden" name="types[][{{ $lang }}]" value="home_slider_images">
        <input type="hidden" name="types[][{{ $lang }}]" value="home_slider_links">

        <div class="bg-white p-3 p-sm-2rem">
            <div class="w-100">
                <!-- Information -->
                <div class="fs-11 d-flex mb-2rem">
                    <div>
                        <svg id="_79508b4b8c932dcad9066e2be4ca34f2" data-name="79508b4b8c932dcad9066e2be4ca34f2"
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <path id="Path_40683" data-name="Path 40683"
                                d="M8,16a8,8,0,1,1,8-8A8.024,8.024,0,0,1,8,16ZM8,1.333A6.667,6.667,0,1,0,14.667,8,6.686,6.686,0,0,0,8,1.333Z"
                                fill="#9da3ae" />
                            <path id="Path_40684" data-name="Path 40684"
                                d="M10.6,15a.926.926,0,0,1-.667-.333c-.333-.467-.067-1.133.667-2.933.133-.267.267-.6.4-.867a.714.714,0,0,1-.933-.067.644.644,0,0,1,0-.933A3.408,3.408,0,0,1,11.929,9a.926.926,0,0,1,.667.333c.333.467.067,1.133-.667,2.933-.133.267-.267.6-.4.867a.714.714,0,0,1,.933.067.644.644,0,0,1,0,.933A3.408,3.408,0,0,1,10.6,15Z"
                                transform="translate(-3.262 -3)" fill="#9da3ae" />
                            <circle id="Ellipse_813" data-name="Ellipse 813" cx="1" cy="1" r="1"
                                transform="translate(8 3.333)" fill="#9da3ae" />
                            <path id="Path_40685" data-name="Path 40685"
                                d="M12.833,7.167a1.333,1.333,0,1,1,1.333-1.333A1.337,1.337,0,0,1,12.833,7.167Zm0-2a.63.63,0,0,0-.667.667.667.667,0,1,0,1.333,0A.63.63,0,0,0,12.833,5.167Z"
                                transform="translate(-3.833 -1.5)" fill="#9da3ae" />
                        </svg>
                    </div>
                    <div class="ml-2 text-gray">
                        <div class="mb-2">
                            {{ translate('Width 1100px and Height 320px for side categories with banner, or Width 1370px and Height 320px for full banner.') }}
                        </div>
                        <div>
                            {{ translate('Only jpg, png, gif and webp with maximum 1MB file Size') }}
                        </div>
                    </div>
                </div>

                <!-- Images & links -->
                <div class="home-slider-target">
                    @php
                        $home_slider_images = get_business_setting('home_slider_images', null, $lang);
                        $home_slider_links = get_business_setting('home_slider_links', null, $lang);
                    @endphp
                    @if ($home_slider_images != null)
                        @foreach (json_decode($home_slider_images, true) as $key => $value)
                            <div class="p-3 p-md-4 mb-3 mb-md-2rem remove-parent" style="border: 1px dashed #e4e5eb;">
                                <div class="row gutters-5">
                                    <!-- Image -->
                                    <div class="col-md-5">
                                        <div class="form-group mb-md-0">
                                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">
                                                    {{ translate('Choose File') }}</div>
                                                <input type="hidden" name="home_slider_images[]" class="selected-files"
                                                    value="{{ json_decode($home_slider_images, true)[$key] }}">
                                            </div>
                                            <div class="file-preview box sm">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- link -->
                                    <div class="col-md">
                                        <div class="form-group mb-md-0">
                                            <input type="text" class="form-control" placeholder="http://"
                                                name="home_slider_links[]"
                                                value="{{ isset(json_decode($home_slider_links, true)[$key]) ? json_decode($home_slider_links, true)[$key] : '' }}">
                                        </div>
                                    </div>
                                    <!-- remove parent button -->
                                    <div class="col-md-auto">
                                        <div class="form-group mb-md-0">
                                            <button type="button"
                                                class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"
                                                data-toggle="remove-parent" data-parent=".remove-parent">
                                                <i class="las la-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Add button -->
                <div class="">
                    <button type="button"
                        class="btn btn-block border hov-bg-soft-secondary fs-14 rounded-0 d-flex align-items-center justify-content-center"
                        style="background: #fcfcfc;" data-toggle="add-more"
                        data-content='
											<div class="p-3 p-md-4 mb-3 mb-md-2rem remove-parent" style="border: 1px dashed #e4e5eb;">
												<div class="row gutters-5">
													<!-- Image -->
													<div class="col-md-5">
														<div class="form-group mb-md-0">
															<div class="input-group" data-toggle="aizuploader" data-type="image">
																<div class="input-group-prepend">
																	<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
																</div>
																<div class="form-control file-amount">{{ translate('Choose File') }}</div>
																<input type="hidden" name="home_slider_images[]" class="selected-files" value="">
															</div>
															<div class="file-preview box sm">
															</div>
														</div>
													</div>
													<!-- link -->
													<div class="col-md">
														<div class="form-group mb-md-0">
															<input type="text" class="form-control" placeholder="http://" name="home_slider_links[]" value="">
														</div>
													</div>
													<!-- remove parent button -->
													<div class="col-md-auto">
														<div class="form-group mb-md-0">
															<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".remove-parent">
																<i class="las la-times"></i>
															</button>
														</div>
													</div>
												</div>
											</div>'
                        data-target=".home-slider-target">
                        <i class="las la-2x text-success la-plus-circle"></i>
                        <span class="ml-2">{{ translate('Add New') }}</span>
                    </button>
                </div>
            </div>
            <!-- Save Button -->
            <div class="mt-4 text-right">
                <button type="submit"
                    class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Save') }}</button>
            </div>
        </div>
    </form>
</div>

<div id="sortable-sections" class="mt-2">
    @foreach ($sections as $section)
        @if ($section == 'marquee')
            <!-- Scrolling Text Section -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="marquee"
                style="cursor: grab;">
                <div class="d-flex justify-content-between ">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16">
                                <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                                    <rect id="Rectangle_18283" data-name="Rectangle_18283" width="2"
                                        height="7" rx="1" fill="#9da3ae"></rect>
                                    <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2"
                                        height="11" rx="1" transform="translate(14)" fill="#9da3ae">
                                    </rect>
                                    <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2"
                                        height="16" rx="1" transform="translate(7)" fill="#9da3ae">
                                    </rect>
                                </g>
                            </svg>
                            <h3 class="mb-0 h6 text-center ml-2 text-center ml-2">
                                {{ translate('Show Scrolling Text') }}
                            </h3>
                        </div>

                        <button data-div="scrolling_text_div"
                            class="div_toggle_btn btn btn-soft-blue btn-sm show_div"></button>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_scrolling_text')"
                            onclick="checkScrollTextStatus(this)"
                            {{ get_business_setting('show_scrolling_text') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div id="scrolling_text_div" class="d-none">
                    <form action="{{ route('business_settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="types[]" value="scrolling_text">
                        <div class="d-flex justify-content-between p-2">
                            <input type="text" class="form-control mr-5"
                                placeholder="{{ translate('scrolling_text') }}" name="scrolling_text"
                                value="{{ base64_decode(get_business_setting('scrolling_text')) ??
                                    '🎉 Enjoy up to 50% off on our Summer Collection! Limited time only! 🎉 | 🚚 Get free shipping on all orders over $50! Shop now and save! 🚚' }}">
                            <button type="submit"
                                class="btn btn-sm btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($section == 'fourElements')
            <!-- Show 4 Element -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="fourElements"
                style="cursor: grab;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16">
                                <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                                    <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2"
                                        height="7" rx="1" fill="#9da3ae"></rect>
                                    <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2"
                                        height="11" rx="1" transform="translate(14)" fill="#9da3ae">
                                    </rect>
                                    <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2"
                                        height="16" rx="1" transform="translate(7)" fill="#9da3ae">
                                    </rect>
                                </g>
                            </svg>
                            <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show 4 Element') }}</h3>
                        </div>

                        <button data-div="four_element_div"
                            class="div_toggle_btn btn btn-soft-blue btn-sm show_div"></button>
                    </div>

                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_4element')"
                            {{ get_business_setting('show_4element') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div id="four_element_div" class="d-none">
                    <form action="{{ route('business_settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="tab" value="four_elements">
                        <input type="hidden" name="types[]" value="four_elements">
                        <div class="bg-white p-3 p-sm-2rem">
                            @php
                                $four_elements = json_decode(get_business_setting('four_elements'));
                            @endphp

                            <!-- Element 1 -->
                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <h3>Element No. 1</h3>
                                </div>
                                <!-- Icon Class -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label class="col-from-label fs-13 fw-500">
                                            <a href="https://www.svgviewer.dev" target="_blank">Select SVG File</a>
                                            (e.g.
                                            <code>&lt;svg xmlns="" .... &lt;/svg&gt;</code>)
                                        </label>
                                        <input type="text" class="form-control" placeholder="SVG File Code"
                                            name="four_elements[]"
                                            value="{{ isset($four_elements[0]) ? $four_elements[0] : '' }}">
                                    </div>
                                </div>

                                <!-- Icon color -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Icon color') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control aiz-color-input"
                                                placeholder="#000000" name="four_elements[]"
                                                value="{{ isset($four_elements[1]) ? $four_elements[1] : '' }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text p-0">
                                                    <input class="aiz-color-picker border-0 size-30px" type="color"
                                                        value="{{ isset($four_elements[1]) ? $four_elements[1] : '#000000' }}">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Header Text -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Header Text') }}</label>
                                        <input type="text" class="form-control" placeholder="Title"
                                            name="four_elements[]"
                                            value="{{ isset($four_elements[2]) ? $four_elements[2] : '' }}">
                                    </div>
                                </div>

                                <!-- Normal Text -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Normal Text') }}</label>
                                        <input type="text" class="form-control" placeholder="Text"
                                            name="four_elements[]"
                                            value="{{ isset($four_elements[3]) ? $four_elements[3] : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Element 2 -->
                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <h3>Element No. 2</h3>
                                </div>

                                <!-- Icon Class -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label class="col-from-label fs-13 fw-500">
                                            <a href="https://www.svgviewer.dev" target="_blank">Select SVG File</a>
                                            (e.g.
                                            <code>&lt;svg xmlns="" .... &lt;/svg&gt;</code>)
                                        </label>
                                        <input type="text" class="form-control" placeholder="SVG File Code"
                                            name="four_elements[]"
                                            value="{{ isset($four_elements[4]) ? $four_elements[4] : '' }}">
                                    </div>
                                </div>

                                <!-- Icon color -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Icon color') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control aiz-color-input"
                                                placeholder="#000000" name="four_elements[]"
                                                value="{{ isset($four_elements[5]) ? $four_elements[5] : '' }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text p-0">
                                                    <input class="aiz-color-picker border-0 size-30px" type="color"
                                                        value="{{ isset($four_elements[5]) ? $four_elements[5] : '#000000' }}">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Header Text -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Header Text') }}</label>
                                        <input type="text" class="form-control" placeholder="Title"
                                            name="four_elements[]"
                                            value="{{ isset($four_elements[6]) ? $four_elements[6] : '' }}">
                                    </div>
                                </div>

                                <!-- Normal Text -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Normal Text') }}</label>
                                        <input type="text" class="form-control" placeholder="Text"
                                            name="four_elements[]"
                                            value="{{ isset($four_elements[7]) ? $four_elements[7] : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Element 3 -->
                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <h3>Element No. 3</h3>
                                </div>
                                <!-- Icon Class -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label class="col-from-label fs-13 fw-500">
                                            <a href="https://www.svgviewer.dev" target="_blank">Select SVG File</a>
                                            (e.g.
                                            <code>&lt;svg xmlns="" .... &lt;/svg&gt;</code>)
                                        </label>
                                        <input type="text" class="form-control" placeholder="SVG File Code"
                                            name="four_elements[]"
                                            value="{{ isset($four_elements[8]) ? $four_elements[8] : '' }}">
                                    </div>
                                </div>

                                <!-- Icon color -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Icon color') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control aiz-color-input"
                                                placeholder="#000000" name="four_elements[]"
                                                value="{{ isset($four_elements[9]) ? $four_elements[9] : '' }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text p-0">
                                                    <input class="aiz-color-picker border-0 size-30px" type="color"
                                                        value="{{ isset($four_elements[9]) ? $four_elements[9] : '#000000' }}">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Header Text -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Header Text') }}</label>
                                        <input type="text" class="form-control" placeholder="Title"
                                            name="four_elements[]"
                                            value="{{ isset($four_elements[10]) ? $four_elements[10] : '' }}">
                                    </div>
                                </div>

                                <!-- Normal Text -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Normal Text') }}</label>
                                        <input type="text" class="form-control" placeholder="Text"
                                            name="four_elements[]"
                                            value="{{ isset($four_elements[11]) ? $four_elements[11] : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Element 4 -->
                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <h3>Element No. 4</h3>
                                </div>
                                <!-- Icon Class -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label class="col-from-label fs-13 fw-500">
                                            <a href="https://www.svgviewer.dev" target="_blank">Select SVG File</a>
                                            (e.g.
                                            <code>&lt;svg xmlns="" .... &lt;/svg&gt;</code>)
                                        </label>
                                        <input type="text" class="form-control" placeholder="SVG File Code"
                                            name="four_elements[]"value="{{ isset($four_elements[12]) ? $four_elements[12] : '' }}">
                                    </div>
                                </div>

                                <!-- Icon color -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Icon color') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control aiz-color-input"
                                                placeholder="#000000"
                                                name="four_elements[]"value="{{ isset($four_elements[13]) ? $four_elements[13] : '' }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text p-0">
                                                    <input class="aiz-color-picker border-0 size-30px" type="color"
                                                        value="{{ isset($four_elements[13]) ? $four_elements[13] : '#000000' }}">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Header Text -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Header Text') }}</label>
                                        <input type="text" class="form-control" placeholder="Title"
                                            name="four_elements[]"value="{{ isset($four_elements[14]) ? $four_elements[14] : '' }}">
                                    </div>
                                </div>

                                <!-- Normal Text -->
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Normal Text') }}</label>
                                        <input type="text" class="form-control" placeholder="Text"
                                            name="four_elements[]"value="{{ isset($four_elements[15]) ? $four_elements[15] : '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="mt-4 text-right">
                                <button type="submit"
                                    class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($section == 'flashSale')
            <!-- Show Flash Deal -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="flashSale"
                style="cursor: grab;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16">
                                <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                                    <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2"
                                        height="7" rx="1" fill="#9da3ae"></rect>
                                    <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2"
                                        height="11" rx="1" transform="translate(14)" fill="#9da3ae">
                                    </rect>
                                    <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2"
                                        height="16" rx="1" transform="translate(7)" fill="#9da3ae">
                                    </rect>
                                </g>
                            </svg>
                            <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Flash Deal') }}</h3>
                        </div>

                        <a class="btn btn-soft-blue btn-sm ml-3" href="{{ route('flash_deals.index') }}"
                            target="_blank">Flash Deals</a>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_flash_deal')"
                            {{ get_business_setting('show_flash_deal') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        @elseif($section == 'todaysSale')
            <!-- Show Today's Deal -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="todaysSale"
                style="cursor: grab;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16">
                                <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                                    <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2"
                                        height="7" rx="1" fill="#9da3ae"></rect>
                                    <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2"
                                        height="11" rx="1" transform="translate(14)" fill="#9da3ae">
                                    </rect>
                                    <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2"
                                        height="16" rx="1" transform="translate(7)" fill="#9da3ae">
                                    </rect>
                                </g>
                            </svg>
                            <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Todays Deal') }}</h3>
                        </div>

                        <button data-div="todays_deal_div"
                            class="div_toggle_btn btn btn-soft-blue btn-sm show_div"></button>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_todays_deal')"
                            {{ get_business_setting('show_todays_deal') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div id="todays_deal_div" class="d-none">
                    <form action="{{ route('business_settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tab" value="todays_deal">
                        <div class="bg-white p-3 p-sm-2rem">
                            <div class="row">
                                <!-- Large Banner -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-from-label fs-13 fw-500">{{ translate('Large Banner') }}
                                            (<small>{{ translate('Will be shown in large device') }}</small>)</label>
                                        <div class="input-group " data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary">
                                                    {{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="todays_deal_banner">
                                            <input type="hidden" name="todays_deal_banner"
                                                value="{{ get_business_setting('todays_deal_banner', null, $lang) }}"
                                                class="selected-files">
                                        </div>
                                        <div class="file-preview box"></div>
                                    </div>
                                </div>
                                <!-- Small Banner -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-from-label fs-13 fw-500">{{ translate('Small Banner') }}
                                            (<small>{{ translate('Will be shown in small device') }}</small>)</label>
                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary">
                                                    {{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="todays_deal_banner_small">
                                            <input type="hidden" name="todays_deal_banner_small"
                                                value="{{ get_business_setting('todays_deal_banner_small', null, $lang) }}"
                                                class="selected-files">
                                        </div>
                                        <div class="file-preview box"></div>
                                    </div>
                                </div>
                                <!-- Products background color -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate('Products background color') }}</label>
                                        <div class="input-group">
                                            @php $todays_deal_bg_color = get_business_setting('todays_deal_bg_color'); @endphp
                                            <input type="hidden" name="types[]" value="todays_deal_bg_color">
                                            <input type="text" class="form-control aiz-color-input"
                                                placeholder="#000000" name="todays_deal_bg_color"
                                                value="{{ $todays_deal_bg_color }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text p-0">
                                                    <input class="aiz-color-picker border-0 size-40px" type="color"
                                                        value="{{ $todays_deal_bg_color }}">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Banner Text Color -->
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label
                                            class="col-from-label fs-13 fw-500">{{ translate("Today's Deal Banner Text Color") }}</label>
                                        <div class="input-group d-flex">
                                            @php
                                                $todays_deal_banner_text_color = get_business_setting(
                                                    'todays_deal_banner_text_color',
                                                );
                                            @endphp
                                            <input type="hidden" name="types[]"
                                                value="todays_deal_banner_text_color">
                                            <div class="radio mar-btm mr-3 d-flex align-items-center">
                                                <input id="todays_deal_banner_text_light" class="magic-radio"
                                                    type="radio" name="todays_deal_banner_text_color"
                                                    value="light" @if ($todays_deal_banner_text_color == 'light' || $todays_deal_banner_text_color == null) checked @endif>
                                                <label for="todays_deal_banner_text_light"
                                                    class="mb-0 ml-2">{{ translate('Light') }}</label>
                                            </div>
                                            <div class="radio mar-btm mr-3 d-flex align-items-center">
                                                <input id="todays_deal_banner_text_dark" class="magic-radio"
                                                    type="radio" name="todays_deal_banner_text_color"
                                                    value="dark" @if ($todays_deal_banner_text_color == 'dark') checked @endif>
                                                <label for="todays_deal_banner_text_dark"
                                                    class="mb-0 ml-2">{{ translate('Dark') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Save Button -->
                            <div class="mt-4 text-right">
                                <button type="submit"
                                    class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($section == 'featuredCategory')
            <!-- Show Featured Categories -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="featuredCategory"
                style="cursor: grab;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16">
                                <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                                    <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2"
                                        height="7" rx="1" fill="#9da3ae"></rect>
                                    <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2"
                                        height="11" rx="1" transform="translate(14)" fill="#9da3ae">
                                    </rect>
                                    <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2"
                                        height="16" rx="1" transform="translate(7)" fill="#9da3ae">
                                    </rect>
                                </g>
                            </svg>
                            <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Featured Categories') }}</h3>
                        </div>

                        <form id="featured_category_count_form" class="form-horizontal ml-3"
                            action="{{ route('business_settings.update') }}" method="POST">
                            @csrf
                            <div class="form-group row mb-0">
                                <input type="hidden" name="types[]" value="featured_category_count">
                                <div class="input-group mx-2">
                                    <select name="featured_category_count" id="featured_category_count"
                                        class="form-control py-1">
                                        <option value="8"
                                            {{ get_business_setting('featured_category_count') == '8' ? 'selected' : '' }}>
                                            8
                                        </option>
                                        <option value="6"
                                            {{ get_business_setting('featured_category_count') == '6' ? 'selected' : '' }}>
                                            6
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_featured_categories')"
                            {{ get_business_setting('show_featured_categories') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>

                </div>
            </div>
        @elseif($section == 'banner')
            <!-- Show Home Banner1 Images -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="banner"
                style="cursor: grab;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16">
                                <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                                    <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2"
                                        height="7" rx="1" fill="#9da3ae"></rect>
                                    <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2"
                                        height="11" rx="1" transform="translate(14)" fill="#9da3ae">
                                    </rect>
                                    <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2"
                                        height="16" rx="1" transform="translate(7)" fill="#9da3ae">
                                    </rect>
                                </g>
                            </svg>
                            <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Home Banner Images') }}</h3>
                        </div>

                        <button data-div="home_banner_div"
                            class="div_toggle_btn btn btn-soft-blue btn-sm show_div"></button>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_home_banner1_images')"
                            {{ get_business_setting('show_home_banner1_images') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div id="home_banner_div" class="d-none">
                    <form action="{{ route('business_settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tab" value="banner_1">
                        <input type="hidden" name="types[][{{ $lang }}]" value="home_banner1_images">
                        <input type="hidden" name="types[][{{ $lang }}]" value="home_banner1_links">

                        <div class="bg-white p-3 p-sm-2rem">
                            <div class="w-100">
                                <label
                                    class="col-from-label fs-13 fw-500 mb-3">{{ translate('Banner & Links (Max 3)') }}</label>

                                <!-- Images & links -->
                                <div class="home-banner1-target">
                                    @php
                                        $home_banner1_images = get_business_setting('home_banner1_images', null, $lang);
                                        $home_banner1_links = get_business_setting('home_banner1_links', null, $lang);
                                    @endphp
                                    @if ($home_banner1_images != null)
                                        @foreach (json_decode($home_banner1_images, true) as $key => $value)
                                            <div class="p-3 p-md-4 mb-3 mb-md-2rem remove-parent"
                                                style="border: 1px dashed #e4e5eb;">
                                                <div class="row gutters-5">
                                                    <!-- Image -->
                                                    <div class="col-md-5">
                                                        <div class="form-group mb-md-0">
                                                            <div class="input-group" data-toggle="aizuploader"
                                                                data-type="image">
                                                                <div class="input-group-prepend">
                                                                    <div
                                                                        class="input-group-text bg-soft-secondary font-weight-medium">
                                                                        {{ translate('Browse') }}</div>
                                                                </div>
                                                                <div class="form-control file-amount">
                                                                    {{ translate('Choose File') }}</div>
                                                                <input type="hidden" name="home_banner1_images[]"
                                                                    class="selected-files"
                                                                    value="{{ json_decode($home_banner1_images, true)[$key] }}">
                                                            </div>
                                                            <div class="file-preview box sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- link -->
                                                    <div class="col-md">
                                                        <div class="form-group mb-md-0">
                                                            <input type="text" class="form-control"
                                                                placeholder="http://" name="home_banner1_links[]"
                                                                value="{{ isset(json_decode($home_banner1_links, true)[$key]) ? json_decode($home_banner1_links, true)[$key] : '' }}">
                                                        </div>
                                                    </div>
                                                    <!-- remove parent button -->
                                                    <div class="col-md-auto">
                                                        <div class="form-group mb-md-0">
                                                            <button type="button"
                                                                class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"
                                                                data-toggle="remove-parent"
                                                                data-parent=".remove-parent">
                                                                <i class="las la-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Add button -->
                                <div class="">
                                    <button type="button"
                                        class="btn btn-block border hov-bg-soft-secondary fs-14 rounded-0 d-flex align-items-center justify-content-center"
                                        style="background: #fcfcfc;" data-toggle="add-more"
                                        data-content='
                                        <div class="p-3 p-md-4 mb-3 mb-md-2rem remove-parent" style="border: 1px dashed #e4e5eb;">
                                            <div class="row gutters-5">
                                                <!-- Image -->
                                                <div class="col-md-5">
                                                    <div class="form-group mb-md-0">
                                                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                                            </div>
                                                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                                            <input type="hidden" name="home_banner1_images[]" class="selected-files" value="">
                                                        </div>
                                                        <div class="file-preview box sm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- link -->
                                                <div class="col-md">
                                                    <div class="form-group mb-md-0 mb-0">
                                                        <input type="text" class="form-control" placeholder="http://" name="home_banner1_links[]" value="">
                                                    </div>
                                                </div>
                                                <!-- remove parent button -->
                                                <div class="col-md-auto">
                                                    <div class="form-group mb-md-0">
                                                        <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".remove-parent">
                                                            <i class="las la-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>'
                                        data-target=".home-banner1-target">
                                        <i class="las la-2x text-success la-plus-circle"></i>
                                        <span class="ml-2">{{ translate('Add New') }}</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Save Button -->
                            <div class="mt-4 text-right">
                                <button type="submit"
                                    class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- <!-- Show Home Banner2 Images -->
    <div class="draggable-section mt-2 border-dotted p-2 align-items-center" style="cursor: grab;">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                        <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2" height="7"
                            rx="1" fill="#9da3ae"></rect>
                        <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2" height="11"
                            rx="1" transform="translate(14)" fill="#9da3ae"></rect>
                        <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2" height="16"
                            rx="1" transform="translate(7)" fill="#9da3ae"></rect>
                    </g>
                </svg>
                <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Home Banner2 Images') }}</h3>
            </div>
            <label class="aiz-switch aiz-switch-success mb-0">
                <input type="checkbox" onchange="updateSettings(this, 'show_home_banner2_images')"
                    {{ get_business_setting('show_home_banner2_images') == 1 ? 'checked' : '' }}>
                <span class="slider round"></span>
            </label>
        </div>
    </div>


    <!-- Show Home Banner3 Images -->
    <div class="draggable-section mt-2 border-dotted p-2 align-items-center" style="cursor: grab;">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                        <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2" height="7"
                            rx="1" fill="#9da3ae"></rect>
                        <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2" height="11"
                            rx="1" transform="translate(14)" fill="#9da3ae"></rect>
                        <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2" height="16"
                            rx="1" transform="translate(7)" fill="#9da3ae"></rect>
                    </g>
                </svg>
                <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Home Banner3 Images') }}</h3>
            </div>
            <label class="aiz-switch aiz-switch-success mb-0">
                <input type="checkbox" onchange="updateSettings(this, 'show_home_banner3_images')"
                    {{ get_business_setting('show_home_banner3_images') == 1 ? 'checked' : '' }}>
                <span class="slider round"></span>
            </label>
        </div>
    </div> --}}
        @elseif($section == 'bestSelling')
            <!-- Show Best Selling -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="bestSelling"
                style="cursor: grab;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16">
                                <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                                    <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2"
                                        height="7" rx="1" fill="#9da3ae"></rect>
                                    <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2"
                                        height="11" rx="1" transform="translate(14)" fill="#9da3ae">
                                    </rect>
                                    <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2"
                                        height="16" rx="1" transform="translate(7)" fill="#9da3ae">
                                    </rect>
                                </g>
                            </svg>
                            <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Best Selling') }}</h3>
                        </div>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_best_selling')"
                            {{ get_business_setting('show_best_selling') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        @elseif($section == 'newProducts')
            <!-- Show New Products -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="newProducts"
                style="cursor: grab;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                                <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2" height="7"
                                    rx="1" fill="#9da3ae"></rect>
                                <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2" height="11"
                                    rx="1" transform="translate(14)" fill="#9da3ae"></rect>
                                <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2" height="16"
                                    rx="1" transform="translate(7)" fill="#9da3ae"></rect>
                            </g>
                        </svg>
                        <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show New Products') }}</h3>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_new_products')"
                            {{ get_business_setting('show_new_products') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        @elseif($section == 'homeCategory')
            <!-- Show Home Categories -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="homeCategory"
                style="cursor: grab;">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 16 16">
                                <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                                    <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2"
                                        height="7" rx="1" fill="#9da3ae"></rect>
                                    <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2"
                                        height="11" rx="1" transform="translate(14)" fill="#9da3ae">
                                    </rect>
                                    <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2"
                                        height="16" rx="1" transform="translate(7)" fill="#9da3ae">
                                    </rect>
                                </g>
                            </svg>
                            <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Home Categories') }}</h3>
                        </div>

                        <button data-div="home_category_div"
                            class="div_toggle_btn btn btn-soft-blue btn-sm show_div"></button>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_home_categories')"
                            {{ get_business_setting('show_home_categories') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div id="home_category_div" class="d-none">
                    <form action="{{ route('business_settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tab" value="home_categories">
                        <div class="bg-white p-3 p-sm-2rem">
                            <div class="w-100">
                                <label class="col-from-label fs-13 fw-500 mb-3">{{ translate('Categories') }}</label>
                                <div class="home-categories-target">
                                    <input type="hidden" name="types[]" value="home_categories">
                                    @php $home_categories = get_business_setting('home_categories'); @endphp
                                    @if ($home_categories != null)
                                        @php $categories = \App\Models\Category::where('parent_id', 0)->with('childrenCategories')->get(); @endphp
                                        @foreach (json_decode($home_categories, true) as $key => $value)
                                            <div class="p-3 p-md-4 mb-3 mb-md-2rem remove-parent"
                                                style="border: 1px dashed #e4e5eb;">
                                                <div class="row gutters-5">
                                                    <div class="col">
                                                        <div class="form-group mb-0">
                                                            <select class="form-control aiz-selectpicker"
                                                                name="home_categories[]" data-live-search="true"
                                                                data-selected={{ $value }} required>
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}">
                                                                        {{ $category->getTranslation('name') }}
                                                                    </option>
                                                                    @foreach ($category->childrenCategories as $childCategory)
                                                                        @include(
                                                                            'categories.child_category',
                                                                            [
                                                                                'child_category' => $childCategory,
                                                                            ]
                                                                        )
                                                                    @endforeach
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button"
                                                            class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"
                                                            data-toggle="remove-parent" data-parent=".remove-parent">
                                                            <i class="las la-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Add button -->
                                <div class="">
                                    <button type="button"
                                        class="btn btn-block border hov-bg-soft-secondary fs-14 rounded-0 d-flex align-items-center justify-content-center"
                                        style="background: #fcfcfc;" data-toggle="add-more"
                                        data-content='
											<div class="p-4 mb-3 mb-md-2rem remove-parent" style="border: 1px dashed #e4e5eb;">
												<div class="row gutters-5">
													<div class="col">
														<div class="form-group mb-0">
															<select class="form-control aiz-selectpicker" name="home_categories[]" data-live-search="true" required>
																@foreach (\App\Models\Category::where('parent_id',
                                        0)->with('childrenCategories')->get() as $category)
                                        <option value="{{ $category->id }}">{{ $category->getTranslation('name') }}
                                        </option>
                                        @foreach ($category->childrenCategories as $childCategory)
                                            @include('categories.child_category', [
                                                'child_category' => $childCategory,
                                            ])
                                        @endforeach
        @endforeach
        </select>
</div>
</div>
<div class="col-auto">
    <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent"
        data-parent=".remove-parent">
        <i class="las la-times"></i>
    </button>
</div>
</div>
</div>' data-target=".home-categories-target">
<i class="las la-2x text-success la-plus-circle"></i>
<span class="ml-2">{{ translate('Add New') }}</span>
</button>
</div>
</div>
<!-- Save Button -->
<div class="mt-4 text-right">
    <button type="submit"
        class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Save') }}</button>
</div>
</div>
</form>
</div>
</div>
@elseif($section == 'brand')
<!-- Show Brands -->
<div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="brand" style="cursor: grab;">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                        <rect id="Rectangle_18283" data-name="Rectangle 18283" width="2" height="7"
                            rx="1" fill="#9da3ae"></rect>
                        <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2" height="11"
                            rx="1" transform="translate(14)" fill="#9da3ae"></rect>
                        <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2" height="16"
                            rx="1" transform="translate(7)" fill="#9da3ae"></rect>
                    </g>
                </svg>
                <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Brands') }}</h3>
            </div>

            <form id="brand_count_form" class="form-horizontal ml-3"
                action="{{ route('business_settings.update') }}" method="POST">
                @csrf
                <div class="form-group row mb-0">
                    <input type="hidden" name="types[]" value="brand_count">
                    <div class="input-group mx-2">
                        <select name="brand_count" id="brand_count" class="form-control py-1">
                            <option value="8"
                                {{ get_business_setting('brand_count') == '8' ? 'selected' : '' }}>
                                8
                            </option>
                            <option value="6"
                                {{ get_business_setting('brand_count') == '6' ? 'selected' : '' }}>
                                6
                            </option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <label class="aiz-switch aiz-switch-success mb-0">
            <input type="checkbox" onchange="updateSettings(this, 'show_brands')"
                {{ get_business_setting('show_brands') == 1 ? 'checked' : '' }}>
            <span class="slider round"></span>
        </label>
    </div>
</div>

<div class="d-flex justify-content-end my-3">
    {{-- <button class="btn btn-success btn-sm">Update</button> --}}
</div>
@endif
@endforeach
</div>


<script type="text/javascript">
    $(document).ready(function() {
        AIZ.plugins.bootstrapSelect('refresh');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Sortable.js on the container
        new Sortable(document.getElementById('sortable-sections'), {
            animation: 150,
            handle: '.draggable-section',
            ghostClass: 'dragging',
            onEnd: function(evt) {
                // Callback to handle the order change
                const orderedIds = Array.from(evt.from.children).map((el) => el.id);
                console.log("New Order: ", orderedIds);

                fetch(`{{ route('homepage_order.update') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        order: orderedIds
                    }),
                }).then(response => response.json()).then(data => {
                    if (data.success) {
                        AIZ.plugins.notify('success',
                            '{{ translate('Homepage Section Order updated successfully') }}'
                        );
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var hash = document.location.hash;
        if (hash) {
            $('.nav-tabs a[href="' + hash + '"]').tab('show');
        } else {
            $('.nav-tabs a[href="#home_slider"]').tab('show');
        }

        // Change hash for page-reload
        $('.nav-tabs a').on('shown.bs.tab', function(e) {
            window.location.hash = e.target.hash;
        });

        $('#brand_count').change(function() {
            handleFormSubmission('#brand_count_form');
        });

        $('#featured_category_count').change(function() {
            handleFormSubmission('#featured_category_count_form');
        });
    });

    function handleFormSubmission(formId) {
        var formData = $(formId).serialize();

        $.ajax({
            url: $(formId).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
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

    function checkCategoryStatus(checkbox) {
        if (checkbox.checked) {
            $('#full_slider_div').removeClass('d-none').addClass('d-flex justify-content-between align-items-center');
        } else {
            $('#full_slider_div').addClass('d-none').removeClass('d-flex justify-content-between align-items-center');
        }
    }

    function checkScrollTextStatus(checkbox) {
        if (checkbox.checked) {
            $('#scroll_text_div').removeClass('d-none').addClass('d-block');
        } else {
            $('#scroll_text_div').addClass('d-none').removeClass('d-block');
        }
    }
</script>
