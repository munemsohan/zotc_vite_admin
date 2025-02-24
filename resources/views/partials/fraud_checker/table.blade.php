<table class="table table-sm text-center table-striped table-bordered">
    <thead>
        <tr>
            <th>Courier</th>
            <th>Total</th>
            <th>Delivered</th>
            <th>Returned</th>
            <th>Suc. Ratio</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_parcels = $delivered_parcels = $canceled_parcels = 0;
        @endphp

        @foreach ($orderguardData ?? [] as $courier => $data)
            @php
                $total = $data['Total Parcels'] ?? $data['Total Delivery'] ?? 0;
                $delivered = $data['Delivered Parcels'] ?? $data['Successful Delivery'] ?? 0;
                $canceled = $data['Canceled Parcels'] ?? $data['Canceled Delivery'] ?? 0;

                $total_parcels += $total;
                $delivered_parcels += $delivered;
                $canceled_parcels += $canceled;

                $success_percentage = $total ? ($delivered / $total) * 100 : 0;
            @endphp
            <tr>
                <td>{{ $courier }}</td>
                <td>{{ $total }}</td>
                <td>{{ $delivered }}</td>
                <td>{{ $canceled }}</td>
                <td>{{ number_format($success_percentage, 2) }}%</td>
            </tr>
        @endforeach

        @php
            $total_success_percentage = $total_parcels ? ($delivered_parcels / $total_parcels) * 100 : 0;
        @endphp

        <tr>
            <td><strong>Total</strong></td>
            <td><strong>{{ $total_parcels }}</strong></td>
            <td><strong>{{ $delivered_parcels }}</strong></td>
            <td><strong>{{ $canceled_parcels }}</strong></td>
            <td><strong>{{ number_format($total_success_percentage, 2) }}%</strong></td>
        </tr>
        <tr>
            <td colspan="5">
                <div class="progress mb-2">
                    <div class="progress-bar bg-success" role="progressbar"
                        style="width: {{ $total_success_percentage }}%"
                        aria-valuenow="{{ $total_success_percentage }}" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    <div class="progress-bar bg-danger" role="progressbar"
                        style="width: {{ 100 - $total_success_percentage }}%"
                        aria-valuenow="{{ 100 - $total_success_percentage }}" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>
                <p class="mb-0 text-center">{{ (int) $total_success_percentage }}% Delivered</p>
            </td>
        </tr>
    </tbody>
</table>
