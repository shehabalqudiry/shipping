@extends('admin.layouts.app')
@section('title', 'عرض تفاصيل الشحنة')
@section('content')


<div>
    <div class="col-sm-12 col-lg-10 mx-auto">
        <h3 class="NavigateHeader">معلومات الشحنة</h3>
    </div>
    <div class="mb-3 col-sm-12 col-lg-10 mx-auto text-right ">
        @if ($shipment->shipmentLabelURL)
        <a href="{{ asset($shipment->shipmentLabelURL) }}" target="_blank" class="btn btn-primary">
            <i class="fa fa-print"></i>
            طباعة
        </a>
        @else
        <a href="#" class="btn disable btn-primary">
            <i class="fa fa-print"></i>
            طباعة
        </a>
        @endif
    </div>
    <div class="d-lg-flex flex-row flex-xs-column align-self-center justify-content-between col-lg-10 mx-auto mb-1">
        <div class="col-sm-12 col-lg-3 mb-2 p-0 ">
            <div class="dashboardbox text-center  " style="height: 190px; overflow: hidden;">
                <img src="data:image/png;base64,{{ $barcode }}" width="180" height="90" alt="" class="my-4">
                <h4 class="scolor text-center" style="font-weight: 700;">
                    {{ $shipment->shipmentID }}
                </h4>
            </div>
        </div>
        <div class="col-xs-12 col-lg-3 mb-2 p-0">
            <div class="dashboardbox">
                <h6 class="text-muted">المزود</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>Aramex</span></h4>
            </div>
            <div class="dashboardbox mt-3">
                <h6 class="text-muted">الحالة</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>{{ $shipment->get_status() }}</span></h4>
            </div>
        </div>
        <div class="col-xs-12 col-lg-3 mb-2 p-0">
            <div class="dashboardbox ">
                <h6 class="text-muted">أنشئت بواسطة</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>{{ $shipment->user->name ?? '' }}</span></h4>
            </div>
            <div class="dashboardbox mt-3">
                <h6 class="text-muted">المدينة</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>{{ $shipment->address->City->name ?? '' }}</span></h4>
            </div>
        </div>
        <div class="col-xs-12 col-lg-2 mb-2 p-0">
            <div class="dashboardbox ">
                <h6 class="text-muted">النوع</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>DOMESTIC</span></h4>
            </div>
            <div class="dashboardbox mt-3">
                <h6 class="text-muted">الدفع عند الإستلام</h6>
                <h4 class="scolor" style="font-weight: 700;"><span>{{ $shipment->cash_on_delivery_amount }} JOD</span></h4>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-10 mx-auto">
        <div class="card mb-3">
            <div class="card-header">معلومات المرسل</div>
            <div class="card-body mb-3">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">الأسم</label></div>
                            <div class="desc">
                                {{ $shipment->address->name }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">رقم الهاتف</label></div>
                            <div class="desc">
                                {{ $shipment->address->phone }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">الدولة</label></div>
                            <div class="desc">
                                JO
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">المدينة</label></div>
                            <div class="desc">
                                {{ $shipment->address->City->name ?? '' }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">المنطقة</label></div>
                            <div class="desc">
                                {{ $shipment->address->region }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">الوصف</label></div>
                            <div class="desc">
                                {{ $shipment->address->desc }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-10 mx-auto mb-3">
        <div class="card">
            <div class="card-header">معلومات المرسل إليه</div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-6 border-right">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">الأسم</label></div>
                            <div class="desc">
                                {{ $shipment->consignee_name }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">رقم الهاتف</label></div>
                            <div class="desc">
                                {{ $shipment->consignee_phone }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">رقم الهاتف البديل</label></div>
                            <div class="desc">
                                {{ $shipment->consignee_cell_phone }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">الرمز البريدي</label></div>
                            <div class="desc">
                                N/A
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">الدولة</label></div>
                            <div class="desc">
                                JO
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">المدينة</label></div>
                            <div class="desc">
                                {{ App\Models\City::find($shipment->consignee_city)->name ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">المنطقة</label></div>
                            <div class="desc">
                                {{ $shipment->consignee_line2 }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">الوصف</label></div>
                            <div class="desc">
                                {{ $shipment->consignee_line1 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-10 mx-auto mb-3">
        <div class="card">
            <div class="card-header">ملخص الشحنة</div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-12"></div>
                    <div class="col-sm-6 border-right">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">القطع</label></div>
                            <div class="desc">
                                {{ $shipment->number_of_pieces }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">ملاحظات</label></div>
                            <div class="desc">
                                {{ $shipment->comments }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">أنشئت في</label></div>
                            <div class="desc">
                                {{ $shipment->created_at->format('Y-m-d') }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">أنشئت بواسطة</label></div>
                            <div class="desc">
                                {{ $shipment->user->name ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-between">
                            <div><label for="" class="Label">المحتويات</label></div>
                            <div class="desc">
                                {{ $shipment->description }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">الوزن الفعلي</label></div>
                            <div class="desc">
                                {{ $shipment->weight }} KG
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">الوزن القابل للشحن</label></div>
                            <div class="desc">
                                {{ $shipment->weight }} KG
                            </div>
                        </div>
                        <!---->
                        <!---->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-10 mx-auto">
        <div class="card mb-3">
            <div class="card-header">ملخص الدفع</div>
            <div class="card-body mb-3">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">الدفع عند الإستلام (JOD)
                                </label></div>
                            <div class="desc">
                                {{ $shipment->cash_on_delivery_amount ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">الرسوم (JOD)</label></div>
                            <div class="desc">
                                {{ $shipment->customs_value_amount }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">المستحق للموقع (JOD)</label></div>
                            <div class="desc">
                                {{ $shipment->customs_value_amount }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">الباقي</label></div>
                            <div class="desc">
                                NaN JOD
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">تم الدفع في</label></div>
                            <div class="desc">
                                N/A
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div><label for="" class="Label">رقم العملية</label></div>
                            <div class="desc">
                                N/A
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-5 mx-auto"></div>
    <div class="col-sm-12 col-lg-10 mx-auto mb-3">
        <div class="card mb-3">
            <div class="card-header">آخر التغييرات</div>
            <div class="card-body mb-3">
                <div class="col-sm-12">
                    <div class="table-responsive" style="font-size: 13px;">
                        <table role="table" aria-busy="false" aria-colcount="4" class="table b-table b-table-stacked-lg" id="__BVID__301">
                            <thead role="rowgroup" class="">
                                <tr role="row" class="">
                                    <th role="columnheader" scope="col" aria-colindex="1" class="bg-dark text-white">
                                        <div>التاريخ</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="2" class="bg-dark text-white">
                                        <div>وصف التتبع</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="3" class="bg-dark text-white">
                                        <div>الوصف</div>
                                    </th>
                                    <th role="columnheader" scope="col" aria-colindex="4" class="bg-dark text-white">
                                        <div>الموقع</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody role="rowgroup">
                                {{-- @dd($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult !== []) --}}
                                @if ($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult == [])
                                @foreach ($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult as $track)
                                <tr role="row" class="">
                                    <td aria-colindex="1" data-label="التاريخ" role="cell" class="">
                                        <div>{{ strftime('%Y-%m-%d %H:%M', strtotime($track->UpdateDateTime)) }}</div>
                                    </td>
                                    <td aria-colindex="2" data-label="وصف التتبع" role="cell" class="">
                                        <div>{{ $track->Comments }}</div>
                                    </td>
                                    <td aria-colindex="3" data-label="الوصف" role="cell" class="">
                                        <div>{{ $track->UpdateDescription }}</div>
                                    </td>
                                    <td aria-colindex="4" data-label="الموقع" role="cell" class="">
                                        <div>{{ $track->UpdateLocation }}</div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                @php
                                    $track = $data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult;
                                @endphp
                                <tr role="row" class="">
                                    <td aria-colindex="1" data-label="التاريخ" role="cell" class="">
                                    <div>
                                        {{ strftime('%Y-%m-%d %H:%M', strtotime($track->UpdateDateTime)) }}
                                    </div>
                                    </td>
                                    <td aria-colindex="2" data-label="وصف التتبع" role="cell" class="">
                                        <div>{{ $track->Comments }}</div>
                                    </td>
                                    <td aria-colindex="3" data-label="الوصف" role="cell" class="">
                                        <div>{{ $track->UpdateDescription }}</div>
                                    </td>
                                    <td aria-colindex="4" data-label="الموقع" role="cell" class="">
                                        <div>{{ $track->UpdateLocation }}</div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br />
    <hr />
    <br />
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Editing Orders') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm display datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>التاريخ</th>
                                    <th>النوع</th>
                                    <th>الوصف</th>
                                    <th>الحاله</th>
                                    <th>الاجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($editOrders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->created_at->format('Y - m - d') }}</td>
                                    <td>{{ $order->type }}</td>
                                    <td><?php echo $order->desc; ?></td>
                                    <td>{{ __($order->get_status()) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                            @if ($order->type == 'تعديل بيانات الحساب الشخصي')
                                            <a class="btn btn-outline-success" href="{{ route('admin.users.edit', $order->user_id) }}"><i class="fa fa-edit"></i></a>
                                            <a class="btn btn-success" href="{{ route('admin.users.show', $order->user_id) }}"><i class="fa fa-eye"></i></a>
                                            @else
                                            <a class="btn btn-outline-success" href="{{ route('admin.shipments.edit', $order->shipment_id) }}"><i class="fa fa-edit"></i></a>
                                            <a class="btn btn-success" href="{{ route('admin.shipments.show', $order->shipment_id) }}"><i class="fa fa-eye"></i></a>
                                            @endif
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editOrder_{{ $order->status . '_' . $order->id }}">تحديث</button>

                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editOrder_{{ $order->status . '_' . $order->id }}" tabindex="-1"
                                    aria-labelledby="editOrder_{{ $order->status . '_' . $order->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editOrder_{{ $order->status . '_' . $order->id }}Label">{{ __('Editing Orders') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                                                @csrf
                                                @method('put')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="message-text"
                                                            class="col-form-label">الحالة</label>
                                                        <select class="form-control" name="status" id="message-text">
                                                            <option {{ $order->status == 0 ? 'selected' : '' }} value="0">قيد المراجعه</option>
                                                            <option {{ $order->status == 1 ? 'selected' : '' }} value="1">تم التحديث</option>
                                                            <option {{ $order->status == 2 ? 'selected' : '' }} value="2">رفض التعديلات</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-secondary">تحديث</button>
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">اغلاق</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
