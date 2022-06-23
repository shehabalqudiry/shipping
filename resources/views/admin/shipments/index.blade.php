@extends('admin.layouts.app')
@section('title', 'الشحنات')
@section('content')
<a class="btn btn-primary mb-3" href="{{ route('admin.import_shipments.create') }}">استيراد من ملف اكسيل</a>
<a class="btn btn-success mb-3" href="{{ asset('assets/file.xlsx') }}">نموذج اكسيل المطلوب</a>
<div class="row">
	<div class="col-12">
	    <div class="card">
	      <div class="card-header">
	        <h5>الشحنات</h5>
	      </div>
	      <div class="card-body">
	        <div class="table-responsive">
	          <table class="table display" id="basic-1">
	            <thead>
	              <tr>
	                <th>#</th>
	                <th>التاريخ</th>
	                <th>AWB</th>
	                <th>المرسل إليه</th>
	                <th>رقم الهاتف</th>
	                <th>الدفع عند الاستلام</th>
	                <th>الناقل</th>
	                <th>الحاله</th>
	                <th>العمليات</th>
	              </tr>
	            </thead>
	              <tbody>
	              	@foreach($shipments as $shipment)
		            <tr>
                        <th>{{ $loop->iteration }}</th>
                        <th>{{ $shipment->created_at->format('Y - m - d') }}</th>
                        <td>{{ $shipment->shipmentID }}</td>
                        <td>{{ $shipment->consignee_name }}</td>
                        <td>{{ $shipment->consignee_phone }}</td>
                        <td>{{ $shipment->cash_on_delivery_amount ?? '0' }}</td>
                        <td>Aramex</td>
                        <td>{{ __($shipment->get_status()) }}</td>
		                <td>
		                	<a class="" href="{{ route('admin.shipments.edit', $shipment->id) }}"><i class="fa fa-edit"></i> تعديل</a>
		                	<a class="" href="{{ route('admin.shipments.show', $shipment->id) }}"><i class="fa fa-eye"></i> عرض</a>
		                	<a class="" href="{{ route('admin.shipments.edit', $shipment->id) }}"><i class="fa fa-trash"></i> حذف</a>
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
