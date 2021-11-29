@extends('main')

@section('title', 'Products')
@section('style')
    <link rel="stylesheet" href="{{ asset('vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/choices.js/choices.min.css') }}" />
@endsection


@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-12">
                @include('errors.validation-error')
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Product Managment</h5>
                            <div class="d-flex">
                                <div class="me-3"><i class="bi bi-funnel text-xl" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-original-title="Filters" id="filter-toggler"></i>
                                </div>
                                <div class="dropstart">
                                    <div role="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"><i class="bi bi-filter text-xl"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="Sorting"></i>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('product.index') }}">All Products</a>
                                        <a class="dropdown-item"
                                            href="{{ route('product.index', ['status' => 1]) }}">Active
                                            Products</a>
                                        <a class="dropdown-item"
                                            href="{{ route('product.index', ['status' => 0]) }}">Inactive
                                            Products</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="filter-container"
                            style=" {{ request()->get('category') || request()->get('subCategory') ? 'display:block' : 'display:none' }}">
                            <form class="pt-3 row">
                                <div class="col-md-5 col-sm-12">
                                    <select name="category" id="category" class="choices form-select">
                                        <option value="">None</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if(request()->get('category') == $category->id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <select name="subCategory" id="subCategory" class="choices form-select">
                                        <option value="">None</option>
                                        @foreach ($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}" @if(request()->get('subCategory') == $subCategory->id) selected @endif>{{ $subCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12 pt-1">
                                    <button type="submit" class="btn btn-outline-primary">Filter</button>
                                </div>
                        </div>
                        </form>
                    </div>
                    <div class="card-content">
                        <div class="card-body table-responsive pt-0">
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
                                            <td data-order="{{ $product->id }}">
                                                <div class="d-flex">
                                                    <div class="avatar avatar-lg me-3">
                                                        <img src="{{ $product->image_link }}"
                                                            alt="{{ $product->name }}">
                                                    </div>
                                                    <a href="{{ route('product.edit', ['product' => $product->id]) }}"
                                                        class="d-flex flex-column text-color-inherit-all">
                                                        <span>{{ $product->name }}</span>
                                                        <span
                                                            class="small font-extrabold">{{ '#' . $product->id }}</span>
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
    <!-- Include Choices JavaScript -->
    <script src="{{ asset('vendors/choices.js/choices.min.js') }}"></script>
    <script src="{{ asset('js/pages/form-element-select.js') }}"></script>

    <!-- DATATABLE -->
    <script src="{{ asset('vendors/jquery-datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/pages/product-index.js') }}"></script>

    <script>
        $('#filter-toggler').click(function() {
            $('#filter-container').toggle();
        })
    </script>
@endsection
