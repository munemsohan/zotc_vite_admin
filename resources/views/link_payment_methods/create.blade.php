@extends('backend.layouts.app')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Link Payment Information') }}</h5>
            </div>

            <form action="{{ route('manual_payment_methods.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-from-label" for="type">{{ translate('Type') }}</label>
                        <div class="col-sm-10">
                            <select class="form-control aiz-selectpicker" name="type" id="type" required>
                                <option value="link_payment">{{ translate('Link Payment') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-from-label" for="name">{{ translate('Name') }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="heading" value="" placeholder="Name"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label" for="signinSrEmail">{{ translate('Checkout Thumbnail') }}
                            (438x235)px</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="false">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="photo" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-from-label">{{ translate('Payment Link') }}</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="description" placeholder="https://shop.bkash.com/***********/paymentlink/default-payment"></textarea>
                        </div>
                    </div>
                    <div class="form-group mb-3 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
