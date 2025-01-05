@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Facebook Boosting/Add Account') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('facebook-boost.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 control-label"
                                for="name">{{ translate('Your Facebook Profile link') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Your Facebook Profile link') }}"
                                    id="profile_link" name="profile_link" class="form-control" required>
                                <span class="small text-muted">(where you want to get access of the account, eg:
                                    https://www.facebook.com/*****)</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="name">{{ translate('Phone Number') }}</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ translate('Phone Number') }}" id="phone"
                                    name="phone" class="form-control" value="{{ auth()->user()->phone }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="name">{{ translate('Dollar Amount') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control py-1" id="amount" name="amount" required>
                                    <option value="20">$20</option>
                                    <option value="50">$50</option>
                                    <option value="100">$100</option>
                                    <option value="1000">$1000</option>
                                </select>

                                <span class="small text-muted">(that you want initially)</span>
                            </div>
                        </div>

                        <div class="row px-5">
                            <div class="col-md-12 py-0">
                                <p class="my-0"><strong>Per 1$=122 tk+15% Tax</strong></p>
                                <p class="my-0" id="total-amount">So you have to pay for $20+15% Tax = <strong>2806
                                        Taka</strong></p>
                            </div>

                            <div class="col-md-6 py-0">
                                <h5 class="mt-3">Bank Payment Info:</h5>
                                <ul>
                                    <li><strong>Account Number:</strong> 1401807751001</li>
                                    <li><strong>Account Name:</strong> W3Space Technologies</li>
                                    <li><strong>Bank Name:</strong> The City Bank Limited</li>
                                    <li><strong>Bank Branch:</strong> Kawran Bazar Branch</li>
                                </ul>
                                <ul>
                                    <li><strong>Account Number:</strong> 1351100023425</li>
                                    <li><strong>Account Name:</strong> W3Space Technologies</li>
                                    <li><strong>Bank Name:</strong> Dutch Bangla Bank</li>
                                    <li><strong>Bank Branch:</strong> Rajshahi</li>
                                </ul>
                            </div>

                            <div class="col-md-6 my-0">
                                <h5 class="mt-3">Mobile Payment Info:</h5>
                                <ul>
                                    <li id="bkash"><strong>Bkash:</strong> 01872739977 (payment with extra 1.5%) =
                                        <strong>2848
                                            Taka</strong>
                                    </li>
                                    <li id="rocket"><strong>Rocket:</strong> 01872739977 (payment with extra 1%) =
                                        <strong>2835
                                            Taka</strong>
                                    </li>
                                    <li id="nagad"><strong>Nagad:</strong> 01872739977 (payment with extra 1.25%) =
                                        <strong>2842
                                            Taka</strong>
                                    </li>
                                    <li id="send-money"><strong>Bkash/Rocket/Nagad:</strong> 01719023450 (send money with
                                        extra
                                        1.25%) =
                                        <strong>2842 Taka</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="name">{{ translate('Comment') }}</label>
                            <div class="col-sm-9">
                                <textarea type="text" placeholder="{{ translate('Comment') }}" id="comment" name="comment" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Order Now') }}</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#amount').change(function() {
                var amount = $(this).val();
                var totalAmount, bkash, rocket, nagad, sendMoney;

                switch (amount) {
                    case '20':
                        totalAmount = 2806;
                        bkash = 2848;
                        rocket = 2835;
                        nagad = 2842;
                        sendMoney = 2842;
                        break;
                    case '50':
                        totalAmount = 7015;
                        bkash = 7121;
                        rocket = 7086;
                        nagad = 7103;
                        sendMoney = 7103;
                        break;
                    case '100':
                        totalAmount = 14030;
                        bkash = 14241;
                        rocket = 14171;
                        nagad = 14206;
                        sendMoney = 14206;
                        break;
                    case '1000':
                        totalAmount = 140300;
                        bkash = 142410;
                        rocket = 141710;
                        nagad = 142060;
                        sendMoney = 142060;
                        break;
                }

                $('#total-amount').html('So you have to pay for $' + amount + '+15% Tax = <strong>' +
                    totalAmount + ' Taka</strong>');
                $('#bkash').html(
                    '<strong>Bkash:</strong> 01872739977 (payment with extra 1.5%) = <strong>' + bkash +
                    ' Taka</strong>');
                $('#rocket').html(
                    '<strong>Rocket:</strong> 01872739977 (payment with extra 1%) = <strong>' + rocket +
                    ' Taka</strong>');
                $('#nagad').html(
                    '<strong>Nagad:</strong> 01872739977 (payment with extra 1.25%) = <strong>' +
                    nagad + ' Taka</strong>');
                $('#send-money').html(
                    '<strong>Bkash/Rocket/Nagad:</strong> 01719023450 (send money with extra 1.25%) = <strong>' +
                    sendMoney + ' Taka</strong>');
            });
        });
    </script>
@endsection
