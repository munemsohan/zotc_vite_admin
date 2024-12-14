@extends('frontend.modern.layouts.app')

@section('additional-css')
    <link rel="stylesheet" href="{{ static_asset('assets/modern/index.css') }}">
@endsection

@section('content')
    <main class="bponi-lg bponi-e bponi-ng bponi-f">
        <div class="bponi-a bponi-b bponi-c flex bponi-og" id="app">
            <div class="flex bponi-n bponi-l relative">
                <div class="bponi-l bponi-ug bponi-vg">
                    <div class="flex bponi-n">
                        <div
                            class="hidden bponi-zc bponi-cda bponi-g bponi-dda bponi-yb bponi-eda bponi-he bponi-ie bponi-je bponi-cr border">
                            <div class="relative bponi-xj bponi-cda"><!----><!---->
                                <ul class="bponi-jda bponi-g bponi-yb bponi-gb bponi-fr bponi-he">
                                    @foreach (get_level_zero_categories()->take(10) as $key => $category)
                                        @php
                                            $category_name = $category->getTranslation('name');
                                        @endphp
                                        <li
                                            class="bponi-l bponi-zd bponi-ca bponi-gf group flex bponi-fc bponi-gr bponi-yb">
                                            <a href="{{ route('products.category', $category->slug) }}">
                                                <div class="flex bponi-ca bponi-hr bponi-go bponi-l">
                                                    <img class="bponi-nb bponi-mb bponi-uj border bponi-gda" lazy="loaded"
                                                        src="{{ isset($category->catIcon->file_name) ? my_asset($category->catIcon->file_name) : static_asset('assets/img/placeholderx200.webp') }}">
                                                    <span
                                                        class="bponi-ia bponi-wb bponi-hda bponi-yn bponi-wj bponi-ef">{{ $category_name }}</span>
                                                </div>
                                            </a>
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                                class="bponi-cc bponi-dc bponi-ob">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 4.5l7.5 7.5-7.5 7.5"></path>
                                            </svg> --}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="flicking-viewport bponi-kk bponi-tpa bponi-vv"
                            style="user-select: none; -webkit-user-drag: none; touch-action: pan-y;">
                            <div class="flicking-camera" style="transform: translate(0px);">
                                @php
                                    $decoded_slider_images = json_decode(
                                        get_setting('home_slider_images', null, $lang),
                                        true,
                                    );
                                    $sliders = get_slider_images($decoded_slider_images);
                                    // dd($sliders);
                                    $home_slider_links = get_setting('home_slider_links', null, $lang);
                                @endphp
                                <a aria-current="page"
                                    href="{{ isset(json_decode($home_slider_links, true)[0]) ? json_decode($home_slider_links, true)[0] : '' }}"
                                    class="active-link" style="width: 100%;">
                                    <img class="bponi-l bponi-kk bponi-opa bponi-jk bponi-vn bponi-vv" lazy="loaded"
                                        src="{{ get_setting('show_full_sliders') ? my_asset($sliders[0]->file_name) : my_asset($sliders[0]->thumbnail) }}">
                                </a>
                            </div>
                        </div>
                    </div>

                    @if (get_setting('show_scrolling_text'))
                        <marquee class="white-bg bponi-qpa bponi-k" direction="left"
                            style="background-color: var(--primary); color: rgb(255, 255, 255); font-weight: 600; position: relative; padding: 6px; margin-bottom: -5px;">
                            {{ base64_decode(get_setting('scrolling_text')) }}
                        </marquee>
                    @endif

                    @if (get_setting('show_home_banner1_images'))
                        <div class="bponi-yi bponi-vv grid bponi-nc bponi-qc bponi-mj bponi-tg">
                            @php $homeBanner1Images = get_setting('home_banner1_images', null, $lang);   @endphp
                            @if ($homeBanner1Images != null)
                                @php
                                    $banner_1_imags = json_decode($homeBanner1Images);
                                    $data_md = count($banner_1_imags) >= 2 ? 2 : 1;
                                    $home_banner1_links = get_setting('home_banner1_links', null, $lang);
                                @endphp
                                @foreach ($banner_1_imags as $key => $value)
                                    <a
                                        href="{{ isset(json_decode($home_banner1_links, true)[$key]) ? json_decode($home_banner1_links, true)[$key] : '' }}">
                                        <img class="bponi-l bponi-jk bponi-ppa2 rounded" alt="" lazy="loaded"
                                            src="{{ uploaded_asset($value) }}">
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    @endif

                    <div class="bponi-t bponi-uc bponi-yi bponi-g relative bponi-uo">
                        <div class="bponi-rpa fixed bponi-cr bponi-g bponi-kr bponi-ud bponi-t bponi-yd shadow"
                            style="display: none;">
                            <div class="flicking-viewport"
                                style="user-select: none; -webkit-user-drag: none; touch-action: pan-y;">
                                <div class="flicking-camera" style="transform: translate(-8px);">
                                    <button
                                        class="bponi-jc bponi-yd bponi-yb border bponi-oj bponi-gf bponi-fi bponi-qb bponi-bk">All</button>
                                </div>
                            </div>
                        </div>
                        <div class="flicking-viewport"
                            style="user-select: none; -webkit-user-drag: none; touch-action: pan-y;">
                            <div class="flicking-camera" style="transform: translate(0px);">
                                <div style="width: 0px;">
                                    <ul class="grid bponi-dba bponi-cm bponi-vp bponi-me bponi-l bponi-jk">
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Baby &amp; Kids</span>
                                            </div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Cellphones &amp;
                                                    Tabs</span></div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Beauty, Health &amp;
                                                    Hair</span></div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Computer &amp;
                                                    Accessories</span></div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Cellphones &amp;
                                                    Tabs</span></div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Computer &amp;
                                                    Accessories</span></div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Women Fashion</span>
                                            </div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Women Fashion</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div style="width: 0px;">
                                    <ul class="grid bponi-dba bponi-cm bponi-vp bponi-me bponi-l bponi-jk">
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Men Fashion</span>
                                            </div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Men Fashion</span>
                                            </div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Baby &amp; Kids</span>
                                            </div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Sports &amp;
                                                    Outdoor</span></div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Sports &amp;
                                                    Outdoor</span></div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Automobile &amp;
                                                    Motorcycle</span></div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Automobile &amp;
                                                    Motorcycle</span></div>
                                        </li>
                                        <li
                                            class="flex bponi-l bponi-le bponi-zd bponi-ca bponi-yb bponi-gf group bponi-upa">
                                            <div class="flex bponi-m bponi-ca"><img
                                                    class="bponi-sl bponi-tl bponi-yb bponi-ml" alt=""
                                                    lazy="loading"
                                                    src="{{ static_asset('assets/modern/image_placeholder.gif') }}"><span
                                                    class="bponi-yn bponi-wj bponi-cca">Beauty, Health &amp;
                                                    Hair</span></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (get_setting('show_flash_deal'))
                        <!-- Flash Deal -->
                        @php
                            $flash_deal = get_featured_flash_deal();
                        @endphp

                        <div class="bponi-yi bponi-pg bponi-ln relative">
                            <div class="bponi-fa bponi-vv relative bponi-yi bponi-lda bponi-mda bponi-nda bponi-oda"
                                first="12">
                                <div id="firework-1" class="firework">
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                </div>
                                <div class="flex bponi-fc bponi-ca bponi-ln">
                                    <div class="bponi-ic bponi-bd">Flash Sale</div>
                                    <div class="flex bponi-qa bponi-dd bponi-ic">
                                        <div class="grid bponi-zq bponi-n bponi-me bponi-ar bponi-ca bponi-le bponi-qb">
                                            <div class="flex bponi-m"><span class="countdown bponi-xl bponi-qb"><span
                                                        style="--value: 4;"></span></span> days </div>
                                            <div class="flex bponi-m"><span class="countdown bponi-xl bponi-qb"><span
                                                        style="--value: 10;"></span></span> hours </div>
                                            <div class="flex bponi-m"><span class="countdown bponi-xl bponi-qb"><span
                                                        style="--value: 4;"></span></span> min </div>
                                            <div class="flex bponi-m"><span class="countdown bponi-xl bponi-qb"><span
                                                        style="--value: 28;"></span></span> sec </div>
                                        </div>
                                    </div><a href="https://foodi.store.bponi.com/product/flash"
                                        class="flex bponi-ca bponi-xh bponi-qb bponi-bd bponi-ada bponi-pda"><span
                                            class="hidden bponi-se">See more</span><svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true" class="bponi-di bponi-ci">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                        </svg></a>
                                </div>
                                @if ($flash_deal != null)
                                    <div class="flicking-viewport"
                                        style="user-select: none; -webkit-user-drag: none; touch-action: pan-y;">
                                        <div class="flicking-camera" style="transform: translate(-435px);">
                                            <div class="bponi-vaa" style="width: 207.5px;"></div>
                                            <div class="bponi-vaa" style="width: 207.5px;"></div>
                                            @php
                                                $flash_deal_products = get_flash_deal_products($flash_deal->id);
                                            @endphp
                                            @foreach ($flash_deal_products as $flash_deal_product)
                                                @if ($flash_deal_product->product != null && $flash_deal_product->product->published != 0)
                                                    @php
                                                        $product_url =
                                                            $flash_deal_product->product->auction_product == 1
                                                                ? route(
                                                                    'auction-product',
                                                                    $flash_deal_product->product->slug,
                                                                )
                                                                : route('product', $flash_deal_product->product->slug);
                                                    @endphp
                                                    <div class="bponi-vaa" style="width: 207.5px;">
                                                        <div
                                                            class="bponi-xja bponi-zd bponi-yj bponi-we bponi-gb flex bponi-m bponi-fc relative bponi-l">
                                                            <a href="{{ $product_url }}" class="bponi-gb">
                                                                <div class="bponi-yja relative">
                                                                    <img alt="Product Image"
                                                                        class="bponi-vn bponi-uw bponi-zja bponi-yb bponi-g"
                                                                        lazy="loading"
                                                                        src="{{ static_asset('assets/modern/image_placeholder.gif') }}">
                                                                </div>
                                                                <div class="bponi-jc">
                                                                    <div class="bponi-kc">
                                                                        <span
                                                                            class="bponi-rha bponi-wc bponi-bd">{{ $flash_deal_product->product->price }}</span>
                                                                    </div>
                                                                    <h2
                                                                        class="bponi-tm bponi-qb font-regular bponi-vj bponi-ig bponi-sf">
                                                                        {{ $flash_deal_product->product->name }}
                                                                    </h2>
                                                                </div>
                                                            </a>
                                                            <div>
                                                                <div
                                                                    class="bponi-ts bponi-om bponi-hd flex bponi-ca bponi-g bponi-ph bponi-yh bponi-yb">
                                                                    <button
                                                                        class="flex bponi-ca bponi-is bponi-rba bponi-kg bponi-yd bponi-jc bponi-gf bponi-wh bponi-yj">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            aria-hidden="true"
                                                                            class="bponi-cc bponi-dc inline bponi-yh">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M12 4.5v15m7.5-7.5h-15"></path>
                                                                        </svg>
                                                                    </button>
                                                                    <button
                                                                        class="flex bponi-ca bponi-xd bponi-l bponi-xc bponi-yd bponi-jc bponi-gf bponi-hg truncate bponi-yj">
                                                                        Buy Now&nbsp;
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            aria-hidden="true"
                                                                            class="bponi-cc bponi-dc inline bponi-yh">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3">
                                                                            </path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="product-modal"
                                                            class="bponi-zs bponi-l bponi-fh bponi-gf fixed bponi-pe bponi-kr bponi-ca bponi-cp bponi-ne bponi-le bponi-wja hidden">
                                                            <div
                                                                class="bponi-bja bponi-rz bponi-aja bponi-g bponi-uu bponi-yj">
                                                                <div>
                                                                    <div class="flex bponi-fc">
                                                                        <a href="{{ $product_url }}"
                                                                            class="bponi-il bponi-kg">{{ $flash_deal_product->product->name }}</a>
                                                                        <button type="button"
                                                                            class="bponi-zb flex bponi-ca bponi-le bponi-qd bponi-tm bponi-ro bponi-tk bponi-jg bponi-z">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke-width="1.5" stroke="currentColor"
                                                                                aria-hidden="true"
                                                                                class="bponi-cc bponi-dc bponi-rj">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                                </path>
                                                                            </svg>
                                                                            <span class="bponi-na">Close menu</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="bponi-yd">
                                                                        <span
                                                                            class="bponi-rha bponi-wh bponi-sha bponi-bd">{{ $flash_deal_product->product->price }}</span>
                                                                    </div>
                                                                    <p class="bponi-yi"></p>
                                                                </div>
                                                                <div
                                                                    class="bponi-cf bponi-g bponi-l flex bponi-fc bponi-ca">
                                                                    <div class="flex bponi-l bponi-mj">
                                                                        <button
                                                                            class="bponi-hc bponi-yh bponi-xj bponi-l bponi-yb">Add
                                                                            to cart</button>
                                                                        <div
                                                                            class="border bponi-xj bponi-fja bponi-yb flex bponi-fc bponi-ca">
                                                                            <button>
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    fill="none" viewBox="0 0 24 24"
                                                                                    stroke-width="1.5"
                                                                                    stroke="currentColor"
                                                                                    aria-hidden="true"
                                                                                    class="bponi-cc bponi-dc bponi-wb">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        d="M19.5 12h-15"></path>
                                                                                </svg>
                                                                            </button>
                                                                            <span class="bponi-wb">0</span>
                                                                            <button>
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    fill="none" viewBox="0 0 24 24"
                                                                                    stroke-width="1.5"
                                                                                    stroke="currentColor"
                                                                                    aria-hidden="true"
                                                                                    class="bponi-cc bponi-dc bponi-wb">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        d="M12 4.5v15m7.5-7.5h-15"></path>
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if (get_setting('show_best_selling'))
                        <!-- Best Selling  -->
                        <div class="bponi-yi bponi-pg bponi-ln relative">
                            <div class="bponi-fa bponi-vv relative bponi-yi bponi-g" first="12">
                                <div id="firework-2" class="firework">
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                </div>
                                <div class="flex bponi-fc bponi-ca bponi-ln"><!---->
                                    <div class="bponi-kg bponi-rj bponi-me">Best Selling</div><a
                                        href="https://foodi.store.bponi.com/product/new"
                                        class="flex bponi-ca bponi-xh bponi-qb bponi-bd bponi-sf bponi-jg"><span
                                            class="">See more</span><svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true" class="bponi-di bponi-ci">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                        </svg></a>
                                </div>
                                <div class="flicking-viewport"
                                    style="user-select: none; -webkit-user-drag: none; touch-action: pan-y;">
                                    <div class="flicking-camera" style="transform: translate(-650.5px);">
                                        <div class="bponi-vaa" style="width: 207.5px;"></div>
                                        <div class="bponi-vaa" style="width: 207.5px;"></div>
                                        <div class="bponi-vaa" style="width: 207.5px;"></div>
                                        @php
                                            $newest_products = get_best_selling_products(8);
                                        @endphp
                                        @foreach ($newest_products as $product)
                                            <div class="bponi-vaa" style="width: 207.5px;">
                                                <div
                                                    class="bponi-xja bponi-zd bponi-yj bponi-we bponi-gb flex bponi-m bponi-fc relative bponi-l">
                                                    <a href="{{ route('product', $product->slug) }}" class="bponi-gb">
                                                        <div class="bponi-yja relative">
                                                            <img alt="{{ $product->name }}"
                                                                class="bponi-vn bponi-uw bponi-zja bponi-yb bponi-g"
                                                                lazy="loading"
                                                                src="{{ uploaded_asset($product->thumbnail_img) }}">
                                                            @if ($product->discount > 0)
                                                                <span
                                                                    class="bponi-aka bponi-ic bponi-hg bponi-bd bponi-bka bponi-md rounded absolute bponi-cka bponi-jd transform bponi-dka">
                                                                    {{ round($product->discount) }}%
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="bponi-jc">
                                                            <div class="bponi-kc">
                                                                <span
                                                                    class="bponi-rha bponi-wc bponi-bd">{{ home_discounted_base_price($product) }}</span>
                                                                @if ($product->discount > 0)
                                                                    <span
                                                                        class="bponi-fi bponi-wb bponi-hg bponi-eka bponi-xc relative bponi-tha bponi-uha bponi-vha bponi-wha bponi-xha bponi-yha bponi-fka bponi-aia">
                                                                        {{-- {{ $product->unit_price }} --}}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <h2
                                                                class="bponi-tm bponi-qb font-regular bponi-vj bponi-ig bponi-sf">
                                                                {{ $product->name }}
                                                            </h2>
                                                        </div>
                                                    </a>
                                                    <div>
                                                        <div
                                                            class="bponi-ts bponi-om bponi-hd flex bponi-ca bponi-g bponi-ph bponi-yh bponi-yb">
                                                            <button
                                                                class="flex bponi-ca bponi-is bponi-rba bponi-kg bponi-yd bponi-jc bponi-gf bponi-wh bponi-yj">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" aria-hidden="true"
                                                                    class="bponi-cc bponi-dc inline bponi-yh">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M12 4.5v15m7.5-7.5h-15"></path>
                                                                </svg>
                                                            </button>
                                                            <button
                                                                class="flex bponi-ca bponi-xd bponi-l bponi-xc bponi-yd bponi-jc bponi-gf bponi-hg truncate bponi-yj">
                                                                Buy Now&nbsp;
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" aria-hidden="true"
                                                                    class="bponi-cc bponi-dc inline bponi-yh">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="product-modal"
                                                    class="bponi-zs bponi-l bponi-fh bponi-gf fixed bponi-pe bponi-kr bponi-ca bponi-cp bponi-ne bponi-le bponi-wja hidden"
                                                    style="">
                                                    <div class="bponi-bja bponi-rz bponi-aja bponi-g bponi-uu bponi-yj">
                                                        <div class="">
                                                            <div class="flex bponi-fc">
                                                                <a href="{{ route('product', $product->slug) }}"
                                                                    class="bponi-il bponi-kg">{{ $product->name }}</a>
                                                                <button type="button"
                                                                    class="bponi-zb flex bponi-ca bponi-le bponi-qd bponi-tm bponi-ro bponi-tk bponi-jg bponi-z">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" aria-hidden="true"
                                                                        class="bponi-cc bponi-dc bponi-rj">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                        </path>
                                                                    </svg>
                                                                    <span class="bponi-na">Close menu</span>
                                                                </button>
                                                            </div>
                                                            <div class="bponi-yd">
                                                                <span
                                                                    class="bponi-rha bponi-wh bponi-sha bponi-bd">{{ home_discounted_base_price($product) }}</span>
                                                                @if ($product->discount > 0)
                                                                    <span
                                                                        class="bponi-fi bponi-wb text-md bponi-iw bponi-xc relative bponi-tha bponi-uha bponi-vha bponi-wha bponi-xha bponi-yha bponi-zha bponi-aia">
                                                                        {{ $product->unit_price }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <p class="bponi-yi"></p>
                                                        </div>
                                                        <div class="bponi-cf bponi-g bponi-l flex bponi-fc bponi-ca">
                                                            <div class="flex bponi-l bponi-mj">
                                                                <button
                                                                    class="bponi-hc bponi-yh bponi-xj bponi-l bponi-yb">Add
                                                                    to cart</button>
                                                                <button
                                                                    class="border bponi-xj bponi-fja bponi-yb flex bponi-fc bponi-ca">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" aria-hidden="true"
                                                                        class="bponi-cc bponi-dc bponi-wb">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" d="M19.5 12h-15">
                                                                        </path>
                                                                    </svg>
                                                                    <span class="bponi-wb">0</span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" aria-hidden="true"
                                                                        class="bponi-cc bponi-dc bponi-wb">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M12 4.5v15m7.5-7.5h-15"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (get_setting('show_new_products'))
                        <!-- New Products -->
                        <div class="bponi-yi bponi-pg bponi-ln relative">
                            <div class="bponi-fa bponi-vv relative bponi-yi bponi-g" first="12">
                                <div id="firework-2" class="firework">
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                </div>
                                <div class="flex bponi-fc bponi-ca bponi-ln"><!---->
                                    <div class="bponi-kg bponi-rj bponi-me">New Arrival</div><a
                                        href="https://foodi.store.bponi.com/product/new"
                                        class="flex bponi-ca bponi-xh bponi-qb bponi-bd bponi-sf bponi-jg"><span
                                            class="">See more</span><svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true" class="bponi-di bponi-ci">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                        </svg></a>
                                </div>
                                <div class="flicking-viewport"
                                    style="user-select: none; -webkit-user-drag: none; touch-action: pan-y;">
                                    <div class="flicking-camera" style="transform: translate(-650.5px);">
                                        <div class="bponi-vaa" style="width: 207.5px;"></div>
                                        <div class="bponi-vaa" style="width: 207.5px;"></div>
                                        <div class="bponi-vaa" style="width: 207.5px;"></div>
                                        @php
                                            $newest_products = Cache::remember(
                                                get_domain() . '_newest_products',
                                                2592000,
                                                function () {
                                                    return filter_products(\App\Models\Product::latest())
                                                        ->limit(8)
                                                        ->get();
                                                },
                                            );
                                        @endphp
                                        @foreach ($newest_products as $product)
                                            <div class="bponi-vaa" style="width: 207.5px;">
                                                <div
                                                    class="bponi-xja bponi-zd bponi-yj bponi-we bponi-gb flex bponi-m bponi-fc relative bponi-l">
                                                    <a href="{{ route('product', $product->slug) }}" class="bponi-gb">
                                                        <div class="bponi-yja relative">
                                                            <img alt="{{ $product->name }}"
                                                                class="bponi-vn bponi-uw bponi-zja bponi-yb bponi-g"
                                                                lazy="loading"
                                                                src="{{ uploaded_asset($product->thumbnail_img) }}">
                                                            @if ($product->discount > 0)
                                                                <span
                                                                    class="bponi-aka bponi-ic bponi-hg bponi-bd bponi-bka bponi-md rounded absolute bponi-cka bponi-jd transform bponi-dka">
                                                                    {{ round($product->discount) }}%
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="bponi-jc">
                                                            <div class="bponi-kc">
                                                                <span
                                                                    class="bponi-rha bponi-wc bponi-bd">{{ home_discounted_base_price($product) }}</span>
                                                                @if ($product->discount > 0)
                                                                    <span
                                                                        class="bponi-fi bponi-wb bponi-hg bponi-eka bponi-xc relative bponi-tha bponi-uha bponi-vha bponi-wha bponi-xha bponi-yha bponi-fka bponi-aia">
                                                                        {{-- {{ $product->unit_price }} --}}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <h2
                                                                class="bponi-tm bponi-qb font-regular bponi-vj bponi-ig bponi-sf">
                                                                {{ $product->name }}
                                                            </h2>
                                                        </div>
                                                    </a>
                                                    <div>
                                                        <div
                                                            class="bponi-ts bponi-om bponi-hd flex bponi-ca bponi-g bponi-ph bponi-yh bponi-yb">
                                                            <button
                                                                class="flex bponi-ca bponi-is bponi-rba bponi-kg bponi-yd bponi-jc bponi-gf bponi-wh bponi-yj">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" aria-hidden="true"
                                                                    class="bponi-cc bponi-dc inline bponi-yh">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M12 4.5v15m7.5-7.5h-15"></path>
                                                                </svg>
                                                            </button>
                                                            <button
                                                                class="flex bponi-ca bponi-xd bponi-l bponi-xc bponi-yd bponi-jc bponi-gf bponi-hg truncate bponi-yj">
                                                                Buy Now&nbsp;
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" aria-hidden="true"
                                                                    class="bponi-cc bponi-dc inline bponi-yh">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="product-modal"
                                                    class="bponi-zs bponi-l bponi-fh bponi-gf fixed bponi-pe bponi-kr bponi-ca bponi-cp bponi-ne bponi-le bponi-wja hidden"
                                                    style="">
                                                    <div class="bponi-bja bponi-rz bponi-aja bponi-g bponi-uu bponi-yj">
                                                        <div class="">
                                                            <div class="flex bponi-fc">
                                                                <a href="{{ route('product', $product->slug) }}"
                                                                    class="bponi-il bponi-kg">{{ $product->name }}</a>
                                                                <button type="button"
                                                                    class="bponi-zb flex bponi-ca bponi-le bponi-qd bponi-tm bponi-ro bponi-tk bponi-jg bponi-z">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" aria-hidden="true"
                                                                        class="bponi-cc bponi-dc bponi-rj">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                        </path>
                                                                    </svg>
                                                                    <span class="bponi-na">Close menu</span>
                                                                </button>
                                                            </div>
                                                            <div class="bponi-yd">
                                                                <span
                                                                    class="bponi-rha bponi-wh bponi-sha bponi-bd">{{ home_discounted_base_price($product) }}</span>
                                                                @if ($product->discount > 0)
                                                                    <span
                                                                        class="bponi-fi bponi-wb text-md bponi-iw bponi-xc relative bponi-tha bponi-uha bponi-vha bponi-wha bponi-xha bponi-yha bponi-zha bponi-aia">
                                                                        {{ $product->unit_price }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <p class="bponi-yi"></p>
                                                        </div>
                                                        <div class="bponi-cf bponi-g bponi-l flex bponi-fc bponi-ca">
                                                            <div class="flex bponi-l bponi-mj">
                                                                <button
                                                                    class="bponi-hc bponi-yh bponi-xj bponi-l bponi-yb">Add
                                                                    to cart</button>
                                                                <button
                                                                    class="border bponi-xj bponi-fja bponi-yb flex bponi-fc bponi-ca">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" aria-hidden="true"
                                                                        class="bponi-cc bponi-dc bponi-wb">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" d="M19.5 12h-15">
                                                                        </path>
                                                                    </svg>
                                                                    <span class="bponi-wb">0</span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="1.5"
                                                                        stroke="currentColor" aria-hidden="true"
                                                                        class="bponi-cc bponi-dc bponi-wb">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M12 4.5v15m7.5-7.5h-15"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Top Brands -->
                    @if (get_setting('top_brands') != null && get_setting('show_brands') == 1)
                        <div class="bponi-yi bponi-pg bponi-ln relative">
                            <div class="bponi-uc bponi-t bponi-we relative bponi-yca">
                                <div id="firework-2" class="firework">
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                    <div class="explosion"></div>
                                </div>
                                <div class="bponi-df flex bponi-fc">
                                    <div></div>
                                    <div class="bponi-me bponi-kg bponi-ic">Brands</div><a
                                        href="https://foodi.store.bponi.com/brands"
                                        class="flex bponi-ca bponi-xh bponi-ada bponi-bda bponi-qb bponi-bd"><span>See
                                            more</span><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true" class="bponi-di bponi-ci">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                                        </svg></a>
                                </div>
                                <div class="flicking-viewport"
                                    style="user-select: none; -webkit-user-drag: none; touch-action: pan-y;">
                                    <div class="flicking-camera" style="transform: translate(-2590px);">
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                            style="width: 176.714px;"></div>
                                        @php
                                            $top_brands = json_decode(get_setting('top_brands'));
                                            $brands = get_brands($top_brands);
                                        @endphp
                                        @foreach ($brands as $brand)
                                            <div class="bponi-zd bponi-g bponi-lc bponi-gb flex bponi-m bponi-fc bponi-vaa"
                                                style="width: 176.714px;">
                                                <div class="bponi-fo">
                                                    <a href="{{ route('products.brand', $brand->slug) }}"
                                                        class="bponi-gb">
                                                        <div class="bponi-ll relative"><img alt="Product Image"
                                                                class="bponi-vn bponi-l bponi-zca bponi-yj" lazy="loading"
                                                                src="{{ isset($brand->brandLogo->file_name) ? my_asset($brand->brandLogo->file_name) : static_asset('assets/img/placeholderx200.webp') }}">
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </main>
@endsection
