@extends('backend.layouts.app')

@section('content')
    <style>
        .show_div {
            padding: 2px 10px;
            margin-left: 10px;
        }

        /* Add SVG icon inside the button using ::before */
        .show_div::before {
            content: "";
            display: inline-block;
            width: 12px;
            height: 8px;
            background-image: url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2250%22%20height%3D%2250%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22M4%208l8%208%208-8%22%20%2F%3E%3C%2Fsvg%3E');
            background-size: cover;
        }

        /* Style for the Hide button */
        .hide_div {
            padding: 2px 10px;
            margin-left: 10px;
        }

        /* Add SVG icon inside the button using ::before */
        .hide_div::before {
            content: "";
            display: inline-block;
            width: 12px;
            height: 8px;
            background-image: url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpath%20d%3D%22M19%2015l-7-7-7%207%22%20%2F%3E%3C%2Fsvg%3E');
            background-size: cover;
        }
    </style>

    <div class="row">
        {{-- homepage settings --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6>Homepage Settings</h6>

                    <button data-div="homepage_settings_div"
                        class="div_toggle_btn btn btn-soft-blue btn-sm show_div"></button>
                </div>
            </div>
        </div>

        {{-- header --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6>Header</h6>
                    <button data-div="header_div" class="div_toggle_btn btn btn-soft-blue btn-sm show_div"></button>
                </div>
            </div>
        </div>


        <div id="homepage_settings_div" class="col-md-12 d-none">
            @include('backend.website_settings.pages.classic.home_page_edit')
        </div>

        <div id="header_div" class="col-md-12 d-none">
            @include('backend.website_settings.header')
        </div>
    </div>

    
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.div_toggle_btn').click(function() {
                var divId = $(this).data('div');
                $('#' + divId).toggleClass('d-none');
                $(this).toggleClass('show_div hide_div');
            });
        });
    </script>
@endsection
