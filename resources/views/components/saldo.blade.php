<div class="col-xxl-6">
    <div class="row">
        <div class="col-xxl-6 col-sm-6 mb-25">
            <!-- Card 1  -->
            <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">


                <div class="overview-content w-100">
                    <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                        <div class="ap-po-details__titlebar">
                            <h1>{{$saldo}}</h1>
                            <p>Nodes Teralokasi ke Participant</p>
                        </div>
                        <div class="ap-po-details__icon-area">
                            <div class="svg-icon order-bg-opacity-primary color-primary">
                                <i class="fa fa-server"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Card 1 End  -->
        </div>

        <div class="col-xxl-6 col-sm-6 mb-25">
            <!-- Card 2 -->
            <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                <div class="overview-content w-100">
                    <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                        <div class="ap-po-details__titlebar">
                            <h1>{{ $trx_today }}</h1>
                            <p>Total WA hari ini by Participant</p>
                        </div>
                        <div class="ap-po-details__icon-area">
                            <div class="svg-icon order-bg-opacity-info color-info">

                                <i class="fa fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Card 2 End  -->
        </div>


        <div class="col-xxl-6 col-sm-6 mb-25">
            <!-- Card 3 -->
            <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">


                <div class="overview-content w-100">
                    <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                        <div class="ap-po-details__titlebar">
                            <h1>{{$trx_all}}</h1>
                            <p>Total WA all-time by Participant</p>
                        </div>
                        <div class="ap-po-details__icon-area">
                            <div class="svg-icon order-bg-opacity-secondary color-secondary">

                                <i class="fa fa-calendar-week"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Card 3 End  -->
        </div>
        <div class="col-xxl-6 col-sm-6 mb-25">
            <!-- Card 4  -->
            <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                <div class="overview-content w-100">
                    <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                        <div class="ap-po-details__titlebar">
                            <h1>{{$participant}}</h1>
                            <p>Jumlah Participant Terdaftar</p>
                        </div>
                        <div class="ap-po-details__icon-area">
                            <div class="svg-icon order-bg-opacity-warning color-warning">

                                <i class="uil uil-users-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Card 4 End  -->
        </div>

            <div class="col-xxl-12 col-sm-12 mb-25">
                <!-- Card 4  -->
                <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                    <div class="overview-content w-100">
                        <div class=" ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div class="ap-po-details__titlebar">
                                <h1>Rp. {{ number_format($saldoKolektif)}}</h1>
                                <p>Saldo Wallet Kolektif Participant</p>
                            </div>
                            <div class="ap-po-details__icon-area">
                                <div class="svg-icon order-bg-opacity-warning color-warning">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Card 4 End  -->
            </div>
    </div>
</div>
