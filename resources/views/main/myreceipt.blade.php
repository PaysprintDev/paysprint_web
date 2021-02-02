<?php use \App\Http\Controllers\ClientInfo; ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PaySprint | Print Invoice</title>
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
    @if(count($invoice) > 0)
    <div class="container invoice-box" id="divToPrint">


        <table class="table table-bordered" cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                @if($clientInfo = \App\ClientInfo::where('user_id', $invoice[0]->uploaded_by)->get())
                               <span style="font-size: 20px;"> {{ $clientInfo[0]->firstname.' '.$clientInfo[0]->lastname }}</span>
                                @endif
                                <br>
                                <span style="font-size: 17px;">Powered By</span><br>
                            <img src="{{ asset('images/logo2.png') }}" style="width:30%; max-width:300px;" align="left">
                            </td>

                            <td>
                                Transaction #: {{ $invoice[0]->trans_id }}<br>
                                Created: {{ date('F d, Y', strtotime($invoice[0]->created_at)) }}<br>
                                Pay Due Date: {{ date('F d, Y', strtotime($invoice[0]->payment_due_date)) }}
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
                                <b>{{ $invoice[0]->name }}</b>, <br>
                                {{ $invoice[0]->address }} <br>
                                {{ $invoice[0]->city.', '.$invoice[0]->state.', '.$invoice[0]->zip }}<br>
                                {{ $invoice[0]->country }}
                            </td>


                            <td>
                                <b>{{ $invoice[0]->email }}</b><br>
                                @if($clientInfo = \App\ClientInfo::where('user_id', $invoice[0]->uploaded_by)->get())
                                Client Name: {{ $clientInfo[0]->firstname.' '.$clientInfo[0]->lastname }} <br>
                                Business Name: {{ $clientInfo[0]->business_name }} <br>
                                Client Address: {{ $clientInfo[0]->address }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td colspan="2" align="center">
                    RECEIPT INFORMATION for {{ $invoice[0]->paidservice }}
                </td>
            </tr>

            <tr class="item">
                <td>
                   Trans. #
                </td>

                <td>
                    {{ $invoice[0]->trans_id }}
                </td>
            </tr>


            <tr class="item">
                <td>
                    Issuer ID #
                </td>

                <td>
                    {{ $invoice[0]->payee_ref_no }}
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Amount Paid
                </td>

                <td style="color: green;">
                    ${{ number_format($invoice[0]->payedAmount, 2) }}
                </td>
            </tr>


            <tr class="item last">
                <td>
                    Note
                </td>

                <td style="font-size: 10px; width: 100% !important">
                    {!! $invoice[0]->description !!}
                </td>
            </tr>
        </table>
        <hr>

            
        
    </div>

    @endif
    <br>
    <center><button type="button" class="btn btn-danger" onclick="printInvoice()">Print</button></center>


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
