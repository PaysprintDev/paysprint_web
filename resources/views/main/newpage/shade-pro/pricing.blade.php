

    @extends('layouts.newpage.app')

@section('content')
    <!-- navbar- -->
    <div class="inner-banner pt-29 pt-lg-30 pb-9 pb-lg-12 bg-default-6">
      <div class="container">
        <div class="row  justify-content-center pt-5">
          <div class="col-xl-8 col-lg-9">
            <div class="px-md-15 text-center">
              <h2 class="title gr-text-2 mb-8 mb-lg-10">{{ $pages }}</h2>
              {{-- <p class="gr-text-7 mb-0 mb-lg-13">Full Time, Remote</p> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="main-block pb-6 pb-lg-17 bg-default-6">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-10 col-lg-10">
            <div class="single-block mb-12 mb-lg-15 table-responsive">
                
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Last Updated | {{ date('d/m/Y') }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Definition of Keywords</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Add Money</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Activities involving adding money to your PS Account from Credit cards, Debit VISA/Mastercard debit or Bank Accounts</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Send Money</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Including activities involving Sending money to Families, Friends and Associates from PS Wallet</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Pay Invoice</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Paying invoice generated and sent by a PS merchant</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Request for Refund to Wallet</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Asking for refund of money sent to a PS user and non-PS user when the receiver is unable to access the funds</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Withdrawal</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">PS user or merchant request for funds to be deposited from PS wallet to prescribed Credit Cards, Debit VISA or Mastercard Debit or Bank Account</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local Currency</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Local Currency is the currency of the country where the user resides</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local Transfer</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Local transfer is the transfer of funds between users in the same country and in same currency</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">International Transfer</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">International Transfer is the transfer of funds between users living in separate countries and with different currencies</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Text/Email to Transfer</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Text/Email to Transfer is a unique method of sending money to families, friends and associates that are not PS users</p></td>
                        </tr>
                    </tbody>
                </table>

                <hr>

                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td><p class="gr-text-6 font-weight-bold mb-9">1.0 Personal/Business</p></td>
                            <td><p class="gr-text-6 font-weight-bold mb-9">Fixed</p></td>
                            <td><p class="gr-text-6 font-weight-bold mb-9">Variable</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Add Money To Wallet</p></td>
                            <td><p class="gr-text-9 mb-0">$1.80</p></td>
                            <td><p class="gr-text-9 mb-0">1.30%</p></td>
                        </tr>
                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Send Money: (Both PS User & Non-PS User)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">No Fee</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International (for Currency Conversion)</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">2% Currency Conversion</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Receive Money: (Both PS User & Non-PS User)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">No Fee</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">2% Currency Conversion</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Pay Invoice (Both PS User & Non-PS User)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">No Fee</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">2% Currency Conversion</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Request for Refund to Wallet</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">No Fee</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">2% Currency Conversion</p></td>
                        </tr>

                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Request for Withdrawal</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Prepaid Card</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">No Fee</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Credit Card</p></td>
                            <td><p class="gr-text-9 mb-0">$1.80</p></td>
                            <td><p class="gr-text-9 mb-0">1.30%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Bank Account</p></td>
                            <td><p class="gr-text-9 mb-0">No Fee</p></td>
                            <td><p class="gr-text-9 mb-0">No Fee/p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Debit VISA/Mastercard</p></td>
                            <td><p class="gr-text-9 mb-0">No Fee</p></td>
                            <td><p class="gr-text-9 mb-0">No Fee/p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Monthly Maintenance Fee</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$5.00</p></td>
                        </tr>

                        <tr>
                            <td><p class="gr-text-9 mb-0">Minimum Wallet Balance</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$5.00</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">WITHDRAWAL LIMITS</p></td>
                        </tr>

                        <tr>
                            <td><p class="gr-text-9 mb-0">FREQUENCY</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">MAXIMUM (Up to)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Transaction</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$500.00</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Day</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$2,500.00</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Week</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$2,500.00</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Month</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$4,000.00</p></td>
                        </tr>
                        
                    </tbody>
                </table>

                <hr>

                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td><p class="gr-text-6 font-weight-bold mb-9">2.0 Merchant (including Charity)</p></td>
                            <td><p class="gr-text-6 font-weight-bold mb-9">Fixed</p></td>
                            <td><p class="gr-text-6 font-weight-bold mb-9">Variable</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Add Money To Wallet</p></td>
                            <td><p class="gr-text-9 mb-0">$1.80</p></td>
                            <td><p class="gr-text-9 mb-0">1.30%</p></td>
                        </tr>
                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Send Money: (Both PS User & Non-PS User)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">No Fee</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International (for Currency Conversion)</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">2% Currency Conversion</p></td>
                        </tr>

                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Accept Payments from PS Users</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">No Fee</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">2% Currency Conversion</p></td>
                        </tr>


                        


                        

                        

                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Accept Payments from Non-PS Users</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Prepaid Card</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Subject to Card Issuer</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Credit Card</p></td>
                            <td><p class="gr-text-9 mb-0">$1.80</p></td>
                            <td><p class="gr-text-9 mb-0">1.30%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Bank Account</p></td>
                            <td><p class="gr-text-9 mb-0">$1.80</p></td>
                            <td><p class="gr-text-9 mb-0">1.30%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">To Debit VISA/Mastercard</p></td>
                            <td><p class="gr-text-9 mb-0">$1.80</p></td>
                            <td><p class="gr-text-9 mb-0">1.30%</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Request for Refund to Wallet</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-Local</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">No Fee</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Local-to-International</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">No Fee</p></td>
                        </tr>

                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">Request for Withdrawal</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Into Prepaid Card</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">Subject to Card Issuer</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Into Credit Card</p></td>
                            <td><p class="gr-text-9 mb-0">$1.80</p></td>
                            <td><p class="gr-text-9 mb-0">1.30%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Into Bank Account</p></td>
                            <td><p class="gr-text-9 mb-0">$1.80</p></td>
                            <td><p class="gr-text-9 mb-0">1.30%</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Into Debit VISA/Mastercard</p></td>
                            <td><p class="gr-text-9 mb-0">$1.80</p></td>
                            <td><p class="gr-text-9 mb-0">1.30%</p></td>
                        </tr>


                        <tr>
                            <td><p class="gr-text-9 mb-0">Monthly Maintenance Fee</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$5.00</p></td>
                        </tr>
                        
                        
                        <tr>
                            <td><p class="gr-text-9 mb-0">Minimum Wallet Balance</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$5.00</p></td>
                        </tr>


                        <tr>
                            <td colspan="3"><p class="gr-text-6 font-weight-bold mb-9">WITHDRAWAL LIMITS</p></td>
                        </tr>

                        <tr>
                            <td><p class="gr-text-9 mb-0">FREQUENCY</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">MAXIMUM (Up to)</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Transaction</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$1,000.00</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Day</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$5,000.00</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Week</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$5,000.00</p></td>
                        </tr>
                        <tr>
                            <td><p class="gr-text-9 mb-0">Per Month</p></td>
                            <td colspan="2"><p class="gr-text-9 mb-0">$20,000.00</p></td>
                        </tr>
                        
                    </tbody>
                </table>

            </div>
           
            
            
          </div>
        </div>
      </div>
    </div>
  @endsection
