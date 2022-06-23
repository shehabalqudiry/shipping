@extends('pages.user.express.index')

@section('expressContent')
<h2 class="mb-4">{{ __('Create') }} {{ __('Local Shipping') }}</h2>
<a class="btn btn-primary mb-3" href="{{ route('front.get_shipments_import') }}">{{ __('Excel Import') }}</a>
<a class="btn btn-success mb-3" href="{{ asset('assets/file.xlsx') }}">{{ __('Excel Import Format') }}</a>
<div class="card">
    @if (session()->has('error'))
        <div class="alert text-center py-4 text-light my-3 alert-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="alert text-center py-4 text-light my-3 alert-success">{{ session()->get('success') }}</div>
    @endif
    <div class="card-header">
        {{-- <h4>#1</h4> --}}
    </div>
    <div class="card-body">
        <div class="container">
            <form method="post" action="{{ route('front.express.store') }}">
                @csrf
                <div class="row">
                    <div class="d-lg-flex flex-row col-sm-12 mb-3 justify-content-center">
                        <div class="col-xl-5 col-sm-12 col-lg-7 px-0 mb-2">
                            <label>{{ __('Shipper') }}</label><span class="text-danger">*</span>
                            <select class="form-control mt-2 ml-2 " name="shipper">
                                @foreach (auth()->user()->addresses->all() as $address)
                                <option value="{{ $address->id }}">
                                    {{ $address->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <a href="{{ route('front.user.address') }}" style="height: 37px;margin-top: 3.3% !important;" class="btn btn-primary ml-xl-3 mr-xl-3 mx-3">{{ __('New Address') }}</a>
                        <div class="col-xl-5 col-sm-12 col-lg-3
                              px-0 px-sm-0
                              mb-2
                              ml-xl-3
                              mt-2 mt-lg-0">
                            <label>{{ __('Provider') }}</label><span class="text-danger">*</span>
                            <select class="form-control mt-2" name="provider">
                                <option value="aramex" selected>Aramex</option>
                            </select>
                        </div>
                    </div>
                    <hr />
                </div>
                <div class="row">
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Consignee Name') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" name="consignee_name" />
                        @error('consignee_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Phone') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" name="consignee_phone" />
                        @error('consignee_phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Phone') }} 2</label>
                        <input class="form-control mt-2 ml-2" type="text" name="consignee_cell_phone" />
                        @error('consignee_cell_phone')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('City') }}</label><span class="text-danger">*</span>
                        <select class="form-control mt-2 ml-2" type="text" name="consignee_city">
                            @foreach (App\Models\City::get() as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('consignee_city')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Region') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" name="consignee_line2" />
                        @error('consignee_line2')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Description') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" name="consignee_line1" />
                        @error('consignee_line1')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>

                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Weight') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" name="weight" />
                        @error('weight')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Contents') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" name="description" />
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Comments') }}</label>
                        <input class="form-control mt-2 ml-2" type="text" name="comments" />
                        @error('comments')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>

                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Reference') }}</label>
                        <input class="form-control mt-2 ml-2" type="text" value="{{ auth()->user()->ACCOUNT_NUMBER() }}" name="reference" />
                        @error('reference')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Number OF Pieces') }}</label><span class="text-danger">*</span>
                        <input class="form-control mt-2 ml-2" type="text" name="number_of_pieces" />
                        @error('number_of_pieces')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Cash On Delivery') }} (JOD)</label>
                        <input class="form-control mt-2 ml-2" type="text" name="cash_on_delivery_amount" />
                        @error('cash_on_delivery_amount')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                    </div>


                </div>
                <button class="btn btn-primary btn-lg my-3" type="submit">{{ __('Apply') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
