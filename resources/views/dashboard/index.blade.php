@section('title',$title)
@section('description',$description)
@extends('layout.app')
@push('js')
    <script src="http://neowa.krapoex.com:8083/assets/js/jquery.min.js"></script>
    <script src="http://neowa.krapoex.com:8083/assets/js/socket.io.js"></script>
@endpush
@section('content')
<div class="crm mb-25">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-12">
                <div class="breadcrumb-main">
                    <h4 class="text-capitalize breadcrumb-title">{{ $title }}</h4>
{{--                    <div class="breadcrumb-action justify-content-center flex-wrap">--}}
{{--                        <nav aria-label="breadcrumb">--}}
{{--                            <ol class="breadcrumb">--}}
{{--                                <li class="breadcrumb-item"><a href="#"><i class="uil uil-estate"></i>{{ trans('page_title.dashboard') }}</a></li>--}}
{{--                                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>--}}
{{--                            </ol>--}}
{{--                        </nav>--}}
{{--                    </div>--}}
                </div>
            </div>

            @include('components.saldo')
{{--            @include('components.dashboard.demo_one.overview_cards')--}}
{{--            @include('components.dashboard.demo_one.sales_report')--}}
{{--            @include('components.dashboard.demo_one.sales_growth')--}}
{{--            @include('components.dashboard.demo_one.sales_location')--}}
{{--            @include('components.dashboard.demo_one.top_sale_products')--}}
{{--            @include('components.dashboard.demo_one.browser_state')--}}

        </div>
    </div>
</div>
@endsection
