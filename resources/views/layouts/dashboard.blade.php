@extends('main')

@section('title', 'Dashboard')
@section('style')

@endsection


@section('content')

    {{-- <div class="page-heading">
            <h3>Horizontal Layout</h3>
        </div> --}}
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    @foreach ($categories_stock as $c_stock)
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="stats-icon {{ array_rand(['purple' => 1, 'blue' => 1, 'green' => 1, 'red' => 1], 1) }}">
                                                <i
                                                    class="{{ array_rand(['iconly-boldBuy' => 1, 'iconly-boldFilter' => 1, 'iconly-boldBag' => 1, 'iconly-boldBag-2' => 1, 'iconly-boldHeart' => 1], 1) }}"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold small text-truncate">
                                                {{ $c_stock->name }}
                                            </h6>
                                            <h6 class="font-extrabold mb-0">{{ $c_stock->stock ?? 0 }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Current Year Monthly Transactions</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Latest Transactions</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($last_transactions as $transaction)
                                                <tr>
                                                    <td class="col-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-md">
                                                                <img src="{{ $transaction->product->image_link }}">
                                                            </div>
                                                            <p class="font-bold ms-3 mb-0">
                                                                {{ $transaction->product->name }}</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">{{ $transaction->quantity }} </p>
                                                    </td>
                                                    <td>
                                                        <p class="mb-0">{{ $transaction->date }}</p>
                                                    </td>
                                                    <td style="text-align:right">
                                                        @if ($transaction->type == 'in')
                                                            <i class="bi bi-arrow-up text-success font-weight-bold"
                                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                                data-bs-original-title="In"></i>
                                                        @else
                                                            <i class="bi bi-arrow-down text-danger" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title=""
                                                                data-bs-original-title="Out"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <!-- <div class="card">
                                                                                                            <div class="card-body py-4 px-4">
                                                                                                                <div class="d-flex align-items-center">
                                                                                                                    <div class="avatar bg-warning avatar-xl">
                                                                                                                        {{-- <img src="assets/images/faces/1.jpg" alt="Face 1"> --}}
                                                                                                                        <span class="avatar-content">{{ strtoupper(Auth::user()->email[0]) }}</span>
                                                                                                                    </div>
                                                                                                                    <div class="ms-3 name">
                                                                                                                        <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                                                                                                                        <h6 class="text-muted mb-0">{{ '@' . Auth::user()->username }}</h6>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div> -->
                <div class="card">
                    <div class="card-header">
                        <h4>Last Month Transactions</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-last-month-transactions"></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>One Month Transactions</h4>
                    </div>
                    <div class="card-body pt-2" id="categories-chart-container">
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/pages/dashboard.js') }}"></script>
    <script>
        //LAST MONTH TRANSACTIONS CHART OPTIONS INIT
        optionsLastMonthTransactions.series = [{{ $stock_in_per }}, {{ $stock_out_per }}];

        //LAST YEAR MONTHLY TRANSACTIONS BAR OPTIONS INIT
        optionsLastYearMonthly.series = [{
                name: 'In',
                data: {!! json_encode($last_year_in) !!}
            },
            {
                name: 'Out',
                data: {!! json_encode($last_year_out) !!}
            }
        ];

        //CATEGORY DYNAMIC CHARTS INITIALIZATION
        const categories_transactions_in_out = {!! json_encode($categories_in_out) !!}; // CATEGORIES ALL TRANSACTION DATA
        const categories_chart_container = document.getElementById(
            'categories-chart-container'); // CATEGORIES CHART CONTAINER
        const svg_url = '{{ asset('vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill') }}';
        // RENDER ALL CHARTS
        const chartLastYearMonthly = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsLastYearMonthly);
        const chartLastMonthTransactions = new ApexCharts(document.getElementById('chart-last-month-transactions'),
            optionsLastMonthTransactions)
        const chart_instances = initCategoryCharts(optionsCategoryLastThirtyDayTransactions, categories_transactions_in_out,
            categories_chart_container, svg_url)
        chartLastYearMonthly.render();
        chartLastMonthTransactions.render()
        chart_instances.forEach(chart_instance => {
            chart_instance.render();
        });
    </script>
@endsection
