@extends('main')

@section('title', 'Edit Product')
@section('style')
    <link rel="stylesheet" href="{{ asset('vendors/choices.js/choices.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/widgets/upload-avatar.css') }}" />
@endsection


@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-12">
                @include('errors.validation-error')
                <form class="card" id="form" method="POST" action="{{ route('product.update', ['product' => $product->id]) }}"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title">Create Product</h5>
                        <div>
                            <button type="submit" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center"><i
                                    class="bi bi-upload me-1"></i>Save</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            @include('components.upload-avatar',['parent_class' => 'm-auto','background_url' => $product->image_link])
                                        </div>
                                        <div class="col-lg-9 pt-4">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Name<span class="ps-1 text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <input type="text" id="name" class="form-control"
                                                        value="{{ $product->name }}" name="name" placeholder="Name">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Stock<span class="ps-1 text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <input type="number" id="stock" value="{{ $product->quantity }}"
                                                        class="form-control" name="stock" placeholder="0">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Type</label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <input type="text" id="type" name="article_code" value="{{ $product->article_code }}"
                                                        class="form-control" placeholder="Article Code">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Category<span class="ps-1 text-danger">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="choices form-select" name="category">
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" @if ($product->category->id == $category->id) {{ 'selected' }} @endif>
                                                                {{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Sub-Category</label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="choices form-select" name="sub_category">>
                                                        @foreach ($sub_categories as $sub_category)
                                                            <option value="{{ $sub_category->id }}"
                                                                @if ($product->sub_category && $product->sub_category->id == $sub_category->id) {{ 'selected' }} @endif>
                                                                {{ $sub_category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <!-- Include Choices JavaScript -->
    <script src="{{ asset('vendors/choices.js/choices.min.js') }}"></script>
    <script src="{{ asset('js/pages/form-element-select.js') }}"></script>
    <script src="{{ asset('js/widgets/upload-avatar.js') }}"></script>
@endsection
