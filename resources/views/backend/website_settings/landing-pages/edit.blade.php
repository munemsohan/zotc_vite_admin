@extends('backend.layouts.app')
@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">{{ translate('Edit Landing Page') }}</h1>
            </div>
        </div>
    </div>
    <div class="card">
        <form action="{{ route('landing-pages.update', $landingPage->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Page Content') }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Page Content') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <textarea class="aiz-text-editor form-control"
                                    data-buttons='[["font", ["bold", "underline", "italic", "clear"]],["para", ["ul", "ol", "paragraph"]],["style", ["style"]],["color", ["color"]],["table", ["table"]],["insert", ["link", "picture", "video"]],["view", ["fullscreen", "codeview", "undo", "redo"]]]'
                                    placeholder="Content.." data-min-height="300" name="page_body" required>{{ $landingPage->page_body }}</textarea>

                                {{-- <textarea class="form-control" name="page_body" cols="30" rows="10">
                                    {{ $landingPage->page_body }}
                                </textarea> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Title') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="{{ translate('Title') }}"
                                    value="{{ $landingPage->title }}" name="title" required
                                    onkeyup="makeSlug(this.value)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Product') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="product_id[]" class="form-control aiz-selectpicker" data-live-search="true"
                                    multiple>
                                    @php
                                        $selectedProductIds = $landingPage->landingPageProducts
                                            ->pluck('product_id')
                                            ->toArray();
                                    @endphp
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ in_array($product->id, $selectedProductIds) ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
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
                                        placeholder="{{ translate('Slug') }}" value="{{ $landingPage->slug }}"
                                        name="slug" id="slug" required>
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
                                            $shipping_info = json_decode($landingPage->shipping_info);
                                        @endphp
                                        @foreach ($shipping_info as $key => $value)
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
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="deleteRow(this)">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-sm btn-success" onclick="addNewShipping()">Add New
                                        +</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Update Page') }}</button>
                    </div>
                </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var currentPage = 4;
        var pagesToShow = 4;


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

        function addNewShipping() {
            var newRowHtml = `
        <tr>
            <td><input type="text" class="form-control" name="shipping_name[]" placeholder="Area Name"></td>
            <td><input type="number" class="form-control" name="shipping_cost[]" placeholder="Shipping Cost"></td>
            <td><button class="btn btn-sm btn-danger" onclick="deleteRow(this)">Delete</button></td>
        </tr>`;
            $('tbody').append(newRowHtml);
        }

        function deleteRow(button) {
            $(button).closest('tr').remove();
        }
    </script>
@endsection
