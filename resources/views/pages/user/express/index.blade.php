@extends('layouts.dashboard')
@section('style')
<style>
    .datatable_filter label{
        float: left !important;
    }
</style>
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<section class="container-fluid mt-0 pt-0">
    <div class="row bg-light">
        <div class="d-flex flex-column flex-shrink-0" style="width: 220px;height:100vh">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <span class="fs-4">{{ __('Shipping') }}</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="{{ route('front.express.index') }}" class="nav-link active" aria-current="page">
                        {{ __('Local Shipping') }}
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-dark">
                        {{ __('International Shipping') }}
                    </a>
                </li>
            </ul>
        </div>

        <div class="col px-5">
            @yield('expressContent')
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@if (app()->getLocale() === 'ar')
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            "order": [[0, 'desc']],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
            }
        });

        $('.basic-1').DataTable({
            "order": [[0, 'desc']],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
            }
        });

        $('#basic-1').DataTable({
            "order": [[0, 'desc']],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json"
            }
        });
        $('.js-example-basic-single').select2();
    } );
</script>
@else
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            "order": [[0, 'desc']]
        });
        $('.basic-1').DataTable({
            "order": [[0, 'desc']]
        });
        $('#basic-1').DataTable({
            "order": [[0, 'desc']]
        });
        $('.js-example-basic-single').select2();
    } );
</script>
@endif
@endsection
