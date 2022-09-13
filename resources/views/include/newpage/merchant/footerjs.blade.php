  </div>
  <!-- Vendor Scripts -->
  <script src="{{ asset('newpage/js/vendor.min.js') }}"></script>
  <!-- Plugin's Scripts -->
  <script src="{{ asset('newpage/plugins/fancybox/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('newpage/plugins/nice-select/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('newpage/plugins/aos/aos.min.js') }}"></script>
  <script src="{{ asset('newpage/plugins/slick/slick.min.js') }}"></script>
  <script src="{{ asset('newpage/plugins/date-picker/js/gijgo.min.js') }}"></script>
  <script src="{{ asset('newpage/plugins/counter-up/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('newpage/plugins/counter-up/jquery.counterup.min.js') }}"></script>
  <script src="{{ asset('newpage/plugins/theme-mode-switcher/gr-theme-mode-switcher.js') }}"></script>
  <!-- Activation Script -->
  <script src="{{ asset('newpage/js/custom.js') }}"></script>

  <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
  <script>



      $('.tab-menu li a').on('click', function(){
		   	var target = $(this).attr('data-rel');
			$('.tab-menu li a').removeClass('active');
		   	$(this).addClass('active');
		   	$("#"+target).fadeIn('slow').siblings(".tab-box").hide();
		   	return false;
  });


  $('#amount').keyup(function (){
    $('.currencyResult').addClass('disp-0');
   
    $('.currencyShow');
  });


  function convertFee() {
    
    
    const amount= $('#amount').val();
   const sending= $('#sendingcountry').val();
   // alert(sending)
   const receiving= $('#receivingcountry').val();

     const data = {
       amount, sending, receiving
     }

     $('#shift').text('Loading...');

     $.ajax({
       
       url: "/api/v1/conversionrate/"+ sending + '/' + receiving,
       method:'GET' ,
     
       success: function (rsp){
        $('.currencyResult').removeClass('disp-0');
        

         const data = rsp;
         const total = data * amount;
         const convertrate = 1 / data
        $('#result').text(total);
       
        $('#round').text(data);

        var sender = 1 +' ' + sending + ' '+'=' +''+ parseFloat(data).toFixed(4)+ ' '+ receiving;
        
        $('#rate').text(sender);


        var exchange = 1 + ' ' + receiving + '=' + convertrate.toFixed(4)+ ' ' + sending
       
        $('#local').text(exchange)
        var price = amount + ' ' +  sending+ ''+'=' +''+total.toFixed(4) + ' ' + receiving;
        $('#totalprice').text(price);
       
        $('#shift').text('Convert');
      

       }
     });
   
 }

 $('#paying').keyup(function (){
    
    $('.currencyDisplay').addClass('disp-0');
    $('.currencyShow');
  });

  function rateFee() {
    
   
    const pay= $('#paying').val();
    //  alert(pay)
   const local= $('#localcountry').val();
   
   const foreign= $('#foreigncountry').val();

     const data = {
       pay,local,foreign
     }
     $('#shift2').text('Loading...');

     $.ajax({
       
       url: "/api/v1/conversionrate/"+ local + "/" + foreign,
       method:'GET' ,
     
       success: function (rsp){

        $('.currencyDisplay').removeClass('disp-0');
       
         const total = rsp;
         
         const total_divide = total * pay;

         
       
         const payer = 1 / total;
        //  alert(payer)
        // $('#result').text(total);
        $('#resultrate').text(total_divide);
        // $('#round').text(total);
        var sender = 1 + ' '+ local + ''+'=' +''+ parseFloat(total).toFixed(4) + foreign;
        $('#rates').text(sender);

        var exchange = 1 + ' ' + foreign + '' + '=' +payer.toFixed(4) + ' ' + local 
        $('#locals').text(exchange)
        
        var pricetotal = pay +' '+local+ '' + '=' + '' +total_divide.toFixed(4) + ' ' + foreign;
        $('#totalpricerate').text(pricetotal);

        
        $('#shift2').text('Convert');
       }
     });
   
 }

  $('#receive_money').click(function(){
      $('#receive_money').show();
      $('#send_money').hide();
  })
  
 
 



  </script>
  
</body>


<!-- Mirrored from uxtheme.net/demos/shade-pro/light/agency.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 30 Dec 2020 17:11:16 GMT -->
</html>