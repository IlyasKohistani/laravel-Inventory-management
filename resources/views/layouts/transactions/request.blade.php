@extends('main')

@section('title', 'Requests')
@section('style')
    <link rel="stylesheet" href="{{ asset('vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
@endsection


@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-12">
                @include('errors.validation-error')
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title">Requests List</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body table-responsive">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>R-Quantity/Stock</th>
                                        <th>Date</th>
                                        <th>Approved/Rejected By</th>
                                        <th>Approved/Rejected At</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="avatar avatar-lg me-3">
                                                        <img src="{{ $request->product->image_link }}"
                                                            alt="{{ $request->product->name }}">
                                                    </div>
                                                    <a href="{{ route('product.edit', ['product' => $request->product->id]) }}"
                                                        class="d-flex flex-column text-color-inherit-all">
                                                        <span>{{ $request->product->name }}</span>
                                                        <span
                                                            class="small font-extrabold">{{ '#' . $request->product->id }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $request->quantity }}/{{ $request->stock }}
                                            </td>
                                            <td>
                                                {{ $request->created_at }}
                                            </td>
                                            <td>
                                                {{ $request->approved_user ? $request->approved_user->name . ' ' . $request->approved_user->surname : '-' }}
                                            </td>
                                            <td>
                                                {{ $request->approved_at ?? '-' }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @switch($request->status)
                                                        @case(0)
                                                            <i class="bi bi-arrow-down text-danger mb-1 me-1"></i><span
                                                                class="text-danger">Rejected</span>
                                                        @break
                                                        @case(1)
                                                            <i class="bi bi-clock-history mb-1 text-muted me-1"></i><span
                                                                class="text-muted">Pending</span>
                                                        @break

                                                        @case(2)
                                                            <i class="bi bi-check text-xl text-success mb-2 me-1"></i><span
                                                                class="text-success">Approved</span>
                                                        @break
                                                        @case(3)
                                                            <i class="bi bi-check-all text-xl text-success mb-2 me-1"></i><span
                                                                class="text-success">Completed</span>
                                                        @break
                                                        @default
                                                            -
                                                    @endswitch
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    @if ($request->status == 3)
                                                        -
                                                    @else
                                                        <div class="dropdown">
                                                            <div role="button" id="dropdownMenuButton"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical text-xl"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="" data-bs-original-title="Actions"></i>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-dark"
                                                                aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('request-transaction.status', ['request_transaction' => $request->id, 'status' => 2]) }}">Approve</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('request-transaction.status', ['request_transaction' => $request->id, 'status' => 3]) }}">Complete</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('request-transaction.status', ['request_transaction' => $request->id, 'status' => 0]) }}">Reject</a>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                    onclick="removeProduct('{{ route('request-transaction.destroy', ['request_transaction' => $request->id]) }}')">Remove</a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <form action="" method="post" id="delete_form">
        @method('DELETE')
        @csrf
    </form>
@endsection

@section('script')
    <script src="{{ asset('vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#datatable").DataTable({
            responsive: true
        });

        //DELETE BUTTON CLICK
        function removeProduct(url) {
            config.messages.confirm(submitDeleteForm, url)
        }
        //SUBMIT FORM
        function submitDeleteForm(url) {
            const form = document.getElementById('delete_form');
            form.action = url;
            form.submit();
        }
    </script>
@endsection
