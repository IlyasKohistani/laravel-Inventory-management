@extends('main')

@section('title', 'Grants')
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
                        <h5 class="card-title">Grants List</h5>
                    </div>
                    <div class="card-content">
                        <div class="card-body table-responsive">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>G-Quantity/Stock</th>
                                        <th>Recipient</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grants as $grant)
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="avatar avatar-lg me-3">
                                                        <img src="{{ $grant->product->image_link }}"
                                                            alt="{{ $grant->product->name }}">
                                                    </div>
                                                    <a href="{{ route('product.edit', ['product' => $grant->product->id]) }}"
                                                        class="d-flex flex-column text-color-inherit-all">
                                                        <span>{{ $grant->product->name }}</span>
                                                        <span class="small font-extrabold">{{ '#' . $grant->product->id }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $grant->quantity }}/{{ $grant->product->quantity }}
                                            </td>
                                            <td>
                                                {{ $grant->recipient }}
                                            </td>
                                            <td>
                                                {{ $grant->created_at }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <div class="dropdown">
                                                        <div role="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                            aria-haspopup="true"  aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical text-xl"
                                                                data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                                data-bs-original-title="Actions"></i>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-dark"
                                                            aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="removeProduct('{{ route('grant-transaction.destroy',['grant' => $grant->id]) }}')">Cancel</a>
                                                        </div>
                                                    </div>
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
        function submitDeleteForm(url){
            const form = document.getElementById('delete_form');
            form.action = url;
            form.submit();
        }
    </script>
@endsection
