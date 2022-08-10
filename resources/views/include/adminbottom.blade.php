C</div>
<!-- ./wrapper -->


<!-- jQuery 3 -->
<script src="{{ asset('ext/bower_components/jquery/dist/jquery.min.js') }}"></script>


@if (Session::has('username') == true)
@if (session('loginCount') < 1) <script src="{{ asset('hopscotch/dist/js/hopscotch.js') }}">
    </script>
    @endif
    @endif

    <!-- Tour Guide plugin -->
    <script src="{{ asset('js/my_first_tour.js') }}"></script>

    <script src="https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
        integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('ext/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('merchantassets/assets/js/dropzone/dropzone.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- bootstrap js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('ext/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Morris.js charts -->
    <script src="{{ asset('ext/bower_components/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('ext/bower_components/morris.js/morris.min.js') }}"></script>

    <!-- DataTables -->
    {{-- <script src="{{ asset('ext/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('ext/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    --}}

    <!-- Sparkline -->
    <script src="{{ asset('ext/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>

    <!-- jvectormap -->
    <script src="{{ asset('ext/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('ext/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- jQuery Knob Chart -->
    <script src="{{ asset('ext/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>

    <!-- daterangepicker -->
    <script src="{{ asset('ext/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('ext/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('ext/plugins/iCheck/icheck.min.js') }}"></script>


    <!-- bootstrap color picker -->
    <script src="{{ asset('ext/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}">
    </script>

    <!-- Summer Note -->
    <script type="text/javascript">
        $(document).ready(function() {

        $('.summernote').summernote();

    });
    </script>

    <!-- bootstrap time picker -->
    <script src="{{ asset('ext/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

    <!-- datepicker -->
    <script src="{{ asset('ext/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('ext/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

    <!-- Slimscroll -->
    <script src="{{ asset('ext/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('ext/bower_components/fastclick/lib/fastclick.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('ext/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('ext/dist/js/pages/dashboard.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('ext/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- InputMask -->
    <script src="{{ asset('ext/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('ext/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('ext/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('ext/dist/js/demo.js') }}"></script>
    {{-- <script src="{{ asset('ext/dist/js/main.js') }}"></script> --}}

    <script src="{{ asset('js/country-state-select.js') }}"></script>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/dt-1.10.25/b-1.7.1/b-html5-1.7.1/datatables.min.js">
    </script>


    {{-- <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>


    @if (session('role') != 'Super')
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/60e32cb8649e0a0a5ccaa278/1f9rmdccf';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    @endif




    <!-- CK Editor -->
    <script src="{{ asset('ext/bower_components/ckeditor/ckeditor.js') }}"></script>


    <script src="{{ asset('pace/pace.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('ext/documentation/docs.js') }}"></script>

    <script>
        $(document).ready(function() {
        $('#example4').DataTable({
            'pageLength': 200,
        });
        $('#message').summernote({
            height: 300,
        });



    });
    </script>

    <script>
        $(function() {
        $('#example1').DataTable({
            'pageLength': 200,
        });
        $('#example2').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'pageLength': 200,
        });

        $('#example3').DataTable({
            'paging': true,
            'pageLength': 200,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });

        $('#promousers').DataTable({
            'paging': true,
            'pageLength': 20,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });



        //Initialize Select2 Elements
        $('.select2').select2();
        // CKEDITOR.replace('event_description');
        // CKEDITOR.replace('single_description');

        //Date picker
        $('#datepicker_start, #datepicker_end').datepicker({
            autoclose: true,
        });
        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false,
        });


        // Check availablabiltiy
        $("#single_email").on("keyup", function() {
            var emailaddress = $("#single_email").val();
            runUsercheck(emailaddress, 'email');
        });

        $("#single_telephone").on("keyup", function() {
            var phonenumber = $("#single_telephone").val();
            runUsercheck(phonenumber, 'telephone');
        });




    });





    function runUsercheck(val, title) {
        var route = "{{ URL('Ajax/singleinvoiceusercheck') }}";
        var thisdata = {
            info: val,
            title: title,
        }

        setHeaders();
        jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            success: function(result) {
                if (result.message == "success" && result.title == "email") {
                    $(".emailcheck").removeClass("disp-0");
                    $(".emailcheck").text(
                        "Email Address is available. (Invoice goes to Customer's PaySprint Account)");
                } else if (result.message == "success" && result.title == "telephone") {
                    $(".phonecheck").removeClass("disp-0");
                    $(".phonecheck").text(
                        "Telephone is available. (Invoice goes to Customer's PaySprint Account)");
                } else if (result.message == "error" && result.title == "email") {
                    $(".emailcheck").removeClass("disp-0");
                    $(".emailcheck").text(
                        "Email Address is not available. (Customer does not need to create a PaySprint Account to Pay Invoice)"
                    );
                } else if (result.message == "error" && result.title == "telephone") {
                    $(".phonecheck").removeClass("disp-0");
                    $(".phonecheck").text(
                        "Telephone is not available. (Customer does not need to create a PaySprint Account to Pay Invoice)"
                    );
                }


            }

        });
    }



    $('#single_invoice_generate').change(function() {
        if ($('#single_invoice_generate').val() == "Manual") {
            $('#single_invoiceno').removeAttr('readonly');
            $('#single_invoiceno').val('');
        } else if ($('#single_invoice_generate').val() == "Auto Generate") {
            var gen_inv = "{{ 'PS_' . date('Ymds') }}";
            $('#single_invoiceno').attr('readonly', true);
            $('#single_invoiceno').val(gen_inv);
        } else {
            $('#single_invoiceno').attr('readonly', true);
            $('#single_invoiceno').val('');
            swal('Oops!', 'Kindly select invoice option', 'error');
            return false;
        }
    });


    $('#single_recurring_service').change(function() {

        if ($('#single_recurring_service').val() == "One Time" || $('#single_recurring_service').val() == "") {
            $('.recuring_time').addClass('disp-0');
        } else {
            $('.recuring_time').removeClass('disp-0');
        }

    });

    $('#recurring_service').change(function() {

        if ($('#recurring_service').val() == "One Time" || $('#recurring_service').val() == "") {
            $('.recuring_time_2').addClass('disp-0');
        } else {
            $('.recuring_time_2').removeClass('disp-0');
        }

    });


    $('#single_service').change(function() {
        if ($('#single_service').val() == "Others") {
            $('.specific').removeClass('disp-0');
        } else {
            $('.specific').addClass('disp-0');
        }
    });


    $('#single_installpay').change(function() {
        if ($('#single_installpay').val() == "Yes") {
            $('.instlim').removeClass('disp-0');
        } else {
            $('.instlim').addClass('disp-0');
        }
    });

    $('#installpay').change(function() {
        if ($('#installpay').val() == "Yes") {
            $('.instlim').removeClass('disp-0');
        } else {
            $('.instlim').addClass('disp-0');
        }
    });






    function creatEvent(id, purpose) {
        var route = "{{ URL('Ajax/CreateEvent') }}";
        var formData = new FormData();
        if (purpose == "ticket") {
            var desccription = $('#event_description').val();
            var desc_val = desccription;


            if ($("#event_title").val() == "" || $("#event_location").val() == "" || $("#datepicker_start").val() ==
                "" || $("#ticket_timeStarts").val() == "" || $("#datepicker_end").val() == "" || $("#ticket_timeEnds")
                .val() == "") {
                swal("Oops!", 'Kindly make sure you fill the required fields', 'warning');
            } else {

                var fileSelect = document.getElementById("event_file");
                if (fileSelect.files && fileSelect.files.length == 1) {
                    var file = fileSelect.files[0]
                    formData.set("event_file", file, file.name);
                }

                formData.append("ticket_id", id);
                formData.append("purpose", purpose);
                formData.append("user_id", $("#user_id").val());
                formData.append("event_title", $("#event_title").val());
                formData.append("event_location", $("#event_location").val());
                formData.append("datepicker_start", $("#datepicker_start").val());
                formData.append("ticket_timeStarts", $("#ticket_timeStarts").val());
                formData.append("datepicker_end", $("#datepicker_end").val());
                formData.append("ticket_timeEnds", $("#ticket_timeEnds").val());
                formData.append("event_description", desc_val);
                formData.append("ticket_free_name", $("#ticket_free_name").val());
                formData.append("ticket_free_qty", $("#ticket_free_qty").val());
                formData.append("ticket_free_price", $("#ticket_free_price").val());
                formData.append("ticket_paid_name", $("#ticket_paid_name").val());
                formData.append("ticket_paid_qty", $("#ticket_paid_qty").val());
                formData.append("ticket_paid_price", $("#ticket_paid_price").val());
                formData.append("ticket_donate_name", $("#ticket_donate_name").val());
                formData.append("ticket_donate_qty", $("#ticket_donate_qty").val());
                formData.append("ticket_donate_price", $("#ticket_donate_price").val());

                $('#savefreeTicket').click();
                $('#savepaidTicket').click();
                $('#savedonateTicket').click();

            }
        } else if (purpose == "uploadExcel") {


            var fileSelect = document.getElementById("excel_file");
            if (fileSelect.files && fileSelect.files.length == 1) {
                var file = fileSelect.files[0]
                formData.set("excel_file", file, file.name);
            }

            formData.append("invoice_id", id);
            formData.append("purpose", purpose);
            formData.append("user_id", $('#user_id').val());
            formData.append("service", $('#service').val());
            formData.append("installpay", $('#installpay').val());
            formData.append("installlimit", $('#installlimit').val());

        } else if (purpose == "setRecur") {

            formData.append("invoice_id", id);
            formData.append("purpose", purpose);
            formData.append("user_id", $('#recur_user_id').val());
            formData.append("recurring", $('#recurring_service').val());
            formData.append("reminder", $('#reminder_service').val());

        } else if (purpose == "single1_upload") {

            formData.append("invoice_id", id);
            formData.append("purpose", purpose);
            formData.append("user_id", $('#single_user_id').val());
            formData.append("firstname", $('#single_firstname').val());
            formData.append("lastname", $('#single_lastname').val());
            formData.append("payee_email", $('#single_email').val());
            formData.append("service", $('#single_service').val());
            formData.append("service_specify", $('#single_service_specify').val());
            formData.append("invoice_no", $('#single_invoiceno').val());
            formData.append("installpay", $('#single_installpay').val());
            formData.append("installlimit", $('#single_installlimit').val());

        } else if (purpose == "single2_upload") {

            var desccription = $('#single_description').val();
            var desc_val = desccription;

            formData.append("invoice_id", id);
            formData.append("purpose", purpose);
            formData.append("user_id", $('#single2_user_id').val());
            formData.append("payee_email", $('#single2_payee_email').val());
            formData.append("invoice_no", $('#single2_invoiceno').val());
            formData.append("payee_ref_no", $('#single_payee_ref_no').val());
            formData.append("transaction_ref", $('#single_transaction_ref').val());
            formData.append("transaction_date", $('#single_transaction_date').val());
            formData.append("description", desc_val);
        } else if (purpose == "single3_upload") {
            formData.append("invoice_id", id);
            formData.append("purpose", purpose);
            formData.append("user_id", $('#single3_user_id').val());
            formData.append("invoice_no", $('#single3_invoiceno').val());
            formData.append("payee_email", $('#single3_payee_email').val());
            formData.append("amount", $('#single_amount').val());
            formData.append("payment_due_date", $('#single_payment_due_date').val());
            formData.append("recurring", $('#single_recurring_service').val());
            formData.append("reminder", $('#single_reminder_service').val());

        }


        Pace.restart();
        Pace.track(function() {
            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                beforeSend: function() {
                    $(".spinner").removeClass('disp-0');
                },
                success: function(result) {

                    if (result.message == 'success' && result.action == 'ticket') {
                        $("#event_title").val('');
                        $("#event_location").val('');
                        $("#datepicker_start").val('');
                        $("#ticket_timeStarts").val('');
                        $("#datepicker_end").val('');
                        $("#ticket_timeEnds").val('');
                        $("#event_description").val('');
                        $("#ticket_free_name").val('');
                        $("#ticket_free_qty").val('');
                        $("#ticket_free_price").val('');
                        $("#ticket_paid_name").val('');
                        $("#ticket_paid_qty").val('');
                        $("#ticket_paid_price").val('');
                        $("#ticket_donate_name").val('');
                        $("#ticket_donate_qty").val('');
                        $("#ticket_donate_price").val('');
                        $("#event_file").val('');
                        $(".freeTicket").addClass('disp-0');
                        $(".paidTicket").addClass('disp-0');
                        $(".donateTicket").addClass('disp-0');
                        $(".spinner").addClass('disp-0');
                        swal("Saved!", result.res, result.message);

                        setTimeout(function() {
                            location.href = result.link;
                        }, 2000);
                    } else if (result.message == 'success' && result.action == 'uploadExcel') {
                        $(".spinner").addClass('disp-0');
                        // Close Modal & Pop up the next
                        $('#close_step1').click();
                        $('#uploadDoc2').click();
                    } else if (result.message == 'success' && result.action == 'setRecur') {
                        $(".spinner").addClass('disp-0');
                        swal("Great!", result.res, result.message);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else if (result.message == 'success' && result.action == 'single1_upload') {
                        $(".spinner").addClass('disp-0');
                        // Close Modal & Pop up the next
                        $('#close_single_step1').click();
                        $('#single2_payee_email').val(result.email);
                        $('#single2_invoiceno').val(result.invoice_no);
                        $('#singleDoc2').click();
                    } else if (result.message == 'success' && result.action == 'single2_upload') {
                        $(".spinner").addClass('disp-0');
                        // Close Modal & Pop up the next
                        $('#close_single_step2').click();
                        $('#single3_payee_email').val(result.email);
                        $('#single3_invoiceno').val(result.invoice_no);
                        $('#singleDoc3').click();
                    } else if (result.message == 'success' && result.action == 'single3_upload') {
                        $(".spinner").addClass('disp-0');
                        swal("Great!", result.res, result.message);
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else if (result.message == 'response') {
                        $('.responseMessage').text(result.res);
                        $('.responseMessage').show().fadeIn().hide(5000);;
                    } else {
                        $(".spinner").addClass('disp-0');
                        swal("Oops!", result.res, result.message);
                    }

                }

            });
        });

    }


    function opennewTicket(val) {
        if (val == 'free') {
            $('.freeTicket').removeClass('disp-0');
            return false;
        }
        if (val == 'paid') {
            $('.paidTicket').removeClass('disp-0');
            return false;
        }
        if (val == 'donate') {
            $('.donateTicket').removeClass('disp-0');
            return false;
        }
    }

    // Logout
    function logout(val) {
        var route = "{{ URL('Ajax/Adminlogout') }}";
        var thisdata = {
            username: val,
        }

        setHeaders();
        jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            success: function(result) {
                if (result.message == "success") {
                    setTimeout(function() {
                        location.href = "{{ route('merchant home') }}";
                    }, 1000);
                }


            }

        });
    }



    function checkStatement() {
        var service = $('#statement_service').val();
        var start_date = $('#statement_start').val();
        var end_date = $('#statement_end').val();

        $('tbody#statementtab').html("");

        var route = "{{ URL('Ajax/getmyStatement') }}";
        var thisdata = {
            service: service,
            start_date: start_date,
            end_date: end_date
        }

        setHeaders();
        jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            beforeSend: function() {
                $('.spinner').removeClass('disp-0');
            },
            success: function(result) {
                $('.spinner').addClass('disp-0');
                if (result.message == "success") {



                    var res = JSON.parse(result.data);
                    var status = result.status;

                    var invoices = "";
                    var payments = "";
                    var invoice;
                    var payment;




                    if (res[0].error == "No statement record") {
                        $('tbody#statementtab').append("<tr><td colspan='7' align='center'>" + res[0]
                            .error + "</td></tr>");
                    } else {

                        if (status == "wallet") {
                            $.each(res, function(v, k) {
                                var price;
                                var icon;
                                var styleColor;

                                if (k.debit != 0) {
                                    price = "-" + k.debit;
                                    icon = '<i class="fas fa-circle text-danger"></i>';
                                    styleColor = "text-danger";
                                } else {
                                    price = "+" + k.credit;
                                    icon = '<i class="fas fa-circle text-success"></i>';
                                    styleColor = "text-danger";
                                }

                                var rem = parseInt(k.invoice_amount) - parseInt(k.amount_paid);

                                invoice = "<tr><td>" + icon + "</td><td>" + k.activity + "<br>" + k
                                    .reference_code + "<br>" + k.created_at +
                                    "</td><td style='font-weight: 700;' class=" + styleColor +
                                    "><strong>" + parseFloat(price).toFixed(2) +
                                    "</strong></td></tr>";
                                // Fetch data

                                invoices += invoice;
                            });
                        } else {
                            $.each(res, function(v, k) {

                                var rem = parseInt(k.invoice_amount) - parseInt(k.amount_paid);

                                invoice = "<tr><td>" + (v + 1) + "</td><td>" + k.transaction_date +
                                    "</td><td>" + k.description + "</td><td>" + k.transactionid +
                                    "</td><td>" + k.invoice_amount + "</td><td>" + k.amount_paid +
                                    "</td><td>" + rem + "</td></tr>";
                                // Fetch data

                                invoices += invoice;
                            });
                        }



                        $('tbody#statementtab').append("<tr>" + invoices + "</tr>");

                    }


                } else {
                    swal(result.title, result.res, result.message);
                }


            }

        });


    }


    function checkreportStatement(val) {

        if (val == "payca") {
            var service = $('#statement_service').val();
            var start_date = $('#statement_start').val();
            var end_date = $('#statement_end').val();


            $('tbody#statementtab').html("");

            var route = "{{ URL('Ajax/getmyreportStatement') }}";
            var thisdata = {
                service: service,
                start_date: start_date,
                end_date: end_date,
                val: 'payca'
            }

            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function() {
                    $('.spinner').removeClass('disp-0');
                },
                success: function(result) {
                    $('.spinner').addClass('disp-0');
                    if (result.message == "success") {



                        var res = JSON.parse(result.data);
                        // console.log(res);
                        var status = result.status;

                        var invoices = "";
                        var payments = "";
                        var invoice;
                        var payment;


                        if (res[0].error == "No statement record") {
                            $('tbody#statementtab').append("<tr><td colspan='11' align='center'>" + res[0]
                                .error + "</td></tr>");
                        } else {

                            $.each(res, function(v, k) {

                                var rem;
                                var amtpaid;
                                var openbal;

                                if (k.opening_balance != undefined) {
                                    openbal = k.opening_balance;
                                } else {
                                    openbal = 0;
                                }

                                if (k.amount_paid != undefined) {
                                    amtpaid = k.amount_paid;
                                } else {
                                    amtpaid = 0;
                                }

                                rem = parseInt(k.invoice_amount) - parseInt(amtpaid);


                                invoice = "<tr><td>" + (v + 1) + "</td><td>" + k.name +
                                    "</td><td>" + k.address + "</td><td>" + k.transaction_ref +
                                    "</td><td>" + k.invoice_no + "</td><td>" + k.due_date +
                                    "</td><td style='color: red; font-weight: bold;'>" + k
                                    .invoice_amount +
                                    "</td><td style='color: blue; font-weight: bold;'>" + openbal +
                                    "</td><td style='color: green; font-weight: bold;'>" + amtpaid +
                                    "</td><td style='color: black; font-weight: bold;'>" + rem +
                                    "</td><td>" + k.description + "</td></tr>";
                                // Fetch data

                                invoices += invoice;
                            });

                            $('tbody#statementtab').append("<tr>" + invoices + "</tr>");

                        }


                    } else {
                        swal(result.title, result.res, result.message);
                    }


                }

            });
        }




    }


    function checkremittance(val) {

        if (val == "payca") {
            var client_id = $('#statement_client_name').val();
            var service = $('#statement_service').val();
            var start_date = $('#statement_start').val();
            var end_date = $('#statement_end').val();


            $('tbody#statementtab').html("");

            var route = "{{ URL('Ajax/getmremittance') }}";
            var thisdata = {
                client_id: client_id,
                service: service,
                start_date: start_date,
                end_date: end_date,
                val: 'payca'
            }

            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function() {
                    $('.spinner').removeClass('disp-0');
                },
                success: function(result) {
                    $('.spinner').addClass('disp-0');
                    $('#reportTable').removeClass('disp-0')
                    if (result.message == "success") {




                        var res = JSON.parse(result.data);
                        var invoices = "";
                        var invoice;

                        var total = 0;
                        $.each(res, function(v, k) {

                            if (result.action == "payca") {
                                invoice = "<tr><td>" + (v + 1) + "</td><td>" + k.name +
                                    "</td><td>" + k.address + "</td><td>" + k.payee_ref_no +
                                    "</td><td>" + k.service + "</td><td>" + k.invoice_no +
                                    "</td><td>" + k.payment_due_date + "</td><td>" + k
                                    .transaction_date + "</td><td>" + k.transactionid +
                                    "</td><td colspan='2' align='center' style='color:green; font-weight:bold;'>$" +
                                    k.amount_paid + "</td></tr>";
                                // Fetch data
                                total += parseInt(k.amount_paid);

                                invoices += invoice;

                            }

                        });

                        $('#no_of_records').text("No of Records - " + res.length);

                        $('#tableaction').html(
                            "<button class='btn btn-danger' onclick='closeTable()'>Close</button>");

                        var lengthCount = res.length;
                        var fixed = total * (result.fixed / 100);
                        var variable = parseFloat(result.variable) * lengthCount;
                        var collection = parseFloat(variable) + parseFloat(fixed);

                        var net = (total - collection);

                        $('tbody#statementtab').append("<tr>" + invoices +
                            "</tr><tr><td colspan='3'></td><td colspan='3'></td><td colspan='3' style='color:green; font-weight:bold;'>Total: <br> Less collection fee: <hr> Net Remittance: </td><td colspan='2' style='color:green; font-weight:bold;' align='center'>$" +
                            total.toFixed(2) + " <br>$" + collection.toFixed(2) + "<hr>$" + net.toFixed(
                                2) + "<br><br><input type='hidden' id='amount' value='" + net.toFixed(
                                2) +
                            "'><input type='hidden' id='action' value='payca'><button class='btn btn-success btn-block' onclick=remittance('" +
                            result.withdraw_id +
                            "')>Remit <img src='https://i.ya-webdesign.com/images/loading-gif-png-5.gif' class='spin" +
                            result.withdraw_id +
                            " disp-0' style='width: 30px; height: 30px;'></button></td></tr>");


                    } else {
                        swal(result.title, result.res, result.message);
                    }


                }

            });
        } else if (val == "comission") {
            var client_id = $('#statement_client_name').val();
            var service = $('#statement_service').val();
            var start_date = $('#statement_start').val();
            var end_date = $('#statement_end').val();


            $('tbody#statementtab').html("");

            var route = "{{ URL('Ajax/getmremittance') }}";
            var thisdata = {
                client_id: client_id,
                service: service,
                start_date: start_date,
                end_date: end_date,
                val: 'comission'
            }

            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function() {
                    $('.spinner').removeClass('disp-0');
                },
                success: function(result) {
                    $('.spinner').addClass('disp-0');
                    if (result.message == "success") {

                        var res = JSON.parse(result.data);
                        var invoices = "";
                        var invoice;

                        var total = 0;
                        var totalAmount = 0;
                        $.each(res, function(v, k) {

                            var fixed = k.amount_paid * (result.fixed / 100);
                            var variable = parseFloat(result.variable) * res.length;
                            var collection = parseFloat(variable) + parseFloat(fixed);



                            if (result.action == "comission") {
                                invoice = "<tr><td>" + (v + 1) + "</td><td>" + k.name +
                                    "</td><td>" + k.payee_ref_no + "</td><td>" + k.service +
                                    "</td><td>" + k.invoice_no +
                                    "</td><td align='center' style='color:green; font-weight:bold;'>$" +
                                    k.amount_paid + "</td></tr>";
                                // Fetch data
                                total += parseFloat(collection);
                                totalAmount += parseInt(k.amount_paid);



                                invoices += invoice;

                            }

                        });

                        $('#no_of_records').text("No of Records - " + res.length);


                        var new_fixed = totalAmount * (result.fixed / 100);
                        var new_variable = parseFloat(result.variable) * res.length;
                        var new_collection = parseFloat(new_variable) + parseFloat(new_fixed);


                        $('tbody#statementtab').append("<tr>" + invoices +
                            "</tr><tr><td colspan='2'></td><td colspan='2' align='right' style='color:black; font-weight:bold;'>Total Amount: <br># of Records: <hr> Fixed: <br> Variable: <br>Commission: </td><td style='color:navy; font-weight:bold;' align='center'><br><br><hr></td><td style='color:green; font-weight:bold;' align='center'> $" +
                            totalAmount.toFixed(2) + " <br>" + res.length + " <hr> <br><br>$" +
                            new_collection.toFixed(2) + "</td></tr>");


                    } else {
                        swal(result.title, result.res, result.message);
                    }


                }

            });
        } else if (val == "epayca") {

            var client_id = $('#statement_client_name').val();
            var service = $('#statement_service').val();
            var start_date = $('#statement_start').val();
            var end_date = $('#statement_end').val();


            $('tbody#statementtab').html("");

            var route = "{{ URL('Ajax/getmremittance') }}";
            var thisdata = {
                client_id: client_id,
                service: service,
                start_date: start_date,
                end_date: end_date,
                val: 'epayca'
            }

            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function() {
                    $('.spinner').removeClass('disp-0');
                },
                success: function(result) {
                    $('.spinner').addClass('disp-0');
                    if (result.message == "success") {




                        var res = JSON.parse(result.data);
                        var invoices = "";
                        var invoice;

                        var total = 0;
                        $.each(res, function(v, k) {

                            if (result.action == "epayca") {
                                invoice = "<tr><td>" + (v + 1) + "</td><td>" + k.client_name +
                                    "</td><td>" + k.client_email +
                                    "</td><td style='color:green; font-weight:bold;' align='center'>$" +
                                    k.amount_to_withdraw + "</td><td>" + k.card_method +
                                    "</td><td>" + k.created_at + "</td></tr>";
                                // Fetch data
                                total += parseInt(k.amount_to_withdraw);

                                invoices += invoice;

                            }

                        });

                        $('#no_of_records').text("No of Records - " + res.length);

                        var lengthCount = res.length;
                        var fixed = total * (result.fixed / 100);
                        var variable = parseFloat(result.variable) * lengthCount;
                        var collection = parseFloat(variable) + parseFloat(fixed);

                        var net = (total - collection);

                        $('tbody#statementtab').append("<tr>" + invoices +
                            "</tr><tr><td colspan='3'></td><td colspan='2' style='color:green; font-weight:bold;'>Total: <br> Less collection fee: <hr> Net Remittance: </td><td colspan='2' style='color:green; font-weight:bold;' align='center'>$" +
                            total.toFixed(2) + " <br>$" + collection.toFixed(2) + "<hr>$" + net.toFixed(
                                2) + "<br><br><input type='hidden' id='amount' value='" + net.toFixed(
                                2) +
                            "'><input type='hidden' id='action' value='epayca'><button class='btn btn-success btn-block' onclick=remittance('" +
                            result.withdraw_id +
                            "')>Remit <img src='https://i.ya-webdesign.com/images/loading-gif-png-5.gif' class='spin" +
                            result.withdraw_id +
                            " disp-0' style='width: 30px; height: 30px;'></button></td></tr>");


                    } else {
                        swal(result.title, result.res, result.message);
                    }


                }

            });

        }




    }


    function closeTable() {
        $('#reportTable').addClass('disp-0')
    }

    function WithdrawCash(user_id, amount) {
        var thisdata = {
            user_id: user_id,
            amount: amount
        };
        var route = "{{ URL('Ajax/WithdrawCash') }}";

        setHeaders();
        jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            beforeSend: function() {
                $('.spinner').removeClass('disp-0');
            },
            success: function(result) {
                $('.spinner').addClass('disp-0');
                if (result.message == "success") {
                    swal(result.title, result.res, result.message);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    swal(result.title, result.res, result.message);
                }


            }

        });

    }


    function withdrawCashopen(user_id, amount) {
        openModal('paymethod');
        $('#my_id').val(user_id);
        $('#amountWithdraw').val(amount);
    }

    function makePayment() {
        var amount = $('#amountWithdraw').val();
        var user_id = $('#my_id').val();
        var card_method = $('#card_method').val();
        var thisdata = {
            user_id: user_id,
            amount: amount,
            card_method: card_method
        };
        var route = "{{ URL('Ajax/epaywithdraw') }}";

        setHeaders();
        jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            beforeSend: function() {
                $('.spinner').removeClass('disp-0');
            },
            success: function(result) {
                $('.spinner').addClass('disp-0');
                if (result.message == "success") {
                    swal(result.title, result.res, result.message);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    swal(result.title, result.res, result.message);
                }


            }

        });

    }


    function remitdetailsCash(user_id, withdraw_id, amount, val) {
        $('tbody#remittancedetails').html('');
        $('tbody#remittancecalcdetails').html('');

        var route = "{{ URL('Ajax/remitdetailsCash') }}";
        var thisdata = {
            user_id: user_id,
            withdraw_id: withdraw_id,
            amount: amount,
            val: val
        };
        var spinner = $('.spinner' + withdraw_id);
        setHeaders();
        jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            beforeSend: function() {
                spinner.removeClass('disp-0');
            },
            success: function(result) {
                spinner.addClass('disp-0');
                if (result.message == "success") {
                    var res = JSON.parse(result.data);
                    var client = JSON.parse(result.client);
                    var total = 0;
                    $.each(res, function(v, k) {

                        total += parseInt(k.amount_paid);

                        if (result.action == 'epayca') {
                            // Open Modal
                            // $("tbody#remittancedetails").append("<tr><td>"+(v+1)+"</td><td align='justify'>"+k.purpose+"</td><td align='center' style='color:green; font-weight: bold;'>$"+k.amount+"</td><td align='justify'>"+k.created_at+"</td><hr></tr>");

                            $("tbody#remittancedetails").append("<tr><td>" + (v + 1) +
                                "</td><td align='justify'>" + k.name +
                                "</td><td align='justify'>" + k.client_id +
                                "</td><td align='justify'>" + k.service +
                                "</td><td align='justify'>-</td><td align='center' style='color:green; font-weight: bold;'>-</td><td align='center' style='color:green; font-weight: bold;'>$" +
                                k.amount_paid + "</td><td align='justify'>" + k.transactionid +
                                "</td><td align='justify'>" + k.transaction_date +
                                "</td><hr></tr>");
                        } else if (result.action == 'payca') {
                            // Open Modal
                            $("tbody#remittancedetails").append("<tr><td>" + (v + 1) +
                                "</td><td align='justify'>" + k.name +
                                "</td><td align='justify'>" + k.payee_ref_no +
                                "</td><td align='justify'>" + k.service +
                                "</td><td align='justify'>" + k.invoice_no +
                                "</td><td align='center' style='color:green; font-weight: bold;'>$" +
                                k.invoice_amount +
                                "</td><td align='center' style='color:green; font-weight: bold;'>$" +
                                k.amount_paid + "</td><td align='justify'>" + k.transactionid +
                                "</td><td align='justify'>" + k.transaction_date +
                                "</td><hr></tr>");
                        }
                    });

                    // Add Up Net Calculation
                    var last = res.length - 1;

                    $('#clientfullname').text("Client Name: " + client[0].firstname + " " + client[0]
                        .lastname);
                    $('#period_start').text("Start Date: " + res[0].transaction_date);
                    $('#period_end').text("End Date: " + res[last].transaction_date);


                    var lengthCount = res.length;
                    var fixed = total * (result.fixed / 100);
                    var variable = parseFloat(result.variable) * lengthCount;
                    var collection = parseFloat(variable) + parseFloat(fixed);

                    var net = (total - collection);

                    $('tbody#remittancecalcdetails').html(
                        "<tr><td></td><td align='justify' style='font-weight: 600; color: navy'>$" +
                        total.toFixed(2) +
                        "</td><td align='justify' style='font-weight: 600; color: red'>$" + collection
                        .toFixed(2) +
                        "</td><td align='justify' style='font-weight: 600; color: green'>$" + net
                        .toFixed(2) + "</td></tr>");

                    $('#view_remittance').click();

                } else {
                    swal(result.title, result.res, result.message);
                }


            }

        });

    }


    function checkfeereport() {
        $('tbody#fee_report').html('');
        var client_email = $('#feereport_client_name').val();
        var platform = $('#feereport_service').val();
        var start_date = $('#period_start').val();
        var end_date = $('#period_end').val();
        var thisdata;
        var route = "{{ URL('Ajax/checkfeeReport') }}";
        var spinner = $('.spinner');

        if (client_email == "") {
            swal('Oops!', 'Please select client name', 'info');
            return false;
        } else if (platform == "") {
            swal('Oops!', 'Please select where you would like to search', 'info');
            return false;
        } else if (start_date == "") {
            swal('Oops!', 'Please select start date', 'info');
            return false;
        } else if (end_date == "") {
            swal('Oops!', 'Please select end date', 'info');
            return false;
        } else {
            thisdata = {
                client_email: client_email,
                platform: platform,
                start_date: start_date,
                end_date: end_date
            };

            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function() {
                    spinner.removeClass('disp-0');
                },
                success: function(result) {
                    spinner.addClass('disp-0');
                    if (result.message == "success") {
                        var res = JSON.parse(result.data);

                        $('#feeperiod_start').text("Start Date: " + result.start_date);
                        $('#feeperiod_end').text("End Date: " + result.end_date);



                        $.each(res, function(v, k) {
                            var total = k.total_fee;

                            var lengthCount = res.length;
                            var fixed = total * (result.fixed / 100);
                            var variable = parseFloat(result.variable) * lengthCount;
                            var collection = parseFloat(variable) + parseFloat(fixed);

                            var net = (total - collection);

                            $("tbody#fee_report").append("<tr><td>" + (v + 1) +
                                "</td><td align='justify'>" + k.remittance_date +
                                "</td><td align='justify'>" + k.client_name +
                                "</td><td align='center' style='color:green; font-weight: bold;'>$" +
                                k.total_amount +
                                "</td><td align='center' style='color:green; font-weight: bold;'>$" +
                                k.total_remittance +
                                "</td><td align='center' style='color:green; font-weight: bold;'>$" +
                                net.toFixed(2) + "</td><td align='justify'>" + k.platform +
                                "</td><hr></tr>");
                        });


                    } else {
                        swal(result.title, result.res, result.message);
                    }


                }

            });

        }


    }

    function remittance(withdraw_id) {
        var route = "{{ URL('Ajax/remitCash') }}";
        var amount = $('#amount').val();
        var val = $('#action').val();
        var thisdata = {
            withdraw_id: withdraw_id,
            amount: amount,
            val: val
        };
        var spinner = $('.spin' + withdraw_id);
        setHeaders();
        jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            beforeSend: function() {
                spinner.removeClass('disp-0');
            },
            success: function(result) {
                spinner.addClass('disp-0');
                if (result.message == "success") {
                    swal(result.title, result.res, result.message);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    swal(result.title, result.res, result.message);
                }


            }

        });

    }


    function setTrans() {
        var route = "{{ URL('Ajax/setupTrans') }}";
        var variable = $('#variable').val();
        var fixed = $('#fixed').val();
        var spinner = $('#trans_btn');
        var thisdata;
        if (variable == "") {
            swal('Oops!', 'Please provide the cost variable', 'info');
            return false;
        } else if (fixed == "") {
            swal('Oops!', 'Please provide the fixed price', 'info');
            return false;
        } else {

            thisdata = {
                variable: variable,
                fixed: fixed
            };

            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function() {
                    spinner.text('Please wait...');
                },
                success: function(result) {
                    spinner.text('Update');

                    if (result.message == "success") {
                        swal(result.title, result.res, result.message);
                        $('#variable').val('');
                        $('#fixed').val('');
                        $('#close_trans').click();
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        swal(result.title, result.res, result.message);
                    }


                }

            });

        }
    }


    function PrintDiv2(val) {
        var divToPrint2 = document.getElementById(val);
        var popupWin = window.open('', '_blank', 'width=800,height=1000');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">' + divToPrint2.innerHTML + '</html>');
        popupWin.document.close();
    }



    function invoiceVisit(id, val) {

        var route = "{{ URL('Ajax/invoiceVisit') }}";
        var thisdata;
        var spinner = $('.spinner' + val);

        if (val == "delete") {

            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this invoice!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        thisdata = {
                            id: id,
                            val: val
                        };
                        setHeaders();
                        jQuery.ajax({
                            url: route,
                            method: 'post',
                            data: thisdata,
                            dataType: 'JSON',
                            beforeSend: function() {
                                spinner.removeClass('disp-0');
                            },
                            success: function(result) {
                                spinner.addClass('disp-0');

                                if (result.message == "success") {
                                    // Route to another page
                                    swal(result.title, result.res, result.message);
                                    setTimeout(function() {
                                        location.href = location.origin + "/Admin";
                                    }, 2000);
                                } else {
                                    swal(result.title, result.res, result.message);
                                }


                            }

                        });

                    } else {

                    }
                });


        } else {
            $('.mainText').addClass('disp-0');
            $('.mainInput').removeClass('disp-0');
            $('.edit').addClass('disp-0');
            $('.updt').removeClass('disp-0');
        }


    }


    function invoiceLinkVisit(id, val) {

        var route = "{{ URL('Ajax/invoicelinkVisit') }}";
        var thisdata;
        var spinner = $('.spinner' + val);

        if (val == "delete") {

            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this invoice!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        thisdata = {
                            id: id,
                            val: val
                        };
                        setHeaders();
                        jQuery.ajax({
                            url: route,
                            method: 'post',
                            data: thisdata,
                            dataType: 'JSON',
                            beforeSend: function() {
                                spinner.removeClass('disp-0');
                            },
                            success: function(result) {
                                spinner.addClass('disp-0');

                                if (result.message == "success") {
                                    // Route to another page
                                    swal(result.title, result.res, result.message);
                                    setTimeout(function() {
                                        location.href = location.origin + "/Admin";
                                    }, 2000);
                                } else {
                                    swal(result.title, result.res, result.message);
                                }


                            }

                        });

                    } else {

                    }
                });


        } else {
            $('.mainText').addClass('disp-0');
            $('.mainInput').removeClass('disp-0');
            $('.edit').addClass('disp-0');
            $('.updt').removeClass('disp-0');
        }


    }

    function del(val, id) {
        if (val == "deletefee" || val == "deletecardissuer" || val == "deletespecialinfo") {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        $("#" + val + id).submit();

                    } else {

                    }
                });
        }
    }

    function markasPaid(id) {

        swal({
                title: "Are you sure?",
                text: "Be sure this is properly reviewed",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    location.href = '/Admin/invoicecomment/' + id;
                } else {

                }
            });

    }


    function markasLinkPaid(id) {

        swal({
                title: "Are you sure?",
                text: "Be sure this is properly reviewed",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    location.href = '/Admin/invoicelinkcomment/' + id;
                } else {

                }
            });

    }


    function whatyouOffer(email) {
        swal({
                title: "Are you a Property Owner?",
                text: "Click on OK if you are a property owner",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    // Show the property I own

                    location.href = "/myrentalmanagementfacility/admin/" + btoa(email);
                } else {

                }
            });
    }

    function viewConsultant(email) {
        swal({
                title: "Are you a Service Provider?",
                text: "Click on OK if you are a service provider",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    // Show the property I own

                    location.href = "/rentalmanagement/consultant"
                } else {

                }
            });
    }

    function flagMoney(val, id) {
        swal({
                title: "Are you sure?",
                text: "Be sure you want to continue.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $("#" + val + id).submit();

                } else {

                }
            });
    }

    function delSupport(id) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $("#delSupport" + id).submit();

                } else {

                }
            });
    }


    function confirmEsPay(escrow_id) {
        swal({
                title: "Are you sure?",
                text: "Kindly confirm you have thoroughly checked before accepting payment",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $("#thisform" + escrow_id).submit();

                } else {

                }
            });
    }


    function declineEsPay(escrow_id) {
        swal({
                title: "Are you sure?",
                text: "Click on OK to decline",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $("#delthisform" + escrow_id).submit();

                } else {

                }
            });
    }



    function confirmPay(transactionid, user_id, coy_id) {
        var thisdata;
        var spinner = $('.spin' + transactionid);
        var route = "{{ URL('Ajax/confirmpayment') }}";

        swal({
                title: "Ready to Confirm!",
                text: "",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        transactionid: transactionid,
                        user_id: user_id,
                        coy_id: coy_id
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        }

                    });

                } else {

                }
            });
    }


    function downgradetoLevel1(id) {

        var thisdata;
        var spinner = $('.spindowngrade' + id);
        var route = "{{ URL('Ajax/downgradeaccount') }}";

        swal({
                title: "Are you sure?",
                text: "Please make sure you have thoroughly checked the account before you downgrade",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        id: id
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        }

                    });

                }
            });

    }


    function approveaccount(id) {

        var thisdata;
        var spinner = $('.spin' + id);
        var route = "{{ URL('Ajax/approveUser') }}";

        swal({
                title: "Are you sure?",
                text: "Please make sure you have thoroughly checked the uploaded means of identification before you proceed",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        id: id
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        }

                    });

                }
            });

    }


    function disapproveaccount(id) {

        var thisdata;
        var spinner = $('.spindis' + id);
        var route = "{{ URL('Ajax/disapproveUser') }}";

        swal({
                title: "Are you sure?",
                text: "You are about to disapprove this user from using PaySprint",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        id: id
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        }

                    });

                }
            });

    }

    function moveaccount(id) {

        var thisdata;
        var spinner = $('.spinmove' + id);
        var route = "{{ URL('Ajax/moveUser') }}";

        swal({
                title: "Are you sure?",
                text: "Please make sure you have thoroughly checked the uploaded means of identification before you proceed",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        id: id
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        }

                    });

                }
            });

    }


    function reverseFee(reference_code) {

        var thisdata;
        var spinner = $('.spin' + reference_code);
        var route = "{{ URL('Ajax/paychargeback') }}";

        swal({
                title: "Are you sure?",
                text: "Please be sure before you proceed!",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        reference_code: reference_code
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.status == 200) {

                                swal("Great!", result.message, "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal("Oops!", result.message, "error");
                            }


                        },
                        error: function(err) {
                            spinner.addClass('disp-0');
                            swal("Oops!", err.responseJSON.message, "error");
                        }

                    });

                }
            });

    }


    function releaseFee(reference_code) {

        var thisdata;
        var spinner = $('.spinFee' + reference_code);
        var route = "{{ URL('Ajax/releasefeeback') }}";

        swal({
                title: "Are you sure?",
                text: "Please be sure before you proceed!",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        reference_code: reference_code
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.status == 200) {

                                swal("Great!", result.message, "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal("Oops!", result.message, "error");
                            }


                        },
                        error: function(err) {
                            spinner.addClass('disp-0');
                            swal("Oops!", err.responseJSON.message, "error");
                        }

                    });

                }
            });

    }


    function closeAccount(id) {

        var thisdata;
        var spinner = $('.spinclose' + id);
        var route = "{{ URL('Ajax/closeuseraccount') }}";

        swal({
                title: "Are you sure?",
                text: "This account will permanently be closed and will not have access to PaySprint",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        id: id
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                // setTimeout(function(){ location.reload(); }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        }

                    });

                }
            });

    }


    function increaseLimit(id, currentLimit) {
        $("#currLimit").html("<span style='color: navy; font-weight:bold;'>Current Transaction Limit: " + currentLimit +
            "</span>");
        $("#limit" + id).click();
    }


    function openAccount(id) {

        var thisdata;
        var spinner = $('.spinopen' + id);
        var route = "{{ URL('Ajax/openuseraccount') }}";

        swal({
                title: "Are you sure?",
                text: "This account will be opened and will have access to PaySprint",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        id: id
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                // setTimeout(function(){ location.reload(); }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        }

                    });

                }
            });

    }



    function uploadDocsForUser(value, id) {

        var formData = new FormData();
        var spinner = $('#uploadBtn' + id);
        var route = "{{ route('upload user doc') }}";

        swal({
                title: "Are you sure?",
                text: "Click Ok to continue...",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {

                    // Do Ajax

                    formData.append("user_id", id);

                    var fileSelect = document.getElementById("uploadContent" + id);
                    if (fileSelect.files && fileSelect.files.length == 1) {
                        var file = fileSelect.files[0]
                        formData.set("image", file, file.name);
                    }

                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.text('Please wait...');
                        },
                        success: function(result) {

                            spinner.text('Upload');

                            if (result.res == "success") {

                                swal('Great', result.message, 'success');

                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal('Oops', result.message, 'error');
                            }




                        },
                        error: function(err) {
                            spinner.text('Upload');
                            swal("Oops!", err.responseJSON.message, "error");
                        }

                    });


                }
            });

    }


    function checkverification(id) {

        var thisdata;
        var spinner = $('.spinvery' + id);
        var route = "{{ URL('Ajax/checkverification') }}";

        swal({
                title: "Ready to override level 1 verification!",
                text: "Click OK to continue",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        id: id
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {

                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        },
                        error: function(err) {
                            spinner.addClass('disp-0');
                            swal("Oops!", err.responseJSON.message, "error");
                        }

                    });

                }
            });

    }


    function grantCountry(id) {
        var route = "{{ URL('Ajax/accesstousepaysprint') }}";

        swal({
                title: "Are you sure?",
                text: "Your decision is about to be processed",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#grantform" + id).submit();

                }
            });
    }


    function grantImt(id) {

        // Open Modal, ask for permission to accept Inbound, Outbound or Both...



        var route = "{{ URL('Ajax/accesstousepaysprintimt') }}";

        swal({
                title: "Are you sure?",
                text: "Your decision is about to be processed",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $('#imtRequest').click();

                    $("input[name='imt_id']").val(id);


                }
            });
    }


    function imtRequestBtn()
    {
        var imt_options = $('#imt_options').val();
        var country_id = $("input[name='imt_id']").val();

        $("input[name='imt_state']").val(imt_options);

        $("#grantimtform" + country_id).submit();

    }





    $('#structure').change(function() {
        if ($('#structure').val() == "Others") {
            $('.specificStructure').removeClass('disp-0');
        } else {
            $('.specificStructure').addClass('disp-0');
        }
    });


    $('#method').change(function() {
        if ($('#method').val() == "Others") {
            $('.specificMethod').removeClass('disp-0');
        } else {
            $('.specificMethod').addClass('disp-0');
        }
    });


    function payMobileMoney(id) {
        var route = "{{ URL('paymobilemoneywithdrawal') }}";
        var thisdata = {
            id: id
        };
        var spinner = $('.spin' + id);


        swal({
                title: "Are you sure?",
                text: "Please make sure you have confirmed user information before you proceed",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        },
                        error: function(err) {
                            spinner.addClass('disp-0');
                            swal("Oops!", err.responseJSON.message, "error");
                        }


                    });

                }
            });




    }


    function payCard(id) {
        var route = "{{ URL('Ajax/paycardwithdrawal') }}";
        var thisdata = {
            id: id
        };
        var spinner = $('.spin' + id);


        swal({
                title: "Are you sure?",
                text: "Please make sure you have confirmed user information before you proceed",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        },
                        error: function(err) {
                            spinner.addClass('disp-0');
                            swal("Oops!", err.responseJSON.message, "error");
                        }


                    });

                }
            });



    }


    function refundMoney(id, val) {

        var thisdata;
        var spinner = $('.spinner' + val + id);
        var route = "{{ URL('Ajax/refundmoneybacktowallet') }}";

        swal({
                title: "Are you sure?",
                text: "Your decision is about to be processed",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        id: id,
                        val: val
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.href = "{{ route('refund money request') }}";
                                }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        },
                        error: function(err) {
                            spinner.addClass('disp-0');
                            swal("Oops!", err.responseJSON.message, "error");
                        }

                    });

                }
            });

    }


    function flagAccount(id) {

        var thisdata;
        var spinner = $('.spin' + id);
        var route = "{{ URL('Ajax/flagguser') }}";

        swal({
                title: "Are you sure?",
                text: "Please make sure you have confirmed user information before you proceed",
                icon: "info",
                buttons: true,
                dangerMode: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        id: id
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            spinner.removeClass('disp-0');
                        },
                        success: function(result) {
                            spinner.addClass('disp-0');

                            if (result.message == "success") {

                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);

                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        },
                        error: function(err) {
                            spinner.addClass('disp-0');
                            swal("Oops!", err.responseJSON.message, "error");
                        }

                    });

                }
            });

    }


    function openModal(val) {
        $('#' + val).click();
    }

    function showForm(val) {
        $(".cardform").removeClass('disp-0');
        $(".pickCard").addClass('disp-0');
    }

    $('#single_tax').change(function() {

        var amount = $('#single_amount').val();

        if ($('#single_tax').val() == "") {
            swal('Oops!', 'Please select a tax', 'info');
        } else if ($('#single_tax').val() == "Set Up Tax") {
            location.href = "{{ route('setup tax') }}";
        } else if ($('#single_tax').val() == "No Tax") {
            $('#single_tax_amount').val(0.00);
            $('#single_total_amount').val(amount);
        } else {

            if ($('#single_amount').val() != "") {
                runTax();

            }


        }

    });

    $('#single_amount').on("keyup", function() {

        if ($('#single_tax').val() != "" && $('#single_amount').val() != "") {
            runTax();
        } else if ($('#single_tax').val() != "" && $('#single_amount').val() == "") {
            swal('Oops!', 'Please specify an amount', 'info');
        }

    });


    function runTax() {

        $('#single_tax_amount').val("");
        $('#single_total_amount').val("");

        var route = "{{ URL('/api/v1/gettaxdetail') }}";
        var thisdata = {
            id: $('#single_tax').val(),
            amount: $('#single_amount').val()
        };


        Pace.restart();
        Pace.track(function() {

            setHeaders();

            jQuery.ajax({
                url: route,
                method: 'get',
                data: thisdata,
                dataType: 'JSON',

                success: function(result) {
                    if (result.message == "success") {
                        var res = result.data;
                        $('#single_tax_amount').val(res.taxAmount.toFixed(2));
                        $('#single_total_amount').val(res.totalAmount.toFixed(2));
                    } else {
                        $('#single_tax_amount').val("0");
                        $('#single_total_amount').val("0");
                    }

                },
                error: function(err) {
                    $('#single_tax_amount').val("0");
                    $('#single_total_amount').val("0");
                }

            });

        });

    }


    function delhandShake(val, id) {
        var route;
        var formData;


        if (val == "deletetax") {

            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this tax!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        formData = new FormData();
                        formData.append("id", $('#id' + id).val());

                        route = "{{ URL('/api/v1/deletetax') }}";


                        Pace.restart();
                        Pace.track(function() {
                            setHeaders();
                            jQuery.ajax({
                                url: route,
                                method: 'post',
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                dataType: 'JSON',

                                success: function(result) {

                                    if (result.status == 200) {
                                        swal("Success", result.message, "success");
                                        setTimeout(function() {
                                            location.href =
                                                "{{ route('setup tax') }}";
                                        }, 2000);
                                    } else {
                                        swal("Oops", result.message, "error");
                                    }


                                },
                                error: function(err) {
                                    swal("Oops", err.responseJSON.message, "error");

                                }

                            });
                        });

                    } else {
                        console.log('Nothing happened');
                    }
                });



        } else if (val == "deletecard") {

            // Ask Are you sure

            swal({
                    title: "Are you sure you want to delete card?",
                    text: "This card will be deleted and can not be recovered!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        // Run Ajax

                        var thisdata = {
                            id: $("#card_id" + id).val()
                        };

                        route = "{{ URL('/api/v1/deletecard') }}";

                        Pace.restart();
                        Pace.track(function() {
                            setHeaders();
                            jQuery.ajax({
                                url: route,
                                method: 'post',
                                data: thisdata,
                                dataType: 'JSON',

                                success: function(result) {

                                    if (result.status == 200) {
                                        swal("Success", result.message, "success");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    } else {
                                        swal("Oops", result.message, "error");
                                    }

                                },
                                error: function(err) {
                                    swal("Oops", err.responseJSON.message, "error");

                                }

                            });
                        });


                    } else {

                    }
                });

        } else if (val == "deletebank") {
            // Ask Are you sure

            swal({
                    title: "Are you sure you want to delete bank account?",
                    text: "This bank account will be deleted and can not be recovered!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        // Run Ajax

                        var thisdata = {
                            id: $("#bank_id" + id).val()
                        };

                        route = "{{ URL('/api/v1/deletebank') }}";

                        Pace.restart();
                        Pace.track(function() {
                            setHeaders();
                            jQuery.ajax({
                                url: route,
                                method: 'post',
                                data: thisdata,
                                dataType: 'JSON',

                                success: function(result) {

                                    if (result.status == 200) {
                                        swal("Success", result.message, "success");
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    } else {
                                        swal("Oops", result.message, "error");
                                    }

                                },
                                error: function(err) {
                                    swal("Oops", err.responseJSON.message, "error");

                                }

                            });
                        });


                    } else {

                    }
                });
        }

    }

    function handShake(val) {

        var route;
        var formData;


        if (val == 'addcard') {

            formData = new FormData(formElem);


            route = "{{ URL('/api/v1/addnewcard') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        // console.log(result);

                        $('#cardSubmit').text('Submit');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == 'editcard') {

            formData = new FormData(formElem);


            route = "{{ URL('/api/v1/editcard') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        // console.log(result);

                        $('#cardSubmit').text('Submit');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.href = "{{ route('Admin') }}";
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == 'singleinvoice') {

            formData = new FormData(formElem);


            route = "{{ URL('/api/v1/singleinvoice') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        // console.log(result);

                        $('#cardSubmit').text('Submit');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.href = "{{ route('Admin') }}";
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        }

        // Generate Invoice Links
        else if (val == 'singleinvoicelink') {

            formData = new FormData(formElem);


            route = "{{ URL('/api/v1/singleinvoicelink') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        // console.log(result);

                        $('#cardSubmit').text('Submit');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.href = "{{ route('Admin') }}";
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == 'bulkinvoice') {

            formData = new FormData(formElem);


            route = "{{ URL('/api/v1/bulkinvoice') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        // console.log(result);

                        $('#cardSubmit').text('Submit');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.href = "{{ route('Admin') }}";
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == 'withdrawmoney') {

            formData = new FormData(formElem);

            route = "{{ URL('/api/v1/moneywithdrawal') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.withdrawmoneyBtn').text('Please wait...');
                    },
                    success: function(result) {
                        console.log(result);

                        $('.withdrawmoneyBtn').text('Withdraw Money');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.href = "{{ route('Admin') }}";
                            }, 5000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        $('.withdrawmoneyBtn').text('Withdraw Money');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == 'addmoney') {
            formData = new FormData(formElem);
            route = "{{ URL('/api/v1/addmoneytowallet') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        console.log(result);

                        $('.cardSubmit').text('Confirm');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.href = "{{ route('Admin') }}";
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        $('.cardSubmit').text('Confirm');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == 'addbank') {

            formData = new FormData(formElem);


            route = "{{ URL('/api/v1/addnewbank') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        // console.log(result);

                        $('#cardSubmit').text('Submit');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == 'createservicetype') {

            formData = new FormData(formElem);


            route = "{{ URL('/api/v1/createservicetype') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        // console.log(result);

                        $('#cardSubmit').text('Submit');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == 'setuptax') {

            formData = new FormData(formElem);


            route = "{{ URL('/api/v1/setuptax') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        // console.log(result);

                        $('#cardSubmit').text('Submit');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == 'edittax') {

            formData = new FormData(formElem);


            route = "{{ URL('/api/v1/edittax') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        // console.log(result);

                        $('#cardSubmit').text('Submit');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == 'editbank') {

            formData = new FormData(formElem);


            route = "{{ URL('/api/v1/editbank') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#cardSubmit').text('Please wait...');
                    },
                    success: function(result) {
                        // console.log(result);

                        $('#cardSubmit').text('Submit');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.href = "{{ route('Admin') }}";
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "transactionpinsettings") {

            formData = new FormData(formElemtransactionpinsettings);

            route = "{{ URL('/api/v1/updatetransactionpin') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#transactionBtn').text('Please wait...');
                    },
                    success: function(result) {

                        $('#transactionBtn').text('Save');


                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $('#transactionBtn').text('Save');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "newtransactionpinsettings") {

            formData = new FormData(formElemnewtransactionpinsettings);

            route = "{{ URL('/api/v1/createtransactionpin') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#transactionBtn').text('Please wait...');
                    },
                    success: function(result) {

                        $('#transactionBtn').text('Save');


                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $('#transactionBtn').text('Save');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "bvnverification") {

            formData = new FormData(formElembvnverification);

            route = "{{ URL('/api/v1/bvnverification') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#bvnBtn').text('Please wait...');
                    },
                    success: function(result) {

                        $('#bvnBtn').text('Save');


                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $('#bvnBtn').text('Save');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "passwordsettings") {

            formData = new FormData(formElempasswordsettings);

            route = "{{ URL('/api/v1/updatepassword') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#passwordBtn').text('Please wait...');
                    },
                    success: function(result) {

                        $('#passwordBtn').text('Save');


                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $('#passwordBtn').text('Save');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "securityquestans") {

            formData = new FormData(formElemsecurityquestans);

            route = "{{ URL('/api/v1/security') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#securityBtn').text('Please wait...');
                    },
                    success: function(result) {

                        $('#securityBtn').text('Save');


                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $('#securityBtn').text('Save');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "resetPassword") {

            formData = new FormData(formElemresetPassword);

            route = "{{ URL('/api/v1/resetpassword') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#' + val + 'Btn').text('Please wait...');
                    },
                    success: function(result) {


                        $('#' + val + 'Btn').text('Submit');

                        $(".close").click();
                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $(".close").click();
                        $('#' + val + 'Btn').text('Submit');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "resetTransactionPin") {

            formData = new FormData(formElemresetTransactionPin);

            route = "{{ URL('/api/v1/resettransactionpin') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#' + val + 'Btn').text('Please wait...');
                    },
                    success: function(result) {


                        $('#' + val + 'Btn').text('Submit');
                        $(".close").click();

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $(".close").click();
                        $('#' + val + 'Btn').text('Submit');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "merchantprofile") {

            formData = new FormData(formElemProfile);

            route = "{{ URL('/api/v1/merchantprofile') }}";



            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#updatemyProfile').text('Updating Profile...');
                    },
                    success: function(result) {

                        $('#updatemyProfile').text('Update Profile');


                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $('#updatemyProfile').text('Update Profile');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "merchantbusiness") {

            formData = new FormData(formElemBusinessProfile);

            route = "{{ URL('/api/v1/merchantbusinessprofile') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#updatemyBusinessProfile').text('Updating Business...');
                    },
                    success: function(result) {

                        $('#updatemyBusinessProfile').text('Update Business');


                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $('#updatemyBusinessProfile').text('Update Business');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "ownerandcontrollers") {

            formData = new FormData(formElemShareholder);

            route = "{{ URL('/api/v1/ownerandcontrollersprofile') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#updatemyOwnership').text('Updating Business...');
                    },
                    success: function(result) {

                        $('#updatemyOwnership').text('Update Information');


                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $('#updatemyOwnership').text('Update Information');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "promotebusiness") {

            formData = new FormData(formElemBusinessProfile);

            route = "{{ URL('/api/v1/promotebusiness') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#promoteMyBusiness').text('Processing Information...');
                    },
                    success: function(result) {

                        $('#promoteMyBusiness').text('Promote Business');


                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 7000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $('#promotemyBusinessProfile').text('Promote Business');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if (val == "broadcastbusiness") {

            formData = new FormData(formElemBusinessProfile);

            route = "{{ URL('/api/v1/broadcastbusiness') }}";


            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#broadcastMyBusiness').text('Processing Information...');
                    },
                    success: function(result) {

                        $('#broadcastMyBusiness').text('Broadcast Business');


                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.reload();
                            }, 7000);
                        } else {
                            swal("Oops", result.message, "error");
                        }


                    },
                    error: function(err) {
                        $('#broadcastmyBusinessProfile').text('Broadcast Business');
                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });

        } else if ('createnew') {
            formData = new FormData(formElem);

            route = "{{ URL('/api/v1/sendmoneytoanonymous') }}";

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.sendmoneyBtn').text('Please wait...');
                    },
                    success: function(result) {
                        console.log(result);

                        $('.sendmoneyBtn').text('Send Money');

                        if (result.status == 200) {
                            swal("Success", result.message, "success");
                            setTimeout(function() {
                                location.href = "{{ route('merchant send money') }}";
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {

                        // console.log(err);

                        if (err.responseJSON.status == 400) {

                            $('.sendmoneyBtn').text('Send Money');
                            swal("Oops", err.responseJSON.message, "error");
                        } else {


                            $('.sendmoneyBtn').text('Send Money');
                            swal("User already exist",
                                "You'll be redirected in 3sec to continue your transfer", "info"
                            );

                            setTimeout(function() {
                                location.href = err.responseJSON.link;
                            }, 2000);
                        }



                    }

                });
            });

        }


    }


    $("#bank_code").change(function() {
        var accountNumber = $("#account_number").val();
        var bankCode = $("#bank_code").val();
        if ($("#accountNumber").val() != "") {

            var route = "{{ URL('/api/v1/verifyaccountnumber') }}";

            var formData = new FormData();
            formData.append("bank_code", bankCode);
            formData.append("account_number", accountNumber);

            Pace.restart();
            Pace.track(function() {
                setHeaders();
                jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',

                    success: function(result) {

                        if (result.status == 200) {
                            $('#account_name').val(result.data.account_name);
                        } else {
                            $('#account_name').val("ACCOUNT NUMBER NOT VALID");
                        }

                    },
                    error: function(err) {

                        swal("Oops", err.responseJSON.message, "error");

                    }

                });
            });
        }

    });


    function promotionAction(val, id) {

        var route = "{{ URL('Ajax/promotionaction') }}";

        var action;
        var thisdata;
        var button = $("#" + val + "" + id);

        if (val == "Remove") {
            action = "This business will be removed from promotions";
        } else {
            action = "You have confirmed this business is successfully broadcasted";
        }

        swal({
                title: "Are you sure?",
                text: action,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        id: id,
                        val: val
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            button.text("Please wait...");
                        },
                        success: function(result) {
                            button.text(val);

                            if (result.message == "success") {
                                // Route to another page
                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 5000);
                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        },
                        error: function(err) {

                            button.text(val);
                            swal("Oops", err.responseJSON.message, "error");


                        }

                    });

                } else {
                    swal('', 'Cancelled', 'info');
                }
            });

    }



    function acceptCrossBorder(transactionid) {

        var route = "{{ URL('Ajax/acceptcrossborderpayment') }}";

        var thisdata;
        var button = $(".spin" + transactionid);


        swal({
                title: "Are you sure?",
                text: 'Be sure you have confirmed the file uploaded',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    thisdata = {
                        transactionid: transactionid,
                    };
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            button.text("Please wait...");
                        },
                        success: function(result) {
                            button.text('Process Payment');

                            if (result.message == "success") {
                                // Route to another page
                                swal(result.title, result.res, result.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal(result.title, result.res, result.message);
                            }


                        },
                        error: function(err) {

                            button.text('Process Payment');
                            swal("Oops", err.responseJSON.message, "error");


                        }

                    });

                } else {
                    swal('', 'Cancelled', 'info');
                }
            });

    }



    function notifyForm(email) {
        var route = "{{ URL('Ajax/notifyupdate') }}";
        var formData = new FormData();
        formData.append("user_id", email);

        Pace.restart();
        Pace.track(function() {
            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(result) {
                    if (result.message == "success") {


                    } else {

                    }
                }

            });
        });

    }


    function payOrg(user_id) {
        var link = location.origin + "/Admin/wallet/payment/sendmoney/" + user_id +
            "?country={{ session('country') }}";
        setTimeout(function() {
            location.href = link;
        }, 1000);
    }


    function restriction(val, name) {
        $('.specialText').addClass("disp-0");

        if (val == "withdrawal")
            swal('Hello ' + name, 'Your account need to be verified before you can make withdrawal', 'info');


        if (val == "addmoney")
            swal('Hello ' + name, 'Your account need to be verified before you can add money', 'info');

        if (val == "invoice")
            swal('Hello ' + name, 'Your account need to be verified before you can pay for invoice', 'info');

        if (val == "specialinfo")
            $('.specialText').removeClass("disp-0");
    }

    function comingSoon() {
        $('.close').click();
        swal('Hey', 'This feature is coming soon', 'info');
    }

    function goBack() {
        window.history.back();
    }

    function resetPin(question, val) {
        $("#" + val + "securityQuest").val(question);
        $("#" + val + "mySecQuest").text(question);
        $("#" + val).click();
    }


    function checkDetail(val) {


        $('tbody#recorgRec').html("");


        if (val == 'rec') {
            if ($('#recorgInfo').val() == "") {
                $('tbody#recorgRec').html("");
                swal("Oops!", "Enter receivers code", "info");
            } else {
                route = "{{ URL('Ajax/getOrganization') }}";
                thisdata = {
                    user_id: $('#recorgInfo').val(),
                    code: $('#reccountryCode').val(),
                    action: val
                };

                Pace.restart();
                Pace.track(function() {
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('tbody#recorgRec').html(
                                "<tr><td colspan='7' align='center'>Please wait...</td></tr>");
                        },
                        success: function(result) {

                            if (result.message == "success") {
                                var datainfo = "";
                                var datarec;
                                var res = JSON.parse(result.data);

                                // console.log(res);


                                $.each(res, function(v, k) {
                                    var datarec = "<tr><td>" + k.name + "</td><td>" + k
                                        .address + "</td><td>" + k.city + "</td><td>" + k
                                        .state + "</td><td>" + k.country + "</td><td>" + k
                                        .amount_to_send +
                                        "</td><td><button class='btn btn-primary' onclick=receiveMoney('" +
                                        k.orgId + "')>Receive Money</button></td></tr>";

                                    datainfo += datarec;
                                });



                                $('tbody#recorgRec').html(datainfo);
                            } else {
                                $('tbody#recorgRec').html("<tr><td colspan='7' align='center'>" +
                                    result.res + "</td></tr>");
                            }


                        }

                    });
                });
            }
        } else if (val == "send") {

            if ($('#orgInfo').val() == "") {
                $('tbody#orgRec').html("");
                swal("Oops!", "Enter receivers code", "info");
            } else {
                route = "{{ URL('Ajax/getOrganization') }}";
                thisdata = {
                    user_id: $('#orgInfo').val(),
                    code: $('#countryCode').val(),
                    action: val
                };

                Pace.restart();
                Pace.track(function() {
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('tbody#orgRec').html(
                                "<tr><td colspan='8' align='center'>Please wait...</td></tr>");
                        },
                        success: function(result) {



                            if (result.message == "success") {
                                var res = JSON.parse(result.data);

                                // console.log(res);

                                // Result
                                // $('tbody#orgRec').html("<tr><td>"+res[0].business_name+"</td><td>"+res[0].address+"</td><td>"+res[0].corporate_type+"</td><td>"+res[0].city+"</td><td>"+res[0].state+"</td><td>"+res[0].country+"</td><td><button class='btn btn-primary' onclick=payOrg('"+res[0].user_id+"')>Send Money</button></td></tr>");


                                var datainfo = "";
                                var datarec;
                                var sendBtn;
                                var avatar;




                                $.each(res, function(v, k) {

                                    // if(result.country == k.country){
                                    // sendBtn = "<button class='btn btn-primary' onclick=payOrg('"+k.ref_code+"')>Send Money</button>";

                                    // }
                                    // else{
                                    //     sendBtn = "<button class='btn btn-primary' onclick=cannotSend()>Send Money</button>";
                                    // }

                                    sendBtn =
                                        "<button class='btn btn-primary' onclick=payOrg('" +
                                        k.ref_code + "')>Send Money</button>";

                                    if (k.avatar != null) {
                                        avatar = k.avatar;
                                    } else {
                                        avatar =
                                            "https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_ft8qly_frobtx.jpg";
                                    }

                                    datarec = "<tr><td><img src='" + avatar +
                                        "' style='width:40px; height:40px; border-radius: 100%;'></td><td>" +
                                        k.name + "</td><td>" + k.address + "</td><td>" + k
                                        .ref_code + "</td><td>" + k.city + "</td><td>" + k
                                        .state + "</td><td>" + k.country + "</td><td>" +
                                        sendBtn + "</td></tr>";

                                    datainfo += datarec;
                                });



                                $('tbody#orgRec').html(datainfo);


                                // $('tbody#orgRec').html("<tr><td>"+res.name+"</td><td>"+res.address+"</td><td>"+res.ref_code+"</td><td>"+res.city+"</td><td>"+res.state+"</td><td>"+res.country+"</td><td><button class='btn btn-primary' onclick=payOrg('"+res.ref_code+"')>Send Money</button></td></tr>");
                            } else {
                                $('tbody#orgRec').html("<tr><td colspan='8' align='center'>" +
                                    result.res + "</td></tr>");
                                // swal(result.title, result.res, result.message);
                            }


                        }

                    });
                });
            }
        } else if (val == "search") {

            if ($('#orgInfosearch').val() == "") {
                $('tbody#searchorgRec').html("");
                swal("Oops!", "Enter receivers name", "info");
            } else {
                route = "{{ URL('Ajax/getOrganization') }}";
                thisdata = {
                    user_id: $('#orgInfosearch').val(),
                    action: val
                };

                Pace.restart();
                Pace.track(function() {
                    setHeaders();
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: thisdata,
                        dataType: 'JSON',
                        beforeSend: function() {
                            $('tbody#searchorgRec').html(
                                "<tr><td colspan='8' align='center'>Please wait...</td></tr>");
                        },
                        success: function(result) {

                            if (result.message == "success") {
                                var res = JSON.parse(result.data);


                                var datainfo = "";
                                var datarec;
                                var sendBtn;
                                var avatar;


                                $.each(res, function(v, k) {

                                    // if(result.country == k.country){
                                    // sendBtn = "<button class='btn btn-primary' onclick=payOrg('"+k.ref_code+"')>Send Money</button>";

                                    // }
                                    // else{
                                    //     sendBtn = "<button class='btn btn-primary' onclick=cannotSend()>Send Money</button>";
                                    // }

                                    sendBtn =
                                        "<button class='btn btn-primary' onclick=payOrg('" +
                                        k.ref_code + "')>Send Money</button>";

                                    if (k.avatar != null) {
                                        avatar = k.avatar;
                                    } else {
                                        avatar =
                                            "https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_ft8qly_frobtx.jpg";
                                    }

                                    datarec = "<tr><td><img src='" + avatar +
                                        "' style='width:40px; height:40px; border-radius: 100%;'></td><td>" +
                                        k.name + "</td><td>" + k.address + "</td><td>" + k
                                        .ref_code + "</td><td>" + k.city + "</td><td>" + k
                                        .state + "</td><td>" + k.country + "</td><td>" +
                                        sendBtn + "</td></tr>";

                                    datainfo += datarec;
                                });




                                $('tbody#searchorgRec').html(datainfo);
                            } else {
                                $('tbody#searchorgRec').html("<tr><td colspan='8' align='center'>" +
                                    result.res + "</td></tr>");
                            }


                        }

                    });
                });
            }
        }

    }


    function getFormData(form) {
        $('#btnSelector').text('Please wait...');
        var unindexed_array = form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i) {
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }

    function moveSelected() {
        var formData = new FormData();
        var checkedData = document.querySelector('.checkerInfo');
        swal({
                title: "Are you sure?",
                text: "This users will be moved to the next level",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    var selectedItem = $("input[name^=checkState]:checked");

                    var responseMessage = "";

                    if (selectedItem.length > 0) {


                        for (let i = 0; i < selectedItem.length; i++) {
                            const element = selectedItem[i].defaultValue;

                            if (element != undefined) {

                                formData.append("id", element);

                                var route = "{{ route('move selected users') }}";

                                Pace.restart();
                                Pace.track(function() {
                                    setHeaders();
                                    jQuery.ajax({
                                        url: route,
                                        method: 'post',
                                        data: formData,
                                        cache: false,
                                        processData: false,
                                        contentType: false,
                                        dataType: 'JSON',
                                        beforeSend: function() {
                                            $('#btnSelector').text('Please wait...');
                                        },
                                        success: function(result) {

                                            $('#btnSelector').text('Move all selected');

                                            if (result.message == "success") {
                                                swal("Success", result.message, "success");
                                                // setTimeout(function(){ location.reload(); }, 2000);
                                            } else {
                                                swal("Oops", result.message, "error");

                                            }

                                        },
                                        error: function(err) {
                                            $('#btnSelector').text('Withdraw Money');
                                            swal("Oops", err.responseJSON.message, "error");


                                        }

                                    });
                                });
                            }

                        }

                        setTimeout(function() {
                            location.reload();
                        }, 15000);
                    }


                } else {
                    swal('', 'Cancelled', 'info');
                }
            });
    }


    function checkMyBox(val, id) {

        // Show cancel icon by default

        var checkProp = $(`#${val+id}`).prop('checked');

        var route = "{{ URL('Ajax/checkIdvPassInfo') }}";
        thisdata = {
            val,
            id,
            checkProp
        };


        Pace.restart();
        Pace.track(function() {
            setHeaders();
            jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function() {
                    iziToast.info({
                        title: 'Hey',
                        message: 'Processing request...',
                        position: 'topRight',
                        timeout: 500,
                    });
                },
                success: function(result) {

                    console.log(result);

                    if (result.message == "success") {

                        iziToast.success({
                            title: 'Great',
                            message: 'Message sent successfully',
                            position: 'topRight',
                        });

                    } else {
                        iziToast.error({
                            title: 'Oops',
                            message: 'Something went wrong!',
                            position: 'topRight',
                        });
                    }


                },
                error: function(err) {
                    iziToast.error({
                        title: 'Oops',
                        message: err.message,
                        position: 'topRight',
                    });
                }

            });
        });



    }

    function activateLive(val, id) {


        swal({
                title: "Are you sure?",
                text: `Click OK to move account to ${val.toUpperCase()} mode`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var route = "{{ URL('Ajax/activatemerchantaccount') }}";
                    thisdata = {
                        val,
                        id
                    };

                    Pace.restart();
                    Pace.track(function() {
                        setHeaders();
                        jQuery.ajax({
                            url: route,
                            method: 'post',
                            data: thisdata,
                            dataType: 'JSON',
                            beforeSend: function() {

                                $(`#btn${id}`).text('Please wait...');
                            },
                            success: function(result) {

                                $(`#btn${id}`).text('Activate Live');

                                console.log(result);

                                if (result.message == "success") {

                                    iziToast.success({
                                        title: 'Great',
                                        message: result.res,
                                        position: 'topRight',
                                    });

                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);

                                } else {
                                    iziToast.error({
                                        title: 'Oops',
                                        message: result.res,
                                        position: 'topRight',
                                    });
                                }


                            },
                            error: function(err) {
                                $(`#btn${id}`).text('Activate Live');
                                iziToast.error({
                                    title: 'Oops',
                                    message: err.message,
                                    position: 'topRight',
                                });
                            }

                        });
                    });


                } else {

                }
            });





    }


    function deleteInvestorPost(id) {

        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this post!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#deletepost'+id).submit();
                }
            });


    }

    function deleteInvestorNews(id) {

swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this news!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#deletenews'+id).submit();
        }
    });


}

    function deleteStore(id) {

        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this store!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#deletestore' + id).submit();
                }
            });


    }

    function processMobileMoney(id) {

        swal({
        title: "Are you sure?",
        text: "Do you want to process this transaction?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
        $('#processmobilemoney' + id).submit();
        }
        });


        }



    function deleteClaim(id) {

swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this claim!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#deleteclaim' + id).submit();
        }
    });


}

function restoreClaim(id) {

swal({
        title: "Are you sure?",
        text: "You are about to restore this Claim!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#restoreclaim' + id).submit();
        }
    });


}


    function integration(id) {

        swal({
                title: "Are you sure?",
                text: "Click on OK to continue",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#integration' + id).submit();
                }
            });


    }

    function deleteCategory(id) {

        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this category!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#deletecategory' + id).submit();
                }
            });


    }

    function updateState(id) {

        swal({
                title: "Are you sure?",
                text: "Are you sure you want to update the state of this category?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#updatestate' + id).submit();
                }
            });


    }

    function storeActivation(id) {
        swal({
                title: "Are you sure?",
                text: "Click OK to continue",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $('#activation'+ id).submit();
                }
            });
    }

    function cannotSend() {
        swal('International Transfer Coming Soon!',
            'We detected this is an international transaction. We\'ll notify you when it is available', 'info');
    }

    function setHeaders() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Authorization': "Bearer " + "{{ session('api_token') }}"
            }
        });
    }



    Dropzone.options.myDropzone = {
        url: "{{ route('Uploads') }}",
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 5,
        maxFiles: 5,
        maxFilesize: 100, // MB
        paramName: "file",
        addRemoveLinks: true,
        init: function() {
            dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

            // for Dropzone to process the queue (instead of default form behavior):
            document.getElementById("submit_all").addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                dzClosure.processQueue();
            });

            //send all the form data along with the files:
            this.on("sendingmultiple", function(data, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
                formData.append("file_title", $("#file_title").val());
            });
        }
    }



    function handleClick(val, item, id){
        if(val === 'edit'){
            $('#formId').val(id);
            $('#name').val(item);
            $('#submitBtn').removeClass('btn-primary');
            $('#submitBtn').addClass('btn-success');
            $('#submitBtn').text('Update');
            $('#myForm').attr('action', "{{ route('edit payment gateway') }}");

        }
        else{
             swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       $('#formId').val(id);

                       $('#myForm').attr('action', "{{ route('delete payment gateway') }}");

                       $('form#myForm').submit();

                    }
                });
        }
    }


    function changeGateway(id){
        $('#myBtn'+id).text('Update gateway').removeClass('btn-success').addClass('btn-danger').attr('onclick', `updateGateway(${id})`);

        $('#mycountrygatewayform'+id).removeClass('disp-0');
        $('#currId'+id).addClass('disp-0');
    }

    function updateGateway(id){
        $('#mycountrygatewayform'+id).submit();
    }

    function checkAutoCredit(id, val) {
        $('#myvalue'+id).val(val);
        $('#checkers'+id).submit();
    }

</script>

    </body>

    </html>
