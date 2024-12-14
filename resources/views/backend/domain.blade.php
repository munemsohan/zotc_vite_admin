@extends('backend.layouts.app')

@section('content')
    <style>
        .pay_btn:hover {
            border: 2px solid rgb(60, 255, 0) !important;
        }

        .text-decoration-line-through {
            text-decoration: line-through;
        }
    </style>

    <div class="row gutters-16">
        <div class="col-lg-12">
            <div class="row gutters-16">
                <div class="col-md-4">
                    <div class="dashboard-box bg-white h-230px mb-2rem overflow-hidden">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    @php
                                        $customDomain = null;
                                        $customDomains = json_decode(get_business_setting('domains'));

                                        if (isset($domains->custom_domain)) {
                                            $customDomains = $domains->custom_domain;
                                            $customDomain = $customDomains[0];
                                        }
                                        $freeDomain = $domains->free_domain;

                                    @endphp
                                    {!! QrCode::size(100)->generate($customDomain ? $customDomain : $freeDomain) !!}
                                    <p class="mt-2">Scan the QR code <br> to visit your shop</p>
                                </div>
                            </div>

                            <div class="col-6 text-center">
                                <b>Shop Address: </b>
                                <br>
                                <a target="_blank" href="//{{ $freeDomain }}">{{ $freeDomain }}</a>
                                <button class="btn px-1 py-0"><i class="la la-copy"></i></button>
                                @if ($domains->custom_domain)
                                    @foreach ($customDomains as $custom_domain)
                                        <br>
                                        <a target="_blank" href="//{{ $custom_domain }}">{{ $custom_domain }}</a>
                                        <button class="btn px-1 py-0"><i class="la la-copy"></i></button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="dashboard-box bg-white h-230px mb-2rem overflow-hidden">
                        <div class="row">
                            {{-- <div class="col-md-2 d-flex align-items-center">
                                    <img src="{{ static_asset('assets/img/www.svg') }}" width="100%">
                                </div> --}}

                            <div class="col-md-12">
                                <b>Buy or connect a domain</b>

                                <p>
                                    Secure the perfect domain for your store that customers can trust and find
                                    easily. Buy a new domain from Shopify, or connect a domain you already purchased from a
                                    third-party like Google Domains or GoDaddy.
                                </p>

                                <div class="btn-group">
                                    <button class="btn btn-sm btn-dark" id="buy_new_domain">
                                        Buy New Domain
                                    </button>
                                    <button class="btn btn-sm btn-secondary border-dark" id="transfer_domain_btn">
                                        Transfer
                                    </button>
                                    <button class="btn btn-sm btn-light border-dark" id="connect_existing_domain">
                                        Connect Existing Domain
                                    </button>
                                </div>

                                <div class="input-group mt-3" id="buy_new_domain_input" style="display: none">
                                    <input type="text" class="form-control" name="custom_domain" id="custom_domain"
                                        placeholder="Type Your Domain Name" value="{{ old('custom_domain') }}"
                                        onchange="checkDomain()">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary input-group-text" onclick="checkDomain()">
                                            <i class="la la-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="input-group mt-3" id="connect_existing_domain_input" style="display: none">
                                    <form class="w-100" action="{{ route('admin.dashboard.connect.custom.domain') }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="custom_domain"
                                                placeholder="Custom Domain" value="{{ old('custom_domain') }}" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-primary input-group-text" type="submit">
                                                    {{ __('Connect') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="input-group mt-3" id="transfer_input" style="display: none">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="transfer_domain"
                                            id="transfer_domain" placeholder="Type your Domain Name eg: abc.com"
                                            value="{{ old('transfer_domain') }}" required>
                                        <input type="text" class="form-control" name="epp_code" id="epp_code"
                                            placeholder="Type your EPP Code" value="{{ old('epp_code') }}" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-primary input-group-text" type="button"
                                                onclick="checkTransferDomain()">
                                                {{ __('Transfer') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-100" id="loading_indicator" style="display: none;">
                                    Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" id="buy_new_domain_div" style="display: none;">
            <div class="card">
                <div class="card-header">
                    Buy New Domain
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover text-center"
                                id="domain_status_list">
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" id="connect_existing_domain_div" style="display: none;">
            <div class="card">
                <div class="card-header">
                    Connect Existing Domain
                </div>
                <form action="{{ route('admin.dashboard.connect.custom.domain') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="custom_domain_para">
                                    Before sending request for your custom domain, You need to add CNAME records (given
                                    in
                                    below table) in your custom domain from your domain registrar account (like -
                                    namecheap,
                                    godaddy etc...).
                                    CNAME records are needed to point your custom domain to our domain ( nazmart.net ),
                                    so
                                    that our website can show your website on your custom domain
                                    Different domain registrar (like - godaddy, namecheap etc...) has different
                                    interface
                                    for adding CNAME records. If you cannot find the place to add CNAME record in your
                                    domain registrar account, then please contact your domain registrar support, they
                                    will
                                    show you the place to add CNAME record for your custom domain. They can also help
                                    you
                                    with adding CNAME record for you.</p>

                                <h5 class="custom_domain_title_two mt-4">
                                    Add CNAME records (take data from below table) in your custom domain from your domain
                                    registrar panel:</h5>
                                <div class="custom_domain_table mt-4">
                                    <table class="table table-default table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Host') }}</th>
                                                <th>{{ __('Value') }}</th>
                                                <th>{{ __('TTL') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ __('CNAME Record') }}</td>
                                                <td>www</td>
                                                <td>zotc.xyz</td>
                                                <td>{{ __('Automatic') }}</td>
                                            </tr>


                                            <tr>
                                                <td>{{ __('CNAME Record') }}</td>
                                                <td>@</td>
                                                <td>zotc.xyz</td>
                                                <td>{{ __('Automatic') }}</td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">
                                                    <b>{{ __('Use this if you are using cloulflare') }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>A Record</td>
                                                <td>@</td>
                                                <td>109.123.233.80</td>
                                                <td>Automatic</td>
                                            </tr>
                                            <tr>
                                                <td>A Record</td>
                                                <td>www</td>
                                                <td>109.123.233.80</td>
                                                <td>Automatic</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><b>Use this if you can change Nameserver</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nameserver1</td>
                                                <td>ns1.zotc.xyz</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Nameserver2</td>
                                                <td>ns2.zotc.xyz</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12" id="transfer_domain_div" style="display: none;">
            <div class="card">
                <div class="card-header">
                    Transfer Domain
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered table-hover text-center"
                                id="transfer_domain_status_list">
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function checkDomain() {
            var domain = $('#custom_domain').val();

            $('#domain_status_list tbody').empty();

            if (domain) {
                // Show loading indicator
                $('#loading_indicator').show();

                $('#buy_new_domain_div').slideDown();

                $.ajax({
                    url: "{{ url('checkCustomDomain') }}/" + domain,
                    method: 'GET',
                    success: function(response) {
                        var domainPrices = {
                            ".com": {
                                price_bdt: "1250 BDT",
                                discount_bdt: "1200 BDT"
                            },
                            ".xyz": {
                                price_bdt: "1450 BDT",
                                discount_bdt: "320 BDT"
                            },
                            ".net": {
                                price_bdt: "1500 BDT",
                                discount_bdt: "1350 BDT"
                            },
                            ".top": {
                                price_bdt: "800 BDT",
                                discount_bdt: "250 BDT"
                            },
                            ".app": {
                                price_bdt: "1700 BDT",
                                discount_bdt: "700 BDT"
                            },
                            ".info": {
                                price_bdt: "2200 BDT",
                                discount_bdt: "450 BDT"
                            },
                            ".biz": {
                                price_bdt: "2400 BDT",
                                discount_bdt: "700 BDT"
                            },
                            ".live": {
                                price_bdt: "2900 BDT",
                                discount_bdt: "440 BDT"
                            },
                            ".shop": {
                                price_bdt: "3500 BDT",
                                discount_bdt: "220 BDT"
                            },
                            ".online": {
                                price_bdt: "3500 BDT",
                                discount_bdt: "240 BDT"
                            },
                            ".co": {
                                price_bdt: "3500 BDT",
                                discount_bdt: "1270 BDT"
                            },
                            ".site": {
                                price_bdt: "3500 BDT",
                                discount_bdt: "430 BDT"
                            },
                            ".io": {
                                price_bdt: "5200 BDT",
                                discount_bdt: "4000 BDT"
                            },
                            ".store": {
                                price_bdt: "5200 BDT",
                                discount_bdt: "240 BDT"
                            },
                            ".shopping": {
                                price_bdt: "3100 BDT",
                                discount_bdt: "1070 BDT"
                            },
                            ".gifts": {
                                price_bdt: "3100 BDT",
                                discount_bdt: "750 BDT"
                            },
                            ".supply": {
                                price_bdt: "2220 BDT",
                                discount_bdt: "2120 BDT"
                            },
                            ".zone": {
                                price_bdt: "750 BDT",
                                discount_bdt: "340 BDT"
                            },
                            ".boutique": {
                                price_bdt: "3100 BDT",
                                discount_bdt: "440 BDT"
                            },
                            ".pro": {
                                price_bdt: "2200 BDT",
                                discount_bdt: "380 BDT"
                            }
                        };

                        // Construct table row for the provided domain
                        var row = `<tr>
    <td>${domain}.com.bd</td>
    <td class="fw-bold text-success">Available</td>
    <td>
        <span class="text-decoration-line-through">2000 BDT</span>
        <br>
        <span class="text-success">1800 BDT</span>
    </td>
    <td>
        <button type="button" class="btn btn-primary" onclick="showPaymentDiv('${domain}.com.bd')">Buy Now</button>
        <div class="form-group mt-2" id="${domain}.com.bd" style="display: none">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="buyDomain('${domain}.com.bd', '1800 BDT', 'bkash')">
                    <img src="{{ url('public/assets/img/cards/bkash.png') }}" width="50px" alt="bKash">
                </button>
                <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="buyDomain('${domain}.com.bd', '1800 BDT', 'visa')">
                    <img src="{{ url('public/assets/img/cards/visa.webp') }}" width="100px" alt="bKash">
                </button>
                <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="buyDomain('${domain}.com.bd', '1800 BDT', 'paddle')">
                    <img src="{{ url('public/assets/img/cards/paypal.webp') }}" width="100px" alt="bKash">
                </button>
            </div>
        </div>
    </td>
</tr>`;

                        $('#domain_status_list tbody').append(row);

                        Object.keys(domainPrices).forEach(function(extension) {
                            var domainPrice = domainPrices[extension];
                            var domainName = domain + extension;

                            var statusClass = response[domainName].status === 'available' ?
                                'text-success' : 'text-danger';
                            var statusText = response[domainName].status === 'available' ? 'Available' :
                                'Not Available';

                            var buyButton = response[domainName].status === 'available' ? `
        <button type="button" class="btn btn-primary" onclick="showPaymentDiv('${domainName}')">Buy Now</button>
        <div class="form-group mt-2" id="${domainName}" style="display: none">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="buyDomain('${domainName}', '${domainPrice.price_bdt}', 'bkash')">
                    <img src="{{ url('public/assets/img/cards/bkash.png') }}" width="50px" alt="bKash">
                </button>
                <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="buyDomain('${domainName}', '${domainPrice.price_bdt}', 'visa')">
                    <img src="{{ url('public/assets/img/cards/visa.webp') }}" width="100px" alt="bKash">
                </button>
                <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="buyDomain('${domainName}', '${domainPrice.price_bdt}', 'paddle')">
                    <img src="{{ url('public/assets/img/cards/paypal.webp') }}" width="100px" alt="bKash">
                </button>
            </div>
        </div>
    ` : '';

                            var row = `
        <tr>
            <td>${domainName}</td>
            <td class="fw-bold ${statusClass}">${statusText}</td>
            <td>
                <span class="text-decoration-line-through">${domainPrice.price_bdt} BDT</span>
                <br>
                <span class="text-success">${domainPrice.discount_bdt} BDT</span>
            </td>
            <td>${buyButton}</td>
        </tr>
    `;

                            $('#domain_status_list tbody').append(row);
                        });

                    },
                    complete: function() {
                        $('#loading_indicator').hide();
                    }
                });
            } else {
                console.log("Domain not provided");
            }
        }

        function checkTransferDomain() {
            var domain = $('#transfer_domain').val();
            var epp_code = $('#epp_code').val();

            $('#transfer_domain_status_list tbody').empty();

            if (domain) {
                // Show loading indicator
                $('#loading_indicator').show();
                $('#transfer_domain_div').slideDown();

                $.ajax({
                    url: "{{ url('checkCustomDomain') }}/" + domain,
                    method: 'GET',
                    success: function(response) {
                        var domainPrices = {
                            ".com": {
                                price_bdt: "1250 BDT"
                            },
                            ".xyz": {
                                price_bdt: "1450 BDT"
                            },
                            ".net": {
                                price_bdt: "1500 BDT"
                            },
                            ".top": {
                                price_bdt: "800 BDT"
                            },
                            ".app": {
                                price_bdt: "1700 BDT"
                            },
                            ".info": {
                                price_bdt: "2200 BDT"
                            },
                            ".biz": {
                                price_bdt: "2400 BDT"
                            },
                            ".live": {
                                price_bdt: "2900 BDT"
                            },
                            ".shop": {
                                price_bdt: "3500 BDT"
                            },
                            ".online": {
                                price_bdt: "3500 BDT"
                            },
                            ".co": {
                                price_bdt: "3500 BDT"
                            },
                            ".site": {
                                price_bdt: "3500 BDT"
                            },
                            ".io": {
                                price_bdt: "5200 BDT"
                            },
                            ".store": {
                                price_bdt: "5200 BDT"
                            },
                            ".shopping": {
                                price_bdt: "3100 BDT"
                            },
                            ".gifts": {
                                price_bdt: "3100 BDT",
                                discount_bdt: "750 BDT"
                            },
                            ".supply": {
                                price_bdt: "2220 BDT"
                            },
                            ".zone": {
                                price_bdt: "750 BDT"
                            },
                            ".boutique": {
                                price_bdt: "3100 BDT"
                            },
                            ".pro": {
                                price_bdt: "2200 BDT"
                            }
                        };

                        Object.keys(response).forEach(function(domainName) {
                            var extension = '.' + domainName.split('.').pop();
                            var domainPrice = domainPrices[extension];

                            if (domainPrice) {
                                var statusClass = response[domainName].status === 'available' ?
                                    'text-success' : 'text-danger';
                                var statusText = response[domainName].status === 'available' ?
                                    'Available' : 'Not Available';

                                var buyButton = response[domainName].status === 'available' ? `
                            <button type="button" data-price_bdt="${domainPrice.price_bdt}" data-domain="${domainName}" class="btn btn-primary" onclick="showPaymentDiv('${domainName}')">Buy Now</button>
                            <div class="form-group mt-2" id="${domainName}" style="display: none">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="transferDomain('${domainName}', '${epp_code}', '${domainPrice.price_bdt}', 'bkash')">
                                        <img src="{{ url('public/assets/img/cards/bkash.png') }}" width="50px" alt="bKash">
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="transferDomain('${domainName}', '${epp_code}', '${domainPrice.price_bdt}', 'visa')">
                                        <img src="{{ url('public/assets/img/cards/visa.webp') }}" width="100px" alt="bKash">
                                    </button>
                                    
                                </div>
                            </div>
                        ` : '';

                                var row = `
                            <tr>
                                <td>${domainName}</td>
                                <td class="fw-bold ${statusClass}">${statusText}</td>
                                <td>
                                    <span class="text-success">${domainPrice.price_bdt} BDT</span>
                                </td>
                                <td>${buyButton}</td>
                            </tr>
                        `;

                                $('#transfer_domain_status_list tbody').append(row);
                            }
                        });
                    },
                    complete: function() {
                        $('#loading_indicator').hide();
                    },
                    error: function() {
                        $('#loading_indicator').hide();
                        AIZ.plugins.notify('danger',
                            'An error occurred while checking the domain status. Please try again.');
                    }
                });
            } else {
                AIZ.plugins.notify('danger', 'Domain not provided');
            }
        }


        function showPaymentDiv(domain) {
            var escapedDomain = domain.replace(/\./g, '\\.');
            $('#' + escapedDomain).slideToggle();
        }

        function buyDomain(domain, price_bdt, gateway) {

            var price_bdt_amount = price_bdt.replace(' BDT', '');

            // Create a hidden form
            var form = $('<form>', {
                'action': "{{ url('buy-domain-by-gateway') }}",
                'method': 'POST',
                'style': 'display: none;'
            });

            form.append($('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': '{{ csrf_token() }}'
            }));

            // Add input fields for POST data
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'gateway',
                'value': gateway
            }));

            // Add input fields for POST data
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'domain',
                'value': domain
            }));

            // Add input fields for POST data
            form.append($('<input>', {
                'type': 'hidden',
                'name': 'price_bdt',
                'value': price_bdt_amount
            }));

            // Append the form to the body and submit it
            $('body').append(form);
            form.submit();
        }

        function transferDomain(domain, epp_code, price_bdt, gateway) {

            var price_bdt_amount = price_bdt.replace(' BDT', '');
            var epp_code = $('#epp_code').val();

            if (epp_code) {
                // Create a hidden form
                var form = $('<form>', {
                    'action': "{{ url('buy-domain-by-gateway') }}",
                    'method': 'POST',
                    'style': 'display: none;'
                });

                form.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '{{ csrf_token() }}'
                }));

                // Add input fields for POST data
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'gateway',
                    'value': gateway
                }));

                // Add input fields for POST data
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'domain',
                    'value': domain
                }));

                // Add input fields for POST data
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'epp_code',
                    'value': epp_code
                }));

                // Add input fields for POST data
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'price_bdt',
                    'value': price_bdt_amount
                }));

                // Append the form to the body and submit it
                $('body').append(form);
                form.submit();
            } else {
                AIZ.plugins.notify('danger', 'Epp Code is not given');
            }
        }

        $(document).ready(function() {
            function hideAllSections() {
                $('#buy_new_domain_input, #buy_new_domain_div, #connect_existing_domain_input, #connect_existing_domain_div, #transfer_input, #transfer_domain_div')
                    .slideUp();
            }

            function toggleBuyNewDomainSection() {
                hideAllSections();
                $('#buy_new_domain_input').slideToggle();
            }

            function toggleConnectExistingDomainSection() {
                hideAllSections();
                $('#connect_existing_domain_input, #connect_existing_domain_div').slideToggle();
            }

            function toggleTransferDomainSection() {
                hideAllSections();
                $('#transfer_input').slideToggle();
            }

            $('#buy_new_domain').click(toggleBuyNewDomainSection);
            $('#connect_existing_domain').click(toggleConnectExistingDomainSection);
            $('#transfer_domain_btn').click(toggleTransferDomainSection);
        });
    </script>
@endsection
