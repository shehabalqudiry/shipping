@extends('layouts.dashboard')
@section('content')
<section class="container card mb-5 p-0">
    <div class="card-header">
        <h3 class="card-title">{{ __('Shipping') }}</h3>
    </div>
    <div class="card-body">
        <div class="row mb-5">
            <div class="col-md-3">
                <div class="card px-3 py-2">
                    <div class="d-flex justify-content-between flex-row-reverse">
                        <h6 class="text-muted">{{ __('Drafts') }}</h6>
                        <h6 class="text-muted">{{ __('Percentage') }}</h6>
                    </div>
                    <div class="d-flex  justify-content-between flex-row-reverse">
                        <h4 class="scolor" style="font-weight: 700;">
                            {{ $shipment->where('status', 0)->count() }}
                        </h4>
                        <h4 style="font-weight: 700;">
                            {{ number_format(($shipment->where('status', 0)->count() * 100) / $shipment->count(), 2) }} %
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card px-3 py-2">
                    <div class="d-flex justify-content-between flex-row-reverse">
                        <h6 class="text-muted">{{ __('Processing') }}</h6>
                        <h6 class="text-muted">{{ __('Percentage') }}</h6>
                    </div>
                    <div class="d-flex  justify-content-between flex-row-reverse">
                        <h4 class="scolor" style="font-weight: 700;">
                            {{ $shipment->where('status', 1)->count() }}
                        </h4>
                        <h4 style="font-weight: 700;">
                            {{ number_format(($shipment->where('status', 1)->count() * 100) / $shipment->count(), 2) }} %
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card px-3 py-2">
                    <div class="d-flex justify-content-between flex-row-reverse">
                        <h6 class="text-muted">{{ __('Delivered') }}</h6>
                        <h6 class="text-muted">{{ __('Percentage') }}</h6>
                    </div>
                    <div class="d-flex  justify-content-between flex-row-reverse">
                        <h4 class="scolor" style="font-weight: 700;">
                            {{ $shipment->whereIn('status', [2, 4])->count() }}
                        </h4>
                        <h4 style="font-weight: 700;">
                            {{ number_format(($shipment->whereIn('status', [2, 4])->count() * 100) / $shipment->count(), 2) }} %
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card px-3 py-2">
                    <div class="d-flex justify-content-between flex-row-reverse">
                        <h6 class="text-muted">{{ __('Returned') }}</h6>
                        <h6 class="text-muted">{{ __('Percentage') }}</h6>
                    </div>
                    <div class="d-flex  justify-content-between flex-row-reverse">
                        <h4 class="scolor" style="font-weight: 700;">
                            {{ $shipment->where('status', 3)->count() }}
                        </h4>
                        <h4 style="font-weight: 700;">
                            {{ number_format(($shipment->where('status', 3)->count() * 100) / $shipment->count(), 2) }} %
                        </h4>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mb-5">
            <div id="chart"></div>
        </div>
    </div>
</section>
<section class="container card mb-5 p-0">
    <div class="card-header">
        <h3 class="card-title">{{ __('Payments') }}</h3>
    </div>
    <div class="card-body">
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card px-3 py-2">
                    <div class="d-flex justify-content-between flex-row-reverse">
                        <h6 class="text-muted">{{ __('Cash In') }}</h6>
                        <h6 class="text-muted">{{ __('Percentage') }}</h6>
                    </div>
                    <div class="d-flex  justify-content-between flex-row-reverse">
                        <h4 class="scolor" style="font-weight: 700;">
                            0
                        </h4>
                        <h4 style="font-weight: 700;">
                            0%
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card px-3 py-2">
                    <div class="d-flex justify-content-between flex-row-reverse">
                        <h6 class="text-muted">{{ __('Cash Out') }}</h6>
                        <h6 class="text-muted">{{ __('Percentage') }}</h6>
                    </div>
                    <div class="d-flex  justify-content-between flex-row-reverse">
                        <h4 class="scolor" style="font-weight: 700;">
                            0
                        </h4>
                        <h4 style="font-weight: 700;">
                            0%
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card px-3 py-2">
                    <div class="d-flex justify-content-between flex-row-reverse">
                        <h6 class="text-muted">مسودات</h6>
                        <h6 class="text-muted">{{ __('Percentage') }}</h6>
                    </div>
                    <div class="d-flex  justify-content-between flex-row-reverse">
                        <h4 class="scolor" style="font-weight: 700;">
                            0
                        </h4>
                        <h4 style="font-weight: 700;">
                            0%
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div id="chart2"></div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
var options = {
    chart: {
    type: 'line'
    },
    stroke: {
    curve: 'smooth',
    },
    series: [{
    name: '{{ __("Drafts") }}',
    data: [80,90,20,588,500]
    },
    {
    name: "{{ __('Delivered') }}",
    data: [30,40,35,50,49]
    },
    {
    name: "{{ __('Processing') }}",
    data: [30,40,35,50,49]
    },
    {
    name: "{{ __('Returned') }}",
    data: [30,40,35,50,49]
    }],
    xaxis: {
    categories: [{{ date('Y') }}, {{ date('Y') + 1 }}, {{ date('Y') + 2 }}, {{ date('Y') + 3 }}, {{ date('Y') + 4 }}, {{ date('Y') + 5 }}]
    }
    }

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    var chart2 = new ApexCharts(document.querySelector("#chart2"), options);

    chart.render();
    chart2.render();
</script>
@endsection
