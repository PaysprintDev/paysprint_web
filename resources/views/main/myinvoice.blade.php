<?php use \App\Http\Controllers\ClientInfo; ?>
<?php use \SimpleSoftwareIO\QrCode\Facades\QrCode; ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PaySprint | Print/View Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">

    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        /* font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; */
        font-family: 'Josefin Sans', sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    /* new invoice */
    
.row.shadow {
  background: #fff;
  border-radius: 5px;
}

/*Invoice*/
.invoice .top-left {
  font-size: 65px;
  color: #3ba0ff;
}

div.to,
div.payment-details {
  line-height: 8px;
  font-size: 14px;
}

.text-mute {
  color: #8c959a;
  text-transform: uppercase;
}

.font-weight-bold {
  color: #1c252c;
}

.header_logo img {
  max-height: 200px;
  max-width: 300px;
}

.invoice .top-right {
  text-align: right;
  padding-right: 20px;
}

.invoice .table-row {
  margin-left: -15px;
  margin-right: -15px;
  margin-top: 25px;
}

.invoice .payment-info {
  font-weight: 500;
}

.invoice .table-row .table > thead {
  border-top: 1px solid #ddd;
}

.invoice .table-row .table > thead > tr > th {
  border-bottom: none;
}

.invoice .table > tbody > tr > td {
  padding: 8px 20px;
}

.invoice .invoice-total {
  margin-right: -10px;
  font-size: 16px;
}

.invoice .last-row {
  border-bottom: 1px solid #ddd;
}

.invoice-ribbon {
  width: 85px;
  height: 88px;
  overflow: hidden;
  position: absolute;
  top: -1px;
  right: -1px;
}

.ribbon-inner {
  text-align: center;
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  position: relative;
  padding: 7px 0;
  left: -5px;
  top: 11px;
  width: 120px;
  font-size: 15px;
  color: #fff;
}

.ribbon-inner:before,
.ribbon-inner:after {
  content: "";
  position: absolute;
}

.ribbon-inner:before {
  left: 0;
}

.ribbon-inner:after {
  right: 0;
}

@media (max-width: 575px) {
  .invoice .top-left,
  .invoice .top-right,
  .invoice .payment-details {
    text-align: center;
  }

  .invoice .from,
  .invoice .to,
  .invoice .payment-details {
    float: none;
    width: 100%;
    text-align: center;
    margin-bottom: 25px;
  }

  .invoice p.lead,
  .invoice .from p.lead,
  .invoice .to p.lead,
  .invoice .payment-details p.lead {
    font-size: 22px;
  }

  .invoice .btn {
    margin-top: 10px;
  }
}

@media print {
  .invoice-ribbon {
    position: absolute !important;
  }
  .row.shadow {
    box-shadow: none !important;
  }
  th {
    color: #000;
  }
  .invoice {
    width: 900px;
    height: 800px;
  }
  thead,
  body {
    -webkit-print-color-adjust: exact;
  }
  .buttons {
    display: none;
  }
}
/* End new invoice */

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>

    <br>
    <div class="container invoice-box">
        <center>
            <a type="button" href="{{ route('invoice') }}" class="btn btn-primary btn-block">Go back</a>
        </center>
    </div>

    <br>

    @if(count($invoice) > 0)
    <br>
    <div class="container invoice-box" id="divToPrint">


        @foreach ($invoice as $invoices)

        

        <table class="table table-bordered" cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                @if($clientInfo = \App\ClientInfo::where('user_id', $invoices->uploaded_by)->get())

                                @if(count($clientInfo) > 0)

                                <span style="font-size: 20px;"> {{ $clientInfo[0]->firstname.' '.$clientInfo[0]->lastname }}</span>
                                @endif

                                @endif
                                <br>
                                <span style="font-size: 17px;">Powered By</span><br>
                            <img src="{{ asset('images/logo2.png') }}" style="width:30%; max-width:300px;" align="left">
                            </td>
                            <td align="center">
                                <center>
                                    {!! QrCode::size(150)->generate('INVOICE NUMBER: '.$invoices->paidinvoice_no); !!}
                                </center>

                            </td>
                            <td>
                                Invoice #: {{ $invoices->paidinvoice_no }}<br>
                                Created: {{ date('F d, Y', strtotime($invoices->created_at)) }}<br>
                                Pay Due Date: {{ date('F d, Y', strtotime($invoices->payment_due_date)) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <b>{{ $invoices->name }}</b>, <br>
                                {{ $invoices->address }} <br>
                                {{ $invoices->city.', '.$invoices->state.', '.$invoices->zip }}<br>
                                {{ $invoices->country }} <br>
                                Payee Ref #: {{ $invoices->payee_ref_no }}
                            </td>


                            <td>
                                <b>{{ $invoices->email }}</b><br>
                                @if($clientInfo = \App\ClientInfo::where('user_id', $invoices->uploaded_by)->get())

                                @if(count($clientInfo) > 0)

                                    Client Name: {{ $clientInfo[0]->firstname.' '.$clientInfo[0]->lastname }} <br>
                                Business Name: {{ $clientInfo[0]->business_name }} <br>
                                Client Address: {{ $clientInfo[0]->address }}

                                @endif
                                


                                @endif
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td colspan="2" align="center">
                    INVOICE INFORMATION for {{ $invoices->paidservice }}
                </td>

            </tr>

            <tr class="item">
                <td>
                   Transaction Ref
                </td>

                <td>
                    {{ $invoices->transaction_ref }}
                </td>
            </tr>

            <tr class="item">
                <td>
                    Amount Invoiced
                </td>

                <td style="color: navy;">
                    {{ Auth::user()->currencySymbol.''.number_format($invoices->invoice_amount, 2) }}
                </td>
            </tr>
            <tr class="item">
                <td>
                    Tax Amount
                </td>

                <td style="color: navy;">
                    {{ Auth::user()->currencySymbol.''.number_format($invoices->tax_amount, 2) }}
                </td>
            </tr>
            <tr class="item">
                <td>
                    Total Amount
                </td>

                <td style="color: black; font-size: 22px; font-weight: 700;">
                    {{ Auth::user()->currencySymbol.''.number_format($invoices->total_amount, 2) }}
                </td>
            </tr>

            <tr class="heading">
                <td colspan="2" align="center">
                    PAYMENT MADE
                </td>

            </tr>
            
            <tr class="item">
                <td>
                    Amount Paid
                </td>

                <td style="color: green; font-weight: 700; font-size: 20px;">
                    @if(isset($invoices->payedAmount)){{ Auth::user()->currencySymbol.''.number_format($invoices->payedAmount, 2) }}@else {{ Auth::user()->currencySymbol.''.number_format(0, 2) }} @endif
                </td>
            </tr>

            @if($invoices->remaining_balance != "" || $invoices->remaining_balance != null)
            <tr class="item">
                <td>
                    Balance on Invoice
                </td>

                <td style="color: tomato; font-weight: 700; font-size: 20px;">
                    {{ Auth::user()->currencySymbol.''.number_format($invoices->remaining_balance, 2) }}
                </td>
            </tr>
            @endif

            
            

            <tr class="item last">
                <td>
                    Note
                </td>

                <td style="font-size: 10px; width: 100% !important">
                    {!! $invoices->description !!}
                </td>
            </tr>
        </table>
        <hr><br>

        @if (preg_match("/ord-/", $invoices->trans_id))

        <div class="col-md-12"><button type="button" class="btn btn-success btn-block" disabled>Invoice Paid</button></div>
            
        @else

        <div class="col-md-12"><button type="button" class="btn btn-success btn-block" onclick="location.href='{{ route('payment', $invoices->paidinvoice_no) }}'">Pay Invoice</button></div>
            
        @endif

        
            
        @endforeach
        
    </div>
    <br><br>
    <center>
            <button type="button" class="btn btn-danger" onclick="printInvoice()">Print Invoice</button>
            
    </center>


    @else

    <div class="container invoice-box">
        Invoice details not found
    </div>

    @endif
    <br>

    
    {{-- Beginning of the new invoice --}}
    {{-- <div class="disp-0">
        <div class="container">
         
            <div class="row shadow">
              <div class="col-sm-12">
                <div class="panel panel-default invoice" id="invoice">
                  <div class="panel-body pt-4">
                    
                    <div class="row">
          
                      <div class="col-sm-4 top-left header_logo">
                        <img src="https://wave-prod-accounting.s3.amazonaws.com/uploads/invoices/business_logos/ed704926-66f1-4c28-8a8a-25f44099eb6c.png" alt="">
                      </div>
          
                      <div class="col-sm-8 top-right">
                        <h4 class="mr-5">INVOICE-1234578</h4>
                        <span class="mr-5">14 April 2014</span>
                      </div>
          
                    </div>
          
                    <div class="row">
                      <div class="col-12 ml-auto">
                        <div class="w-100 text-right">
                          <span class="lead marginbottom font-weight-bold">Dynofy</span><br>
                          <span class="w-100 text-right">
                            350 Rhode Island Street<br>
                            Suite 240, San Francisco<br>
                            California, 94103<br>
                            415-767-3600 <br>
                            contact@dynofy.com
                          </span>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
          
                      <div class="col-6 to">
                        <p class="mb-3 text-mute">Bill To:</p>
                        <p class="font-weight-bold">John Doe</p>
                        <p>425 Market Street</p>
                        <p>Suite 2200, San Francisco</p>
                        <p>California, 94105</p>
                        <p>Phone: 415-676-3600</p>
                        <p>Email: john@doe.com</p>
          
                      </div>
          
                      <div class="col-6 text-right payment-details">
                        <p class="lead marginbottom payment-info">Payment details</p>
                        <p>Date: 14 April 2014</p>
                        <p>VAT: DK888-777 </p>
                        <p>Total Amount: $1019</p>
                        <p>Account Name: Flatter</p>
                      </div>
          
                    </div>
          
                    <div class="row table-row">
                      <table class="table table-striped">
                        <thead style="background: #121D36!important; color: #FFFFFF;">
                          <tr>
                            <th class="text-center" style="width:5%">#</th>
                            <th style="width:50%">Item</th>
                            <th class="text-right" style="width:15%">Quantity</th>
                            <th class="text-right" style="width:15%">Unit Price</th>
                            <th class="text-right" style="width:15%">Total Price</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-center">1</td>
                            <td>Flatter Theme</td>
                            <td class="text-right">10</td>
                            <td class="text-right">$18</td>
                            <td class="text-right">$180</td>
                          </tr>
                          <tr>
                            <td class="text-center">2</td>
                            <td>Flat Icons</td>
                            <td class="text-right">6</td>
                            <td class="text-right">$59</td>
                            <td class="text-right">$254</td>
                          </tr>
                          <tr>
                            <td class="text-center">3</td>
                            <td>Wordpress version</td>
                            <td class="text-right">4</td>
                            <td class="text-right">$95</td>
                            <td class="text-right">$285</td>
                          </tr>
                          <tr class="last-row">
                            <td class="text-center">4</td>
                            <td>Server Deployment</td>
                            <td class="text-right">1</td>
                            <td class="text-right">$300</td>
                            <td class="text-right">$300</td>
                          </tr>
                        </tbody>
                      </table>
          
                    </div>
          
                    <div class="row">
                      <div class="col-6">
          
                      </div>
                      <div class="col-6 text-right pull-right invoice-total">
                        <p>
                          <span class="font-weight-bold">Subtotal</span> : $1019
                        </p>
                        <p>
                          <span class="font-weight-bold">Total</span> : $991
                        </p>
                      </div>
                    </div>
          
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div> --}}

    
    


    <script>
        function printInvoice(){
            // Print Section
        var divToPrint2 = document.getElementById('divToPrint');
        var popupWin = window.open('', '_blank', 'width=800,height=1000');
        popupWin.document.open();
        popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
        }
    </script>
</body>
</html>
