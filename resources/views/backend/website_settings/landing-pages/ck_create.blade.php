@extends('backend.layouts.app')
@section('content')
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
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
        <form action="{{ route('landing-pages.store.ck') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Page Content') }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Title') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="{{ translate('Title') }}"
                                    name="title" required onkeyup="makeSlug(this.value)">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Product') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="product_id[]" class="form-control aiz-selectpicker" data-live-search="true"
                                    multiple>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Link') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group d-block d-md-flex">
                                    <div class="input-group-prepend ">
                                        <span
                                            class="input-group-text text-sm flex-grow-1 py-0 px-2">{{ route('home') }}/</span>
                                    </div>
                                    <input type="text" class="form-control w-100 w-md-auto"
                                        placeholder="{{ translate('Slug') }}" name="slug" id="slug" required>
                                </div>
                                <small
                                    class="form-text text-muted">{{ translate('Use character, number, hypen only') }}</small>
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
                                        value="default" checked>
                                    <label for="product-shipping">
                                        <span>Default Shipping System</span>
                                    </label>
                                </div>

                                <div class="radio mar-btm mx-2">
                                    <input class="magic-radio shipping_type" type="radio" name="shipping_type"
                                        value="custom">
                                    <label for="product-shipping">
                                        <span>Custom Shipping System</span>
                                    </label>
                                </div>
                            </div>
                            <div class="row" style="display: none" id="custom_shipping_div">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="shipping_name[]"
                                                    value="Inside Dhaka" placeholder="Area Name">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="shipping_cost[]"
                                                    value="60" placeholder="Shipping Cost">
                                            </td>

                                            <td>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="deleteRow(this)">Delete</button>
                                            </td>

                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="shipping_name[]"
                                                    value="Outside Dhaka" placeholder="Area Name">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="shipping_cost[]"
                                                    value="120" placeholder="Shipping Cost">
                                            </td>

                                            <td>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="deleteRow(this)">Delete</button>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-sm btn-success" onclick="addNewShipping()">Add New
                                        +</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div id="editor"></div>
                    </div>

                    <div class="col-md-12 text-center my-2">
                        <button type="submit" class="btn btn-primary">{{ translate('Import Page') }}</button>
                    </div>
                </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script type="text/javascript">
        $('.shipping_type').on('change', function() {
            var shipping_type = $(this).val();
            if (shipping_type == 'custom') {
                $('#custom_shipping_div').show();
            } else {
                $('#custom_shipping_div').hide();
            }
        });

        function makeSlug(page_name) {
            var slug = page_name.trim().replace(/\s+/g, '-').toLowerCase();

            slug = slug.replace(/[^a-z0-9-]/g, '');

            $('#slug').val(slug);
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
