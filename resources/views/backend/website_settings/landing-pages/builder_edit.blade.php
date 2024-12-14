@extends('backend.layouts.app')
@section('content')
    @php
        $htmlContentPath = public_path('landing-pages/' . get_domain() . '/html/' . $landingPage->page_body);
    @endphp

    <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3">{{ translate('Edit Landing Page') }}</h1>
            </div>
        </div>
    </div>
    <div class="card">
        <form action="{{ route('landing-pages.update.builder') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $landingPage->id }}">
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
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            @foreach ($landingPage->landingPageProducts as $landingProduct)
                                                {{ $landingProduct->product_id == $product->id ? 'selected' : '' }} @endforeach>
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
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-2 col-from-label" for="name">{{ translate('Page Content') }} <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div id="gjs"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p class="h5 text-danger text-right pr-4">Click <i class="las la-expand-arrows-alt text-dark"></i> to Edit This Page</p>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary my-3">{{ translate('Update Page') }}</button>
                    </div>                    
                </div>
                <input type="hidden" name="html_content" id="html_content">
                <input type="hidden" name="css_content" id="css_content">
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/grapesjs"></script>
    <script src="https://unpkg.com/grapesjs-blocks-basic"></script>
    <script src="https://unpkg.com/grapesjs-plugin-forms"></script>
    <script src="https://unpkg.com/grapesjs-navbar"></script>
    <script src="https://unpkg.com/grapesjs-plugin-export"></script>
    <script src="https://unpkg.com/grapesjs-tooltip"></script>
    <script type="text/javascript">
        var editor = grapesjs.init({
            container: '#gjs',
            plugins: [
                'gjs-blocks-basic',
                'gjs-plugin-forms',
                'gjs-navbar',
                'gjs-plugin-export',
                'gjs-tooltip',
            ],
            pluginsOpts: {
                'gjs-blocks-basic': {},
                'gjs-plugin-forms': {},
                'gjs-navbar': {},
                'gjs-plugin-export': {
                    addExportBtn: true,
                    btnLabel: 'Export',
                    filenamePfx: 'my-template'
                },
                'gjs-tooltip': {}
            },
            height: '100%',
            fromElement: true,
            storageManager: {
                autoload: 0
            },
            styleManager: {
                sectors: [{
                    name: 'General',
                    open: false,
                    buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom']
                }, {
                    name: 'Flex',
                    open: false,
                    buildProps: ['flex-direction', 'flex-wrap', 'justify-content', 'align-items',
                        'align-content', 'order', 'flex-basis', 'flex-grow', 'flex-shrink', 'align-self'
                    ]
                }, {
                    name: 'Dimension',
                    open: false,
                    buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding'],
                }, {
                    name: 'Typography',
                    open: false,
                    buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color',
                        'line-height', 'text-shadow'
                    ],
                }, {
                    name: 'Decorations',
                    open: false,
                    buildProps: ['border-radius-c', 'background-color', 'border-radius', 'border',
                        'box-shadow', 'background'
                    ],
                }, {
                    name: 'Extra',
                    open: false,
                    buildProps: ['transition', 'perspective', 'transform'],
                }]
            },
        });

        // Set initial content
        editor.setComponents(`@php
            if (file_exists($htmlContentPath)) {
                echo file_get_contents($htmlContentPath);
            }
        @endphp`);

        // Fetch and set the CSS content
        $.get('{{ asset('public/landing-pages/' . get_domain() . '/css/' . $landingPage->page_header) }}', function(data) {
            editor.setStyle(data);
        });

        // Form submission handler
        $('form').submit(function(e) {
            // Prevent the default form submission
            e.preventDefault();

            // Get HTML and CSS from GrapesJS editor
            var htmlContent = editor.getHtml();
            var cssContent = editor.getCss();

            // Set the content to hidden fields
            $('#html_content').val(htmlContent);
            $('#css_content').val(cssContent);

            // Continue with the form submission
            this.submit();
        });

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
