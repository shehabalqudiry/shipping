@extends('pages.user.payments.master')
@section('active1', 'active')
@section('paymentsContent')

    <h5>{{ __('Payments') }}</h5>
    @if (session()->has('error'))
        <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success') }}</div>
    @endif
    <div class="row mb-5">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <h3>{{ $shipments->sum('cash_on_delivery_amount') - ($shipments->sum('collect_amount') ?? 0) }}</h3>
                    {{-- <a href="#" class="btn btn-success">{{ __('Withdraw') }}</a> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal"
                data-bs-target="#exampleModal">{{ __('Export') }}</button>
                <button type="button" class="btn btn-secondary mb-4" data-bs-toggle="modal" data-bs-target="#filter">{{ __('Filter') }}</button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('front.payments.export') }}">
                            <div class="modal-body">
                                @csrf
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">{{ __('Type') }}</label>
                                    <select name="fileType" class="form-control" id="recipient-name">
                                        <option value="pdf">pdf</option>
                                        <option value="xlsx">xlsx</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">{{ __('From') }}</label>
                                    <input type="date" name="from" class="form-control" id="message-text">
                                </div>

                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">{{ __('To') }}</label>
                                    <input type="date" name="to" class="form-control" id="message-text">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Apply') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="">
                            <div class="modal-body">
                                {{-- @csrf --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <label for="message-text" class="col-form-label">{{ __('From') }}</label>
                                        <input type="date" name="from" class="form-control" id="message-text">
                                    </div>

                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <label for="message-text" class="col-form-label">{{ __('To') }}</label>
                                        <input type="date" name="to" class="form-control" id="message-text">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Apply') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table display table-bordered basic-1" cellpadding="0" cellspacing="0" border="0"
                            id="hidden-table-info">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Created.') }}</th>
                                    <th>{{ __('Value') }} (JOD)</th>
                                    <th>{{ __('Action Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>{{ $shipments->sum('cash_on_delivery_amount') - ($shipments->sum('collect_amount') ?? 0) }}
                                        </td>
                                        <td>{{ $transaction->status }}</td>
                                        <td>
                                            <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                                <a class="btn btn-success"
                                                    href="{{ route('front.payments.show', $transaction->id) }}">عرض</a>
                                            </div>
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
