    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    @if (session('error'))
        <script>
            swal('Oops', '{{ session('error') }}', 'error');
        </script>

    @endif
