<div id="bulk-send-carrier" class="modal fade">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{ translate('Send to Carrier') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>{{ translate('Order Code') }}</th>
                            <th data-breakpoints="md">{{ translate('Np') }}</th>
                            <th data-breakpoints="md">{{ translate('Customer') }}</th>
                            <th data-breakpoints="md">{{ translate('Amount') }}</th>
                            <th data-breakpoints="md">{{ translate('Delivery Status') }}</th>
                            @if (addon_is_activated('refund_request'))
                                <th>{{ translate('Refund') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer text-center">
                <p class="mt-1">{{ translate('Are you sure to send to carrier?') }}</p>
                <button type="button" class="btn btn-link mt-2"
                    data-dismiss="modal">{{ translate('Cancel') }}</button>
                <a href="javascript:void(0)" onclick="bulk_send_carrier()"
                    class="btn btn-primary mt-2">{{ translate('Send To Carrier') }}</a>
            </div>
        </div>
    </div>
</div>
