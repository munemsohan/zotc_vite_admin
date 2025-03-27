<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ translate('INVOICE') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <style media="all">
        @page {
            margin: 0;
            padding: 0;
        }

        body,
        html {
            position: relative;
            font-size: 13px !important;
            /* Default font */
            font-family: {{ $font_family }};
            font-weight: normal;
            direction: '{{ $direction }}';
            text-align: '{{ $text_align }}';
            margin: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1 0 auto;
        }

        .footer {
            position: absolute;
            font-size: 12px;
            bottom: 20px;
            left: 0;
            width: 100%;
            padding: 1.5rem;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
        }

        .gry-color,
        .gry-color * {
            color: #000;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th,
        table.padding td {
            padding: .25rem .7rem;
        }

        table.sm-padding td {
            padding: .1rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="content">
        <div style="background: #eceff4;padding: 1rem;">
            <table>
                <tr>
                    <td>
                        @php
                            // Get logo
                            $logo = get_business_setting('header_logo');
                        @endphp
                        @if ($logo != null)
                            <img src="{{ uploaded_asset(get_business_setting('header_logo_white')) }}" height="30"
                                style="display:inline-block;background: white !important;">
                        @else
                            <h1 class="fw-bold">{{ get_business_setting('website_name') }}</h1>
                        @endif
                    </td>
                    <td></td>
                    <td class="text-right strong" style="font-size: 1.5rem;">{{ translate('INVOICE') }}</td>
                </tr>
                <tr>
                    <td class="strong" style="font-size: 1rem;">{{ get_business_setting('website_name') }}</td>
                    <td></td>
                    <td class="text-right strong" style="font-size: 1.2rem;">
                        <span class="strong" style="font-size: 15px;">{{ $order->code }}</span>
                    </td>
                </tr>
                @php
                    $trackingArray = explode('-', $order->tracking_code);
                @endphp
                <tr>
                    <td class="gry-color small">{{ get_business_setting('contact_address', null, session('locale')) }}
                    </td>
                    <td align="center">
                        @if (isset($trackingArray[0]) && !empty($trackingArray[0]))
                            <span>Consignment ID: {{ $trackingArray[0] }}</span>
                        @endif
                    </td>
                    <td align="right">
                        <img src="{{ $barcode }}" alt="barcode">
                    </td>
                </tr>
                <tr>
                    <td class="gry-color small">
                        {{ translate('Email') }}: {{ get_business_setting('contact_email') }}
                    </td>
                    <td align="center">
                        @if (isset($trackingArray[1]) && !empty($trackingArray[1]))
                            <span>Tracking ID: {{ $trackingArray[1] }}</span>
                        @endif
                    </td>
                    <td class="text-right small">
                        <span class="gry-color small">{{ translate('Date') }}:</span>
                        <span class=" strong">{{ date('d-m-Y', $order->date) }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="gry-color small">{{ translate('Phone') }}: {{ get_business_setting('contact_phone') }}
                    </td>
                    <td></td>
                    <td class="text-right small">
                        <span class="gry-color small">{{ translate('Payment') }}:</span>
                        <span
                            class="strong">{{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</span>
                    </td>
                </tr>
                <tr>
                    @php
                        $domains = json_decode(get_zotc_setting('domains'));
                        $custom_domains = $domains->custom_domain;
                        $free_domain = $domains->free_domain;

                        if (!empty($custom_domains)) {
                            // Get the last custom domain
                            $url = end($custom_domains);
                        } else {
                            $url = $free_domain;
                        }
                    @endphp

                    <td class="gry-color small">{{ translate('Website') }}: {{ $url }}</td>
                    <td class="gry-color small"></td>
                    <td class="text-right small">Due:
                        {{ single_price2($order->grand_total - $order->partialPayments->sum('amount')) }} </td>
                </tr>
            </table>
        </div>

        <div style="padding: 1rem;padding-bottom: 0">
            <table>
                @php
                    $shipping_address = json_decode($order->shipping_address);
                @endphp
                <tr>
                    <td class="strong small gry-color">{{ translate('Bill to') }}:</td>
                </tr>
                <tr>
                    <td class="strong" style="font-size: 1.5rem">{{ $shipping_address->name ?? $order->user->name }}</td>
                </tr>
                <tr>
                    <td class="gry-color small">
                        {{ $shipping_address->address ?? '' }},
                        {{ $shipping_address->city ?? '' }},
                        @if (!empty($shipping_address->state))
                            {{ $shipping_address->state }} -
                        @endif
                        {{ $shipping_address->postal_code ?? '' }},
                        {{ $shipping_address->country ?? '' }}
                    </td>
                </tr>
                @if (!empty($shipping_address->email) && !Str::endsWith($shipping_address->email, '@zo.tc'))
                    <tr>
                        <td class="gry-color small">
                            {{ translate('Email') }}: {{ $shipping_address->email }}
                        </td>
                    </tr>
                @endif
                @if (!empty($shipping_address->phone))
                    <tr>
                        <td class="gry-color small">
                            {{ translate('Phone') }}: {{ $shipping_address->phone }}
                        </td>
                    </tr>
                @endif
            </table>
        </div>

        <div style="padding: 1rem;">
            <table class="padding text-left small border-bottom">
                <thead>
                    <tr class="gry-color" style="background: #eceff4;">
                        <th width="35%" class="text-left">{{ translate('Product Name') }}</th>
                        <th width="15%" class="text-left">{{ translate('Delivery Type') }}</th>
                        <th width="10%" class="text-left">{{ translate('Qty') }}</th>
                        <th width="15%" class="text-left">{{ translate('Unit Price') }}</th>
                        @if ($order->orderDetails->sum('tax') > 0)
                            <th width="10%" class="text-left">{{ translate('Tax') }}</th>
                        @endif
                        <th width="15%" class="text-right">{{ translate('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="strong">
                    @foreach ($order->orderDetails as $key => $orderDetail)
                        @if ($orderDetail->product != null)
                            <tr class="">
                                <td>
                                    {{ $orderDetail->product->name }}
                                    @if ($orderDetail->variation != null)
                                        ({{ $orderDetail->variation }})
                                    @endif
                                    <br>
                                    <small>
                                        @php
                                            $product_stock = json_decode($orderDetail->product->stocks->first(), true);
                                        @endphp
                                        {{ translate('SKU') }}: {{ $product_stock['sku'] }}
                                    </small>
                                </td>
                                <td>
                                    @if ($order->shipping_type != null && $order->shipping_type == 'home_delivery')
                                        {{ translate('Home Delivery') }}
                                    @elseif ($order->shipping_type == 'pickup_point')
                                        @if ($order->pickup_point != null)
                                            {{ $order->pickup_point->getTranslation('name') }}
                                            ({{ translate('Pickup Point') }})
                                        @else
                                            {{ translate('Pickup Point') }}
                                        @endif
                                    @elseif ($order->shipping_type == 'carrier')
                                        @if ($order->carrier_id != null)
                                            {{ $order->carrier->name }} ({{ translate('Carrier') }})
                                            <br>
                                            {{ translate('Transit Time') . ' - ' . $order->carrier->transit_time }}
                                        @else
                                            {{ translate('Carrier') }}
                                        @endif
                                    @endif
                                </td>
                                <td class="">{{ $orderDetail->quantity }}</td>
                                <td class="currency">{{ single_price2($orderDetail->price / $orderDetail->quantity) }}
                                </td>
                                @if ($order->orderDetails->sum('tax') > 0)
                                    <td class="currency">
                                        {{ single_price2($orderDetail->tax / $orderDetail->quantity) }}</td>
                                @endif
                                <td class="text-right currency">
                                    {{ single_price2($orderDetail->price + $orderDetail->tax) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <table class="text-right sm-padding small strong">
                <thead>
                    <tr>
                        <th width="60%"></th>
                        <th width="40%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left" style="padding:0 1rem">
                            @php
                            $removedXML = '<?xml version="1.0" encoding="UTF-8"@endphp';
$qrCode = QrCode::size(100)->generate($order->track_url);
$qrCode = str_replace($removedXML, '', $qrCode);
?>
                            {!! $qrCode !!}
                            <p style="margin-top: 10px; font-size: 11px">{{ $order->track_url }}</p>
                        </td>
                        <td>
                            <table class="text-right sm-padding small strong">
                                <tbody>
                                    <tr>
                                        <th class="gry-color text-left">{{ translate('Sub Total') }}</th>
                                        <td class="currency">{{ single_price2($order->orderDetails->sum('price')) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="gry-color text-left">{{ translate('Shipping Cost') }}</th>
                                        <td class="currency">
                                            {{ single_price2($order->orderDetails->sum('shipping_cost')) }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="gry-color text-left">{{ translate('Total Tax') }}</th>
                                        <td class="currency">{{ single_price2($order->orderDetails->sum('tax')) }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="gry-color text-left">{{ translate('Coupon Discount') }}</th>
                                        <td class="currency">{{ single_price2($order->coupon_discount) }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-left strong">{{ translate('Grand Total') }}</th>
                                        <td class="currency">{{ single_price2($order->grand_total) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="footer">
        <div style="float: left; width: 40%; text-align: left; padding-left: 10px;">
            @if (!empty(get_zotc_setting('invoice_footer_logo_link')))
                <img src="{{ get_zotc_setting('invoice_footer_logo_link') }}" height="30"
                    style="display:inline-block; background: white !important;">
            @else
                <img src="https://zo.tc/assets/img/invoice-logo.webp" height="30"
                    style="display:inline-block; background: white !important;">
            @endif
        </div>
        <div style="float: left; width: 55%;">
            <p style="margin-top: 10px; text-align: right;">
                {{ !empty(get_zotc_setting('invoice_footer_text'))
                    ? get_zotc_setting('invoice_footer_text')
                    : 'Instantly Build your eCommerce Website with https://' . get_zotc_setting('central_domain') }}
            </p>
        </div>
    </div>
</body>

</html>
