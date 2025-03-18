@extends('backend.layouts.app')

@section('content')
    <div class="card">
        @can('add_website_page')
            <div class="card-header">
                <h6 class="mb-0 fw-600">{{ translate('Landing Pages') }}</h6>
                <div>
                    <a href="{{ route('landing-pages.create') }}"
                        class="btn btn-circle btn-info">{{ translate('Add Landing Page By Builder') }}</a>
                </div>
            </div>
        @endcan
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('URL') }}</th>
                        <th class="text-right">{{ translate('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($page as $key => $page)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <a href="{{ str_replace('admin/', '', url('landing/' . $page->slug)) }}"
                                    class="text-reset">{{ $page->title }}</a>
                            </td>
                            <td>{{ str_replace('admin/', '', url('landing/' . $page->slug)) }}</td>
                            <td class="text-right">
                                <a href="{{ str_replace('admin/', '', url('landing/' . $page->slug)) }}" target="_blank"
                                    class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                    title="{{ translate('Delete') }}">
                                    <i class="las la-eye"></i>
                                </a>
                                @can('edit_website_page')
                                    <a href="{{ route('landing-pages.edit', $page->id) }}"
                                        class="btn btn-icon btn-circle btn-sm btn-soft-success" title="Edit">
                                        <i class="las la-pen"></i>
                                    </a>

                                    <a href="{{ route('landing-pages.builder.edit', ['code' => $page->slug]) }}"
                                        class="btn btn-icon btn-circle btn-sm btn-soft-warning" title="Builder Edit">
                                        <i class="las la-shapes"></i>
                                    </a>
                                @endcan
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                    data-href="{{ route('landing-pages.delete', $page->id) }} "
                                    title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
