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

<div id="sortable-sections" class="mt-2">
    @foreach ($sections as $section)
        @if ($section == 'marquee')
            <!-- Scrolling Text Section -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="marquee" style="cursor: grab;">
                <div class="d-flex justify-content-between ">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g id="Group_28009" data-name="Group 28009" transform="translate(0 16) rotate(-90)">
                                <rect id="Rectangle_18283" data-name="Rectangle_18283" width="2" height="7"
                                    rx="1" fill="#9da3ae"></rect>
                                <rect id="Rectangle_16236" data-name="Rectangle_16236" width="2" height="11"
                                    rx="1" transform="translate(14)" fill="#9da3ae"></rect>
                                <rect id="Rectangle_18284" data-name="Rectangle_18284" width="2" height="16"
                                    rx="1" transform="translate(7)" fill="#9da3ae"></rect>
                            </g>
                        </svg>
                        <h3 class="mb-0 h6 text-center ml-2 text-center ml-2">{{ translate('Show Scrolling Text') }}
                        </h3>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_scrolling_text')"
                            onclick="checkScrollTextStatus(this)"
                            {{ get_business_setting('show_scrolling_text') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>
                <div id="scroll_text_div"
                    class="{{ get_business_setting('show_scrolling_text') == 1 ? 'd-block' : 'd-none' }}">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
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
                        <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show 4 Element') }}</h3>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_4element')"
                            {{ get_business_setting('show_4element') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        @elseif($section == 'flashSale')
            <!-- Show Flash Deal -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="flashSale"
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
                        <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Flash Deal') }}</h3>
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
                        <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Todays Deal') }}</h3>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_todays_deal')"
                            {{ get_business_setting('show_todays_deal') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        @elseif($section == 'featuredCategory')
            <!-- Show Featured Categories -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="featuredCategory"
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
                        <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Featured Categories') }}</h3>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <form id="featured_category_count_form" class="form-horizontal mr-3"
                            action="{{ route('business_settings.update') }}" method="POST">
                            @csrf
                            <div class="form-group row mb-0">
                                <input type="hidden" name="types[]" value="featured_category_count">
                                <div class="input-group mx-2">
                                    <select name="featured_category_count" id="featured_category_count"
                                        class="form-control">
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
                        <div>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" onchange="updateSettings(this, 'show_featured_categories')"
                                    {{ get_business_setting('show_featured_categories') == 1 ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($section == 'banner')
            <!-- Show Home Banner1 Images -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="banner"
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
                        <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Home Banner1 Images') }}</h3>
                    </div>
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_home_banner1_images')"
                            {{ get_business_setting('show_home_banner1_images') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
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
                        <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Best Selling') }}</h3>
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
                        <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Home Categories') }}</h3>
                    </div>

                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'show_home_categories')"
                            {{ get_business_setting('show_home_categories') == 1 ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        @elseif($section == 'brand')
            <!-- Show Brands -->
            <div class="draggable-section mt-2 border-dotted p-2 align-items-center" id="brand"
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
                        <h3 class="mb-0 h6 text-center ml-2">{{ translate('Show Brands') }}</h3>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <form id="brand_count_form" class="form-horizontal mr-3"
                            action="{{ route('business_settings.update') }}" method="POST">
                            @csrf
                            <div class="form-group row mb-0">
                                <input type="hidden" name="types[]" value="brand_count">
                                <div class="input-group mx-2">
                                    <select name="brand_count" id="brand_count" class="form-control">
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
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" onchange="updateSettings(this, 'show_brands')"
                                {{ get_business_setting('show_brands') == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

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
