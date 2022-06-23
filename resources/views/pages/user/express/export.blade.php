<table id="customers" style="font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100vw;">
    <thead>
        <tr>
            <th style="text-align: center;padding: 20px">#</th>
            <th style="text-align: center;padding: 20px">Created At</th>
            <th style="text-align: center;padding: 20px">AWB</th>
            <th style="text-align: center;padding: 20px">Shipper</th>
            <th style="text-align: center;padding: 20px">Consignee</th>
            <th style="text-align: center;padding: 20px">phone</th>
            <th style="text-align: center;padding: 20px">City</th>
            <th style="text-align: center;padding: 20px">COD (JOD)</th>
            <th style="text-align: center;padding: 20px">Cost (JOD)</th>
            <th style="text-align: center;padding: 20px">Total (JOD)</th>
            <th style="text-align: center;padding: 20px">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shipments as $shipment)
            <tr>
                <th style="padding: 12px;text-align: center;" scope="row">{{ $loop->iteration }}</th>
                <td style="width: 70px;padding: 12px auto;text-align: center;">{{ $shipment->created_at }}</td>
                <td style="width: 70px;padding: 12px auto;text-align: center;">{{ $shipment->shipmentID }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment->address->name ?? '' }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment->consignee_name }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment->consignee_phone }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ App\Models\City::find($shipment->consignee_city)->first()->name ?? '' }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment->cash_on_delivery_amount ?? '0' }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment->collect_amount }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment->cash_on_delivery_amount - ($shipment->collect_amount ?? 0) }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment->get_status() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
