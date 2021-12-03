    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @if (session('error'))
        <script>
            swal('Oops', '{{ session('error') }}', 'error');
        </script>

    @endif
