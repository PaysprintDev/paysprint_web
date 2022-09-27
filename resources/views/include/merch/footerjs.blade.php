</div>


</div>
<!-- latest jquery-->
<script src=" {{ asset('merchantassets/assets/js/jquery-3.5.1.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- feather icon js-->
<script src=" {{ asset('merchantassets/assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src=" {{ asset('merchantassets/assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- Sidebar jquery-->
<script src=" {{ asset('merchantassets/assets/js/sidebar-menu.js') }}"></script>
<script src=" {{ asset('merchantassets/assets/js/config.js') }}"></script>
<!-- Bootstrap js-->
<script src=" {{ asset('merchantassets/assets/js/bootstrap/popper.min.js') }}"></script>
<script src=" {{ asset('merchantassets/assets/js/bootstrap/bootstrap.min.js') }}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('merchantassets/assets/js/chart/chartist/chartist.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/chart/chartist/chartist-plugin-tooltip.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/chart/knob/knob.min.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/chart/knob/knob-chart.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/chart/apex-chart/stock-prices.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/prism/prism.min.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/counter/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/counter/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/counter/counter-custom.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/custom-card/custom-card.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/vector-map/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/vector-map/map/jquery-jvectormap-au-mill.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/vector-map/map/jquery-jvectormap-in-mill.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/vector-map/map/jquery-jvectormap-asia-mill.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/dashboard/default.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/notify/index.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/datepicker/date-picker/datepicker.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/dropzone/dropzone-script.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/print.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js"></script>
<script src="{{ asset('pace/pace.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


<!-- Plugins JS Ends-->

<!-- Plugins JS start-->
<script src=" {{ asset('merchantassets/assets/js/form-wizard/form-wizard-three.js') }}"></script>
<script src=" {{ asset('merchantassets/assets/js/form-wizard/jquery.backstretch.min.js') }}"></script>
<!-- Plugins JS Ends-->

<!-- Plugins JS start-->
<script src="{{ asset('merchantassets/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<!-- Plugins JS Ends-->

<!-- Theme js-->
<script src="{{ asset('merchantassets/assets/js/script.js') }}"></script>
<script src="{{ asset('merchantassets/assets/js/theme-customizer/customizer.js') }}"></script>
<!-- Plugin used-->
<script src="{{ asset('js/country-state-select.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script language="javascript">
    populateCountries("delivery_country", "delivery_state");
</script>


<script>
    $(document).ready(function() {



        $('.invoicetable').DataTable({
            'pageLength': 20,
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


        $('.store_description').summernote({
            placeholder: 'Enter product description',
            tabsize: 2,
            height: 120,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['help']]
            ]
        });


        $('#aboutUs, #testimonialDescription').summernote({
            tabsize: 2,
            height: 160,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['help']]
            ]
        });
        $('#pricingOffer1, #pricingOffer2, #pricingOffer3, #serviceBenefits1, #serviceBenefits2, #serviceBenefits3, #serviceBenefits4, #serviceBenefits5, #serviceBenefits6').summernote({
            tabsize: 2,
            height: 120,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['help']]
            ]
        });

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
                        $('#cardSubmit').text('Submit');
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
                        $('#cardSubmit').text('Submit');
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
                                location.href = "{{ route('dashboard') }}";
                            }, 2000);
                        } else {
                            swal("Oops", result.message, "error");
                        }

                    },
                    error: function(err) {
                        $('#cardSubmit').text('Submit');
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
                        $('#cardSubmit').text('Submit');
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
                        $('#cardSubmit').text('Submit');
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
                        // console.log(result);

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
                        $('#cardSubmit').text('Submit');
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
                        $('#cardSubmit').text('Submit');
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
                        $('#cardSubmit').text('Submit');
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
                        $('#cardSubmit').text('Submit');
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
                        $('#cardSubmit').text('Submit');
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
                        // console.log(result);

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

    function changeMyPlan(val) {
        if ('changeplan') {
            var formData = new FormData(formElemchangeplan);

            swal({
                    title: "Are you sure?",
                    text: "Click OK to proceed",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        route = "{{ URL('/api/v1/changeplan') }}";

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

                                    $('#cardSubmit').text('Upgrade Account');


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
                                    $('#cardSubmit').text('Upgrade Account');
                                    swal("Oops", err.responseJSON.message, "error");

                                }

                            });
                        });
                    } else {

                    }
                });



        }
    }

    function deleteProduct(id) {

        swal({
                title: "Are you sure?",
                text: "Click OK to proceed",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(`#formProduct${id}`).submit();
                } else {

                }
            });



    }


    function deleteDiscount(id) {

        swal({
                title: "Are you sure?",
                text: "Click OK to proceed",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(`#formDiscount${id}`).submit();
                } else {

                }
            });



    }


    function generateDiscountCode() {
        // Generate random...
        $('#code').val('');
        const randomCode = Math.random().toString(16).substr(2, 8).toUpperCase();

        $('#code').val(randomCode);
    }

    function generateProductCode() {
        // Generate random...
        $('.productCode').val('');

        // STPR_ => Store Product
        const randomCode = `STPR_${Math.random().toString(16).substr(2, 8).toUpperCase()}`;

        $('.productCode').val(randomCode);
        $('.productCode').attr('readonly', true);
    }

    function comingSoon() {
        swal('Hey!', 'This feature is coming soon to your screen', 'info');
    }

    $('#valueType').change(function() {
        if ($('#valueType').val() == "Percentage") {
            $('.symbolText').text('%');
        } else {
            $('.symbolText').text('{{ Auth::user()->currencySymbol }}');
        }
    });


    async function outForDelivery(orderId) {

        // Run axios...
        try {

            $('#delivery' + orderId).text('Please wait...');


            var data = new FormData();


            data.append('orderId', orderId);


            var headers = {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Authorization': 'Bearer {{ Auth::user()->api_token }}'
            };

            const config = {
                method: 'POST',
                url: "{{ URL('/api/v1/order/out-for-delivery') }}",
                headers: headers,
                data: data
            }


            const response = await axios(config);

            swal("Great!", response.data.message, "success");

            setTimeout(function() {
                location.reload();
            }, 2000);

        } catch (error) {

            $('#delivery' + orderId).text('Out for Delivery / Pickup');

            if (error.response) {
                swal("Oops", error.response.data.message, "error");
            } else {
                swal("Oops", error.message, "error");
            }
        }


    }

    function setHeaders() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Authorization': "Bearer " + "{{ Auth::user()->api_token }}"
            }
        });
    }


    $('.prodCategory').change(function() {
        if ($('.prodCategory').val() == 'Other') {
            $('.specifycategory').removeClass('disp-0');
        } else {
            $('.specifycategory').addClass('disp-0');
        }
    });

    $('#flexCheckDefault').on('click', function() {
        if ($('#flexCheckDefault').prop('checked') == true) {
            // Setup pickup point...
            $('.instorebtn').click();
        }
    });
    $('#flexCheckChecked').on('click', function() {
        if ($('#flexCheckChecked').prop('checked') == true) {
            // CLicking on another function
            // $('.deliveryshippingbtn').click();
            shippingWithRate();
        }
    });

    function shippingWithRate() {
        $('.deliveryshippingbtn').click();
    }



    Dropzone.options.myGreatDropzone = { // camelized version of the `id`
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        accept: function(file, done) {
            if (file.name == "justinbieber.jpg") {
                done("Naha, you don't.");
            } else {
                done();
            }
        }
    };



    // Service Store AJAX...

    async function serviceSetup(id, value) {
        try {

            $('.' + value).removeClass('disp-0');
            $('.' + value + id).addClass('disp-0');

            var formData;

            if (value === 'header') {
                formData = new FormData(formElemHead);
            }
            if (value === 'about') {
                formData = new FormData(formElemAbout);
            }
            if (value === 'service') {
                formData = new FormData(formElemService);
            }
            if (value === 'pricing') {
                formData = new FormData(formElemPricing);
            }
            if (value === 'testimonial') {
                formData = new FormData(formElemTestimonial);
            }
            if (value === 'contact') {
                formData = new FormData(formElemContact);
            }

            formData.append('value', value);
            formData.append('merchantId', id);

            var headers = {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Authorization': 'Bearer {{ Auth::user()->api_token }}'
            };

            const config = {
                method: 'POST',
                url: "{{ URL('/api/v1/service/setup') }}",
                headers: headers,
                data: formData
            }

            const response = await axios(config);

            $('.' + value).addClass('disp-0');
            $('.' + value + id).removeClass('disp-0');

            iziMessage(true, 'Good', response.data.message);

        } catch (error) {

            $('.' + value).addClass('disp-0');
            $('.' + value + id).removeClass('disp-0');

            if (error.response) {
                iziMessage(false, 'Error', error.response.data.message);
            } else {
                iziMessage(false, 'Error', error.message);
            }


        }
    }

    function getMyPaymentLink(id) {
        $('#paymentLinkModal' + id).click();
        $('#acceptLinkBtn').attr('disabled', true);
    }

    function acceptLinkTerms() {
        $('#myPaymentLinkUp').submit();
    }

    $('#paylink_checkbox').change(function() {

        if ($('#paylink_checkbox').prop('checked') === false) {
            $('#acceptLinkBtn').attr('disabled', true);
        } else {
            $('#acceptLinkBtn').attr('disabled', false);
        }

    });

    function becomeAnAgent(ref_code) {

        let data = {
            ref_code: ref_code
        };

        var headers = {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
            'Authorization': 'Bearer {{ Auth::user()->api_token }}'
        };

        swal({
                title: "Are you sure?",
                text: "Click OK if you want to become a payout agent",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(async (willDelete) => {
                if (willDelete) {

                    try {

                        const config = {
                            method: 'POST',
                            url: "{{ URL('/api/v1/becomepayoutagent') }}",
                            headers,
                            data
                        }


                        const response = await axios(config);

                        iziMessage(true, 'Good', response.data.message);

                        setTimeout(() => {
                            location.reload();
                        }, 1000);

                    } catch (error) {

                        if (error.response) {
                            iziMessage(false, 'Error', error.response.data.message);
                        } else {
                            iziMessage(false, 'Error', error.message);
                        }

                    }



                }
            });
    }


    function payoutProcessFund(transaction_id) {


        let data = {
            transaction_id
        };

        var headers = {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
            'Authorization': 'Bearer {{ Auth::user()->api_token }}'
        };

        swal({
                title: "Are you sure?",
                text: "Click OK if you have confirmed recipient identification and the cash paid out",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(async (willDelete) => {
                if (willDelete) {

                    $('#processbtn' + transaction_id).text('Please wait...');


                    try {

                        const config = {
                            method: 'POST',
                            url: "{{ URL('/api/v1/processpayout') }}",
                            headers,
                            data
                        }


                        const response = await axios(config);

                        $('#processbtn' + transaction_id).text('Process fund');

                        iziMessage(true, 'Good', response.data.message);

                        setTimeout(() => {
                            location.reload();
                        }, 1000);

                    } catch (error) {
                        $('#processbtn' + transaction_id).text('Process fund');

                        if (error.response) {
                            iziMessage(false, 'Error', error.response.data.message);
                        } else {
                            iziMessage(false, 'Error', error.message);
                        }

                    }



                }
            });
    }






    function iziMessage(status, title, message) {

        return iziToast.show({
            title,
            message,
            backgroundColor: status === false ? '#f7a3a3' : '#dbeddd',
            position: 'topRight'
        });
    }
</script>

</body>

<!-- Mirrored from laravel.pixelstrap.com/viho/dashboard by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Nov 2021 16:20:40 GMT -->

</html>