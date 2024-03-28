@section('title',$title)
@section('description',$description)
@extends('layout.app')
@push('js')
    <script src="http://neowa.krapoex.com:8083/assets/js/jquery.min.js"></script>
    <script src="http://neowa.krapoex.com:8083/assets/js/socket.io.js"></script>
    <script>
        $(document).ready(function () {
            buttons = document.querySelectorAll('.btn-scan');
            buttons.forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();

                    //     get attribute data-url from button
                    var url = $(this).data('url');
                    //     get data-node-id from button
                    var node_id = $(this).data('node-id');

                    // add class 'show' to modal with id 'scan + node_id'
                    $('#scan' + node_id).addClass('show');
                    // add display block to modal with id 'scan + node_id'
                    $('#scan' + node_id).css('display', 'block');

                    var socket = io(url)

                    socket.on('connection', function (socket) {
                        console.log("connc");
                    });

                    socket.on('message', function (msg) {
                        $('#data_logs' + node_id).append($('<li class="list-group-item"">').text(msg));
                    });

                    socket.on('qr', function (src) {
                        $('#qrcode' + node_id).attr('src', src);
                        $('#qrcode' + node_id).show();
                    });

                    socket.on('ready', function (data) {
                        $('#qrcode' + node_id).hide();
                    });

                    socket.on('authenticated', function (data) {
                        $('#qrcode').hide();
                    });
                })
            });


        });
        document.addEventListener("click", someListener);

        function someListener(event) {
            var element = event.target;
            if (element.classList.contains("close-node")) {
                console.log('is close node')

                var idmodal = element.getAttribute('data-idmodal');
                $('#' + idmodal).removeClass('show');
                $('#' + idmodal).css('display', 'none');
            }
        }
    </script>
@endpush
@section('content')
    @foreach($nodes as $key => $node)
        <div class="modal fade" id="scan{{$node->id_device}}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="box-title">Scan Node {{$key + 1}}</h5>
                        <a href="#" class="close close-node">
                            <span class="close-node" data-idmodal="scan{{$node->id_device}}"
                                  aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            {{ csrf_field() }}
                            <input type="hidden" id="tuClientId">
                            <div class="form-group row">
                                <img src="" alt="QR Code" id="qrcode{{$node->id_device}}" class="img-fluid">
                            </div>

                            <div class="form-group row">
                                <p>Engine Logs : </p>
                                <ul class="list-group" id="data_logs{{$node->id_device}}">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

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
                            <th scope="col">#</th>
                            <th scope="col">Status</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Scan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @foreach($nodes as $key => $node)
                                <th scope="row">{{ $key+1 }}</th>
                                <td>
                                    @if($node->is_scanned == 1)
                                        <span
                                            class="rounded-pill bg-success text-bg-success flex-1 text-center text-white"
                                            style="font-size: 14px; padding: 0 6.64px; line-height: 20px; height: 20px">Active</span>
                                    @elseif($node->health != 'yes')
                                        <span
                                            class="rounded-pill bg-danger text-bg-danger flex-1 text-center text-white"
                                            style="font-size: 14px; padding: 0 6.64px; line-height: 20px; height: 20px">Offline</span>
                                    @else
                                        <span
                                            class="rounded-pill bg-warning text-bg-warning flex-1 text-center text-white"
                                            style="font-size: 14px; padding: 0 6.64px; line-height: 20px; height: 20px">Available</span>
                                    @endif
                                </td>
                                <td>
                                    @if($node->is_scanned == 1 && $node->health == 'yes')
                                        {{ $node->phone }}
                                    @endif
                                </td>
                                <td>
                                    @if($node->is_scanned == 0 && $node->health == 'yes')
                                        <a href="#" data-url="{{$node->url_socket}}" data-node-id="{{$node->id_device}}"
                                           class="btn btn-sm btn-info flex-1 btn-scan"
                                           style="font-size: 14px; padding: 0 6.64px; line-height: normal; height: 20px">Scan
                                            Node</a>
                                    @endif
                                </td>
                        </tr>
                        </tbody>
                    </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
