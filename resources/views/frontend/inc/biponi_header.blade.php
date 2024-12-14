<div class="bponi-uo bponi-rr fixed bponi-sr bponi-l bponi-tr">
    <div class="bponi-b flex bponi-ur bponi-m bponi-vr bponi-wr">
        <div class="sticky bponi-pe bponi-fe flex bponi-tl bponi-ha bponi-ni bponi-bi bponi-xr"><button type="button"
                class="bponi-tc bponi-c bponi-yh bponi-bl bponi-uo"><span class="bponi-na">Open sidebar</span><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true" class="bponi-mb bponi-nb bponi-zr">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12">
                    </path>
                </svg></button>
            <div class="flex bponi-ka bponi-fc bponi-tn bponi-yr"><a aria-current="page" href="{{ route('home') }}"
                    class="active-link bponi-l flex bponi-le bponi-ca"><img class="bponi-tj bponi-ft" alt="Foodi"
                        lazy="loading" src="{{ static_asset('assets/modern/image_placeholder.gif') }}"></a>
                <div class="flex bponi-ca bponi-gs"><button type="button"
                        class="bponi-uj flex bponi-ca bponi-bp bponi-zr bponi-bc"><span class="bponi-na">View
                            notifications</span><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                            class="bponi-mb bponi-nb bponi-zr">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                            </path>
                        </svg></button><a href="{{ route('home') }}/user/wishlist" class="bponi-bp"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" class="bponi-mb bponi-nb bponi-zr">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z">
                            </path>
                        </svg></a><!----></div>
            </div>
        </div>
    </div>
</div>
<nav class="hidden bponi-zc bponi-zs sticky bponi-pe bponi-g bponi-ph">
    <div class="bponi-a bponi-b bponi-c bponi-l bponi-hs">
        <div class="flex bponi-fc bponi-l bponi-ca">
            <div class="flex bponi-fc bponi-ka">
                <div class="flex bponi-is bponi-js bponi-ks bponi-ka">
                    <a aria-current="page" href="{{ route('home') }}" class="active-link">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if ($header_logo != null)
                            <img class="bponi-ls bponi-tl" alt="" lazy="loaded"
                                src="{{ uploaded_asset($header_logo) }}">
                        @else
                            <h2 class="fw-bold text-primary">{{ get_setting('website_name') }}</h2>
                        @endif

                    </a>
                    <div class="flex bponi-m bponi-ms">
                        <div id="search-field"
                            class="bponi-gd bponi-tc bponi-yb border bponi-rt bponi-g bponi-yh flex bponi-ca relative">
                            <input type="search"
                                class="bponi-l bponi-qd rounded bponi-st bponi-tt bponi-nd bponi-ut bponi-ir bponi-vt bponi-sd"
                                placeholder="Search by name...">
                            <div class="absolute"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                    class="bponi-cc bponi-dc">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                    </path>
                                </svg></div>
                            <div id="search-dropdown"
                                class="bponi-gb absolute bponi-cs bponi-kr bponi-l bponi-g bponi-hb bponi-ds bponi-ef bponi-es bponi-kc bponi-fe"
                                style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex bponi-ca bponi-dd bponi-eo">
                <div class="relative bponi-me flex bponi-ca bponi-vi">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true" class="bponi-cc bponi-dc bponi-wb">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                        </path>
                    </svg>
                    <div class="bponi-qb bponi-wb bponi-bo">
                        @auth
                            @if (isAdmin())
                                <a href="{{ route('admin.dashboard') }}" target="_blank">
                                    <span class="bponi-rha bponi-tn bponi-ns bponi-fd bponi-ui">{{ $user->name }}</span>
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}">
                                    <span class="bponi-rha bponi-tn bponi-ns bponi-fd bponi-ui">{{ $user->name }}</span>
                                </a>
                            @endif

                            <a href="{{ route('logout') }}">
                                <span class="bponi-bo bponi-ui">Logout</span>
                            </a>
                        @else
                            <a href="{{ route('user.login') }}">
                                <span class="bponi-tn bponi-ns bponi-fd bponi-ui">Sign In</span>
                            </a>

                            <a href="{{ route('user.registration') }}">
                                <span class="bponi-bo bponi-ui">Register</span>
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="relative bponi-vi group bponi-wb bponi-ui bponi-qb bponi-zd">
                    @php
                        $total = 0;
                        $carts = get_user_cart();
                        if (count($carts) > 0) {
                            foreach ($carts as $key => $cartItem) {
                                $product = get_single_product($cartItem['product_id']);
                                $total =
                                    $total + cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
                            }
                        }
                    @endphp
                    <a href="{{ route('cart') }}" class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="bponi-mb bponi-nb">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z">
                            </path>
                        </svg>
                        @if (isset($carts) && count($carts) > 0)
                            <span
                                class="absolute bponi-os bponi-ps flex bponi-di bponi-ci bponi-uj bponi-ic bponi-ca bponi-le bponi-qs bponi-hg">{{ count($carts) }}</span>
                        @endif
                    </a>
                    <div
                        class="bponi-wt bponi-wb absolute bponi-xt bponi-ud hidden bponi-fa bponi-g bponi-yt bponi-lc bponi-ef bponi-es bponi-zt bponi-v">
                        <h3 class="bponi-kg bponi-wc">Cart</h3>
                        <div>
                            <div class="flex bponi-fc bponi-ni bponi-uc">
                                <div class="flex">
                                    <div class="bponi-qr bponi-rs"><img class="bponi-l" alt=""
                                            lazy="loading"
                                            src="{{ static_asset('assets/modern/image_placeholder.gif') }}">
                                    </div>
                                    <div class="bponi-ss bponi-qb truncate bponi-wj">
                                        <p>Apple iPhone 11 (128GB) - হলুদ</p>
                                        <div class="bponi-bd"><span>৳123,000</span></div>
                                    </div>
                                </div>
                                <div class="flex bponi-ca">
                                    <div
                                        class="bponi-ep bponi-z bponi-mb bponi-nb flex bponi-ca bponi-le bponi-wc bponi-kg bponi-zb bponi-zd">
                                        <span>-</span>
                                    </div>
                                    <div class="bponi-kg bponi-ts">6</div>
                                    <div
                                        class="bponi-ep bponi-z bponi-mb bponi-nb flex bponi-ca bponi-le bponi-wc bponi-kg bponi-zb bponi-zd">
                                        <span>+</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex bponi-fc bponi-ni bponi-uc">
                                <div class="flex">
                                    <div class="bponi-qr bponi-rs"><img class="bponi-l" alt=""
                                            lazy="loading"
                                            src="{{ static_asset('assets/modern/image_placeholder.gif') }}">
                                    </div>
                                    <div class="bponi-ss bponi-qb truncate bponi-wj">
                                        <p>Adidas Men's NMD_R1Running Casual Shoes</p>
                                        <div class="bponi-bd"><span>৳15,250</span></div>
                                    </div>
                                </div>
                                <div class="flex bponi-ca">
                                    <div
                                        class="bponi-ep bponi-z bponi-mb bponi-nb flex bponi-ca bponi-le bponi-wc bponi-kg bponi-zb bponi-zd">
                                        <span>-</span>
                                    </div>
                                    <div class="bponi-kg bponi-ts">5</div>
                                    <div
                                        class="bponi-ep bponi-z bponi-mb bponi-nb flex bponi-ca bponi-le bponi-wc bponi-kg bponi-zb bponi-zd">
                                        <span>+</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex bponi-fc bponi-ni bponi-uc">
                                <div class="flex">
                                    <div class="bponi-qr bponi-rs"><img class="bponi-l" alt=""
                                            lazy="loading"
                                            src="{{ static_asset('assets/modern/image_placeholder.gif') }}">
                                    </div>
                                    <div class="bponi-ss bponi-qb truncate bponi-wj">
                                        <p>Toddler Baby Girl Valentine's Day Outfit Mother's Bestie Long
                                            Sleeve Dress Love Heart Princess Tulle Tutu Dress</p>
                                        <div class="bponi-bd"><span>৳2,260</span></div>
                                    </div>
                                </div>
                                <div class="flex bponi-ca">
                                    <div
                                        class="bponi-ep bponi-z bponi-mb bponi-nb flex bponi-ca bponi-le bponi-wc bponi-kg bponi-zb bponi-zd">
                                        <span>-</span>
                                    </div>
                                    <div class="bponi-kg bponi-ts">1</div>
                                    <div
                                        class="bponi-ep bponi-z bponi-mb bponi-nb flex bponi-ca bponi-le bponi-wc bponi-kg bponi-zb bponi-zd">
                                        <span>+</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex bponi-fc bponi-ni bponi-uc">
                                <div class="flex">
                                    <div class="bponi-qr bponi-rs"><img class="bponi-l" alt=""
                                            lazy="loading"
                                            src="{{ static_asset('assets/modern/image_placeholder.gif') }}">
                                    </div>
                                    <div class="bponi-ss bponi-qb truncate bponi-wj">
                                        <p>Salat khimar with adjust borkha and haat</p>
                                        <div class="bponi-bd"><span>৳3,200</span></div>
                                    </div>
                                </div>
                                <div class="flex bponi-ca">
                                    <div
                                        class="bponi-ep bponi-z bponi-mb bponi-nb flex bponi-ca bponi-le bponi-wc bponi-kg bponi-zb bponi-zd">
                                        <span>-</span>
                                    </div>
                                    <div class="bponi-kg bponi-ts">3</div>
                                    <div
                                        class="bponi-ep bponi-z bponi-mb bponi-nb flex bponi-ca bponi-le bponi-wc bponi-kg bponi-zb bponi-zd">
                                        <span>+</span>
                                    </div>
                                </div>
                            </div><a href="{{ route('home') }}/checkout"
                                class="bponi-yd bponi-t bponi-yj flex bponi-ca bponi-fc bponi-mj bponi-yi bponi-hc bponi-ic">
                                <div>Checkout</div>
                                <div class="bponi-wh bponi-bd">৳826,110</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <a href="{{ route('wishlists.index') }}" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                            class="bponi-mb bponi-nb bponi-wb bponi-ui">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z">
                            </path>
                        </svg>
                    </a>
                </div>
                <div class="relative"><button id="headlessui-listbox-button-1" type="button"
                        aria-haspopup="listbox" aria-expanded="false" data-headlessui-state=""
                        class="relative bponi-l bponi-au rounded bponi-g bponi-bu bponi-lr bponi-cu bponi-ef border bponi-bi bponi-bl bponi-du bponi-eu bponi-fu bponi-gu bponi-hu bponi-rd"><span
                            class="block truncate">🇧🇩 BN</span><span
                            class="bponi-oa absolute bponi-td bponi-ud flex bponi-ca bponi-tn"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                class="bponi-cc bponi-dc bponi-zb">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                            </svg></span></button><!----></div>
            </div>
        </div>
    </div>
    <div class="bponi-hc bponi-ic">
        <div class="bponi-a bponi-b bponi-c hidden bponi-gc">
            <div class="flex justify bponi-qb"><a aria-current="page" href="{{ route('home') }}"
                    class="active-link bponi-gd bponi-jc bponi-mu bponi-zj bponi-va flex bponi-nu bponi-g bponi-nm"><svg
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true" class="bponi-cc bponi-dc">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
                        </path>
                    </svg>
                    <p>Home</p>
                </a><a href="{{ route('categories.all') }}"
                    class="bponi-gd bponi-jc bponi-mu bponi-zj bponi-va flex bponi-nu"><!---->
                    <p>Categories</p>
                </a>
                @if (get_setting('header_menu_labels') != null)
                    @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                        <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}"
                            class="bponi-gd bponi-jc bponi-mu bponi-zj bponi-va flex bponi-nu"><!---->
                            <p>{{ translate($value) }}</p>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
<div class="bponi-uo fixed bponi-sr bponi-l bponi-tl bponi-cg bponi-us bponi-od bponi-g bponi-vs bponi-ws">
    <div class="grid bponi-jk bponi-xs bponi-b"><a aria-current="page" href="{{ route('home') }}"
            class="active-link bponi-xb bponi-m bponi-ca bponi-le bponi-qj group" type="button"><svg
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" aria-hidden="true" class="bponi-nb bponi-mb bponi-ml bponi-yh bponi-ou">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
                </path>
            </svg><span class="bponi-na">Home</span></a><a href="{{ route('home') }}/categories/"
            class="bponi-xb bponi-m bponi-ca bponi-le bponi-qj group" type="button"><svg
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" aria-hidden="true" class="bponi-nb bponi-mb bponi-ml bponi-yh bponi-ou">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z">
                </path>
            </svg><span class="bponi-na">Category</span></a>
        <div class="flex bponi-ca bponi-le"><a href="{{ route('home') }}/checkout/"
                class="bponi-xb bponi-ca bponi-le bponi-ro bponi-tm bponi-rb bponi-hc bponi-uj bponi-qh group bponi-pu bponi-qu bponi-bl bponi-ru"
                type="button">
                <div class="relative"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        class="bponi-nb bponi-mb bponi-ic">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                        </path>
                    </svg><span class="bponi-na">Cart</span><span
                        class="absolute bponi-id bponi-ys flex bponi-di bponi-ci bponi-uj bponi-ic bponi-ca bponi-le bponi-qs bponi-hg">15</span>
                </div>
            </a></div><a href="{{ route('home') }}/feed/" class="bponi-xb bponi-m bponi-ca bponi-le bponi-qj group"
            type="button"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                class="bponi-nb bponi-mb bponi-ml bponi-yh bponi-ou">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z">
                </path>
            </svg><span class="bponi-na">Community</span></a><a href="{{ route('home') }}/user/"
            class="bponi-xb bponi-m bponi-ca bponi-le bponi-qj group" type="button"><svg
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" aria-hidden="true" class="bponi-nb bponi-mb bponi-ml bponi-yh bponi-ou">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                </path>
            </svg><span class="bponi-na">Profile</span></a>
    </div>
</div>
