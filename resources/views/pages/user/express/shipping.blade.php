@extends('pages.user.express.index')

@section('expressContent')
    <h2 class="mb-4">{{ __('Local Shipping') }}</h2>
    @if (session()->has('error'))
        <div class="text-center py-4 text-light my-3 bg-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="text-center py-4 text-light my-3 bg-success">{{ session()->get('success') }}</div>
    @endif
    <a class="btn btn-primary mb-3" href="{{ route('front.express.create') }}">{{ __('Create') }}</a>
    <a class="btn btn-success mb-3" href="{{ route('front.express.call_aramex') }}">{{ __('Call Aramex') }}</a>
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
    data-bs-target="#exampleModal">{{ __('Export') }}</button>

    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal"
    data-bs-target="#filter">{{ __('Filter') }}</button>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('front.express.export') }}">
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

    <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">{{ __('Action Status') }}</label>
                        <select name="status" class="form-control" id="recipient-name">
                            <option value="0">New</option>
                            <option value="1">Processing</option>
                            <option value="2">Delivered</option>
                            <option value="3">Returned</option>
                            <option value="4">Pending Payments</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label">{{ __('Cash On Delivery') }}</label>
                        <input type="number" name="cod" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="col-form-label">{{ __('Phone') }}</label>
                        <input type="text" name="phone" class="form-control">
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
        <ul class="card-header pb-0 nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                    type="button" role="tab" aria-controls="all" aria-selected="true">{{ __('All') }}
                    ({{ $ships->count() }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="New-tab" data-bs-toggle="tab" data-bs-target="#New" type="button"
                    role="tab" aria-controls="New" aria-selected="false">{{ __('New') }}
                    ({{ $ships->where('status', 0)->count() }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="processing-tab" data-bs-toggle="tab" data-bs-target="#processing"
                    type="button" role="tab" aria-controls="processing" aria-selected="false">{{ __('Processing') }}
                    ({{ $ships->where('status', 1)->count() }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivered"
                    type="button" role="tab" aria-controls="delivered" aria-selected="false">{{ __('Delivered') }}
                    ({{ $ships->where('status', 2)->count() }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="returned-tab" data-bs-toggle="tab" data-bs-target="#returned"
                    type="button" role="tab" aria-controls="returned" aria-selected="false">{{ __('Returned') }}
                    ({{ $ships->where('status', 3)->count() }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="pending-payments-tab" data-bs-toggle="tab"
                    data-bs-target="#pending-payments" type="button" role="tab" aria-controls="pending-payments"
                    aria-selected="false">{{ __('Pending Payments') }}
                    ({{ $ships->where('status', 4)->count() }})</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="done-payments-tab" data-bs-toggle="tab"
                    data-bs-target="#done-payments" type="button" role="tab" aria-controls="done-payments"
                    aria-selected="false">{{ __('Payment Successful') }}
                    ({{ $ships->where('status', 5)->count() }})</button>
            </li>
        </ul>
        <div class="card-body tab-content" id="myTabContent">
            <div class="tab-pane fade show rounded-3 active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <table class="table border text-center datatable" id="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Created.') }}</th>
                            <th>AWB</th>
                            <th>{{ __('Consignee') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Cash On Delivery') }}</th>
                            <th>{{ __('Provider') }}</th>
                            <th>{{ __('Action Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($ships as $ship)
                            <tr>
                                <th>{{ $ship->created_at->format('Y - m - d') }}</th>
                                <td>{{ $ship->shipmentID }}</td>
                                <td>{{ $ship->consignee_name }}</td>
                                <td>{{ $ship->consignee_phone }}</td>
                                <td>{{ $ship->cash_on_delivery_amount ?? '0' }}</td>
                                <td>Aramex</td>
                                <td>{{ __($ship->get_status()) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('front.express.show', $ship->id) }}"><i
                                            class="fa fa-eye"></i> {{ __('Showing') }}</a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editOrder_{{ $ship->status . '_' . $ship->id }}">{{ __('Editing Orders') }}</button>

                                    <div class="modal fade" id="editOrder_{{ $ship->status . '_' . $ship->id }}" tabindex="-1"
                                        aria-labelledby="editOrder_{{ $ship->status . '_' . $ship->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editOrder_{{ $ship->status . '_' . $ship->id }}Label">{{ __('Editing Orders') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('front.express.shipment_update') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="shipment_id" value="{{ $ship->id }}" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">{{ __('Description') }}</label>
                                                            <textarea class="form-control" name="desc" id="message-text"></textarea>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show rounded-3" id="New" role="tabpanel" aria-labelledby="New-tab">
                <table class="table border text-center datatable" id="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Created.') }}</th>
                            <th>AWB</th>
                            <th>{{ __('Consignee') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Cash On Delivery') }}</th>
                            <th>{{ __('Provider') }}</th>
                            <th>{{ __('Action Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($ships->where('status', 0) as $ship)
                            <tr>
                                <th>{{ $ship->created_at->format('Y - m - d') }}</th>
                                <td>{{ $ship->shipmentID }}</td>
                                <td>{{ $ship->consignee_name }}</td>
                                <td>{{ $ship->consignee_phone }}</td>
                                <td>{{ $ship->cash_on_delivery_amount ?? '0' }}</td>
                                <td>Aramex</td>
                                <td>{{ __($ship->get_status()) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('front.express.show', $ship->id) }}"><i
                                            class="fa fa-eye"></i> {{ __('Showing') }}</a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editOrder_{{ $ship->status . '_' . $ship->id }}">{{ __('Editing Orders') }}</button>

                                    <div class="modal fade" id="editOrder_{{ $ship->status . '_' . $ship->id }}" tabindex="-1"
                                        aria-labelledby="editOrder_{{ $ship->status . '_' . $ship->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editOrder_{{ $ship->status . '_' . $ship->id }}Label">{{ __('Editing Orders') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('front.express.shipment_update') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="shipment_id" value="{{ $ship->id }}" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">{{ __('Description') }}</label>
                                                            <textarea class="form-control" name="desc" id="message-text"></textarea>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show rounded-3" id="processing" role="tabpanel" aria-labelledby="processing-tab">
                <table class="table border text-center datatable" id="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Created.') }}</th>
                            <th>AWB</th>
                            <th>{{ __('Consignee') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Cash On Delivery') }}</th>
                            <th>{{ __('Provider') }}</th>
                            <th>{{ __('Action Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($ships->where('status', 1) as $ship)
                            <tr>
                                <th>{{ $ship->created_at->format('Y - m - d') }}</th>
                                <td>{{ $ship->shipmentID }}</td>
                                <td>{{ $ship->consignee_name }}</td>
                                <td>{{ $ship->consignee_phone }}</td>
                                <td>{{ $ship->cash_on_delivery_amount ?? '0' }}</td>
                                <td>Aramex</td>
                                <td>{{ __($ship->get_status()) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('front.express.show', $ship->id) }}"><i
                                            class="fa fa-eye"></i> {{ __('Showing') }}</a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editOrder_{{ $ship->status . '_' . $ship->id }}">{{ __('Editing Orders') }}</button>

                                    <div class="modal fade" id="editOrder_{{ $ship->status . '_' . $ship->id }}" tabindex="-1"
                                        aria-labelledby="editOrder_{{ $ship->status . '_' . $ship->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editOrder_{{ $ship->status . '_' . $ship->id }}Label">{{ __('Editing Orders') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('front.express.shipment_update') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="shipment_id" value="{{ $ship->id }}" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">{{ __('Description') }}</label>
                                                            <textarea class="form-control" name="desc" id="message-text"></textarea>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show rounded-3" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                <table class="table border text-center datatable" id="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Created.') }}</th>
                            <th>AWB</th>
                            <th>{{ __('Consignee') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Cash On Delivery') }}</th>
                            <th>{{ __('Provider') }}</th>
                            <th>{{ __('Action Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($ships->where('status', 2) as $ship)
                            <tr>
                                <th>{{ $ship->created_at->format('Y - m - d') }}</th>
                                <td>{{ $ship->shipmentID }}</td>
                                <td>{{ $ship->consignee_name }}</td>
                                <td>{{ $ship->consignee_phone }}</td>
                                <td>{{ $ship->cash_on_delivery_amount ?? '0' }}</td>
                                <td>Aramex</td>
                                <td>{{ __($ship->get_status()) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('front.express.show', $ship->id) }}"><i
                                            class="fa fa-eye"></i> {{ __('Showing') }}</a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editOrder_{{ $ship->status . '_' . $ship->id }}">{{ __('Editing Orders') }}</button>

                                    <div class="modal fade" id="editOrder_{{ $ship->status . '_' . $ship->id }}" tabindex="-1"
                                        aria-labelledby="editOrder_{{ $ship->status . '_' . $ship->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editOrder_{{ $ship->status . '_' . $ship->id }}Label">{{ __('Editing Orders') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('front.express.shipment_update') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="shipment_id" value="{{ $ship->id }}" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">{{ __('Description') }}</label>
                                                            <textarea class="form-control" name="desc" id="message-text"></textarea>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show rounded-3" id="returned" role="tabpanel" aria-labelledby="returned-tab">
                <table class="table border text-center datatable" id="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Created.') }}</th>
                            <th>AWB</th>
                            <th>{{ __('Consignee') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Cash On Delivery') }}</th>
                            <th>{{ __('Provider') }}</th>
                            <th>{{ __('Action Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($ships->where('status', 3) as $ship)
                            <tr>
                                <th>{{ $ship->created_at->format('Y - m - d') }}</th>
                                <td>{{ $ship->shipmentID }}</td>
                                <td>{{ $ship->consignee_name }}</td>
                                <td>{{ $ship->consignee_phone }}</td>
                                <td>{{ $ship->cash_on_delivery_amount ?? '0' }}</td>
                                <td>Aramex</td>
                                <td>{{ __($ship->get_status()) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('front.express.show', $ship->id) }}"><i
                                            class="fa fa-eye"></i> {{ __('Showing') }}</a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editOrder_{{ $ship->status . '_' . $ship->id }}">{{ __('Editing Orders') }}</button>

                                    <div class="modal fade" id="editOrder_{{ $ship->status . '_' . $ship->id }}" tabindex="-1"
                                        aria-labelledby="editOrder_{{ $ship->status . '_' . $ship->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editOrder_{{ $ship->status . '_' . $ship->id }}Label">{{ __('Editing Orders') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('front.express.shipment_update') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="shipment_id" value="{{ $ship->id }}" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">{{ __('Description') }}</label>
                                                            <textarea class="form-control" name="desc" id="message-text"></textarea>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show rounded-3" id="pending-payments" role="tabpanel"
                aria-labelledby="pending-payments-tab">
                <table class="table border text-center datatable" id="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Created.') }}</th>
                            <th>AWB</th>
                            <th>{{ __('Consignee') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Cash On Delivery') }}</th>
                            <th>{{ __('Provider') }}</th>
                            <th>{{ __('Action Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($ships->where('status', 4) as $ship)
                            <tr>
                                <th>{{ $ship->created_at->format('Y - m - d') }}</th>
                                <td>{{ $ship->shipmentID }}</td>
                                <td>{{ $ship->consignee_name }}</td>
                                <td>{{ $ship->consignee_phone }}</td>
                                <td>{{ $ship->cash_on_delivery_amount ?? '0' }}</td>
                                <td>Aramex</td>
                                <td>{{ __($ship->get_status()) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('front.express.show', $ship->id) }}"><i
                                            class="fa fa-eye"></i> {{ __('Showing') }}</a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editOrder_{{ $ship->status . '_' . $ship->id }}">{{ __('Editing Orders') }}</button>

                                    <div class="modal fade" id="editOrder_{{ $ship->status . '_' . $ship->id }}" tabindex="-1"
                                        aria-labelledby="editOrder_{{ $ship->status . '_' . $ship->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editOrder_{{ $ship->status . '_' . $ship->id }}Label">{{ __('Editing Orders') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('front.express.shipment_update') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="shipment_id" value="{{ $ship->id }}" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">{{ __('Description') }}</label>
                                                            <textarea class="form-control" name="desc" id="message-text"></textarea>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade show rounded-3" id="pending-payments" role="tabpanel"
                aria-labelledby="pending-payments-tab">
                <table class="table border text-center datatable" id="datatable">
                    <thead>
                        <tr>
                            <th>{{ __('Created.') }}</th>
                            <th>AWB</th>
                            <th>{{ __('Consignee') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Cash On Delivery') }}</th>
                            <th>{{ __('Provider') }}</th>
                            <th>{{ __('Action Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($ships->where('status', 5) as $ship)
                            <tr>
                                <th>{{ $ship->created_at->format('Y - m - d') }}</th>
                                <td>{{ $ship->shipmentID }}</td>
                                <td>{{ $ship->consignee_name }}</td>
                                <td>{{ $ship->consignee_phone }}</td>
                                <td>{{ $ship->cash_on_delivery_amount ?? '0' }}</td>
                                <td>Aramex</td>
                                <td>{{ __($ship->get_status()) }}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('front.express.show', $ship->id) }}"><i
                                            class="fa fa-eye"></i> {{ __('Showing') }}</a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editOrder_{{ $ship->status . '_' . $ship->id }}">{{ __('Editing Orders') }}</button>

                                    <div class="modal fade" id="editOrder_{{ $ship->status . '_' . $ship->id }}" tabindex="-1"
                                        aria-labelledby="editOrder_{{ $ship->status . '_' . $ship->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editOrder_{{ $ship->status . '_' . $ship->id }}Label">{{ __('Editing Orders') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('front.express.shipment_update') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="shipment_id" value="{{ $ship->id }}" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">{{ __('Description') }}</label>
                                                            <textarea class="form-control" name="desc" id="message-text"></textarea>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
