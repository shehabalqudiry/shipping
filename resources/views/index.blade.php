@extends('layouts.app')
@section('content')
<div class="container pt-3">
    <!-- ======= Services Section ======= -->
    <section id="services" class="row services">
        <div class="container">
            <div class="row">
                <div class="col-md-6 py-5">
                    <h1 class="text-dark my-4 fw-bold"
                        style="font-size: calc(1.7rem + 1.6901vw - 6.33788px);line-heightv: calc(1.7rem + 2.2535vw - 8.45062px);">
                        {{ __('The best and fastest way to deliver your shipments in simple steps') }}
                    </h1>
                    @if (auth()->check())
                    <a href="{{ route('front.user.account') }}" class="btn btn-primary py-3 px-5 btn-lg">{{ __('Profile') }}</a>
                    @else
                    <a href="{{ route('front.get_register') }}" class="btn btn-primary py-3 px-5 btn-lg">{{ __('Register') }}</a>
                    @endif
                    {{-- <a class="btn btn-primary py-3 px-5 btn-lg" href="#">اشحن لمرة واحدة</a> --}}
                </div>
                <div class="col-md-6 mt-4 mt-lg-0">
                    <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active mr-2 tabtitle activeTab" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                aria-selected="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="46" fill="currentColor"
                                    viewBox="0 0 16 16" class="bi bi-truck">
                                    <path
                                        d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                                    </path>
                                </svg>
                                <span class="ml-1 mr-1">{{ __('Local Shipping') }}</span></a>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link mr-2 tabtitle" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="46" fill="currentColor"
                                    viewBox="0 0 16 16" class="bi bi-globe">
                                    <path
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z">
                                    </path>
                                </svg>
                                <span class="ml-1 mr-1">{{ __('International Shipping') }}</span></a>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @if (session()->has('value'))
                                <div class="text-center font-4 mt-4">
                                    {{ session()->get('value') }} (JOD)
                                </div>
                            @endif
                            <form class="my-4" action="{{ route('front.sumExpress') }}" method="post">
                                @csrf
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">{{ __('From') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control @error('city_to') is-invalid @enderror" name="city_from"
                                            id="exampleFormControlInput1">
                                            <option value="" selected>{{ __('City') }}</option>
                                            @foreach (App\Models\City::where('status', 1)->get() as $s_city)
                                            <option value="{{ $s_city->id }}">{{ $s_city->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">{{ __('To') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control @error('city_to') is-invalid @enderror" name="city_to"
                                            id="exampleFormControlInput1">
                                            <option value="" selected>{{ __('City') }}</option>
                                            @foreach (App\Models\City::where('status', 1)->get() as $s_city)
                                            <option value="{{ $s_city->id }}">{{ $s_city->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">{{ __('Weight') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control @error('city_to') is-invalid @enderror" name="wighte"
                                            id="exampleFormControlInput1">
                                            <option value="" selected>{{ __('Weight') }}</option>
                                            <option value="10" class="text-muted py-3 my-3" style="font-size:14px">
                                                <span>5 (KG)</option>
                                            @for($w = 5; $w <= 100; $w+=5)
                                                <option value="{{ $w+5 }}" class="text-muted p-3" style="font-size:14px">{{ $w }} (KG) - {{ $w+5 }} (KG)</option>
                                            @endfor
                                        </select>
                                        @error('city_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-center my-5">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Apply') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade text-center py-3" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <a href="#" class="btn btn-primary py-3 px-5 btn-lg">{{ __('Contact us') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Services Section -->
</div>
@endsection
