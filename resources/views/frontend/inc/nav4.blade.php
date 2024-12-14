<style>
    .search-container {
        position: relative;
        display: inline-block;
    }

    #search {
        padding-right: 120px;
        /* Ensure padding for placeholder text */
        width: 100%;
    }

    #category-image {
        position: absolute;
        left: 20%;
        top: 50%;
        bottom: 0;
        transform: translateY(-50%);
        height: 16px;
        opacity: 0.6;
    }

    .placeholder {
        position: absolute;
        left: 25%;
        top: 0;
        bottom: 0;
        line-height: 38px;
        color: #898b92;
    }

    #search:focus+.placeholder {
        opacity: 0;
    }
</style>

<div class="row mx-0 top-navbar shadow @if (get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white">
    <div class="container py-2">
        <div class="row">
            <div class="col-md-2 d-none d-md-block">
                <!-- Header Logo -->
                <a class="d-block py-1 d-flex align-items-center" href="{{ route('home') }}">
                    @php
                        $header_logo = get_setting('header_logo');
                    @endphp
                    @if ($header_logo != null)
                        <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
                            class="mw-100 h-30px h-md-40px" height="40">
                    @else
                        <h2 class="fw-bold text-primary">{{ get_setting('website_name') }}</h2>
                    @endif
                </a>
            </div>

            <div class="col-md-6">
                <!-- Search Bar -->
                <div class="position-relative logo-bar-area pt-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <!-- top menu sidebar button -->
                        <button type="button" class="btn d-lg-none ml-3 mr-sm-4 p-0 active" data-toggle="class-toggle"
                            data-target=".aiz-top-menu-sidebar">
                            <div class="flex-container">
                                <i class="las la-bars fs-24 text-dark"></i>
                            </div>
                        </button>

                        <a class="d-lg-none mx-3 mt-2" href="{{ route('home') }}">
                            @if ($header_logo != null)
                                <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
                                    class="mw-100 h-30px h-md-40px" height="40">
                            @else
                                <h5 class="fw-bold text-primary">{{ get_setting('website_name') }}</h5>
                            @endif
                        </a>

                        <!-- Search Icon for small device -->
                        <div class="d-lg-none ml-auto">
                            <a class="p-2 d-block text-white" href="javascript:void(0);" data-toggle="class-toggle"
                                data-target=".front-header-search">
                                <i class="las la-search la-flip-horizontal la-2x"></i>
                            </a>
                        </div>

                        <!-- Search field -->
                        <div class="flex-grow-1 front-header-search d-flex align-items-center">
                            <div class="position-relative flex-grow-1 px-3 px-lg-0">
                                <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                                    <div class="">
                                        <div class="d-lg-none" data-toggle="class-toggle"
                                            data-target=".front-header-search">
                                            <button class="btn px-2 text-white" type="button"><i
                                                    class="la la-2x la-long-arrow-left"></i></button>
                                        </div>
                                        <div class="search-container d-flex justify-content-start">
                                            <input type="text"
                                                class="border border-soft-light form-control fs-14 hov-animate-outline"
                                                id="search" name="keyword" placeholder="Search for "
                                                autocomplete="off">
                                            <div id="placeholder_category">
                                                <img class="cat-image lazyload mr-2 opacity-60 position-absolute"
                                                    id="category-image"
                                                    src="{{ static_asset('assets/img/placeholderx200.webp') }}"
                                                    width="16" alt="Category Image"
                                                    onerror="this.onerror=null; this.src='{{ static_asset('assets/img/placeholderx200.webp') }}';">
                                                <span class="placeholder" id="dynamic-placeholder"></span>
                                            </div>
                                        </div>

                                        {{-- <div class="search-input-box">
                                            <input type="text"
                                                class="border border-soft-light form-control fs-14 hov-animate-outline"
                                                id="search" name="keyword" autocomplete="off">

                                            <svg id="Group_723" data-name="Group 723"
                                                xmlns="http://www.w3.org/2000/svg" width="20.001" height="20"
                                                viewBox="0 0 20.001 20">
                                                <path id="Path_3090" data-name="Path 3090"
                                                    d="M9.847,17.839a7.993,7.993,0,1,1,7.993-7.993A8,8,0,0,1,9.847,17.839Zm0-14.387a6.394,6.394,0,1,0,6.394,6.394A6.4,6.4,0,0,0,9.847,3.453Z"
                                                    transform="translate(-1.854 -1.854)" fill="#b5b5bf" />
                                                <path id="Path_3091" data-name="Path 3091"
                                                    d="M24.4,25.2a.8.8,0,0,1-.565-.234l-6.15-6.15a.8.8,0,0,1,1.13-1.13l6.15,6.15A.8.8,0,0,1,24.4,25.2Z"
                                                    transform="translate(-5.2 -5.2)" fill="#b5b5bf" />
                                            </svg>
                                        </div> --}}
                                    </div>
                                </form>
                                <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100"
                                    style="min-height: 200px">
                                    <div class="search-preloader absolute-top-center">
                                        <div class="dot-loader">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                    <div class="search-nothing d-none p-3 text-center fs-16">

                                    </div>
                                    <div id="search-content" class="text-left">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Search box -->
                        <div class="d-none d-lg-none ml-3 mr-0">
                            <div class="nav-search-box">
                                <a href="#" class="nav-box-link">
                                    <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-none d-md-block">
                <div class="h-100 d-flex align-items-center justify-content-between">
                    @auth
                        <span class="d-flex align-items-center justify-content-center nav-user-info h-100"
                            id="nav-user-info">
                            <!-- Image -->
                            <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">
                                @if ($user->avatar_original != null)
                                    <img src="{{ $user_avatar }}" class="img-fit h-100" alt="{{ translate('avatar') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                @else
                                    <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image"
                                        alt="{{ translate('avatar') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                @endif
                            </span>
                            <!-- Name -->
                            <h4 class="h5 fs-14 fw-700 text-dark ml-2 mb-0">{{ $user->name }}</h4>
                        </span>

                        <!-- Loged in user Menus -->
                        <div class="hover-user-top-menu position-absolute right-0 top-100 z-3">
                            <div class="container">
                                <div class="position-static float-right">
                                    <div class="aiz-user-top-menu bg-white rounded-0 border-top shadow-sm"
                                        style="width:200px;">
                                        <ul class="list-unstyled no-scrollbar mb-0 text-left">
                                            @if (isAdmin())
                                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                                    <a href="{{ route('admin.dashboard') }}"
                                                        class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 16 16">
                                                            <path id="Path_2916" data-name="Path 2916"
                                                                d="M15.3,5.4,9.561.481A2,2,0,0,0,8.26,0H7.74a2,2,0,0,0-1.3.481L.7,5.4A2,2,0,0,0,0,6.92V14a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V6.92A2,2,0,0,0,15.3,5.4M10,15H6V9A1,1,0,0,1,7,8H9a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H11V9A2,2,0,0,0,9,7H7A2,2,0,0,0,5,9v6H2a1,1,0,0,1-1-1V6.92a1,1,0,0,1,.349-.76l5.74-4.92A1,1,0,0,1,7.74,1h.52a1,1,0,0,1,.651.24l5.74,4.92A1,1,0,0,1,15,6.92Z"
                                                                fill="#b5b5c0" />
                                                        </svg>
                                                        <span
                                                            class="user-top-menu-name has-transition ml-3">{{ translate('Dashboard') }}</span>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                                    <a href="{{ route('dashboard') }}"
                                                        class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 16 16">
                                                            <path id="Path_2916" data-name="Path 2916"
                                                                d="M15.3,5.4,9.561.481A2,2,0,0,0,8.26,0H7.74a2,2,0,0,0-1.3.481L.7,5.4A2,2,0,0,0,0,6.92V14a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V6.92A2,2,0,0,0,15.3,5.4M10,15H6V9A1,1,0,0,1,7,8H9a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H11V9A2,2,0,0,0,9,7H7A2,2,0,0,0,5,9v6H2a1,1,0,0,1-1-1V6.92a1,1,0,0,1,.349-.76l5.74-4.92A1,1,0,0,1,7.74,1h.52a1,1,0,0,1,.651.24l5.74,4.92A1,1,0,0,1,15,6.92Z"
                                                                fill="#b5b5c0" />
                                                        </svg>
                                                        <span
                                                            class="user-top-menu-name has-transition ml-3">{{ translate('Dashboard') }}</span>
                                                    </a>
                                                </li>
                                            @endif

                                            @if (isCustomer())
                                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                                    <a href="{{ route('purchase_history.index') }}"
                                                        class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" viewBox="0 0 16 16">
                                                            <g id="Group_25261" data-name="Group 25261"
                                                                transform="translate(-27.466 -542.963)">
                                                                <path id="Path_2953" data-name="Path 2953"
                                                                    d="M14.5,5.963h-4a1.5,1.5,0,0,0,0,3h4a1.5,1.5,0,0,0,0-3m0,2h-4a.5.5,0,0,1,0-1h4a.5.5,0,0,1,0,1"
                                                                    transform="translate(22.966 537)" fill="#b5b5bf" />
                                                                <path id="Path_2954" data-name="Path 2954"
                                                                    d="M12.991,8.963a.5.5,0,0,1,0-1H13.5a2.5,2.5,0,0,1,2.5,2.5v10a2.5,2.5,0,0,1-2.5,2.5H2.5a2.5,2.5,0,0,1-2.5-2.5v-10a2.5,2.5,0,0,1,2.5-2.5h.509a.5.5,0,0,1,0,1H2.5a1.5,1.5,0,0,0-1.5,1.5v10a1.5,1.5,0,0,0,1.5,1.5h11a1.5,1.5,0,0,0,1.5-1.5v-10a1.5,1.5,0,0,0-1.5-1.5Z"
                                                                    transform="translate(27.466 536)" fill="#b5b5bf" />
                                                                <path id="Path_2955" data-name="Path 2955"
                                                                    d="M7.5,15.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5"
                                                                    transform="translate(23.966 532)" fill="#b5b5bf" />
                                                                <path id="Path_2956" data-name="Path 2956"
                                                                    d="M7.5,21.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5"
                                                                    transform="translate(23.966 529)" fill="#b5b5bf" />
                                                                <path id="Path_2957" data-name="Path 2957"
                                                                    d="M7.5,27.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5"
                                                                    transform="translate(23.966 526)" fill="#b5b5bf" />
                                                                <path id="Path_2958" data-name="Path 2958"
                                                                    d="M13.5,16.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"
                                                                    transform="translate(20.966 531.5)" fill="#b5b5bf" />
                                                                <path id="Path_2959" data-name="Path 2959"
                                                                    d="M13.5,22.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"
                                                                    transform="translate(20.966 528.5)" fill="#b5b5bf" />
                                                                <path id="Path_2960" data-name="Path 2960"
                                                                    d="M13.5,28.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"
                                                                    transform="translate(20.966 525.5)" fill="#b5b5bf" />
                                                            </g>
                                                        </svg>
                                                        <span
                                                            class="user-top-menu-name has-transition ml-3">{{ translate('Purchase History') }}</span>
                                                    </a>
                                                </li>
                                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                                    <a href="{{ route('digital_purchase_history.index') }}"
                                                        class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.001"
                                                            height="16" viewBox="0 0 16.001 16">
                                                            <g id="Group_25262" data-name="Group 25262"
                                                                transform="translate(-1388.154 -562.604)">
                                                                <path id="Path_2963" data-name="Path 2963"
                                                                    d="M77.864,98.69V92.1a.5.5,0,1,0-1,0V98.69l-1.437-1.437a.5.5,0,0,0-.707.707l1.851,1.852a1,1,0,0,0,.707.293h.172a1,1,0,0,0,.707-.293l1.851-1.852a.5.5,0,0,0-.7-.713Z"
                                                                    transform="translate(1318.79 478.5)" fill="#b5b5bf" />
                                                                <path id="Path_2964" data-name="Path 2964"
                                                                    d="M67.155,88.6a3,3,0,0,1-.474-5.963q-.009-.089-.015-.179a5.5,5.5,0,0,1,10.977-.718,3.5,3.5,0,0,1-.989,6.859h-1.5a.5.5,0,0,1,0-1l1.5,0a2.5,2.5,0,0,0,.417-4.967.5.5,0,0,1-.417-.5,4.5,4.5,0,1,0-8.908.866.512.512,0,0,1,.009.121.5.5,0,0,1-.52.479,2,2,0,1,0-.162,4l.081,0h2a.5.5,0,0,1,0,1Z"
                                                                    transform="translate(1324 486)" fill="#b5b5bf" />
                                                            </g>
                                                        </svg>
                                                        <span
                                                            class="user-top-menu-name has-transition ml-3">{{ translate('Downloads') }}</span>
                                                    </a>
                                                </li>
                                                @if (get_setting('conversation_system') == 1)
                                                    <li class="user-top-nav-element border border-top-0" data-id="1">
                                                        <a href="{{ route('conversations.index') }}"
                                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 16 16">
                                                                <g id="Group_25263" data-name="Group 25263"
                                                                    transform="translate(1053.151 256.688)">
                                                                    <path id="Path_3012" data-name="Path 3012"
                                                                        d="M134.849,88.312h-8a2,2,0,0,0-2,2v5a2,2,0,0,0,2,2v3l2.4-3h5.6a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2m1,7a1,1,0,0,1-1,1h-8a1,1,0,0,1-1-1v-5a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1Z"
                                                                        transform="translate(-1178 -341)"
                                                                        fill="#b5b5bf" />
                                                                    <path id="Path_3013" data-name="Path 3013"
                                                                        d="M134.849,81.312h8a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h-.5a.5.5,0,0,0,0,1h.5a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2h-8a2,2,0,0,0-2,2v.5a.5.5,0,0,0,1,0v-.5a1,1,0,0,1,1-1"
                                                                        transform="translate(-1182 -337)"
                                                                        fill="#b5b5bf" />
                                                                    <path id="Path_3014" data-name="Path 3014"
                                                                        d="M131.349,93.312h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1"
                                                                        transform="translate(-1181 -343.5)"
                                                                        fill="#b5b5bf" />
                                                                    <path id="Path_3015" data-name="Path 3015"
                                                                        d="M131.349,99.312h5a.5.5,0,1,1,0,1h-5a.5.5,0,1,1,0-1"
                                                                        transform="translate(-1181 -346.5)"
                                                                        fill="#b5b5bf" />
                                                                </g>
                                                            </svg>
                                                            <span
                                                                class="user-top-menu-name has-transition ml-3">{{ translate('Conversations') }}</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if (get_setting('wallet_system') == 1)
                                                    <li class="user-top-nav-element border border-top-0" data-id="1">
                                                        <a href="{{ route('wallet.index') }}"
                                                            class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="16"
                                                                height="16" viewBox="0 0 16 16">
                                                                <defs>
                                                                    <clipPath id="clip-path1">
                                                                        <rect id="Rectangle_1386"
                                                                            data-name="Rectangle 1386" width="16"
                                                                            height="16" fill="#b5b5bf" />
                                                                    </clipPath>
                                                                </defs>
                                                                <g id="Group_8102" data-name="Group 8102"
                                                                    clip-path="url(#clip-path1)">
                                                                    <path id="Path_2936" data-name="Path 2936"
                                                                        d="M13.5,4H13V2.5A2.5,2.5,0,0,0,10.5,0h-8A2.5,2.5,0,0,0,0,2.5v11A2.5,2.5,0,0,0,2.5,16h11A2.5,2.5,0,0,0,16,13.5v-7A2.5,2.5,0,0,0,13.5,4M2.5,1h8A1.5,1.5,0,0,1,12,2.5V4H2.5a1.5,1.5,0,0,1,0-3M15,11H10a1,1,0,0,1,0-2h5Zm0-3H10a2,2,0,0,0,0,4h5v1.5A1.5,1.5,0,0,1,13.5,15H2.5A1.5,1.5,0,0,1,1,13.5v-9A2.5,2.5,0,0,0,2.5,5h11A1.5,1.5,0,0,1,15,6.5Z"
                                                                        fill="#b5b5bf" />
                                                                </g>
                                                            </svg>
                                                            <span
                                                                class="user-top-menu-name has-transition ml-3">{{ translate('My Wallet') }}</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                                    <a href="{{ route('support_ticket.index') }}"
                                                        class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16.001" viewBox="0 0 16 16.001">
                                                            <g id="Group_25259" data-name="Group 25259"
                                                                transform="translate(-316 -1066)">
                                                                <path id="Subtraction_184" data-name="Subtraction 184"
                                                                    d="M16427.109,902H16420a8.015,8.015,0,1,1,8-8,8.278,8.278,0,0,1-1.422,4.535l1.244,2.132a.81.81,0,0,1,0,.891A.791.791,0,0,1,16427.109,902ZM16420,887a7,7,0,1,0,0,14h6.283c.275,0,.414,0,.549-.111s-.209-.574-.34-.748l0,0-.018-.022-1.064-1.6A6.829,6.829,0,0,0,16427,894a6.964,6.964,0,0,0-7-7Z"
                                                                    transform="translate(-16096 180)" fill="#b5b5bf" />
                                                                <path id="Union_12" data-name="Union 12"
                                                                    d="M16414,895a1,1,0,1,1,1,1A1,1,0,0,1,16414,895Zm.5-2.5V891h.5a2,2,0,1,0-2-2h-1a3,3,0,1,1,3.5,2.958v.54a.5.5,0,1,1-1,0Zm-2.5-3.5h1a.5.5,0,1,1-1,0Z"
                                                                    transform="translate(-16090.998 183.001)"
                                                                    fill="#b5b5bf" />
                                                            </g>
                                                        </svg>
                                                        <span
                                                            class="user-top-menu-name has-transition ml-3">{{ translate('Support Ticket') }}</span>
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="user-top-nav-element border border-top-0" data-id="1">
                                                <a href="{{ route('logout') }}"
                                                    class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="15.999" viewBox="0 0 16 15.999">
                                                        <g id="Group_25503" data-name="Group 25503"
                                                            transform="translate(-24.002 -377)">
                                                            <g id="Group_25265" data-name="Group 25265"
                                                                transform="translate(-216.534 -160)">
                                                                <path id="Subtraction_192" data-name="Subtraction 192"
                                                                    d="M12052.535,2920a8,8,0,0,1-4.569-14.567l.721.72a7,7,0,1,0,7.7,0l.721-.72a8,8,0,0,1-4.567,14.567Z"
                                                                    transform="translate(-11803.999 -2367)"
                                                                    fill="#d43533" />
                                                            </g>
                                                            <rect id="Rectangle_19022" data-name="Rectangle 19022"
                                                                width="1" height="8" rx="0.5"
                                                                transform="translate(31.5 377)" fill="#d43533" />
                                                        </g>
                                                    </svg>
                                                    <span
                                                        class="user-top-menu-name text-primary has-transition ml-3">{{ translate('Logout') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!--Login & Registration -->
                        <span class="d-flex justify-content-center text-dark nav-user-info">
                            <a href="{{ route('user.login') }}"
                                class="text-dark opacity-60 hov-opacity-100 hov-text-dark fs-12 d-inline-block border-right border-soft-light border-width-2 pr-2">{{ translate('Login') }}</a>
                            <a href="{{ route('user.registration') }}"
                                class="text-dark opacity-60 hov-opacity-100 hov-text-dark fs-12 d-inline-block pl-2">{{ translate('Registration') }}</a>
                        </span>
                    @endauth

                    <!-- Cart -->
                    <div class="d-none d-xl-block has-transition" data-hover="dropdown">
                        <div class="nav-cart-box dropdown h-100" id="cart_items">
                            @php
                                $total = 0;
                                $carts = get_user_cart();
                                if (count($carts) > 0) {
                                    foreach ($carts as $key => $cartItem) {
                                        $product = get_single_product($cartItem['product_id']);
                                        $total =
                                            $total +
                                            cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
                                    }
                                }
                            @endphp
                            <!-- Cart button with cart count -->
                            <a href="javascript:void(0)" class="d-flex align-items-center" data-toggle="dropdown"
                                data-display="static" title="{{ translate('Cart') }}">
                                <span class="position-relative d-inline-block">
                                    <i class="las la-shopping-cart fs-28 text-dark"></i>
                                </span>
                            </a>

                            <!-- Cart Items -->
                            <div id="clickCart"
                                class="dropdown-menu dropdown-menu-right dropdown-menu-lg p-0 stop-propagation rounded-0">
                                @if (isset($carts) && count($carts) > 0)
                                    <div class="fs-16 fw-700 text-soft-dark pt-4 pb-2 mx-4 border-bottom"
                                        style="border-color: #e5e5e5 !important;">
                                        {{ translate('Cart Items') }}
                                    </div>
                                    <!-- Cart Products -->
                                    <ul
                                        class="h-300px overflow-auto c-scrollbar-light list-group list-group-flush mx-1">
                                        @foreach ($carts as $key => $cartItem)
                                            @php
                                                $product = get_single_product($cartItem['product_id']);
                                            @endphp
                                            @if ($product != null)
                                                <li class="list-group-item border-0 hov-scale-img">
                                                    <span class="d-flex align-items-center">
                                                        <a href="{{ route('product', $product->slug) }}"
                                                            class="text-reset d-flex align-items-center flex-grow-1">
                                                            <img src="{{ static_asset('assets/img/placeholderx200.webp') }}"
                                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                class="img-fit lazyload size-60px has-transition"
                                                                alt="{{ $product->getTranslation('name') }}"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholderx200.webp') }}';">
                                                            <span class="minw-0 pl-2 flex-grow-1">
                                                                <span
                                                                    class="fw-700 fs-13 text-dark mb-2 text-truncate-2"
                                                                    title="{{ $product->getTranslation('name') }}">
                                                                    {{ $product->getTranslation('name') }}
                                                                </span>
                                                                <span
                                                                    class="fs-14 fw-400 text-secondary">{{ $cartItem['quantity'] }}x</span>
                                                                <span
                                                                    class="fs-14 fw-400 text-secondary">{{ cart_product_price($cartItem, $product) }}</span>
                                                            </span>
                                                        </a>
                                                        <span class="">
                                                            <button onclick="removeFromCart({{ $cartItem['id'] }})"
                                                                class="btn btn-sm btn-icon stop-propagation">
                                                                <i class="la la-close fs-18 fw-600 text-secondary"></i>
                                                            </button>
                                                        </span>
                                                    </span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <!-- Subtotal -->
                                    <div class="px-3 py-2 fs-15 border-top d-flex justify-content-between mx-4"
                                        style="border-color: #e5e5e5 !important;">
                                        <span class="fs-14 fw-400 text-secondary">{{ translate('Subtotal') }}</span>
                                        <span class="fs-16 fw-700 text-dark">{{ single_price($total) }}</span>
                                    </div>
                                    <!-- View cart & Checkout Buttons -->
                                    <div class="py-3 text-center border-top mx-4"
                                        style="border-color: #e5e5e5 !important;">
                                        <div class="row gutters-10 justify-content-center">
                                            <div class="col-sm-6 mb-2">
                                                <a href="{{ route('cart') }}"
                                                    class="btn btn-primary btn-sm btn-block rounded-4 text-white">
                                                    {{ translate('Checkout') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center p-3">
                                        <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                        <h3 class="h6 fw-700">{{ translate('Your Cart is empty') }}</h3>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist -->
                    <div class="d-none d-xl-block" id="wishlist">
                        <a href="{{ route('wishlists.index') }}" class="d-flex align-items-center text-dark"
                            data-toggle="tooltip" data-title="{{ translate('Wishlist') }}" data-placement="top">
                            <span class="position-relative d-inline-block text-dark">
                                <i class="la la-heart fs-20"></i>
                                @if (Auth::check() && count(Auth::user()->wishlists) > 0)
                                    <span
                                        class="badge badge-primary badge-inline badge-pill absolute-top-right--10px">{{ count(Auth::user()->wishlists) }}</span>
                                @endif
                            </span>
                        </a>
                    </div>


                    <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                        <!-- Language switcher -->
                        @if (get_setting('show_language_switcher') == 'on')
                            <li class="list-inline-item dropdown mr-4" id="lang-change">

                                <a class="dropdown-toggle text-secondary fs-12 py-2 c-pointer" data-toggle="dropdown"
                                    data-display="static">
                                    <span class="">{{ $system_language->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    @foreach (get_all_active_language() as $key => $language)
                                        <li>
                                            <a data-flag="{{ $language->code }}"
                                                class="dropdown-item c-pointer @if ($system_language->code == $language->code) active @endif">
                                                <img src="{{ static_asset('assets/img/placeholderx200.webp') }}"
                                                    data-src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}"
                                                    class="mr-1 lazyload" alt="{{ $language->name }}"
                                                    height="11">
                                                <span class="language">{{ $language->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif

                        <!-- Currency Switcher -->
                        @if (get_setting('show_currency_switcher') == 'on')
                            <li class="list-inline-item dropdown ml-auto ml-lg-0 mr-0" id="currency-change">
                                @php
                                    $system_currency = get_system_currency();
                                @endphp

                                <a class="dropdown-toggle text-secondary fs-12 py-2 c-pointer" data-toggle="dropdown"
                                    data-display="static">
                                    {{ $system_currency->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                                    @foreach (get_all_active_currency() as $key => $currency)
                                        <li>
                                            <a class="dropdown-item c-pointer @if ($system_currency->code == $currency->code) active @endif"
                                                data-currency="{{ $currency->code }}">{{ $currency->name }}
                                                ({{ $currency->symbol }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu Bar -->
    <div class="w-100 d-none d-lg-block position-relative bg-primary h-40px">
        <div class="container h-100">
            <div class="d-flex h-100">
                <!-- Categoty Menu Button -->
                <div class="d-none d-xl-block all-category has-transition bg-black-10" id="category-menu-bar">
                    <div class="px-3 h-100"
                        style="padding-top: 6px;padding-bottom: 6px; width:270px; cursor: pointer;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span lang="bd"
                                    class="fw-700 fs-16 text-white mr-3">{{ translate('Categories') }}</span>
                                <a href="{{ route('categories.all') }}" class="text-reset">
                                    <span
                                        class="d-none d-lg-inline-block text-white hov-opacity-80">({{ translate('See All') }})</span>
                                </a>
                            </div>
                            <i class="las la-angle-down text-white has-transition" id="category-menu-bar-icon"
                                style="font-size: 1.2rem !important"></i>
                        </div>
                    </div>
                </div>
                <!-- Header Menus -->
                @php
                    $nav_txt_color =
                        get_setting('header_nav_menu_text') == 'light' || get_setting('header_nav_menu_text') == null
                            ? 'text-white'
                            : 'text-dark';
                @endphp
                <div class="ml-xl-4 w-100 overflow-hidden">
                    <div class="d-flex align-items-center justify-content-center justify-content-xl-start h-100">
                        <ul class="list-inline mb-0 pl-0 hor-swipe c-scrollbar-light">
                            @if (get_setting('header_menu_labels') != null)
                                @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                                    <li class="list-inline-item mr-0 animate-underline-white">
                                        <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}"
                                            class="fs-13 px-3 py-2 d-inline-block fw-700 {{ $nav_txt_color }} header_menu_links hov-bg-black-10
                                        @if (url()->current() == json_decode(get_setting('header_menu_links'), true)[$key]) active @endif">
                                            {{ translate($value) }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <!-- Cart -->
                {{-- <div class="d-none d-xl-block align-self-stretch ml-5 mr-0 has-transition bg-black-10"
                    data-hover="dropdown">
                    <div class="nav-cart-box dropdown h-100" id="cart_items" style="width: max-content;">
                        @include('frontend.' . get_setting('homepage_select') . '.partials.cart')
                    </div>
                </div> --}}
            </div>
        </div>
        <!-- Categoty Menus -->
        <div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 z-3 d-none"
            id="click-category-menu">
            <div class="container">
                <div class="d-flex position-relative">
                    <div class="position-static">
                        @include('frontend.' . get_setting('homepage_select') . '.partials.category_menu')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Top Menu Sidebar -->
<div class="aiz-top-menu-sidebar collapse-sidebar-wrap sidebar-xl sidebar-left d-lg-none z-1035">
    <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-top-menu-sidebar"
        data-same=".hide-top-menu-bar"></div>
    <div class="collapse-sidebar c-scrollbar-light text-left">
        <button type="button" class="btn btn-sm p-4 hide-top-menu-bar" data-toggle="class-toggle"
            data-target=".aiz-top-menu-sidebar">
            <i class="las la-times la-2x text-primary"></i>
        </button>
        @auth
            <span class="d-flex align-items-center nav-user-info pl-4">
                <!-- Image -->
                <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">
                    @if ($user->avatar_original != null)
                        <img src="{{ $user_avatar }}" class="img-fit h-100" alt="{{ translate('avatar') }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                    @else
                        <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image"
                            alt="{{ translate('avatar') }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                    @endif
                </span>
                <!-- Name -->
                <h4 class="h5 fs-14 fw-700 text-dark ml-2 mb-0">{{ $user->name }}</h4>
            </span>
        @else
            <!--Login & Registration -->
            <span class="d-flex align-items-center nav-user-info pl-4">
                <!-- Image -->
                <span
                    class="size-40px rounded-circle overflow-hidden border d-flex align-items-center justify-content-center nav-user-img">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19.902" height="20.012" viewBox="0 0 19.902 20.012">
                        <path id="fe2df171891038b33e9624c27e96e367"
                            d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1.006,1.006,0,1,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1,10,10,0,0,0-6.25-8.19ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z"
                            transform="translate(-2.064 -1.995)" fill="#91919b" />
                    </svg>
                </span>
                <a href="{{ route('user.login') }}"
                    class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block border-right border-soft-light border-width-2 pr-2 ml-3">{{ translate('Login') }}</a>
                <a href="{{ route('user.registration') }}"
                    class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block py-2 pl-2">{{ translate('Registration') }}</a>
            </span>
        @endauth
        <hr>
        <ul class="mb-0 pl-3 pb-3 h-100">
            @if (get_setting('header_menu_labels') != null)
                @foreach (json_decode(get_setting('header_menu_labels'), true) as $key => $value)
                    <li class="mr-0">
                        <a href="{{ json_decode(get_setting('header_menu_links'), true)[$key] }}"
                            class="fs-13 px-3 py-2 w-100 d-inline-block fw-700 text-dark header_menu_links
                        @if (url()->current() == json_decode(get_setting('header_menu_links'), true)[$key]) active @endif">
                            {{ translate($value) }}
                        </a>
                    </li>
                @endforeach
            @endif
            @auth
                @if (isAdmin())
                    <hr>
                    <li class="mr-0">
                        <a href="{{ route('admin.dashboard') }}"
                            class="fs-13 px-3 py-2 w-100 d-inline-block fw-700 text-dark header_menu_links">
                            {{ translate('My Account') }}
                        </a>
                    </li>
                @else
                    <hr>
                    <li class="mr-0">
                        <a href="{{ route('dashboard') }}"
                            class="fs-13 px-3 py-2 w-100 d-inline-block fw-700 text-dark header_menu_links
                            {{ areActiveRoutes(['dashboard'], ' active') }}">
                            {{ translate('My Account') }}
                        </a>
                    </li>
                @endif
                @if (isCustomer())
                    <li class="mr-0">
                        <a href="{{ route('all-notifications') }}"
                            class="fs-13 px-3 py-2 w-100 d-inline-block fw-700 text-dark header_menu_links
                            {{ areActiveRoutes(['all-notifications'], ' active') }}">
                            {{ translate('Notifications') }}
                        </a>
                    </li>
                    <li class="mr-0">
                        <a href="{{ route('wishlists.index') }}"
                            class="fs-13 px-3 py-2 w-100 d-inline-block fw-700 text-dark header_menu_links
                            {{ areActiveRoutes(['wishlists.index'], ' active') }}">
                            {{ translate('Wishlist') }}
                        </a>
                    </li>
                    <li class="mr-0">
                        <a href="{{ route('compare') }}"
                            class="fs-13 px-3 py-2 w-100 d-inline-block fw-700 text-dark header_menu_links
                            {{ areActiveRoutes(['compare'], ' active') }}">
                            {{ translate('Compare') }}
                        </a>
                    </li>
                @endif
                <hr>
                <li class="mr-0">
                    <a href="{{ route('logout') }}"
                        class="fs-13 px-3 py-2 w-100 d-inline-block fw-700 text-primary header_menu_links">
                        {{ translate('Logout') }}
                    </a>
                </li>
            @endauth
        </ul>
        <br>
        <br>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div id="order-details-modal-body">

            </div>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            const categories = @json(get_level_zero_categories()->take(10)->map(function ($category) {
                        return [
                            'name' => $category->name,
                            'imgSrc' => isset($category->catIcon->file_name) ? my_asset($category->catIcon->file_name) : null,
                        ];
                    }));

            let currentIndex = 0;
            const placeholderSpan = $('#dynamic-placeholder');
            const categoryImg = $('#category-image');
            const searchInput = $('#search');
            const placeholderCategory = $('#placeholder_category');

            function updatePlaceholder() {
                placeholderSpan.fadeOut(500, function() {
                    $(this).text(categories[currentIndex].name);
                    if (categories[currentIndex].imgSrc) {
                        categoryImg.attr('src', categories[currentIndex].imgSrc + '?time=' + new Date()
                            .getTime());
                        categoryImg.attr('alt', categories[currentIndex].name);
                        categoryImg.show();
                    } else {
                        categoryImg.hide();
                    }
                    $(this).fadeIn(500);
                });
                currentIndex = (currentIndex + 1) % categories.length;
            }

            updatePlaceholder();
            setInterval(updatePlaceholder, 2000);

            searchInput.on('focus', function() {
                placeholderCategory.hide();
                $(this).attr('placeholder', '');
            }).on('blur', function() {
                if (!$(this).val().trim()) {
                    $(this).attr('placeholder', 'Search for ');
                    placeholderCategory.show();
                }
            });

            placeholderCategory.on('click', function() {
                $(this).hide();
                searchInput.attr('placeholder', '').focus();
            });

            $(document).on('click', function(e) {
                if (!$(e.target).is('#search, #placeholder_category')) {
                    if (!searchInput.val().trim()) {
                        searchInput.attr('placeholder', 'Search for ');
                        placeholderCategory.show();
                    }
                }
            });

            function showOrderDetails(orderId) {
                const modalBody = $('#order-details-modal-body');
                const modalSize = $('#modal-size');

                modalBody.html(null);
                if (!modalSize.hasClass('modal-lg')) {
                    modalSize.addClass('modal-lg');
                }

                $.post('{{ route('orders.details') }}', {
                    _token: '{{ csrf_token() }}',
                    order_id: orderId
                }, function(data) {
                    modalBody.html(data);
                    $('#order_details').modal();
                    $('.c-preloader').hide();
                    AIZ.plugins.bootstrapSelect('refresh');
                }).fail(function() {
                    alert('Error: Could not retrieve order details.');
                });
            }
        });
    </script>
@endsection
