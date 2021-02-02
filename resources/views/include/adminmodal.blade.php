{{-- Create Ticke Modal --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" id="create_event" data-toggle="modal" data-target="#exampleModalCenter">
  Create event
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Create Event</h5>

      </div>
      <div class="modal-body">
                <!-- /.box-header -->
        <div class="box-body">

          <div class="row">
            <h4>1. Event Detail</h4> <hr>
            <div class="col-md-12">
              <div class="form-group has-success">
                  <label class="control-label" for="event_title"><i class="fa fa-file"></i> Event title <span>*</span></label>
                  <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ session('user_id') }}">
                  <input type="text" class="form-control" id="event_title" name="event_title" placeholder="Give it a short distinct name">
                </div>
            </div>

            <div class="col-md-12">
              <div class="form-group has-success">
                  <label class="control-label" for="event_location"><i class="fa fa-globe"></i> Location <span>*</span></label>
                  <select class="form-control select2" id="event_location" name="event_location" data-placeholder="Search for Location" style="width: 100%;">
                    <option value="Alberta">Alberta</option>
                    <option value="British Columbia">British Columbia</option>
                    <option value="Manitoba">Manitoba</option>
                    <option value="New Brunswick">New Brunswick</option>
                    <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                    <option value="Nova Scotia">Nova Scotia</option>
                    <option value="Ontario">Ontario</option>
                    <option value="Prince Edward Island">Prince Edward Island</option>
                    <option value="Quebec">Quebec</option>
                    <option value="Saskatchewan">Saskatchewan</option>
                    <option value="Northwest Territories">Northwest Territories</option>
                    <option value="Nunavut">Nunavut</option>
                    <option value="Yukon">Yukon</option>
                </select>
                </div>
            </div>

            <div class="col-md-6">
              <div class="form-group has-success">
                <label>Starts:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker_start" name="datepicker_start">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

            </div>

            <div class="col-md-6">
               <!-- time Picker -->
              <div class="bootstrap-timepicker">
                <div class="form-group has-success">
                  <label>&nbsp;</label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="ticket_timeStarts" id="ticket_timeStarts">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>
            </div>

              <div class="col-md-6">
              <div class="form-group has-success">
                <label>Ends:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker_end" name="datepicker_end">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->

            </div>

            <div class="col-md-6">
               <!-- time Picker -->
              <div class="bootstrap-timepicker">
                <div class="form-group has-success">
                  <label>&nbsp;</label>

                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="ticket_timeEnds" id="ticket_timeEnds">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group has-success">
                  <label for="event_file">Upload Image</label>
                  <input type="file" id="event_file" name="event_file" class="form-control">

                  <small class="help-block text-primary" style="color: darkblue;">We recommend uploading image that's no larger than 10MB.</small>
                </div>
            </div>


            <div class="col-md-12">
              <div class="form-group has-success">
                  <label for="event_description">Event Description</label>
                  {{-- <textarea name="event_description" id="event_description" cols="30" rows="10" class="form-control"></textarea> --}}
                  <div class="box-body pad">
                    <form>
                          <textarea id="event_description" name="event_description" class="form-control"></textarea>
                    </form>
                  </div>
              </div>
            </div>

            <h4>2. Create Tickets</h4> <hr>

                           <div class="col-md-12">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ticket name <span style="color: tomato;">*</span></th>
                                            <th>Quantity available <span style="color: tomato;">*</span></th>
                                            <th>Price</th>
                                            <th align="center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr class="freeTicket disp-0">
                                            <td>
                                                <input type="text" name="ticket_free_name" id="ticket_free_name" class="form-control" placeholder="RSVP">
                                            </td>
                                            <td>
                                                <input title="Enter the total number of tickets available for this ticket type" type="text" name="ticket_free_qty" id="ticket_free_qty" class="form-control" placeholder="100">
                                            </td>
                                            <td>
                                                <input type="hidden" name="ticket_free_price" id="ticket_free_price" value="Free">
                                                FREE
                                            </td>
                                            <td align="center">
                                                <hr style="margin-top: -10px;">
                                                <a type="button" id="savefreeTicket" style="cursor: pointer;"><i class="fa fa-save" style="font-size: 20px; color: #7181bf;"></i></a>
                                                <a type="button" style="cursor: pointer;" onclick="$('.launchModal').click()"><i title="cancel" class="fa fa-trash" style="font-size: 20px; color: #d8533b;"></i></a>
                                            </td>
                                        </tr>

                                        <tr class="paidTicket disp-0">
                                            <td>
                                                <input type="text" name="ticket_paid_name" id="ticket_paid_name" class="form-control" placeholder="RSVP">
                                            </td>
                                            <td>
                                                <input title="Enter the total number of tickets available for this ticket type" type="text" name="ticket_paid_qty" id="ticket_paid_qty" class="form-control" placeholder="100">
                                            </td>
                                            <td>
                                                <input title="Set your ticket price" class="form-control" placeholder="15.00" name="ticket_paid_price" id="ticket_paid_price">
                                            </td>
                                            <td align="center">
                                                <hr style="margin-top: -10px;">
                                                <a type="button" id="savepaidTicket" style="cursor: pointer;"><i class="fa fa-save" style="font-size: 20px; color: #7181bf;"></i></a>
                                                <a type="button" style="cursor: pointer;" onclick="$('.launchModal').click()"><i title="cancel" class="fa fa-trash" style="font-size: 20px; color: #d8533b;"></i></a>
                                            </td>
                                        </tr>

                                        <tr class="donateTicket disp-0">
                                            <td>
                                                <input type="text" name="ticket_donate_name" id="ticket_donate_name" class="form-control" placeholder="RSVP">
                                            </td>
                                            <td>
                                                <input title="Enter the total number of tickets available for this ticket type" type="text" name="ticket_donate_qty" id="ticket_donate_qty" class="form-control" placeholder="100">
                                            </td>
                                            <td>
                                                <input title="Set your ticket price" class="form-control" placeholder="15.00" name="ticket_donate_price" id="ticket_donate_price">
                                            </td>
                                            <td align="center">
                                                <hr style="margin-top: -10px;">
                                                <a type="button" id="savedonateTicket" style="cursor: pointer;"><i class="fa fa-save" style="font-size: 20px; color: #7181bf;"></i></a>
                                                <a type="button" style="cursor: pointer;" onclick="$('.launchModal').click()"><i title="cancel" class="fa fa-trash" style="font-size: 20px; color: #d8533b;"></i></a>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                              <center>
                                <p>What type of ticket would you like to start with?</p>
                               <p>
                                   <button type="button" class="btn btn-success" onclick="opennewTicket('free')"><i class="fa fa-plus-circle"></i> Free Ticket</button>
                                   <button type="button" class="btn btn-success" onclick="opennewTicket('paid')"><i class="fa fa-plus-circle"></i> Paid Ticket</button>
                                   <button type="button" class="btn btn-success" onclick="opennewTicket('donate')"><i class="fa fa-plus-circle"></i> Donation</button>
                               </p>
                           </center>
                           </div>


          </div>
          <!-- /.row -->
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="creatEvent('{{ uniqid().'_'.time() }}', 'ticket')">Save</button>
        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
      </div>

    </div>
  </div>
</div>



{{-- End Create Ticket Modal --}}



{{-- Start Single Invoice --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" id="singleDoc1" data-toggle="modal" data-target="#exampleSingledocs1">
  Create single event
</button>

<!-- Modal -->
<div class="modal fade" id="exampleSingledocs1" tabindex="-1" role="dialog" aria-labelledby="exampleSingledocs1Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_single_step1">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Create Invoice</h5>

      </div>
        <div class="modal-body">
            <h1>STEP 1:</h1>
                    <!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_firstname">Name</label>
                            <input type="hidden" id="single_user_id" name="single_user_id" class="form-control" value="{{ session('user_id') }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="single_firstname" id="single_firstname" class="form-control" placeholder="Firstname">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="single_lastname" id="single_lastname" class="form-control" placeholder="Lastname">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_email">Email</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="single_email" id="single_email" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_service">Type of Service</label>
                            <select name="single_service" class="form-control" id="single_service">
                                <option value="Rent">Rent</option>
                                <option value="Property Tax">Property Tax</option>
                                <option value="Utility Bills">Utility Bills</option>
                                <option value="Traffic Ticket">Traffic Ticket</option>
                                <option value="Tax Bills">Tax Bills</option>
                                <option value="Others"> Others</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row disp-0 specific">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_service_specify">Specify Service Type</label>
                            <input type="text" name="single_service_specify" id="single_service_specify" class="form-control">
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_service">Accept Installmental Payment</label>
                            <select name="single_installpay" class="form-control" id="single_installpay">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row instlim disp-0">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_service">Kindly Set Installmental Limt</label>
                            <select name="single_installlimit" class="form-control" id="single_installlimit">
                                <option value="0">Select limit</option>
                                  @for($i=1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                  @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_service">Generate Invoice Number</label>
                            <select name="single_invoice_generate" class="form-control" id="single_invoice_generate">
                                <option value="">Select Option</option>
                                <option value="Manual">Manual</option>
                                <option value="Auto Generate">Auto Generate</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_invoiceno">Invoice Number</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="single_invoiceno" id="single_invoiceno" class="form-control" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /.row -->
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="creatEvent('{{ "PaySprint_".date("Ymds") }}', 'single1_upload')">Next</button>
        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
      </div>

    </div>
  </div>
</div>

{{-- End Single Invoice --}}

{{-- Start Single2 Invoice --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" id="singleDoc2" data-toggle="modal" data-target="#exampleSingledocs2">
  Create single event
</button>

<!-- Modal -->
<div class="modal fade" id="exampleSingledocs2" tabindex="-1" role="dialog" aria-labelledby="exampleSingledocs2Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_single_step2">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Create Invoice</h5>

      </div>
        <div class="modal-body">
            <h1>STEP 2:</h1>
                    <!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_payee_ref_no">Reference Number </label>
                            <input type="hidden" name="single2_invoiceno" id="single2_invoiceno" class="form-control" value="">
                            <input type="hidden" id="single2_user_id" name="single2_user_id" class="form-control" value="{{ session('user_id') }}">
                            <input type="hidden" id="single2_payee_email" name="single2_payee_email" class="form-control" value="">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="single_payee_ref_no" id="single_payee_ref_no" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_transaction_ref">Transaction Ref.</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="single_transaction_ref" id="single_transaction_ref" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_transaction_date">Transaction Date</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="date" name="single_transaction_date" id="single_transaction_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_description">Description</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box-body pad">
                                        <form>
                                            <textarea id="single_description" name="single_description" class="form-control"></textarea>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /.row -->
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="creatEvent('{{ "PaySprint_".date("Ymds") }}', 'single2_upload')">Next</button>
        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
      </div>

    </div>
  </div>
</div>

{{-- End Single2 Invoice --}}


{{-- Start Single3 Invoice --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" id="singleDoc3" data-toggle="modal" data-target="#exampleSingledocs3">
  Create single event
</button>

<!-- Modal -->
<div class="modal fade" id="exampleSingledocs3" tabindex="-1" role="dialog" aria-labelledby="exampleSingledocs3Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_single_step3">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Create Invoice</h5>

      </div>
        <div class="modal-body">
            <h1>STEP 3:</h1>
                    <!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_amount">Amount </label>
                            <input type="hidden" name="single3_invoiceno" id="single3_invoiceno" class="form-control" value="">
                            <input type="hidden" id="single3_user_id" name="single3_user_id" class="form-control" value="{{ session('user_id') }}">
                            <input type="hidden" id="single3_payee_email" name="single3_payee_email" class="form-control" value="">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="number" name="single_amount" id="single_amount" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_payment_due_date">Payment Due Date</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="date" name="single_payment_due_date" id="single_payment_due_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="service">Recurring</label>
                            <select name="single_recurring_service" class="form-control" id="single_recurring_service">
                                <option value="">Select Option</option>
                                <option value="One Time">One Time</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Bi-Monthly">Bi-Monthly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quaterly">Quaterly</option>
                                <option value="Half Yearly"> Half Yearly</option>
                                <option value="Yearly"> Yearly</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row recuring_time disp-0">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="service">Reminder</label>
                            <select name="single_reminder_service" class="form-control" id="single_reminder_service">
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }} Day(s)</option>
                                @endfor

                            </select>
                        </div>
                    </div>
                </div>
            <!-- /.row -->
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="creatEvent('{{ "PaySprint_".date("Ymds") }}', 'single3_upload')">Save & Submit</button>
        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
      </div>

    </div>
  </div>
</div>

{{-- End Single3 Invoice --}}




{{-- Start Upload Doc --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" id="uploadDoc" data-toggle="modal" data-target="#exampleUploaddocs">
  Create event
</button>

<!-- Modal -->
<div class="modal fade" id="exampleUploaddocs" tabindex="-1" role="dialog" aria-labelledby="exampleUploaddocsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_step1">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Upload Invoice</h5>

      </div>
        <div class="modal-body">
            <h1>STEP 1:</h1>
                    <!-- /.box-header -->
            <div class="box-body">
              <div class="alert alert-danger responseMessage disp-0"></div>
            <div class="row">
                <div class="col-md-12">
                    <p style="color: red; font-weight:bold; text-transform:uppercase">Click on Image to download and view sample</p>
                    <a href="{{ asset('downloadsample/testsample.xlsx') }}" target="_blank" download=""><img src="{{ asset('images/testformat.png') }}" alt="" style="width: 100%"/></a>
                </div>
            </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="service">Type of Service</label>
                            <input type="hidden" id="user_id" name="user_id" class="form-control" value="{{ session('user_id') }}">
                            <select name="service" class="form-control" id="service">
                                <option value="Rent">Rent</option>
                                <option value="Property Tax">Property Tax</option>
                                <option value="Utility Bills">Utility Bills</option>
                                <option value="Traffic Ticket">Traffic Ticket</option>
                                <option value="Tax Bills">Tax Bills</option>
                                <option value="Others"> Others</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="service">Accept Installmental Payment</label>
                            <select name="installpay" class="form-control" id="installpay">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row instlim disp-0">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="single_service">Kindly Set Installmental Limt</label>
                            <select name="installlimit" class="form-control" id="installlimit">
                                <option value="0">Select limit</option>
                                  @for($i=1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                  @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="event_file">Upload File</label>
                            <input type="file" id="excel_file" name="excel_file" class="form-control">

                            <small class="help-block text-primary" style="color: darkblue;">We recommend uploading xls or xlsx format.</small>
                        </div>
                        </div>
                    </div>
                </form>
            <!-- /.row -->
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="creatEvent('{{ "PaySprint_".date("Ymds") }}', 'uploadExcel')">Next</button>
        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
      </div>

    </div>
  </div>
</div>

{{-- End Upload Doc --}}



{{-- Start Statement  --}}






<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" id="checkstatement" data-toggle="modal" data-target="#examplestatements">
  Create event
</button>

<!-- Modal -->
<div class="modal fade" id="examplestatements" tabindex="-1" role="dialog" aria-labelledby="examplestatementsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_step1">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Check Statements</h5>

      </div>
        <div class="modal-body">
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="statement_service">Type of Service</label>
                            <select name="statement_service" class="form-control" id="statement_service">
                                <option value="Rent">Rent</option>
                                <option value="Property Tax">Property Tax</option>
                                <option value="Utility Bills">Utility Bills</option>
                                <option value="Traffic Ticket">Traffic Ticket</option>
                                <option value="Tax Bills">Tax Bills</option>
                                <option value="Others"> Others</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-success">
                            <label for="statement_start">Start Date</label>
                            <input type="date" name="statement_start" id="statement_start" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-success">
                            <label for="statement_end">End Date</label>
                            <input type="date" name="statement_end" id="statement_end" class="form-control">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="checkStatement()">Get Statement</button>
        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
      </div>

    </div>
  </div>
</div>



{{-- End Statement  --}}


{{-- Start Upload Doc Stage 2 --}}

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" id="uploadDoc2" data-toggle="modal" data-target="#exampleUploaddocs2">
  Create event
</button>

<!-- Modal -->
<div class="modal fade" id="exampleUploaddocs2" tabindex="-1" role="dialog" aria-labelledby="exampleUploaddocs2Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_step2">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Set Reminder and Recurring</h5>

      </div>
        <div class="modal-body">
            <h1>STEP 2:</h1>
            <hr>
                    <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="service">Recurring</label>
                            <input type="hidden" id="recur_user_id" name="recur_user_id" class="form-control" value="{{ session('user_id') }}">
                            <select name="recurring_service" class="form-control" id="recurring_service">
                                <option value="One Time">One Time</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Bi-Monthly">Bi-Monthly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quaterly">Quaterly</option>
                                <option value="Half Yearly"> Half Yearly</option>
                                <option value="Yearly"> Yearly</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row recuring_time_2 disp-0">
                    <div class="col-md-12">
                        <div class="form-group has-success">
                            <label for="service">Reminder</label>
                            <select name="reminder_service" class="form-control" id="reminder_service">
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }} Day(s)</option>
                                @endfor

                            </select>
                        </div>
                    </div>
                </div>
                <br>

                </form>
            <!-- /.row -->
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="creatEvent('{{ date('Ymdhis').''.mt_rand(1000, 9999) }}', 'setRecur')">Save & Submit</button>
        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
      </div>

    </div>
  </div>
</div>

{{-- End Upload Doc Stage 2 --}}


{{-- Select Payment Method Start --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" id="paymethod" data-toggle="modal" data-target="#payMethodmodal">
  Create event
</button>

<!-- Modal -->
<div class="modal fade" id="payMethodmodal" tabindex="-1" role="dialog" aria-labelledby="payMethodmodalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_step2">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Select Payment Method</h5>

      </div>
        <div class="modal-body">
           
            <div class="box-body table table-responsive">
                <table class="table table-striped table-bordered">
                  <tbody>
                      
                      <tr>
                        <td colspan="2">
                          <input type="hidden" name="my_id" id="my_id" value="">
                          <input type="hidden" name="amountWithdraw" id="amountWithdraw" value="">
                          <select class="form-control" id="card_method">
                            <option value="">Select Payment Method</option>
                            <option value="Prepaid card">Prepaid card</option>
                            <option value="Debit card">Debit card</option>
                            <option value="eTransfer">eTransfer</option>
                        </select></td>
                      </tr>
                  </tbody>
                </table>
                
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="makePayment()">Withdraw</button>
        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
      </div>

    </div>
  </div>
</div>


{{-- Select Payment Method End --}}


{{-- View Details START --}}

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" data-toggle="modal" data-target="#remittancePostsCenter" id="view_remittance">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="remittancePostsCenter" tabindex="-1" role="dialog" aria-labelledby="remittancePostsCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="remittancePostsLongTitle">View Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="print_statement">
          <h4 id="clientfullname" style="font-weight: bold;"></h4>
          <div class="row">
            <div class="col-md-6">
              <h5 id="period_start" style="font-weight: bold;"></h5>
            </div>
            <div class="col-md-6">
              <h5 id="period_end" style="font-weight: bold;"></h5>
            </div>
          </div>
          <div class="table table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Payee Name</th>
                  <th>Payee Ref.</th>
                  <th>Service Paid For</th>
                  <th>Invoice #</th>
                  <th>Invoice Amount</th>
                  <th>Amount Paid</th>
                  <th>Tranx ID.</th>
                  <th>Date Paid</th>
                </tr>
              </thead>

                <tbody id="remittancedetails"></tbody>
                
            </table>

            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Total Amount</th>
                  <th>Less Collection Fee</th>
                  <th>Net Remittance</th>
                </tr>
              </thead>
              
                <tbody id="remittancecalcdetails"></tbody>
                
            </table>
          </div>
            
      </div>
      <div class="modal-footer activation">
          <center><button class="btn btn-danger btn-block" onclick="PrintDiv2('print_statement')">Print</button></center>
      </div>
    </div>
  </div>
</div>


{{-- View Details END--}}


@if(session('role') == "Super")

{{-- Create Transaction Fee Start --}}


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary disp-0" id="transactioncost" data-toggle="modal" data-target="#transactionsetmodal">
  Create event
</button>

<!-- Modal -->
<div class="modal fade" id="transactionsetmodal" tabindex="-1" role="dialog" aria-labelledby="transactionsetmodalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close_trans">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="exampleModalLongTitle">Set Transaction Cost</h5>

      </div>
        <div class="modal-body">
           
            <div class="box-body">
              
              <div class="row">
                <div class="col-md-12">
                  @if(count($transCost) > 0)

            <h5 style="color: green; font-weight: bold;">Variable: {{ $transCost[0]->variable }}%</h5>
            <h5 style="color: navy; font-weight: bold;">Fixed: ${{ number_format($transCost[0]->fixed, 2) }}</h5>

            @else

            <h5 style="color: green; font-weight: bold;">Variable: 0%</h5>
            <h5 style="color: navy; font-weight: bold;">Fixed: ${{ number_format(0, 2) }}</h5>

           @endif
           <hr>
                  <div class="col-md-6">
                    <label>Variable</label>
                    <input type="number" name="variable" id="variable" class="form-control" placeholder="2.9%">
                  </div>
                  <div class="col-md-6">
                    <label>Fixed</label>
                    <input type="number" name="fixed" id="fixed" class="form-control" placeholder="0.3">
                  </div>
                </div>
              </div>                
            </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="setTrans()" id="trans_btn">Update</button>
        <img src="https://cdn.dribbble.com/users/608059/screenshots/2032455/spinner.gif" class="spinner disp-0" style="width: auto; height: 50px;">
      </div>

    </div>
  </div>
</div>



{{-- Create Transaction Fee End --}}

@endif
