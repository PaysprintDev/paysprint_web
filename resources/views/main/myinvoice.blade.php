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
