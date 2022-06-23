@extends('pages.user.payments.master')
@section('active1', 'active')
@section('paymentsContent')


<div class="row">
	<div class="col-sm-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>المدفوعات</h5>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
	          <table class="table display" id="basic-1">
	            <thead>
	              <tr>
	                <th>#</th>
	                <th>AWB</th>
	                <th>المرسل</th>
	                <th>المستلم</th>
	                <th>رقم الهاتف</th>
	                <th>المدينة</th>
	                <th>الدفع عند الاستلام</th>
	                <th>المصاريف</th>
	                <th>الباقي</th>
	                <th>الاجراءات</th>
	              </tr>
	            </thead>
	              <tbody>
	              	@foreach($shipments as $shipment)
		            <tr>
                        <th>{{ $loop->iteration }}</th>
                        {{-- <th>{{ $shipment->created_at->format('Y - m - d') }}</th> --}}
                        <td>{{ $shipment->shipmentID }}</td>
                        <td>{{ $shipment->address->name ?? '' }}</td>
                        <td>{{ $shipment->consignee_name }}</td>
                        <td>{{ $shipment->consignee_phone }}</td>
                        <td>{{ App\Models\City::find($shipment->consignee_city)->first()->name ?? '' }}</td>
                        <td>{{ $shipment->cash_on_delivery_amount ?? '0' }}</td>
                        <td>{{ $shipment->collect_amount }}</td>
                        <td>{{ $shipment->cash_on_delivery_amount - ($shipment->collect_amount ?? 0) }}</td>
                        {{-- <td>Aramex</td> --}}
                        {{-- <td>{{ __($shipment->get_status()) }}</td> --}}
		                {{-- <td>
		                	<a class="" href="{{ route('admin.shipments.edit', $shipment->id) }}"><i class="fa fa-edit"></i> تعديل</a>
		                	<a class="" href="{{ route('admin.shipments.show', $shipment->id) }}"><i class="fa fa-eye"></i> عرض</a>
		                	<a class="" href="{{ route('admin.shipments.edit', $shipment->id) }}"><i class="fa fa-trash"></i> حذف</a>
		                </td> --}}
		                <td>
                            <a class="btn btn-success" href="{{ route('front.express.show', $shipment->id) }}">عرض</a>
                        </td>
                    </tr>
		            @endforeach
	          	  </tbody>
	          </table>
	        </div>
	      </div>
	    </div>
	</div>
</div>

@endsection