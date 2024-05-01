@section('title',$title)
@section('description',$description)
@extends('layout.app')
{{--@push('js')--}}
{{--    <script src="http://neowa.krapoex.com:8083/assets/js/jquery.min.js"></script>--}}
{{--    <script src="http://neowa.krapoex.com:8083/assets/js/socket.io.js"></script>--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            buttons = document.querySelectorAll('.btn-change-user');--}}
{{--            buttons.forEach(function (button) {--}}
{{--                button.addEventListener('click', function (e) {--}}
{{--                    e.preventDefault();--}}

{{--                    //     get attribute data-url from button--}}
{{--                    var id = $(this).data('id');--}}
{{--                    var select = $(this).data('select');--}}

{{--                //     do ajax to '/change-node-user' with method post--}}
{{--                    $.ajaxSetup({--}}
{{--                        headers: {--}}
{{--                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                        }--}}
{{--                    })--}}

{{--                    $.ajax({--}}
{{--                        url: '/change-node-user',--}}
{{--                        method: 'post',--}}
{{--                        data: {--}}
{{--                            id: id,--}}
{{--                            email: $('#' + select).val()--}}
{{--                        },--}}
{{--                        success: function (response) {--}}
{{--                            alert(response)--}}
{{--                            $('#current' + id).html($('#' + select).val())--}}
{{--                        }--}}


{{--                    })--}}
{{--                })--}}
{{--            });--}}


{{--        });--}}
{{--        document.addEventListener("click", someListener);--}}

{{--        function someListener(event) {--}}
{{--            var element = event.target;--}}
{{--            if (element.classList.contains("close-node")) {--}}
{{--                console.log('is close node')--}}

{{--                var idmodal = element.getAttribute('data-idmodal');--}}
{{--                $('#' + idmodal).removeClass('show');--}}
{{--                $('#' + idmodal).css('display', 'none');--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--@endpush--}}
@section('content')
    <div class="crm mb-25">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">{{$title}}
                    </div>
                </div>
                <div class="row">
                    {{--                    @foreach($nodes as $key => $node)--}}
                    {{--                        <div class="col-lg-4 col-md-6">--}}
                    {{--                            <div class="card card-block card-stretch card-height nodes-card">--}}
                    {{--                                <div class="card-body">--}}
                    {{--                                    <div class="d-flex justify-content-between w-100 align-items-center gap-2">--}}
                    {{--                                        <h6 class="mb-0">Node {{ $key+1 }}</h6>--}}
                    {{--                                        @if($node->is_scanned == 1)--}}
                    {{--                                            <span class="rounded-pill bg-success text-bg-success flex-1">$node->phone</span>--}}
                    {{--                                        @elseif($node->health != 'yes')--}}
                    {{--                                            <span--}}
                    {{--                                                class="rounded-pill bg-danger text-bg-danger flex-1">Offline</span>--}}
                    {{--                                        @else--}}
                    {{--                                            <span--}}
                    {{--                                                class="rounded-pill bg-warning text-bg-warning flex-1 text-center text-white" style="font-size: 11px; padding: 0 6.64px; line-height: 20px; height: 20px"">Available</span>--}}
                    {{--                                        @endif--}}
                    {{--                                        @if($node->is_scanned == 0 && $node->health == 'yes')--}}
                    {{--                                            <a href="#" class="btn btn-sm btn-info flex-1 btn-scan"--}}
                    {{--                                               style="font-size: 11px; padding: 0 6.64px; line-height: normal; height: 20px">Scan--}}
                    {{--                                                Node</a>--}}
                    {{--                                        @endif--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    @endforeach--}}
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Code</th>
                            <th class="text-center" scope="col">Status</th>
                            <th class="text-center" scope="col">Allocation</th>
                            <th class="text-center" scope="col">Phone</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($nodes as $key => $node)
                            <tr>
                                <th class="text-center" scope="row">{{ $key+1 }}</th>
                                <td class="text-center">{{ $node->nama }}</td>
                                <td class="text-center">
                                    @if($node->health == "OK")
                                        <span
                                            class="rounded-pill bg-success text-bg-success flex-1 text-center text-white"
                                            style="font-size: 14px; padding: 0 6.64px; line-height: 20px; height: 20px">Scanned</span>
                                    @elseif($node->health == "NOK" || $node->health == "NOKLOGIN")
                                        <span
                                            class="rounded-pill bg-warning text-bg-warning flex-1 text-center text-white"
                                            style="font-size: 14px; padding: 0 6.64px; line-height: 20px; height: 20px">Not Scanned</span>
                                    @else
                                        <span
                                            class="rounded-pill bg-dark text-bg-dark flex-1 text-center text-white"
                                            style="font-size: 14px; padding: 0 6.64px; line-height: 20px; height: 20px">Service Down</span>

                                    @endif
                                </td>
                                <td class="text-center" id="current{{$node->id_device}}">
                                    {{ $node->reseller_user_allocation }}
                                </td>
                                <td class="text-center">
                                    {{ $node->phone }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
