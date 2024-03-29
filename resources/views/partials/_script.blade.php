<!-- JavaScript Bundle with Popper -->
<script src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendors/apexcharts/apexcharts.js') }}"></script>
<script src="{{ asset('js/pages/horizontal-layout.js') }}"></script>
<script src="{{ asset('vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>


<!-- global app configuration object -->
<script>
    var config = {
        routes: {
            import: "{{ route('import.import') }}",
            product: {
                status:  "{{ route('product.status', ['product'=>'ID']) }}"
            },
            transactions: {
                request:  "{{ route('request-transaction.index') }}",
                grant:  "{{ route('grant-transaction.index') }}"
            }
        },
        loader: {
            hide: function() {
                document.getElementById('loader-container').classList.add('d-none');
                document.body.classList.remove('overflow-hidden');
            },
            show: function() {
                document.getElementById('loader-container').classList.remove('d-none');
                document.body.classList.add('overflow-hidden');
            },
            toggle: function() {
                $('#loader-container').toggleClass('d-none')
                $('body').toggleClass('overflow-hidden')
            }
        },
        messages: {
            success: function(message = 'Package added successfully.', delay = 2000) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    text: message,
                    showConfirmButton: false,
                    timer: delay
                })
            },
            error: function(message = 'The transaction could not be completed.', delay = 2500) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    text: message,
                    showConfirmButton: false,
                    timer: delay
                })
            },
            info: function(message, delay = 1500) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    text: message,
                    showConfirmButton: false,
                    timer: delay
                })
            },
            confirm: function(callback, data, message = 'Are you sure?', delay = 1500) {
                Swal.fire({
                    title: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback && data && callback(data);
                    }
                })
            }

        },
        func: {
            customError: function(response) {
                let errors = response.responseJSON.errors;
                if (errors && typeof errors === 'object')
                    for (const key in errors) {
                        return errors[key][0];
                    }

                return response.responseJSON.message ? response.responseJSON.message : null;
            },
        },
    };

    @if (\Session::has('popupMessage'))
        @switch(\Session::get('popupMessage')['status'])
            @case('success')
                config.messages.success("{{ \Session::get('popupMessage')['message'] }}")
            @break
            @case('error')
                config.messages.error("{{ \Session::get('popupMessage')['message'] }}")
            @break
            @default
                config.messages.info("{{ \Session::get('popupMessage')['message'] }}")
        @endswitch
    @endif

    
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    
</script>
