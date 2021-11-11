@extends('main')

@section('title', 'Imports')
@section('style')
    <link rel="stylesheet" href="{{ asset('vendors/toastify/toastify.css') }}">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <style>
        /**
                 * FilePond Custom Styles
                 */
        .filepond--drop-label {
            color: #4c4e53;
        }

        .filepond--label-action {
            text-decoration-color: #babdc0;
        }

        .filepond--panel-root {
            border-radius: 2em;
            background-color: #edf0f4;
            height: 1em;
        }

        .filepond--item-panel {
            background-color: #435ebe;
        }

        .filepond--drip-blob {
            background-color: #7f8a9a;
        }

        .filepond--credits {
            top: 5px !important;
        }

    </style>
@endsection


@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-12">
                @include('errors.validation-error')
                <form class="card" id="form" method="post" action="{{ route('import.import') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title">Import Records</h5>
                        <button type="submit" class="btn btn-outline-primary btn-sm d-flex align-items-center"><i
                                class="bi bi-upload me-1"></i>Upload</button>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">Using the import template or already created valid Excel file, upload
                                here to see how your file look. <code>If your Excel file rows contain valid data,</code> All
                                records would be stored. In order to be sure about data validaty, you should download an
                                example Excel file template.<a href="#"> click here!</a>
                            </p>
                            <!-- File uploader with validation -->
                            <input type="file" class="with-validation-filepond" name="file" id="filepond-input-field"
                                required data-max-file-size="100MB" data-max-files="3">
                        </div>
                    </div>
                </form>
                <div id="dataTable"></div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <!-- filepond validation -->
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <!-- toastify -->
    <script src="{{ asset('vendors/toastify/toastify.js') }}"></script>
    <!-- filepond -->
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <!-- Custom -->
    <script src="{{ asset('js/pages/imports.js') }}"></script>
    <script src="{{ asset('js/mazer.js') }}"></script>
@endsection
