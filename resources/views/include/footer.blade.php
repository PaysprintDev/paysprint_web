<!-- jQuery JS -->

    <script src="{{ asset('js/jquery-1.12.0.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://raw.githubusercontent.com/HubSpot/pace/v1.0.0/pace.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <!-- Animate JS -->
    <script src="{{ asset('vendors/animate/wow.min.js') }}"></script>
    <!-- Camera Slider -->
    <script src="{{ asset('vendors/camera-slider/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('vendors/camera-slider/camera.min.js') }}"></script>
    <!-- Isotope JS -->
    <script src="{{ asset('vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendors/isotope/isotope.pkgd.min.js') }}"></script>
    <!-- Progress JS -->
    <script src="{{ asset('vendors/Counter-Up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('vendors/Counter-Up/waypoints.min.js') }}"></script>
    <!-- Owlcarousel JS -->
    <script src="{{ asset('vendors/owl_carousel/owl.carousel.min.js') }}"></script>
    <!-- Stellar JS -->
    <script src="{{ asset('vendors/stellar/jquery.stellar.js') }}"></script>
    <!-- Theme JS -->
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="{{ asset('pace/pace.min.js') }}"></script>

    <script src="{{ asset('ext/plugins/countrycode/js/jquery.ccpicker.js') }}"></script>





{{-- Ajax --}}

<script>


$(document).ready(function(){
    

    // $("#orgInfo").CcPicker();

    $('#typepayamount').val(0);
    $('#orgpayuser_id').val("");


    $("#search_field").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  // To style only selects with the my-select class
    $('#property_owner').selectpicker();



});




var route;
var thisdata;
var name;
var email;

function creatEvent(id, purpose){
    route = "{{ URL('Ajax/CreateEvent') }}";

    if($("#ticket_title").val() ==  "" || $("#ticket_location").val() == "" || $("#ticket_dateStarts").val() == "" || $("#ticket_timeStarts").val() == "" || $("#ticket_dateEnds").val() == "" || $("#ticket_timeEnds").val() == ""){
        swal("Oops!", 'Kindly make sure you fill the required fields', 'warning');
    }
    else{
           var formData = new FormData();

      var fileSelect = document.getElementById("ticket_image");
      if(fileSelect.files && fileSelect.files.length == 1){
         var file = fileSelect.files[0]
         formData.set("ticket_image", file , file.name);
       }

      formData.append("ticket_id", id);
      formData.append("purpose", purpose);
      formData.append("user_id", $("#user_id").val());
      formData.append("ticket_title", $("#ticket_title").val());
      formData.append("ticket_location", $("#ticket_location").val());
      formData.append("ticket_dateStarts", $("#ticket_dateStarts").val());
      formData.append("ticket_timeStarts", $("#ticket_timeStarts").val());
      formData.append("ticket_dateEnds", $("#ticket_dateEnds").val());
      formData.append("ticket_timeEnds", $("#ticket_timeEnds").val());
      formData.append("ticket_description", $("#ticket_description").val());
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

      Pace.restart();
      Pace.track(function(){
          setHeaders();
            jQuery.ajax({
            url: route,
            method: 'post',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            beforeSend: function(){
              $(".spinner").removeClass('disp-0');
            },
            success: function(result){

                if(result.message == 'success' && result.action == 'ticket'){
                    $("#ticket_title").val('');
                    $("#ticket_location").val('');
                    $("#ticket_dateStarts").val('');
                    $("#ticket_timeStarts").val('');
                    $("#ticket_dateEnds").val('');
                    $("#ticket_timeEnds").val('');
                    $("#ticket_description").val('');
                    $("#ticket_free_name").val('');
                    $("#ticket_free_qty").val('');
                    $("#ticket_free_price").val('');
                    $("#ticket_paid_name").val('');
                    $("#ticket_paid_qty").val('');
                    $("#ticket_paid_price").val('');
                    $("#ticket_donate_name").val('');
                    $("#ticket_donate_qty").val('');
                    $("#ticket_donate_price").val('');
                    $("#ticket_image").val('');
                    $(".freeTicket").addClass('disp-0');
                    $(".paidTicket").addClass('disp-0');
                    $(".donateTicket").addClass('disp-0');
                    $(".spinner").addClass('disp-0');
                    swal("Saved!", result.res, result.message);

                    setTimeout(function(){ location.href = result.link; }, 2000);
                }
                else{
                    $(".spinner").addClass('disp-0');
                    swal("Oops!", result.res, result.message);
                }

            }

          });
      });
    }




}


function opennewTicket(val){
    if(val == 'free'){
        $('.freeTicket').removeClass('disp-0');
        return false;
    }
    if(val == 'paid'){
        $('.paidTicket').removeClass('disp-0');
        return false;
    }
    if(val == 'donate'){
        $('.donateTicket').removeClass('disp-0');
        return false;
    }
}

function openModal(val){
    $('#'+val).click();
}

function setupBilling(){

    name = $('#myname').val();
    email = $('#myemail').val();
    var invoice_no = $('#myinvoiceRef').val();
    var service = $('#myservice').val();
    var amount = $('#myamount').val();
    var date = $('#mydate').val();
    var description = $('#mydescription').val();

    if(invoice_no == ""){
        swal('Oops', 'Reference number is missing', 'error');
        return false;
    }
    else if(service == ""){
        swal('Oops', 'Please select a service option', 'error');
        return false;
    }
    else if(amount == ""){
        swal('Oops', 'Please enter amount', 'error');
        return false;
    }
    else if(date == ""){
        swal('Oops', 'Kindly pick date', 'error');
        return false;
    }
    else if(description == ""){
        swal('Oops', 'Please tag bill with a description', 'error');
        return false;
    }
    else{
        route = "{{ URL('Ajax/setupBills') }}";
        thisdata = {
            name: name,
            email: email,
            invoice_no: invoice_no,
            service: service,
            amount: amount,
            date: date,
            description: description
        };
    Pace.restart();
      Pace.track(function(){
          setHeaders();
            jQuery.ajax({
            url: route,
            method: 'post',
            data: thisdata,
            dataType: 'JSON',
            beforeSend: function(){
              $("#saveBill").text('Please wait...');
            },
            success: function(result){

                if(result.message == 'success' && result.info == "good_insert"){
                    $("#myinvoiceRef").val('');
                    $("#myservice").prop('selectedIndex', 0);
                    $("#myamount").val('');
                    $("#mydate").val('');
                    $("#mydescription").val('');

                    $("#saveBill").text('Save');
                    $("#close_setup").click();
                    swal(result.title, result.res, result.message);
                }
                else if(result.message == 'warning' && result.info == "exist"){
                    $("#saveBill").text('Save');
                    // Make a suggestion
                        swal({
                        title: result.title,
                        text: result.res,
                        icon: result.message,
                        buttons: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            route = "{{ URL('Ajax/checkmyBills') }}";
                            thisdata = {invoice_no: invoice_no};

                            Pace.restart();
                            Pace.track(function(){
                                    setHeaders();
                                    jQuery.ajax({
                                    url: route,
                                    method: 'post',
                                    data: thisdata,
                                    dataType: 'JSON',
                                    beforeSend: function(){
                                        swal('Please wait...');
                                    },
                                    success: function(result){

                                        if(result.message == "success"){
                                            // Take to view invoice
                                            $("#close_setup").click();
                                            setTimeout(function(){ window.open(result.link, '_blank'); }, 2000);
                                        }
                                        else{
                                            swal(result.title, result.res, result.message);
                                        }


                                    }

                                });
                            });

                        }
                        });

                }
                else{
                    $("#saveBill").text('Save');
                    swal(result.title, result.res, result.message);
                }

            }

          });
      });
    }


}


function getStatement(){
    $('tbody#statementRec').html('');
    if($('#invoiceService').val() == ""){
        swal('Oops', 'Please select a service', 'error');
        return false;
    }
    else if($('#start_date').val() == ""){
        swal('Oops', 'Please enter start date', 'error');
        return false;
    }
    else if($('#end_date').val() == ""){
        swal('Oops', 'Please enter end date', 'error');
        return false;
    }
    else{
    route = "{{ URL('Ajax/getmystatement') }}";
    thisdata = {start_date: $('#start_date').val(), end_date: $('#end_date').val(), name: $('#invname').val(), email: $('#invemail').val(), service: $('#invoiceService').val()};

        Pace.restart();
        Pace.track(function(){
                setHeaders();
                jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function(){
                    $('#invoice_check').text('Please wait...');
                },
                success: function(result){

                    if(result.message == "success" && result.info == "mystatement"){
                        var res = JSON.parse(result.data);
                        var status = result.status;

                        var invoices = "";
                        var payments = "";
                        var invoice;
                        var payment;

                        var today = new Date();
                        // var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

                        var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();


                        if(res[0].error == "No statement record"){
                            $('tbody#statementRec').append("<tr><td colspan='6' align='center'>"+res[0].error+"</td></tr>");
                        }
                        else{

                            $('#invoice_check').text('Submit');

                            var total = 0;
                            var statement;
                            var statements;


                            $.each(res, function(v,k){

                                var transform;
                                var price;
                                var calctotal;
                                var payaction;
                                var urlRoute;

                                if(k.action == "Payment"){
                                    transform = 'red';
                                    price = "-"+k.debit;
                                    urlRoute = "/Myreceipt";


                                }
                                else{
                                    transform = 'green';
                                    price = k.credit;
                                    urlRoute = "/Myinvoice";

                                }


                                var calctotal = parseFloat(k.credit) - parseFloat(k.debit);


                                var today = new Date(k.trans_date);
                                    today = new Date(today.getTime() - 3000000);
                                    var date_format_str = (today.getDate().toString().length==2?today.getDate().toString():"0"+today.getDate().toString())+"/"+((today.getMonth()+1).toString().length==2?(today.getMonth()+1).toString():"0"+(today.getMonth()+1).toString())+"/"+today.getFullYear().toString()+" "+(today.getHours().toString().length==2?today.getHours().toString():"0"+today.getHours().toString())+":"+((parseInt(today.getMinutes()/5)*5).toString().length==2?(parseInt(today.getMinutes()/5)*5).toString():"0"+(parseInt(today.getMinutes()/5)*5).toString())+":00";

                                    statement = "<tr><td style='font-weight:bold; font-size: 11px;'>"+date_format_str+"</td><td>"+k.activity+"</td><td>"+k.reference_code+"</td><td><span style='color:"+transform+"; font-weight:bold;'>"+price+"</span></td><td>"+k.balance+"</td><td><a type='button' class='btn btn-default' href='"+urlRoute+"/"+k.reference_code+"' target='_blank' style='border:1px solid grey'>View Payment Receipt</a></td></tr>";



                                    statements += statement;

                                    total += calctotal;


                            });

                            var today = new Date();
                            today = new Date(today.getTime() - 3000000);
                            var date_format_str = (today.getDate().toString().length==2?today.getDate().toString():"0"+today.getDate().toString())+"/"+((today.getMonth()+1).toString().length==2?(today.getMonth()+1).toString():"0"+(today.getMonth()+1).toString())+"/"+today.getFullYear().toString();

                            $('tbody#statementRec').append(statements+"<tr><td colspan='3' align='right' style='font-size: 14px; font-weight: bold;'>Total as of "+date_format_str+"</td><td style='font-size: 14px; font-weight: bold;'>"+total.toFixed(2)+"</td><td colspan='3'></td></tr>");


                        }



                    }
                    else{
                        $('#invoice_check').text('Submit');
                        swal(result.title, result.res, result.message);
                    }


                }

            });
        });


    }
}


function contactUs(){
    var route = "{{ URL('Ajax/contactus') }}";
    var name = $('#name').val();
    var email = $('#email').val();
    var subject = $('#subject').val();
    var website = $('#website').val();
    var message = $('#message').val();

    if(name == ""){
        swal('Oops!', 'Please provide your fullname', 'info');
        return false;
    }
    else if(email == ""){
        swal('Oops!', 'Please provide a valid email address', 'info');
        return false;
    }
    else if(message == ""){
        swal('Oops!', 'Please write us a message', 'info');
        return false;
    }
    else{
        var thisdata = {
            name: name,
            email: email,
            subject: subject,
            website: website,
            message: message
        };


            Pace.restart();
            Pace.track(function(){
                    setHeaders();
                    jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: thisdata,
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#name').val('');
                        $('#email').val('');
                        $('#subject').val('');
                        $('#website').val('');
                        $('#message').val('');
                    },
                    success: function(result){

                        if(result.message == "success"){
                            swal('Great!', result.res, result.message);
                        }
                        else{
                            swal('Oops!', result.res, result.message);
                        }
                    }

                });
            });

    }
}

function getInvoice(){
    if($('#invoiceService').val() == ""){
        swal('Oops', 'Please select a service', 'error');
        return false;
    }
    else if($('#invoiceReference').val() == ""){
        swal('Oops', 'Please enter your reference number', 'error');
        return false;
    }
    else{
    route = "{{ URL('Ajax/getmyInvoice') }}";
    thisdata = {invoice_no: $('#invoiceReference').val(), name: $('#invname').val(), email: $('#invemail').val(), service: $('#invoiceService').val()};

        Pace.restart();
        Pace.track(function(){
                setHeaders();
                jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function(){
                    $('#invoice_check').text('Please wait...');
                },
                success: function(result){

                    if(result.message == "success" && result.info == "service_correct"){
                        // Take to view invoice
                        $('#invoice_check').text('Submit');
                        swal(result.title, result.res, result.message);
                        setTimeout(function(){ window.open(result.link, '_blank'); }, 2000);
                    }
                    else if(result.message == "warning" && result.info == "service_no"){
                        // Take to view invoice
                        $('#invoice_check').text('Submit');
                        swal(result.title, result.res, result.message);

                        // Ask Question
                        swal({
                        title: result.title,
                        text: result.res,
                        icon: result.message,
                        buttons: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            setTimeout(function(){ window.open(result.link, '_blank'); }, 2000);
                        }
                        });


                    }
                    else if(result.message == "warning" && result.info == "user_no"){
                        // Take to view invoice
                        $('#invoice_check').text('Submit');
                        swal(result.title, result.res, result.message);

                        // Ask Question
                        swal({
                        title: result.title,
                        text: result.res,
                        icon: result.message,
                        buttons: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            setTimeout(function(){ window.open(result.link, '_blank'); }, 2000);
                        }
                        });

                    }
                    else{
                        $('#invoice_check').text('Submit');
                        swal(result.title, result.res, result.message);
                    }


                }

            });
        });


    }

}

function makePay(){
    var sumVal = 0;
    var rem_bal;
    if($('#invoiceNumber').val() == ""){
        swal('Oops!', 'Please type your reference number');
        return false;
    }
    else{


        location.href = location.origin+"/payment/"+$('#invoiceNumber').val();

        // route = "{{ URL('Ajax/getPayment') }}";
        // thisdata = {invoice_no: $('#invoiceNumber').val(), email: $('#payemail').val()};

        //     Pace.restart();
        //     Pace.track(function(){
        //             setHeaders();
        //             jQuery.ajax({
        //             url: route,
        //             method: 'post',
        //             data: thisdata,
        //             dataType: 'JSON',
        //             beforeSend: function(){
        //                 $('#pay_invoice').text('Please wait...');
        //                 $('#payinvoiceRef').val('');
        //                 $('#payservice').val('');
        //                 $('#payamount').val('');
        //                 $('#payinvamount').val('');
        //                 $('#paybalance').val('');
        //             },
        //             success: function(result){

        //                 if(result.message == "success"){
        //                     $('#pay_invoice').text('Submit');
        //                     var res = JSON.parse(result.data);
        //                     swal({
        //                         title: result.title,
        //                         text: result.res,
        //                         icon: result.message,
        //                         buttons: "Continue",
        //                         })
        //                         .then((willDelete) => {
        //                         if (willDelete) {


        //                             if(res[0].remaining_balance != null){
        //                                 rem = parseInt(res[0].remaining_balance);
        //                             }
        //                             else{
        //                                 rem = "0";
        //                             }

        //                             if(res[0].installpay == "No"){
        //                                 $('.instPay').addClass('disp-0');
        //                             }

        //                             else if(res[0].installpay == "Yes" && res[0].installlimit == res[0].installcount){
        //                                 $('.instPay').addClass('disp-0');
        //                                 $('#inf_alert').html("<div class='alert alert-danger'>You can not pay installmentally as you have exceeded the limit</div>");
        //                             }
        //                             else if(res[0].installpay == null && res[0].installlimit == 0){
        //                                 $('.instPay').addClass('disp-0');
        //                             }
        //                             else if(res[0].installpay == "Yes" && res[0].installlimit > 0){
        //                                 $('.instPay').removeClass('disp-0');
        //                             }



        //                             var bal;
        //                             var calcbal = parseInt(res[0].amount) - parseInt(res[0].amount_paid);

        //                             if(calcbal > 0){
        //                                 bal = calcbal;
        //                             }
        //                             else{
        //                                 bal = 0;
        //                             }

        //                             sumVal = parseInt(res[0].amount) + bal;


        //                             // Auto load info
        //                             $('#payname').val(res[0].name);
        //                             $('#payemail').val(res[0].payee_email);
        //                             $('#payuser_id').val(res[0].uploaded_by);
        //                             $('#payinvoiceRef').val(res[0].invoice_no);
        //                             $('#payservice').val(res[0].service);
        //                             $('#payamount').val(sumVal);
        //                             $('#payinvamount').val(res[0].amount);
        //                             $('#paybalance').val(bal);
        //                             // Pop up
        //                             $('#pay_for_invoice').click();
        //                             // setTimeout(function(){ location.href = result.link; }, 1000);
        //                         }
        //                     });
        //                 }
        //                 else{
        //                     $('#pay_invoice').text('Submit');
        //                     swal(result.title, result.res, result.message);
        //                 }


        //             }

        //         });
        //     });
    }


}

// Admin Invoice Payment
function makePays(invoice_no){
    var sumVal = 0;
    var rem_bal;
    if($('#invoiceNumber').val() == ""){
        swal('Oops!', 'Please type your reference number');
        return false;
    }
    else{

        location.href = location.origin+"/payment/"+invoice_no;

        // route = "{{ URL('Ajax/getPayment') }}";
        // thisdata = {invoice_no: invoice_no, email: $('#payemail').val()};

        //     Pace.restart();
        //     Pace.track(function(){
        //             setHeaders();
        //             jQuery.ajax({
        //             url: route,
        //             method: 'post',
        //             data: thisdata,
        //             dataType: 'JSON',
        //             beforeSend: function(){
        //                 $('#pay_invoice').text('Please wait...');
        //                 $('#payinvoiceRef').val('');
        //                 $('#payservice').val('');
        //                 $('#payamount').val('');
        //                 $('#payinvamount').val('');
        //                 $('#paybalance').val('');
        //             },
        //             success: function(result){

        //                 if(result.message == "success"){
        //                     $('#pay_invoice').text('Submit');
        //                     var res = JSON.parse(result.data);
        //                     swal({
        //                         title: result.title,
        //                         text: result.res,
        //                         icon: result.message,
        //                         buttons: "Continue",
        //                         })
        //                         .then((willDelete) => {
        //                         if (willDelete) {


        //                             if(res[0].remaining_balance != null){
        //                                 rem = parseInt(res[0].remaining_balance);
        //                             }
        //                             else{
        //                                 rem = "0";
        //                             }

        //                             if(res[0].installpay == "No"){
        //                                 $('.instPay').addClass('disp-0');
        //                             }

        //                             else if(res[0].installpay == "Yes" && res[0].installlimit == res[0].installcount){
        //                                 $('.instPay').addClass('disp-0');
        //                                 $('#inf_alert').html("<div class='alert alert-danger'>You can not pay installmentally as you have exceeded the limit</div>");
        //                             }
        //                             else if(res[0].installpay == null && res[0].installlimit == 0){
        //                                 $('.instPay').addClass('disp-0');
        //                             }
        //                             else if(res[0].installpay == "Yes" && res[0].installlimit > 0){
        //                                 $('.instPay').removeClass('disp-0');
        //                             }



        //                             var bal;
        //                             var calcbal = parseInt(res[0].amount) - parseInt(res[0].amount_paid);

        //                             if(calcbal > 0){
        //                                 bal = calcbal;
        //                             }
        //                             else{
        //                                 bal = 0;
        //                             }

        //                             sumVal = parseInt(res[0].amount) + bal;


        //                             // Auto load info
        //                             $('#payname').val(res[0].name);
        //                             $('#payemail').val(res[0].payee_email);
        //                             $('#payuser_id').val(res[0].uploaded_by);
        //                             $('#payinvoiceRef').val(res[0].invoice_no);
        //                             $('#payservice').val(res[0].service);
        //                             $('#payamount').val(sumVal);
        //                             $('#payinvamount').val(res[0].amount);
        //                             $('#paybalance').val(bal);
        //                             // Pop up
        //                             $('#pay_for_invoice').click();
        //                             // setTimeout(function(){ location.href = result.link; }, 1000);
        //                         }
        //                     });
        //                 }
        //                 else{
        //                     $('#pay_invoice').text('Submit');
        //                     swal(result.title, result.res, result.message);
        //                 }


        //             }

        //         });
        //     });
    }


}

$('#installmental').change(function(){
    if($('#installmental').val() == "Yes"){
        $('.typeamount').removeClass('disp-0');
        $('#typepayamount').val('');
    }
    else if($('#installmental').val() == "No"){
        $('.typeamount').addClass('disp-0');
        $('#typepayamount').val(0);
    }
});


function checkDetail(val){

    $('tbody#recorgRec').html("");


    if(val == 'rec'){
        if($('#recorgInfo').val() == ""){
        $('tbody#recorgRec').html("");
        swal("Oops!", "Enter receivers code", "info");
    }
    else{
    route = "{{ URL('Ajax/getOrganization') }}";
    thisdata = {user_id: $('#recorgInfo').val(), code: $('#reccountryCode').val(), action: val};

        Pace.restart();
        Pace.track(function(){
                setHeaders();
                jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function(){
                    $('tbody#recorgRec').html("<tr><td colspan='7' align='center'>Please wait...</td></tr>");
                },
                success: function(result){

                    if(result.message == "success"){
                        var datainfo = "";
                        var datarec;
                        var res = JSON.parse(result.data);

                        $.each(res, function(v, k){
                           var datarec = "<tr><td>"+k.name+"</td><td>"+k.address+"</td><td>"+k.city+"</td><td>"+k.state+"</td><td>"+k.country+"</td><td>"+k.amount_to_send+"</td><td><button class='btn btn-primary' onclick=receiveMoney('"+k.orgId+"')>Receive Money</button></td></tr>";

                           datainfo += datarec;
                        });

                        

                        $('tbody#recorgRec').html(datainfo);
                    }
                    else{
                        $('tbody#recorgRec').html("<tr><td colspan='7' align='center'>"+result.res+"</td></tr>");
                    }


                }

            });
        });
    }
    }
    else{

        if($('#orgInfo').val() == ""){
        $('tbody#orgRec').html("");
        swal("Oops!", "Enter receivers code", "info");
    }
    else{
    route = "{{ URL('Ajax/getOrganization') }}";
    thisdata = {user_id: $('#orgInfo').val(), code: $('#countryCode').val(), action: val};

        Pace.restart();
        Pace.track(function(){
                setHeaders();
                jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function(){
                    $('tbody#orgRec').html("<tr><td colspan='7' align='center'>Please wait...</td></tr>");
                },
                success: function(result){

                    if(result.message == "success"){
                        var res = JSON.parse(result.data);
                        // Result
                        // $('tbody#orgRec').html("<tr><td>"+res[0].business_name+"</td><td>"+res[0].address+"</td><td>"+res[0].corporate_type+"</td><td>"+res[0].city+"</td><td>"+res[0].state+"</td><td>"+res[0].country+"</td><td><button class='btn btn-primary' onclick=payOrg('"+res[0].user_id+"')>Send Money</button></td></tr>");

                        $('tbody#orgRec').html("<tr><td>"+res.name+"</td><td>"+res.address+"</td><td>"+res.corporationType+"</td><td>"+res.city+"</td><td>"+res.state+"</td><td>"+res.country+"</td><td><button class='btn btn-primary' onclick=payOrg('"+res.ref_code+"')>Send Money</button></td></tr>");
                    }
                    else{
                        $('tbody#orgRec').html("<tr><td colspan='7' align='center'>"+result.res+"</td></tr>");
                        // swal(result.title, result.res, result.message);
                    }


                }

            });
        });
    }
    }

}

$('#orgInfo').change(function(){
    $('tbody#orgRec').html("");
    if($('#orgInfo').val() == ""){
        $('tbody#orgRec').html("");
    }
    else{
    route = "{{ URL('Ajax/getOrganization') }}";
    thisdata = {user_id: $('#orgInfo').val(), code: $('#countryCode').val()};

        Pace.restart();
        Pace.track(function(){
                setHeaders();
                jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function(){
                    $('tbody#orgRec').html("<tr><td colspan='7' align='center'>Please wait...</td></tr>");
                },
                success: function(result){

                    if(result.message == "success"){
                        var res = JSON.parse(result.data);
                        // Result
                        // $('tbody#orgRec').html("<tr><td>"+res[0].business_name+"</td><td>"+res[0].address+"</td><td>"+res[0].corporate_type+"</td><td>"+res[0].city+"</td><td>"+res[0].state+"</td><td>"+res[0].country+"</td><td><button class='btn btn-primary' onclick=payOrg('"+res[0].user_id+"')>Send Money</button></td></tr>");

                        $('tbody#orgRec').html("<tr><td>"+res.name+"</td><td>"+res.address+"</td><td>"+res.corporationType+"</td><td>"+res.city+"</td><td>"+res.state+"</td><td>"+res.country+"</td><td><button class='btn btn-primary' onclick=payOrg('"+res.ref_code+"')>Send Money</button></td></tr>");
                    }
                    else{
                        $('tbody#orgRec').html("<tr><td colspan='7' align='center'>"+result.res+"</td></tr>");
                        // swal(result.title, result.res, result.message);
                    }


                }

            });
        });
    }
});





function getBronchure(val){
    openModal('bronchure_download');
}

function downloadBronchure(){
    var name = $('#d_name').val();
    var email = $('#d_email').val();
    var route = "{{ URL('Ajax/getBronchure') }}";
    var thisdata;

    if(name == ""){
        swal('Oops!', 'Please provide full name', 'error');
        return false;
    }
    else if(email == ""){
        swal('Oops!', 'Please provide a valid email address', 'error');
        return false;
    }
    else{
        thisdata = {
            name: name,
            email: email
        };

        Pace.restart();
        Pace.track(function(){
                setHeaders();
                jQuery.ajax({
                url: route,
                method: 'post',
                data: thisdata,
                dataType: 'JSON',
                beforeSend: function(){
                    $('#getBronch').text("Processing...");
                },
                success: function(result){
                    $('#getBronch').text("Download Bronchure");

                    if(result.message == "success"){
                        $('#d_name').val('');
                        $('#d_email').val('');
                        $('#close_bronchure').click();
                        swal(result.title, result.res, result.message);
                        // Load download link
                        setTimeout(function(){ window.open(location.origin+"/bronchure/PAYca_Brochure.pdf", "_blank"); }, 1000);
                    }
                    else{
                        swal(result.title, result.res, result.message);
                    }


                }

            });
        });
    }

}


function payOrg(user_id){
    // Click Modal
    // $('#pay_for_organization').click();
    // $('#orgpayuser_id').val(user_id);

    // Take to payment route
    location.href = location.origin+"/payment/sendmoney/"+user_id;
}

function receiveMoney(user_id){
    location.href = location.origin+"/payment/receivemoney/"+user_id;
}

$('#orgpayservice').change(function(){
    if($('#orgpayservice').val() == "Others"){
        $('.others').removeClass('disp-0');
    }
    else{
        $('.others').addClass('disp-0');
    }
});

// Moneris Payment
function orgmonerisPay(){
    name = $('#orgpayname').val();
    email = $('#orgpayemail').val();
    var user_id = $('#orgpayuser_id').val();
    var service = $('#orgpayservice').val();
    var purpose = $('#orgpaypurpose').val();
    var amount = $('#orgpayamount').val();
    var month = $('#orgmonth').val();
    var year = $('#orgpayyear').val();
    var payment_method = $('#payment_method').val();
    var creditcard_no = $('#orgpaycreditcard').val();

    if(service == ""){
        swal('Oops!', 'Please select payment purpose', 'info');
        return false;
    }
    else if(amount == ""){
        swal('Oops!', 'Please enter amount', 'info');
        return false;
    }
    else if(month == ""){
        swal('Oops!', 'Please select month', 'info');
        return false;
    }

    else if(payment_method == ""){
        swal('Oops!', 'Please select payment method', 'info');
        return false;
    }
    else if(creditcard_no == ""){
        swal('Oops!', 'Please insert card number', 'info');
        return false;
    }

    else if(creditcard_no.length != 16){
        swal('Oops!', 'Invalid card number', 'info');
        return false;
    }
    else if(year == ""){
        swal('Oops!', 'Please select year', 'info');
        return false;
    }
    else{
            route = "{{ URL('Ajax/orgPaymentInvoice') }}";
            thisdata = {
                name: name,
                email: email,
                user_id: user_id,
                service: service,
                purpose: purpose,
                amount: amount,
                creditcard_no: creditcard_no,
                expirydate: year,
                month: month,
            };

            Pace.restart();
            Pace.track(function(){
                    setHeaders();
                    jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: thisdata,
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#orgpayBill').text('Please wait...');
                    },
                    success: function(result){

                        if(result.message == "success"){
                            $('#orgpayBill').text('Proceed to Pay');
                            swal(result.title, result.res, result.message);
                            setTimeout(function(){ location.reload(); }, 3000);
                        }
                        else{
                            $('#orgpayBill').text('Proceed to Pay');
                            swal(result.title, result.res, result.message);
                        }


                    }

                });
            });
    }


}


// Moneris Payment
function monerisPay(){
    name = $('#payname').val();
    email = $('#payemail').val();
    var user_id = $('#payuser_id').val();
    var invoice_no = $('#payinvoiceRef').val();
    var service = $('#payservice').val();
    var amount = $('#payamount').val();
    var month = $('#paymonth').val();
    var year = $('#payyear').val();
    var paycreditcard = $('#paycreditcard').val();
    var typepayamount = $('#typepayamount').val();
    var payment_method = $('#make_payment_method').val();

    if(typepayamount > amount){
        swal('Oops!', 'Please check your amount value, as this input value is higher', 'info');
        return false;
    }
    else if(paycreditcard.length != 16){
        swal('Oops!', 'Invalid card number', 'error');
        return false;
    }
    else if(payment_method == ""){
        swal('Oops!', '"Please select payment method"', 'error');
        return false;
    }
    else if(paycreditcard == ""){
        swal('Oops!', '"Please enter card number"', 'error');
        return false;
    }
    else{
            route = "{{ URL('Ajax/PaymentInvoice') }}";
            thisdata = {
                name: name,
                email: email,
                user_id: user_id,
                invoice_no: invoice_no,
                service: service,
                amount: amount,
                typepayamount: typepayamount,
                creditcard_no: paycreditcard,
                payment_method: payment_method,
                month: month,
                expirydate: year,
            };

            Pace.restart();
            Pace.track(function(){
                    setHeaders();
                    jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: thisdata,
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#payBill').text('Please wait...');
                    },
                    success: function(result){

                        if(result.message == "success"){
                            $('#payBill').text('Proceed to Pay');
                            swal(result.title, result.res, result.message);
                            setTimeout(function(){ location.reload(); }, 3000);
                        }
                        else{
                            $('#payBill').text('Proceed to Pay');
                            swal(result.title, result.res, result.message);
                        }


                    }

                });
            });
    }


}


$('#problem_in_unit').change(function(){

    if($('#problem_in_unit').val() == "Yes"){
        $('.if_yes').removeClass('disp-0');
        $('.if_no').addClass('disp-0');
    }
    else if($('#problem_in_unit').val() == "No"){
        $('.if_no').removeClass('disp-0');
        $('.if_yes').addClass('disp-0');
    }
    else{
        $('.if_no').addClass('disp-0');
        $('.if_yes').addClass('disp-0');
    }
});




function create_request(){

    var route = "{{ URL('Ajax/createMaintenance') }}";
    var formData = new FormData();

      var name = $('#ten_name').val();
      var email = $('#ten_email').val();
      var property_owner = $('#property_owner').val();
      var phone_number = $('#phone_number').val();
      var problem_in_unit = $('#problem_in_unit').val();
      var describe_event = $('#describe_event').val();
      var subject = $('#subject').val();
      var details = $('#details').val();
      var additional_info = $('#additional_info').val();
      var priority = $('#priority').val();


       if(property_owner == ""){
            swal("Oops", "Please select the property owner", "error");
            return false;
       }
       else if(phone_number == ""){
            swal("Oops", "Please type in your phone number", "error");
            return false;
       }
       else if(problem_in_unit == ""){
            swal("Oops", "Please select an option for the problem in unit field", "error");
            return false;
       }
       else if(subject == ""){
            swal("Oops", "Please insert the subject for this maintenance request", "error");
            return false;
       }
       else if(details == ""){
            swal("Oops", "Please provide details to this maintenance request", "error");
            return false;
       }
       else{

              var fileSelect = document.getElementById("add_file");
              if(fileSelect.files && fileSelect.files.length > 0){
                for (var i = 0; i < fileSelect.files.length; i++) {
                    var file = fileSelect.files[i];

                     formData.set("add_file", file);

                }

               }


               formData.append("name", name);
               formData.append("email", email);
               formData.append("property_owner", property_owner);
               formData.append("phone_number", phone_number);
               formData.append("problem_in_unit", problem_in_unit);
               formData.append("describe_event", describe_event);
               formData.append("subject", subject);
               formData.append("details", details);
               formData.append("additional_info", additional_info);
               formData.append("priority", priority);



             Pace.restart();
              Pace.track(function(){
                  setHeaders();
                    jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function(){
                      $(".spinner").removeClass('disp-0');
                    },
                    success: function(result){
                        if(result.message == "success"){
                            swal(result.title, result.res, result.message);
                            setTimeout(function(){ location.reload(); }, 3000);
                        }
                        else{
                            swal(result.title, result.res, result.message);
                        }
                    }

                  });
              });

       }



}


$('#perform_action').change(function() {
    var val = $('#perform_action').val();
    if(val == "open"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/maintenance/status?s=open"; }, 3000);
    }
    else if(val == "submitted"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/maintenance/status?s=submitted"; }, 3000);
    }
    else if(val == "tenant_main"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement"; }, 3000);
    }
    else if(val == "admin_menu"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin"; }, 3000);
    }
    else if(val == "consultant_menu"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/consultant"; }, 3000);
    }
    else if(val == "create"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/maintenance"; }, 3000);
    }
    else if(val == "progress"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/maintenance/status?s=progress"; }, 3000);
    }
    else if(val == "close"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/maintenance/status?s=closed"; }, 3000);
    }
    else if(val == "cancel"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/maintenance/status?s=cancelled"; }, 3000);
    }
    else if(val == "request_submitted"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/maintenance?s=submitted"; }, 3000);
    }
    else if(val == "request_opened"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/maintenance?s=open"; }, 3000);
    }
    else if(val == "request_cancelled"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/maintenance?s=cancelled"; }, 3000);
    }
    else if(val == "request_closed"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/maintenance?s=closed"; }, 3000);
    }
    else if(val == "request_completed"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/maintenance?s=complete"; }, 3000);
    }
    else if(val == "create_building"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/facility"; }, 3000);
    }

    else if(val == "create_staff"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/consultant"; }, 3000);
    }
    else if(val == "view_building"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/viewfacility"; }, 3000);
    }
    else if(val == "view_staff"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/viewconsultant"; }, 3000);
    }
    else if(val == "view_quotes"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/viewquotes"; }, 3000);
    }
    else if(val == "view_invoices"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/admin/viewinvoices"; }, 3000);
    }
    else if(val == "workorder_received"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/consultant/workorder?s=received"; }, 3000);
    }
    else if(val == "workorder_completed"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.href = location.origin+"/rentalmanagement/consultant/workorder?s=complete"; }, 3000);
    }
    else if(val == "workorder_generate"){
        swal('Redirecting!', 'You will be redirected in 3secs', 'info');
        setTimeout(function(){ location.reload(); }, 3000);
    }
    else{
        swal('Oops!', 'You did not select an option', 'info');
    }
});


function makeDel(val){
    swal({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover request",
    icon: "warning",
    buttons: true,
    dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
        $('#'+val).submit();
    } else {

    }
    });
}


function decision(action, id){
    var route = "{{ URL('Ajax/quotedecision') }}";
    var spinner = $('.'+action+'_'+id);
    var formData = new FormData();

    formData.append("action", action);
    formData.append("maintenance_id", id);


    swal({
    title: "Are you sure?",
    text: "Proceed to "+action,
    icon: "warning",
    buttons: true,
    dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
        // Run Ajax
            Pace.restart();
              Pace.track(function(){
                  setHeaders();
                    jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function(){
                      spinner.removeClass('disp-0');
                    },
                    success: function(result){
                        spinner.addClass('disp-0');
                        if(result.message == "success"){
                            swal(result.title, result.res, result.message);
                            setTimeout(function(){ location.reload(); }, 3000);
                        }
                        else{
                            swal(result.title, result.res, result.message);
                        }
                    }

                  });
              });
    }
    else {
        console.log('Closed request');
    }
    });

}



function decisionmaker(action, id){
    var route = "{{ URL('Ajax/quotedecisionmaker') }}";
    var spinner = $('.'+action+'_'+id);
    var formData = new FormData();

    formData.append("action", action);
    formData.append("maintenance_id", id);


    swal({
    title: "Are you sure?",
    text: "Proceed to "+action,
    icon: "warning",
    buttons: true,
    dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
        // Run Ajax
            Pace.restart();
              Pace.track(function(){
                  setHeaders();
                    jQuery.ajax({
                    url: route,
                    method: 'post',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    beforeSend: function(){
                      spinner.removeClass('disp-0');
                    },
                    success: function(result){
                        spinner.addClass('disp-0');
                        if(result.message == "success"){
                            swal(result.title, result.res, result.message);
                            setTimeout(function(){ location.reload(); }, 3000);
                        }
                        else{
                            swal(result.title, result.res, result.message);
                        }
                    }

                  });
              });
    }
    else {
        console.log('Closed request');
    }
    });

}


function goBack() {
  window.history.back();
}

$('#type_of_service').change(function(){
    if($('#type_of_service').val() == "Others"){
        $('.if_Others').removeClass('disp-0');
    }
    else{
        $('.if_Others').addClass('disp-0');
    }
});

$('#installment').change(function(){
    if($('#installment').val() == "Yes"){
        $('#installment_limit').removeAttr('disabled');
    }
    else{
        $('#installment_limit').attr('disabled', 'disabled');
    }
});


$('#invoice_generate').change(function(){
    if($('#invoice_generate').val() == "Manual"){
        $('#invoice_number').removeAttr('readonly');
    }
    else{
        var gen_inv = "{{ 'PAYca_'.date('Ymds') }}";
        $('#invoice_number').attr('readonly', true);
        $('#invoice_number').val(gen_inv);
    }
});

$('#recurring_service').change(function(){
    if($('#recurring_service').val() != "One Time"){
        $('#reminder_service').removeAttr('disabled');
    }
    else{
        $('#reminder_service').attr('disabled', 'disabled');
    }
});


$('#property_owner').on('change', function(){
    if($('#property_owner').val() != ""){
        var route = "{{ URL('Ajax/getFacility') }}";

        var formData = new FormData();
        formData.append("user_id", $('#property_owner').val());

        // run ajax
        Pace.restart();
        Pace.track(function(){
            setHeaders();
            jQuery.ajax({
            url: route,
            method: 'post',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            beforeSend: function(){
                $('#property_facility').html(`<option>Please wait...</option>`);
            },
            success: function(result){
                $('#property_facility').html('');
                if(result.message == "success"){
                    // Show result
                    var res = JSON.parse(result.data);

                    $('#property_facility').html(`<option value="">Select Building/Facility</option>`);
                    $.each(res, function(v, k){
                        $('#property_facility').append(`<option value="${k.id}">${k.buildinglocation_street_number+' '+k.buildinglocation_street_name+', '+k.buildinglocation_city+' '+k.buildinglocation_zipcode+', '+k.buildinglocation_state+' '+k.buildinglocation_country}</option>`);

                    });

                }
                else{
                    // Show result
                    $('#property_facility').append(`<option value="">No record</option>`);
                }
            }

            });
        });
    }
});


$('#property_facility').on('keydown keyup change', function(){
    if($('#property_facility').val() != ""){
        var route = "{{ URL('Ajax/getbuildingaddress') }}";

        var formData = new FormData();
        formData.append("id", $('#property_facility').val());

        // run ajax
        Pace.restart();
        Pace.track(function(){
            setHeaders();
            jQuery.ajax({
            url: route,
            method: 'post',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            beforeSend: function(){
                $('#unit_id').val('');
            },
            success: function(result){
                if(result.message == "success"){
                    // Show result
                    var res = JSON.parse(result.data);

                    $('#unit_id').val(res[0].buildinglocation_street_number+' '+res[0].buildinglocation_street_name+', '+res[0].buildinglocation_city+' '+res[0].buildinglocation_zipcode+', '+res[0].buildinglocation_state+' '+res[0].buildinglocation_country);

                }
                else{
                    // Show result
                    $('#unit_id').val('');
                }
            }

            });
        });
    }
});


    //Set CSRF HEADERS
 function setHeaders(){
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': "{{csrf_token()}}"
      }
    });
 }


 function comingSoon(){
     swal('Hey', 'This feature is coming soon', 'info');
 }





</script>




</body>
</html>
