{{-- START SETUP E-BILLING --}}

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" data-toggle="modal" data-target="#exampleModalCenter" id="setup_ebilling">
  Launch demo Setup Billing
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" id="close_setup" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">SET-UP BILLING</h5>

      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label>Fullname</label><br>
                    <input type="text" class="form-control" name="myname" id="myname" value="{{ $name }}" readonly disabled>
                </div>
                <div class="col-md-6">
                    <label>Email Address</label><br>
                    <input type="email" class="form-control" name="myemail" id="myemail" value="{{ $email }}" readonly disabled>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Invoice Reference Number</label><br>
                    <input type="text" class="form-control" name="myinvoiceRef" id="myinvoiceRef" placeholder="172349***">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Select Service</label><br>
                    <select name="myservice" id="myservice" class="form-control">
                        <option value="">Select a service</option>
                        <option value="Property Tax">Property Tax</option>
                        <option value="Utility Bills">Utility Bills</option>
                        <option value="Traffic Tickets">Traffic Tickets</option>
                        <option value="Tax Bills">Tax Bills</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label>Amount</label><br>
                    <input type="number" name="myamount" id="myamount" class="form-control" placeholder="500">
                </div>
                <div class="col-md-6">
                    <label>Due Date</label><br>
                    <input type="date" name="mydate" id="mydate" class="form-control">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Description</label><br>
                    <textarea name="mydescription" id="mydescription" cols="30" rows="10" class="form-control"></textarea>
                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="setupBilling()" id="saveBill">Save</button>
      </div>
    </div>
  </div>
</div>

{{-- END SETUP E-BILLING --}}


{{-- Make Payment --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" data-toggle="modal" data-target="#exampleMonerisPay" id="pay_for_invoice">
  Launch demo Make Payment
</button>

<!-- Modal -->
<div class="modal fade" id="exampleMonerisPay" tabindex="-1" role="dialog" aria-labelledby="exampleMonerisPayTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" id="close_setup" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Make Payment</h5>

      </div>
      <div class="modal-body">
            <div class="row disp-0">
                <div class="col-md-6">
                    <label>Fullname</label><br>
                    <input type="text" class="form-control" name="payname" id="payname" readonly disabled>
                </div>
                <div class="col-md-6">
                    <label>Email Address</label><br>
                    <input type="text" class="form-control" name="payemail" id="payemail" readonly disabled>
                    <input type="hidden" class="form-control" name="payuser_id" id="payuser_id" readonly disabled>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Invoice Reference Number</label><br>
                    <input type="text" class="form-control" name="payinvoiceRef" id="payinvoiceRef" readonly disabled>
                </div>
            </div>
            <br>
            <div class="row disp-0">
                <div class="col-md-12">
                    <label>Type of Service</label><br>
                    {{-- <select name="payservice" class="form-control billinginput_box" id="payservice">
                        <option value="">--Select Service--</option>
                        <option value="Property Tax">Property Tax</option>
                        <option value="Utility Bills">Utility Bills</option>
                        <option value="Traffic Ticket">Traffic Ticket</option>
                        <option value="Tax Bills">Tax Bills</option>
                        <option value="Others"> Others</option>
                    </select> --}}
                    <input type="text" name="payservice" id="payservice" class="form-control" readonly disabled>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Invoice Amount</label><br>
                    <input type="hidden" name="payamount" id="payamount" class="form-control" readonly disabled>
                    <input type="number" name="payinvamount" id="payinvamount" class="form-control" readonly disabled>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Balance</label><br>
                    <input type="number" name="paybalance" id="paybalance" class="form-control" readonly disabled>
                </div>
            </div>
            <br>
            <div class="row instPay disp-0">
                <div class="col-md-12">
                    <label>Would you like to pay installmentally?</label><br>
                    <select name="installmental" class="form-control billinginput_box" id="installmental">
                        <option value="">--Select Option--</option>
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>
            </div>
            <div id="inf_alert"></div>
            <br>
            <div class="row typeamount disp-0">
                <div class="col-md-12">
                    <label>Type Amount</label><br>
                    <input type="number" name="typepayamount" id="typepayamount" class="form-control">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Payment Method</label><br>
                    <select name="make_payment_method" class="form-control billinginput_box" id="make_payment_method">
                        <option value="">Select payment method</option>
                        <option value="Creditcard">Credit Card</option>
                        <option value="Debitcard">Debit Card</option>
                        <option value="Exbccard">EXBC Card</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Card Number</label><br>
                    <input type="number" name="paycreditcard" id="paycreditcard" class="form-control" placeholder="4242****">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label>Expiry Month</label><br>
                    <select class="form-control" name="paymonth" id="paymonth">
                        <?php $today = 1; $count = 13;?>
                        @for ($i = $today; $i < $count; $i++)

                        <option value="{{ $i }}">@if($i < 10) {{ "0".$i }}  @else {{ $i }} @endif</option>

                        @endfor
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Expiry Year</label><br>
                    <select name="payyear" id="payyear" class="form-control">
                        <?php $today = 20; $count = 30;?>
                        @for ($i = $today; $i < $count; $i++)

                            <option value="{{ $i }}">{{ $i }}</option>

                        @endfor
                    </select>
                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="monerisPay()" id="payBill">Proceed to Pay</button>
      </div>
    </div>
  </div>
</div>

{{-- End Make Payment --}}





{{-- Make Organization Payment --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" data-toggle="modal" data-target="#exampleorgMonerisPay" id="pay_for_organization">
  Launch demo Make Organization Payment
</button>

<!-- Modal -->
<div class="modal fade" id="exampleorgMonerisPay" tabindex="-1" role="dialog" aria-labelledby="exampleorgMonerisPayTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" id="close_setup" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Send Money</h5>

      </div>
      <div class="modal-body">
            <div class="row disp-0">
                <div class="col-md-6">
                    <label>Fullname</label><br>
                    <input type="text" class="form-control" name="orgpayname" id="orgpayname" value="{{ $name }}" readonly disabled>
                </div>
                <div class="col-md-6">
                    <label>Email Address</label><br>
                    <input type="text" class="form-control" name="orgpayemail" id="orgpayemail" value="{{ $email }}" readonly disabled>
                    <input type="hidden" class="form-control" name="orgpayuser_id" id="orgpayuser_id" value="" readonly disabled>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-12">
                    <label>Purpose of Payment</label><br>
                    <select name="orgpayservice" class="form-control billinginput_box" id="orgpayservice">
                        <option value="">Select Option</option>
                        <option value="Offering">Offering</option>
                        <option value="Tithe">Tithe</option>
                        <option value="Seed">Seed</option>
                        <option value="Contribution">Contribution</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row others disp-0">
                <div class="col-md-12">
                    <label>Specify Purpose</label><br>
                    <input type="text" name="orgpaypurpose" id="orgpaypurpose" class="form-control">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Payment Method</label><br>
                    <select name="payment_method" class="form-control billinginput_box" id="payment_method">
                        <option value="">Select payment method</option>
                        <option value="Debitcard">Debit Card</option>
                        <option value="Creditcard">Credit Card</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Amount</label><br>
                    <input type="number" name="orgpayamount" id="orgpayamount" class="form-control">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Card Number</label><br>
                    <input type="number" name="orgpaycreditcard" id="orgpaycreditcard" class="form-control" placeholder="4242****">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label>Expiry Month</label><br>
                    <select class="form-control" name="orgmonth" id="orgmonth">
                        <?php $today = 1; $count = 13;?>
                        @for ($i = $today; $i < $count; $i++)

                        <option value="{{ $i }}">@if($i < 10) {{ "0".$i }}  @else {{ $i }} @endif</option>

                        @endfor
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Expiry Year</label><br>
                    <select name="orgpayyear" id="orgpayyear" class="form-control">
                        <?php $today = 20; $count = 30;?>
                        @for ($i = $today; $i < $count; $i++)

                            <option value="{{ $i }}">{{ $i }}</option>

                        @endfor
                    </select>

                </div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="orgmonerisPay()" id="orgpayBill">Proceed to Pay</button>
      </div>
    </div>
  </div>
</div>

{{-- End Make Organization Payment --}}



{{-- Download Bronchure --}}


{{-- START SETUP E-BILLING --}}

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" data-toggle="modal" data-target="#bronchureDownloadCenter" id="bronchure_download">
  Launch demo download bronchure
</button>

<!-- Modal -->
<div class="modal fade" id="bronchureDownloadCenter" tabindex="-1" role="dialog" aria-labelledby="bronchureDownloadCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" id="close_bronchure" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="bronchureDownloadLongTitle">FILL FORM BELOW TO GET BROCHURE</h5>

      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label>Fullname</label><br>
                    <input type="text" class="form-control" name="d_name" id="d_name" value="">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <label>Email Address</label><br>
                    <input type="email" class="form-control" name="d_email" id="d_email" value="">
                </div>
            </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="downloadBronchure()" id="getBronch">Download Brochure</button>
      </div>
    </div>
  </div>
</div>

{{-- END SETUP E-BILLING --}}


{{-- End DOwnload Bronchure --}}



{{-- Start Question for Maintenance --}}



<button type="button" class="btn btn-primary disp-0" data-toggle="modal" data-target="#accessMaintenanceCenter" id="access_maintenance">
  Launch demo maintenance access
</button>

<!-- Modal -->
<div class="modal fade" id="accessMaintenanceCenter" tabindex="-1" role="dialog" aria-labelledby="accessMaintenanceCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" id="close_bronchure" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="accessMaintenanceLongTitle">MAINTENANCE SERVICE</h5>

      </div>
      <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <h1 style="text-align: center;">How would you like to access rental management service?</h1>
            </div>

        </div>

      </div>
      <div class="modal-footer">
       <center>

       <button type="button" class="btn btn-danger" onclick="location.href='{{ route('rentalmanagement') }}'">TENANT</button>
        <button type="button" class="btn btn-success" onclick="location.href='{{ route('rentalManagementAdmin') }}'">PROPERTY MANAGER/OWNER</button>
        <button type="button" class="btn btn-primary" onclick="location.href='{{ route('rentalManagementConsultant') }}'">SERVICE PROVIDERS</button>

       </center>
      </div>
    </div>
  </div>
</div>



{{-- End Question for Maintenance --}}




{{-- Start Admin Maintnenace Request --}}

<button type="button" class="btn btn-primary disp-0" data-toggle="modal" data-target="#accessMaintenanceCenter" id="admin_maintenance">
  Launch demo maintenance access
</button>

<!-- Modal -->
<div class="modal fade" id="accessMaintenanceCenter" tabindex="-1" role="dialog" aria-labelledby="accessMaintenanceCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" id="close_bronchure" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="accessMaintenanceLongTitle">MAINTENANCE SERVICE</h5>

      </div>
      <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <h1 style="text-align: center;">How would you like to access maintenance service?</h1>
            </div>

        </div>

      </div>
      <div class="modal-footer">
       <center>

       <button type="button" class="btn btn-danger" onclick="location.href='{{ route('maintenance') }}'">TENANT</button>
        <button type="button" class="btn btn-success" onclick="location.href='{{ route('rentalManagementAdmin') }}'">PROPERTY MANAGER/OWNER</button>
        <button type="button" class="btn btn-primary" onclick="location.href='{{ route('rentalManagementConsultant') }}'">SERVICE PROVIDERS</button>

       </center>
      </div>
    </div>
  </div>
</div>



{{-- End Admin Maintnenace Request --}}
