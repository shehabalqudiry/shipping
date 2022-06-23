@extends('admin.layouts.app')
@section('title', 'المدفوعات')
@section('content')

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
	                <th>القيمة</th>
	                <th>المستخدم</th>
	                <th>الشحنات</th>
	                <th>الاجراءات</th>
	              </tr>
	            </thead>
	              <tbody>
	              	@foreach($transactions as $transaction)
		            <tr>
		                <td>{{ $loop->iteration }}</td>
		                <td>{{ $transaction->value }}</td>
		                <td>{{ $transaction->user->name ?? '' }}</td>
		                <td>{{ $transaction->imports->count() }}</td>
		                <td>
                            <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#edittransaction_{{ $transaction->status . '_' . $transaction->id }}">تحديث</button>
                            <a class="btn btn-success" href="{{ route('admin.transactions.show', $transaction->id) }}">عرض</a>

                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="edittransaction_{{ $transaction->status . '_' . $transaction->id }}" tabindex="-1"
                        aria-labelledby="edittransaction_{{ $transaction->status . '_' . $transaction->id }}Label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edittransaction_{{ $transaction->status . '_' . $transaction->id }}Label">تعديل الحالة</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.transactions.update', $transaction->id) }}">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="message-text"
                                                class="col-form-label">صورة الايصال</label>
                                                <input class="form-control" name="image" type="file">
                                        </div>
                                        <div class="mb-3">
                                            <label for="message-text"
                                                class="col-form-label">الحالة</label>
                                                <select class="form-control" name="status" id="message-text">
                                                    <option {{ $transaction->status == 0 ? 'selected' : '' }} value="0">قيد المراجعه</option>
                                                    <option {{ $transaction->status == 1 ? 'selected' : '' }} value="1">تم التحديث</option>
                                                    <option {{ $transaction->status == 2 ? 'selected' : '' }} value="2">رفض التعديلات</option>
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

@endsection
{{--  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  --}}
