@extends('main')

@section('title', 'Products')
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
                        <h5 class="card-title">Product Managment</h5>
                        <div class="dropstart">
                            <div role="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"><i class="bi bi-filter text-xl" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-original-title="Filters"></i>
                            </div>
                            <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('product.index') }}">All Products</a>
                                <a class="dropdown-item" href="{{ route('product.index', ['status' => 1]) }}">Active
                                    Products</a>
                                <a class="dropdown-item" href="{{ route('product.index', ['status' => 0]) }}">Inactive
                                    Products</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body table-responsive">
                            <table class="table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="avatar avatar-lg me-3">
                                                        <img src="{{ $product->image_link }}"
                                                            alt="{{ $product->name }}">
                                                    </div>
                                                    <a href="{{ route('product.edit', ['product' => $product->id]) }}"
                                                        class="d-flex flex-column text-color-inherit-all">
                                                        <span>{{ $product->name }}</span>
                                                        <span class="small font-extrabold">{{ '#' . $product->id }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $product->category->name }}
                                            </td>
                                            <td>
                                                {{ $product->quantity }}
                                            </td>
                                            <td>
                                                {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    @if ($product->status == 0)
                                                        <i onclick="onDisableButtonClick({{ $product->id }},1)"
                                                            class="bi bi-check text-success cursor-pointer text-xl me-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                            data-bs-original-title="Activate Product"></i>
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
                                                                    href="{{ route('product.edit', ['product' => $product->id]) }}">Edit</a>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="onRequestButtonClick({{ $product->id }}, '{{ $product->name }}', {{ $product->quantity }})">Request</a>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="onGrantButtonClick({{ $product->id }},'{{ $product->name }}', {{ $product->quantity }})">Grant</a>
                                                                <a class="dropdown-item" href="#" class="disable-button"
                                                                    onclick="onDisableButtonClick({{ $product->id }},0)">Inactivate</a>
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
@endsection

@section('script')
    <script src="{{ asset('vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script>
        // Jquery Datatable
        let jquery_datatable = $("#datatable").DataTable({
            responsive: true
        });


        //DISABLE REQUEST
        function onDisableButtonClick(id, status) {
            let data = {
                id: id,
                status: status,
                message: status == 1 ? 'Product has been activated successfully!' :
                    'Product has been inactivated successfully!'
            }
            config.messages.confirm(disableProduct, data)
        }

        

        function disableProduct(data) {
            config.loader.show();
            var formData = new FormData();
            formData.append("id", data.id);
            formData.append("status", data.status);
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            $.ajax({
                url: config.routes.product.status.replace('ID', data.id),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    config.loader.hide();
                    config.messages.success(data.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                },
                error: function(response, error) {
                    config.loader.hide();
                    config.messages.error(config.func.customError(response));
                }
            });
        }

        //REQUEST FOR PRODUCT
        function onRequestButtonClick(id, name, stock) {
            Swal.fire({
                title: 'Request Details',
                html: `<p class="text-start ps-3 small ms-1">There is only ` + stock + " " + name + ` items left in stock.</p>
                        <input type="number" id="quantity" class="swal2-input w-75" placeholder="Quantity">
                        <textarea id="note" class="swal2-input w-75" placeholder="Note"></textarea>`,
                confirmButtonText: 'Submit',
                focusConfirm: false,
                customClass: {
                    title: 'text-muted text-start ps-5',
                    htmlContainer: 'mt-0',
                },
                showCancelButton: true,
                preConfirm: () => {
                    const quantity = Swal.getPopup().querySelector('#quantity').value
                    const description = Swal.getPopup().querySelector('#note').value
                    if (!quantity || quantity < 1) {
                        Swal.showValidationMessage(`Qauntity is required.`)
                    }
                    return {
                        quantity: quantity,
                        description: description
                    }
                }
            }).then((result) => {
                if (result.isDismissed) return false;
                config.loader.show();
                var formData = new FormData();
                formData.append("product_id", id);
                formData.append("quantity", result.value.quantity);
                formData.append("note", result.value.description);
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                $.ajax({
                    url: config.routes.transactions.request,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        config.loader.hide();
                        config.messages.success('Your request has been created successfully.');
                        setTimeout(() => {
                            window.location.href = config.routes.transactions.request;
                        }, 1500);
                    },
                    error: function(response, error) {
                        config.loader.hide();
                        config.messages.error(config.func.customError(response));
                    }
                });
            })
        }


        //GRANT PRODUCT
        function onGrantButtonClick(id, name, stock) {
            Swal.fire({
                title: 'Grant Details',
                html: `<p class="text-start ps-3 small ms-1">There is only ` + stock + " " + name + ` items left in stock.</p>
                <input type="number" id="quantity" class="swal2-input w-75" placeholder="Quantity">
                <input type="text" id="recipient" class="swal2-input w-75" placeholder="Recipient">
                <textarea id="note" class="swal2-input w-75" placeholder="Note"></textarea>`,
                confirmButtonText: 'Submit',
                focusConfirm: false,
                customClass: {
                    title: 'text-muted text-start ps-5',
                    htmlContainer: 'mt-0',
                },
                showCancelButton: true,
                preConfirm: () => {
                    const quantity = Swal.getPopup().querySelector('#quantity').value
                    const recipient = Swal.getPopup().querySelector('#recipient').value
                    const description = Swal.getPopup().querySelector('#note').value
                    if (!quantity) {
                        Swal.showValidationMessage(`Qauntity is required.`)
                    }
                    if (quantity > stock) {
                        Swal.showValidationMessage(`There is only ` + stock + ` items left in stock.`)
                    }
                    return {
                        quantity: quantity,
                        recipient: recipient,
                        description: description
                    }
                }
            }).then((result) => {
                if (result.isDismissed) return false;
                config.loader.show();
                var formData = new FormData();
                formData.append("product_id", id);
                formData.append("quantity", result.value.quantity);
                formData.append("recipient", result.value.recipient);
                formData.append("note", result.value.description);
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                $.ajax({
                    url: config.routes.transactions.grant,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        config.loader.hide();
                        config.messages.success('Your grant has been created successfully.');
                        setTimeout(() => {
                            window.location.href = config.routes.transactions.grant;
                        }, 1500);
                    },
                    error: function(response, error) {
                        config.loader.hide();
                        config.messages.error(config.func.customError(response));
                    }
                });
            })
        }
    </script>
@endsection
