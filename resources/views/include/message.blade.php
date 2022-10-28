    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    @if (session('success'))
        <script>
            swal('Good', '{{ session("success") }}', 'success');
        </script>

    @elseif(session('error'))

        <script>
            swal('Oops', '{{ session("error") }}', 'error');
        </script>

    @endif