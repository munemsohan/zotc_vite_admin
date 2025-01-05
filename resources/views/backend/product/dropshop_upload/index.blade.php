@extends('backend.layouts.app')

@section('content')
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
    <style>
        .tree ul {
            list-style-type: none;
            margin-left: -22px;
        }

        .tree ul ul {
            margin-left: 5px;
        }

        .tree li {
            margin: 2px 0;
            position: relative;
        }

        .tree li label {
            margin-left: 5px;
        }

        .collapse-btn {
            cursor: pointer;
            margin-right: 5px;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <div class="btn-group">
                <button class="btn btn-sm btn-primary form-button" data-type="category">Import Products</button>
                <button class="btn btn-sm btn-danger form-button" data-type="stock">Update Product stock</button>
            </div>
        </div>
        <div class="card-body">
            <form id="category-form" action="{{ route('upload-dropshop-products') }}" method="POST" style="display: none">
                @csrf
                <!-- Buttons to upload from different databases -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary fetch-categories" data-source="zotc_bds">Import
                                Products from dropshop.com.bd</button>
                        </div>
                        
                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary fetch-categories" data-source="zotc_bdb">Import
                                Products from shopbase.com.bd</button>
                        </div>

                        <div class="col-md-4">
                            <button type="button" class="btn btn-primary fetch-categories" data-source="zotc_bdm">Import
                                Products from mohasagor.com.bd</button>
                        </div>
                        {{-- @for ($i = 3; $i <= 4; $i++) --}}
                            {{-- <div class="col-md-2">
                                <button type="button" class="btn btn-primary fetch-categories">Coming Soon</button>
                            </div> --}}
                        {{-- @endfor --}}
                    </div>
                    <input type="hidden" name="db_source" id="db_source" value="">
                </div>

                <!-- Select All Checkbox -->
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="select-all-categories">
                        {{ translate('Select All Categories and Products') }}
                    </label>
                </div>

                <!-- Dynamic Checkboxes for Categories and Products -->
                <div class="form-group tree">
                    <div class="row" id="category-checkboxes">
                        <!-- Categories will be dynamically inserted here -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <!-- Select for Commission Type -->
                        <div class="form-group">
                            <label for="commission_type">{{ translate('Commission Type') }}</label>
                            <select class="form-control" id="commission_type" name="commission_type">
                                <option value="amount">{{ translate('Flat') }}</option>
                                <option value="percent">{{ translate('Percent') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Input for Commission Amount -->
                        <div class="form-group">
                            <label for="commission_amount">{{ translate('Commission Amount') }}</label>
                            <input type="number" class="form-control" id="commission_amount" name="commission_amount"
                                step="0.01" value="0" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Submit Button -->
                        <button type="submit"
                            class="btn btn-success mt-3">{{ translate('Upload Categories with Products') }}</button>
                    </div>
                </div>
            </form>

            <form id="stock-form" action="{{ route('update-dropshop-products') }}" method="POST" style="display: none">
                @csrf
                <!-- Buttons to upload from different databases -->
                <div class="form-group">
                    <div class="row">
                        {{-- <div class="col-md-4">
                            <button type="button" class="btn btn-danger update-stock" data-source="zotc_bds">Update Stocks
                                from dropshop.com.bd</button>
                        </div> --}}
                        @for ($i = 2; $i <= 4; $i++)
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger update-stock"
                                    data-source="zotc_bds_{{ $i }}">Coming Soon</button>
                            </div>
                        @endfor
                    </div>
                    <input type="hidden" name="db_source" id="stock_db_source" value="">
                </div>
                <div class="row" id="stock_update_div" style="display: none">
                    <div class="col-md-4">
                        <!-- Select for Commission Type -->
                        <div class="form-group">
                            <label for="commission_type">{{ translate('Commission Type') }}</label>
                            <select class="form-control" id="commission_type" name="commission_type">
                                <option value="amount">{{ translate('Flat') }}</option>
                                <option value="percent">{{ translate('Percent') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Input for Commission Amount -->
                        <div class="form-group">
                            <label for="commission_amount">{{ translate('Commission Amount') }}</label>
                            <input type="number" class="form-control" id="commission_amount" name="commission_amount"
                                step="0.01" value="0" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success mt-3">{{ translate('Confirm To Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle forms based on button click
            $('.form-button').on('click', function() {
                $('#category-form, #stock-form').slideUp();
                const type = $(this).data('type');
                if (type === 'category') {
                    $('#category-form').slideDown();
                } else if (type === 'stock') {
                    $('#stock-form').slideDown();
                }
            });

            // Fetch categories based on the data-source attribute of the clicked button
            $('.fetch-categories').on('click', function() {
                var button = $(this);
                var pre_html = button.html();
                button.prop('disabled', true);
                button.html('Loading <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>', true);
                $('#category-checkboxes').empty();
                const source = $(this).data('source');
                $.ajax({
                    url: "{{ route('fetch-dropshop-categories') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        source: source
                    },
                    success: function(data) {
                        if (data.success) {
                            var categoriesHTML = '';
                            data.categories.forEach((category, index) => {
                                categoriesHTML += `<div class="col-md-3">
                                        <span class="collapse-btn"><i class="fas fa-plus-square"></i></span>
                                        <input type="checkbox" id="category-${category.id}" class="category-checkbox" value="${category.id}">
                                        <label class="fw-700">${category.name}</label>
                                        <ul style="display:none">`;

                                category.products.forEach(product => {
                                    categoriesHTML += `<li><div class="d-flex justify-content-left">
                                        <input type="checkbox" name="products[]" class="product-checkbox" data-category-id="${category.id}" value="${product.id}">
                                        <label>${product.name}</label>
                                        </div></li>`;
                                });

                                categoriesHTML += `</ul></div>`;
                            });
                            categoriesHTML += '</div>'; // Close the last row
                            $('#category-checkboxes').append(categoriesHTML);
                            $('#db_source').val(source);
                        } else {
                            alert('{{ translate('Failed to fetch categories') }}');
                        }
                        button.prop('disabled', false);
                        button.html(pre_html);
                    },
                    error: function() {
                        alert(
                        '{{ translate('An error occurred while fetching categories') }}');
                        button.prop('disabled', false);
                    }
                });
            });

            // Select/Deselect all categories and products
            $('#select-all-categories').on('change', function() {
                const isChecked = this.checked;
                $('.category-checkbox, .product-checkbox').prop('checked', isChecked);
            });

            // Select/Deselect all products when a category is selected/deselected
            $('#category-checkboxes').on('change', '.category-checkbox', function() {
                const isChecked = this.checked;
                $(this).siblings('ul').find('.product-checkbox').prop('checked', isChecked);
            });

            // Ensure the select-all checkbox reflects the state of individual checkboxes
            $('#category-checkboxes').on('change', '.product-checkbox', function() {
                const allChecked = $('.product-checkbox').length === $('.product-checkbox:checked').length;
                $('#select-all-categories').prop('checked', allChecked);

                const categoryId = $(this).data('category-id');
                const allProductsChecked = $(`.product-checkbox[data-category-id="${categoryId}"]`)
                    .length === $(`.product-checkbox[data-category-id="${categoryId}"]:checked`).length;
                $(`#category-${categoryId}`).prop('checked', allProductsChecked);
            });

            // Toggle stock submit button visibility
            $('.update-stock').on('click', function() {
                const source = $(this).data('source');
                $('#stock_db_source').val(source);
                $('#stock_update_div').show();
            });

            // Collapse and expand categories
            $('#category-checkboxes').on('click', '.collapse-btn', function() {
                $(this).siblings('ul').toggle();
                $(this).children('i').toggleClass('fa-minus-square fa-plus-square');
            });
        });
    </script>
@endsection
