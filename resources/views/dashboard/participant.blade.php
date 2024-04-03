@section('title',$title)
@section('description',$description)
@extends('layout.app')
@push('js')
    <script src="http://neowa.krapoex.com:8083/assets/js/jquery.min.js"></script>
    <script src="http://neowa.krapoex.com:8083/assets/js/socket.io.js"></script>
    <script>
        $(document).ready(function () {
            buttons = document.querySelectorAll('.btn-toggle');
            buttons.forEach(function (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();

                    //     get attribute data-url from button
                    var id = $(this).data('id');
                    var iduser = $(this).data('the-id');

                    //     do ajax to '/change-node-user' with method post
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })

                    $.ajax({
                        url: '/toggle-user/' + id,
                        method: 'get',
                        success: function (response) {
                            alert(response)
                            //     if success, change the text of button
                            if (response == 'success') {
                                if ($('#togglestatus' + iduser).text() == 'Active') {
                                    $('#togglestatus' + iduser).text('Nonactive')
                                    $('#togglestatus' + iduser).removeClass('bg-success')
                                    $('#togglestatus' + iduser).addClass('bg-danger')
                                } else {
                                    $('#togglestatus' + iduser).text('Active')
                                    $('#togglestatus' + iduser).removeClass('bg-danger')
                                    $('#togglestatus' + iduser).addClass('bg-success')
                                }
                            }
                        }
                    })
                })
            });

            //     check if participantEmail, participantPhone, and participantNama is not empty
            $('#participantEmail, #participantPhone, #participantNama, #participantFee').on('keyup', function () {
                if ($('#participantEmail').val() != '' && $('#participantPhone').val() != '' && $('#participantNama').val() != '' && $('#participantFee').val() != 0) {
                    $('#btnSaveParticipant').prop('disabled', false)
                } else {
                    $('#btnSaveParticipant').prop('disabled', true)
                }
            })

            //     when button save participant clicked do ajax to '/add-participant' with method post
            $('#btnSaveParticipant').on('click', function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })

                $.ajax({
                    url: '/add-participant',
                    method: 'post',
                    data: {
                        email: $('#participantEmail').val(),
                        phone: $('#participantPhone').val(),
                        nama: $('#participantNama').val(),
                        fee: $('#participantFee').val()
                    },
                    success: function (response) {
                        if (response == 'success') {
                            location.reload()
                        } else {
                            alert('Failed to add participant')
                        }
                    }
                })
            })
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
    <div class="modal fade" id="addParticipant" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="box-title">Add New Participant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Phone</label>
                        <input type="number" class="form-control" id="participantPhone" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="participantEmail" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="participantNama" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Fee (if value is 10, then 90% of wallet
                            is for participant)</label>
                        <input type="number" class="form-control" id="participantFee" placeholder="10, 20, 30 etc">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSaveParticipant" disabled>Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="crm mb-25">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">{{$title}}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="w-100 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary btn-sm end-0" data-bs-toggle="modal"
                                data-bs-target="#addParticipant">
                            Add Participant
                        </button>
                    </div>
                </div>
                <div class="row justify-content-center flex-1 pe-0">
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
                    <table class="table table-striped w-100">
                        <thead>
                        <tr>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Email</th>
                            <th class="text-center" scope="col">Phone</th>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Rekening</th>
                            <th class="text-center" scope="col">Wallet</th>
                            <th class="text-center" scope="col">Fee</th>
                            <th class="text-center" scope="col">After Fee</th>
                            <th class="text-center" scope="col">Is Active</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user as $key => $u)
                            <tr>
                                <th class="text-center" scope="row">{{ $key+1 }}</th>
                                <td class="text-center">{{ $u->email }}</td>
                                <td class="text-center">
                                    {{ $u->phone }}
                                </td>
                                <td class="text-center">
                                    {{ $u->nama }}
                                </td>
                                <td class="text-center">
                                    {{ $u->rekening }}
                                </td>
                                <td class="text-center">
                                    Rp. {{ number_format($u->wallet) }}
                                </td>
                                <td class="text-center">
                                    ({{$u->fee}}%) Rp. {{ number_format($u->wallet * (100/$u->fee / 100)) }}
                                </td>
                                <td class="text-center">
                                    Rp. {{ number_format($u->wallet - ($u->wallet * (100/$u->fee / 100))) }}
                                </td>
                                <td class="text-center">
                                    @if($u->is_active == 1)
                                        <span
                                            class="rounded-pill bg-success text-bg-success flex-1 text-center text-white"
                                            id="togglestatus{{$u->id}}"
                                            style="font-size: 14px; padding: 0 6.64px; line-height: 20px; height: 20px">Active</span>
                                    @else
                                        <span
                                            class="rounded-pill bg-danger text-bg-danger flex-1 text-center text-white"
                                            id="togglestatus{{$u->id}}"
                                            style="font-size: 14px; padding: 0 6.64px; line-height: 20px; height: 20px">Nonactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button data-id="{{$u->email}}" data-the-id="{{$u->id}}"
                                            class="btn btn-sm btn-info mx-auto btn-toggle"
                                            style="font-size: 14px; padding: 0 6.64px; line-height: normal; height: 20px">
                                        Toggle Active
                                    </button>
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
