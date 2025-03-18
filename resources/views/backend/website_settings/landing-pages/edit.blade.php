@extends('backend.layouts.app')
@section('content')
    <style>
        .screen {
            display: block;
            height: 350px;
            overflow: hidden;
            position: relative;
            border: 2px solid #b3b3b3;
            border-radius: 1px;
            margin: 0 auto;
        }

        .screen img {
            width: 100%;
            height: auto;
            position: absolute;
            z-index: 0;
            margin: 0;
            padding: 0;
            transition: transform 7s ease;
        }

        .screen:hover img {
            transform: translateY(calc(-100% + 350px));
        }
    </style>

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">{{ translate('Add New Landing Page') }}</h1>
            </div>
        </div>
    </div>
    <div class="card">
        <form action="{{ route('landing-pages.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Page Content') }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="landing_page_id" value="{{ $landingPage->id }}">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Title') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="{{ translate('Title') }}"
                                    name="title" value="{{ $landingPage->title }}" required
                                    onkeyup="makeSlug(this.value)">
                            </div>
                        </div>

                        <?php
                        $selectedProducts = $landingPage->landingPageProducts->pluck('product_id')->toArray();
                        $selectedProductStatus = $landingPage->landingPageProducts->pluck('is_selected', 'product_id')->toArray();
                        ?>

                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Product') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="product_id[]" id="product_select" class="form-control aiz-selectpicker"
                                    data-live-search="true" multiple required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            @if (in_array($product->id, $selectedProducts)) selected @endif>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="end_time">{{ translate('End Date') }}</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="end_time"
                                    value="{{ $landingPage->end_time ? \Carbon\Carbon::parse($landingPage->end_time)->format('Y-m-d\TH:i') : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Link') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-text">{{ str_replace('admin/', '', url('landing')) }}/</span>
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        value="{{ $landingPage->slug }}" required>
                                </div>
                                <small
                                    class="form-text text-muted">{{ translate('Use character, number, hyphen only') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label">{{ translate('Selected Products') }}</label>
                            <div class="col-sm-10">
                                <ul class="list-group" id="selected_product_list"></ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card-header">
                            <h6 class="fw-600 mb-0">{{ translate('Shipping') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="radio mar-btm mx-2">
                                    <input class="magic-radio shipping_type" type="radio" name="shipping_type"
                                        value="default" {{ $landingPage->shipping_type == 'default' ? 'checked' : '' }}>
                                    <label for="product-shipping">
                                        <span>Default Shipping System</span>
                                    </label>
                                </div>

                                <div class="radio mar-btm mx-2">
                                    <input class="magic-radio shipping_type" type="radio" name="shipping_type"
                                        value="custom" {{ $landingPage->shipping_type == 'custom' ? 'checked' : '' }}>
                                    <label for="product-shipping">
                                        <span>Custom Shipping System</span>
                                    </label>
                                </div>
                            </div>
                            <div class="row"
                                style="display: {{ $landingPage->shipping_type == 'custom' ? 'block' : 'none' }}"
                                id="custom_shipping_div">
                                <table class="table">
                                    <tbody>
                                        @php
                                            $shipping_infos = json_decode($landingPage->shipping_info);
                                        @endphp
                                        @foreach ($shipping_infos as $key => $value)
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="shipping_name[]"
                                                        value="{{ $key }}" placeholder="Area Name">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="shipping_cost[]"
                                                        value="{{ $value }}" placeholder="Shipping Cost">
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="deleteRow(this)">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-sm btn-success" onclick="addNewShipping()">Add
                                        New
                                        +</button>
                                </div>
                            </div>

                            <div class="col-md-12 text-right mt-5 mb-2">
                                <button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var selectedProductStatus = {!! json_encode($selectedProductStatus) !!};

        $(document).ready(function() {
            showSelectedProducts();
        });

        $('.shipping_type').on('change', function() {
            var shipping_type = $(this).val();
            if (shipping_type == 'custom') {
                $('#custom_shipping_div').show();
            } else {
                $('#custom_shipping_div').hide();
            }
        });

        $('#product_select').on('change', function() {
            addSelectedProductRow();
        });

        function addSelectedProductRow() {
            var selectedProducts = $('#product_select option:selected');
            var productList = $('#selected_product_list');
            productList.empty();

            if (selectedProducts.length > 0) {
                selectedProducts.each(function() {
                    var productId = $(this).val();
                    var productName = $(this).text();
                    var isSelected = selectedProductStatus[productId] == 1;

                    var listItem = `
                        <li class="list-group-item d-flex justify-content-start align-items-center">
                            <input type="checkbox" name="is_selected[]" value="${productId}" checked>
                            <label class="ml-2">${productName}</label>
                        </li>
                    `;
                    productList.append(listItem);
                });
            }
        }

        function showSelectedProducts() {
            var selectedProducts = $('#product_select option:selected');
            var productList = $('#selected_product_list');
            productList.empty();

            if (selectedProducts.length > 0) {
                selectedProducts.each(function() {
                    var productId = $(this).val();
                    var productName = $(this).text();
                    var isSelected = selectedProductStatus[productId] == 1;

                    var listItem = `
                        <li class="list-group-item d-flex justify-content-start align-items-center">
                            <input type="checkbox" name="is_selected[]" value="${productId}" ${isSelected ? 'checked' : ''}>
                            <label class="ml-2">${productName}</label>
                        </li>
                    `;
                    productList.append(listItem);
                });
            }
        }

        // Function to add a new shipping row
        function addNewShipping() {
            var newRowHtml = `
                            <tr>
                                <td><input type="text" class="form-control" name="shipping_name[]" placeholder="Area Name"></td>
                                <td><input type="number" class="form-control" name="shipping_cost[]" placeholder="Shipping Cost"></td>
                                <td><button class="btn btn-sm btn-danger" onclick="deleteRow(this)">Delete</button></td>
                            </tr>`;
            $('tbody').append(newRowHtml);
        }

        // Function to delete a row
        function deleteRow(button) {
            $(button).closest('tr').remove();
        }
    </script>
@endsection
