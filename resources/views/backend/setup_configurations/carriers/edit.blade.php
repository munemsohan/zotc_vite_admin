@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Carrier Informations') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('carriers.index') }}" class="btn btn-primary">
                    <span>{{ translate('Back') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Carrier Information') }}</h5>
                </div>
                <div class="card-body">
                    <form id="carrier-form">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul class="m-0"></ul>
                        </div>

                        <input name="_method" type="hidden" value="PATCH">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-2 col-from-label">{{ translate('Carrier Name') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="carrier_name" value="{{ $carrier->name }}"
                                    placeholder="{{ translate('Carrier Name') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-from-label">{{ translate('Transit Time') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="transit_time"
                                    value="{{ $carrier->transit_time }}" placeholder="{{ translate('Transit Name') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-from-label">{{ translate('Logo') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ translate('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                    <input type="hidden" name="logo" class="selected-files"
                                        value="{{ $carrier->logo }}">
                                </div>
                                <div class="file-preview box sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-from-label">{{ translate('Sandbox') }} ? </label>
                            <div class="col-md-9">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="sandbox" @if ($carrier->sandbox == 1) checked @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        @if ($carrier->api_info)
                            @foreach (json_decode($carrier->api_info, true) as $key => $value)
                                <div class="form-group row d-flex sandboxhide"
                                    style="display: {{ $carrier->sandbox == 1 ? 'none' : 'block' }}">
                                    <label class="col-md-2 col-from-label">{{ translate($key) }}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="api_info[{{ $key }}]"
                                            placeholder="{{ translate($key) }}" value="{{ $value }}">
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if ($carrier->id == 1)
                            <div class="row border p-2">
                                <label class="col-md-2 col-from-label">{{ translate('Insert These in this URL:') }}
                                    <a href="https://merchant.pathao.com/courier/developer-api" target="_blank">
                                        https://merchant.pathao.com/courier/developer-api
                                    </a>
                                </label>

                                <!-- Status Update URL -->
                                <div class="col-md-5 form-group d-flex align-items-center mt-2">
                                    <input type="text" id="statusUpdateUrl" value="{{ url('pathao/status-update') }}"
                                        class="form-control w-full" readonly>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="copyToClipboard('statusUpdateUrl')">
                                        <i class="la la-copy"></i>
                                    </button>
                                </div>

                                <!-- Webhook ID -->
                                <div class="col-md-2 form-group d-flex align-items-center mt-2 ml-3">
                                    <input type="text" id="webhookId" value="{{ get_zotc_setting('webhook_id') }}"
                                        class="form-control w-full" readonly>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="copyToClipboard('webhookId')">
                                        <i class="la la-copy"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if ($carrier->id == 2)
                            <div class="row border p-2">
                                <label class="col-md-2 col-from-label">{{ translate('Insert These in this URL:') }}
                                    <a href="https://steadfast.com.bd/user/webhook/add" target="_blank">
                                        https://steadfast.com.bd/user/webhook/add
                                    </a>
                                </label>

                                <!-- Status Update URL -->
                                <div class="col-md-5 form-group d-flex align-items-center mt-2">
                                    <input type="text" id="statusUpdateUrl" value="{{ url('steadfast/status-update') }}"
                                        class="form-control w-full" readonly>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="copyToClipboard('statusUpdateUrl')">
                                        <i class="la la-copy"></i>
                                    </button>
                                </div>

                                <!-- Webhook ID -->
                                <div class="col-md-2 form-group d-flex align-items-center mt-2 ml-3">
                                    <input type="text" id="webhookId" value="{{ get_zotc_setting('webhook_id') }}"
                                        class="form-control w-full" readonly>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="copyToClipboard('webhookId')">
                                        <i class="la la-copy"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <script>
                            function copyToClipboard(elementId) {
                                var copyText = $('#' + elementId);
                                copyText.select();
                                copyText[0].setSelectionRange(0, 99999);
                                document.execCommand("copy");

                                alert("Copied to clipboard: " + copyText.val());
                            }
                        </script>

                        <div class="form-group row mt-2">
                            <label class="col-md-2 col-from-label">{{ translate('Free Shipping') }} ? </label>
                            <div class="col-md-9">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="shipping_type" onchange="freeShipping(this)"
                                        id="shipping_type" @if ($carrier->free_shipping == 1) checked @endif>
                                    <span></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row" id="billing_type_section">
                            <label class="col-md-2 col-from-label">{{ translate('Billing Type') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control aiz-selectpicker" name="billing_type"
                                    onchange="update_price_range_form()"
                                    data-selected="{{ $carrier->carrier_ranges->first()->billing_type ?? '' }}"
                                    id="billing_type" data-live-search="true">
                                    <option value="weight_based">{{ translate('According to Weight') }}</option>
                                    <option value="price_based">{{ translate('According to Price') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="button" class="btn btn-primary"
                                id="carrier-submit-btn">{{ translate('Update Carrier Informations') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            update_price_range_form();
            freeShipping();

            $('input[name="sandbox"]').on('change', function() {
                sandbox(this);
            });
        });

        function sandbox(el) {
            if (el.checked) {
                $(".sandboxhide").hide();
            } else {
                $(".sandboxhide").show();
            }
        }

        function freeShipping() {
            var billing_type = "{{ $carrier->carrier_ranges->first()->billing_type ?? 'weight_based' }}";
            if ($('#shipping_type').is(":checked")) {
                $("#billing_type_section").hide();
                $("#price_range_form").hide();
                $("#billing_type").val('').change();
            } else {
                $("#billing_type_section").show();
                $("#price_range_form").show();
                $("#billing_type").val(billing_type).change();
            }
        }

        function update_price_range_form() {
            var billing_type = $('#billing_type').val();

            $(".carrier_range_form_header_text").html(billing_type === 'weight_based' ?
                "{{ translate('Weight based carrier price range') }}" :
                "{{ translate('Price based carrier price range') }}");
            $(".price_range_text").html(billing_type === 'weight_based' ?
                "{{ translate('Will be applied when the weight is') }}" :
                "{{ translate('Will be applied when the price is') }}");
            $(".bill_based_on").html(billing_type === 'weight_based' ? "{{ translate('kg') }}" : "$");
        }

        $(document).on("change", ".zone_enable", function() {
            $(this).closest("tr").find('.shipping_cost').prop("disabled", !this.checked);
        });

        $(document).on("click", "#addNewRange", function() {
            var tablebody = $("#price-range-table").find("tbody");
            var lastRow = tablebody.find("tr:last");
            var lastInput = lastRow.find("td:last input");

            if (!lastInput.val() || parseFloat(lastInput.val()) <= 0) {
                alert('Please validate the last range before creating a new one.');
                return;
            }

            var newRow = lastRow.clone();
            newRow.find("input").val('');
            tablebody.append(newRow);
        });

        $(document).on("click", ".delete-range", function() {
            $(this).closest("tr").remove();
        });

        $("#carrier-submit-btn").click(function() {
            var data = new FormData($('#carrier-form')[0]);

            if (!$('input[name=shipping_type]').prop('checked')) {
                var delimiter1 = $('.delimiter1');
                var delimiter2 = $('.delimiter2');
                for (let i = 0; i < delimiter1.length; i++) {
                    if (delimiter1[i].value && delimiter2[i].value) {
                        if (parseFloat(delimiter1[i].value) >= parseFloat(delimiter2[i].value)) {
                            alert('Please put the last range greater than the first range.');
                            delimiter2[i].focus();
                            return false;
                        }
                        if (i > 0 && (parseFloat(delimiter1[i].value) != parseFloat(delimiter2[i - 1].value))) {
                            alert('Please put the first range equal to the previous last range.');
                            delimiter1[i].focus();
                            return false;
                        }
                    }
                }
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ route('carriers.update', $carrier->id) }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    window.location.replace("{{ route('carriers.index') }}");
                },
                error: function(jqXHR) {
                    $(".print-error-msg").find("ul").html('');
                    $(".print-error-msg").css('display', 'block');
                    $.each(jqXHR.responseJSON.errors, function(key, value) {
                        $(".print-error-msg").find("ul").append('<li>' + value[0] + '</li>');
                    });

                    $("html, body").animate({ scrollTop: 0 }, 800);
                }
            });
        });
    </script>
@endsection
