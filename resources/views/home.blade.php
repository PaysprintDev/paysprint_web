@extends('layouts.app')



@section('title', 'Home')

@show

@section('content')

    <!-- Professional Builde -->
    <section class="professional_builders row">
        <div class="container">
            <br>
            <br>
           <div class="row builder_all">
                <div class="col-md-6 col-sm-6 builder walletInformation">
                    <div class="alert alert-warning">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="font-sm">
                                                                Wallet Balance
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h4>
                                                                {{ $data['currencyCode'][0]->currencies[0]->symbol."".number_format(Auth::user()->wallet_balance, 2) }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                            </div>
                </div>
                <div class="col-md-6 col-sm-6 builder walletInformation">
                    <div class="alert alert-info">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="font-sm">
                                                                Total Withdrawals
                                                            </h3>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h4>
                                                                {{ number_format(Auth::user()->number_of_withdrawals) }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                            </div>
                </div>
           </div>
        </div>
    </section>
    <!-- End Professional Builde -->


    <!-- Professional Builde -->
    <section class="professional_builder row">
        <div class="container">
           <div class="row builder_all">
                <div class="col-md-6 col-sm-6 builder">
                    <br>
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Send & Receive</h2>
                        </div>
                        <div class="col-md-4">
                            <i class="far fa-paper-plane"></i>
                        </div>
                    </div>
                    <div class="table table-responsive infoRec">
                        <table class="table table-striped">
                            <tbody>


                                @if (count($data['sendReceive']) > 0)
                                    @foreach ($data['sendReceive'] as $sendRecData)
                                        <tr>
                                            <td><i class="fas fa-circle {{ ($sendRecData->credit != 0) ? "text-success" : "text-danger" }}"></i></td>
                                            <td>

                                                    <div class="row">
                                                        <div class="col-md-12" style="text-align: left;">
                                                            {!! $sendRecData->activity !!}
                                                        </div>
                                                        <div class="col-md-12" style="text-align: left;">
                                                            <small>
                                                                {{ $sendRecData->reference_code }}
                                                            </small><br>
                                                            <small>
                                                                {{ date('d/m/Y h:i a', strtotime($sendRecData->created_at)) }}
                                                            </small>
                                                        </div>
                                                    </div>

                                                </td>
                                            <td style="font-weight: 700" class="{{ ($sendRecData->credit != 0) ? "text-success" : "text-danger" }}">{{ ($sendRecData->credit != 0) ? "+".$data['currencyCode'][0]->currencies[0]->symbol.number_format($sendRecData->credit, 2) : "-".$data['currencyCode'][0]->currencies[0]->symbol.number_format($sendRecData->debit, 2) }}</td>
                                        </tr>
                                    @endforeach

                                @else
                                <tr>
                                    <td colspan="3" align="center">No record</td>
                                </tr>
                                @endif
                                
                                
                                
                            </tbody>
                        </table>

                            <a href="javascript:void(0)" type="button" class="btn btn-primary" onclick="$('#sendMoney').click()">Send Money</a>

                    </div>
                </div>
                <div class="col-md-6 col-sm-6 builder">
                    <br>
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Pay Invoice</h2>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                    </div>
                    <div class="table table-responsive infoRec">
                        <table class="table table-striped">
                            <tbody>

                                @if (count($data['payInvoice']) > 0)
                                    @foreach ($data['payInvoice'] as $payInv)
                                        <tr>
                                            <td><i class="fas fa-circle {{ ($payInv->credit != 0) ? "text-success" : "text-danger" }}"></i></td>
                                            <td>

                                                    <div class="row">
                                                        <div class="col-md-12" style="text-align: left;">
                                                            {!! $payInv->activity !!}
                                                        </div>
                                                        <div class="col-md-12" style="text-align: left;">
                                                            <small>
                                                                {{ $payInv->reference_code }}
                                                            </small><br>
                                                            <small>
                                                                {{ date('d/m/Y h:i a', strtotime($payInv->created_at)) }}
                                                            </small>
                                                        </div>
                                                    </div>

                                                </td>
                                            <td style="font-weight: 700" class="{{ ($payInv->credit != 0) ? "text-success" : "text-danger" }}">{{ ($payInv->credit != 0) ? "+".$data['currencyCode'][0]->currencies[0]->symbol.number_format($payInv->credit, 2) : "-".$data['currencyCode'][0]->currencies[0]->symbol.number_format($payInv->debit, 2) }}</td>
                                        </tr>
                                    @endforeach

                                @else
                                <tr>
                                    <td colspan="3" align="center">No record</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                                    <a href="{{ route('invoice') }}" type="button" class="btn btn-primary">Pay Invoice</a>

                    </div>
                </div>
           </div>


           <div class="row builder_all">
                <div class="col-md-6 col-sm-6 builder">
                    <br>
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Wallet Transactions</h2>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                    <div class="table table-responsive infoRec">
                        <table class="table table-striped">
                            <tbody>
                                @if (count($data['sendReceive']) > 0)
                                    @foreach ($data['sendReceive'] as $sendRecData)
                                        <tr>
                                            <td><i class="fas fa-circle {{ ($sendRecData->credit != 0) ? "text-success" : "text-danger" }}"></i></td>
                                            <td>

                                                    <div class="row">
                                                        <div class="col-md-12" style="text-align: left;">
                                                            {!! $sendRecData->activity !!}
                                                        </div>
                                                        <div class="col-md-12" style="text-align: left;">
                                                            <small>
                                                                {{ $sendRecData->reference_code }}
                                                            </small><br>
                                                            <small>
                                                                {{ date('d/m/Y h:i a', strtotime($sendRecData->created_at)) }}
                                                            </small>
                                                        </div>
                                                    </div>

                                                </td>
                                            <td style="font-weight: 700" class="{{ ($sendRecData->credit != 0) ? "text-success" : "text-danger" }}">{{ ($sendRecData->credit != 0) ? "+".$data['currencyCode'][0]->currencies[0]->symbol.number_format($sendRecData->credit, 2) : "-".$data['currencyCode'][0]->currencies[0]->symbol.number_format($sendRecData->debit, 2) }}</td>
                                        </tr>
                                    @endforeach

                                @else
                                <tr>
                                    <td colspan="3" align="center">No record</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                                    <a href="{{ route('my account') }}" type="button" class="btn btn-primary">My Wallet</a>

                    </div>
                </div>
                <div class="col-md-6 col-sm-6 builder">
                    <br>
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Notifications</h2>
                        </div>
                        <div class="col-md-4">
                            <i class="far fa-bell"></i>
                        </div>
                    </div>
                    <div class="table table-responsive infoRec">
                        <table class="table table-striped">
                            <tbody>
                                @if (count($data['urgentnotification']) > 0)
                                    @foreach ($data['urgentnotification'] as $urgentNotify)
                                        <tr>
                                            <td><i class="fas fa-circle {{ ($urgentNotify->credit != 0) ? "text-success" : "text-danger" }}"></i></td>
                                            <td align="left">

                                                    <div class="row">
                                                        <div class="col-md-12" style="text-align: left;">
                                                            {!! $urgentNotify->activity !!}
                                                        </div>
                                                        <div class="col-md-12" style="text-align: left;">
                                                            <small>
                                                                {{ $urgentNotify->reference_code }}
                                                            </small><br>
                                                            <small>
                                                                {{ date('d/m/Y h:i a', strtotime($urgentNotify->created_at)) }}
                                                            </small>
                                                        </div>
                                                    </div>

                                                </td>
                                            <td style="font-weight: 700" class="{{ ($urgentNotify->credit != 0) ? "text-success" : "text-danger" }}">{{ ($urgentNotify->credit != 0) ? "+".$data['currencyCode'][0]->currencies[0]->symbol.number_format($urgentNotify->credit, 2) : "-".$data['currencyCode'][0]->currencies[0]->symbol.number_format($urgentNotify->debit, 2) }}</td>
                                        </tr>
                                    @endforeach

                                @else
                                <tr>
                                    <td colspan="3" align="center">No record</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
           </div>
        </div>
    </section>
    <!-- End Professional Builde -->

    <!-- About Us Area -->
    <section class="about_us_area row disp-0">
        <div class="container">
            <div class="tittle wow fadeInUp">
                <h2>ABOUT US</h2>
                <h4>PaySprint is a method of sending bills and collecting
                    electronic payments in which bills are delivered over the Internet and customers can pay electronically.</h4>
            </div>
            <div class="row about_row">
                <div class="who_we_area col-md-7 col-sm-6">
                    <div class="subtittle">
                        <h2>WHO WE ARE</h2>
                    </div>
                    <p>We generally involve in integrating multiple systems including a billing system, banking system, a customer’s bank bill pay system, an online interface for revenue collection and some of the best applications that improves the quality of lives we live.</p>

                    <a href="{{ route('contact') }}" class="button_all">Contact Now</a>
                </div>
                <div class="col-md-5 col-sm-6 about_client">
                    <img src="https://res.cloudinary.com/pilstech/image/upload/v1602675914/paysprint_with_name_black_and_yellow_png_ur7bli.png" alt="Paysprint Logo" style="height: 350px; width: auto;">
                </div>
            </div>
        </div>
    </section>
    <!-- End About Us Area -->

    

    <!-- What ew offer Area -->
    <section class="what_we_area row disp-0">
        <div class="container">
            <div class="tittle wow fadeInUp">
                <h2>WHAT WE OFFER</h2>
                <h4>PaySprint is most helpful for businesses that send recurring bills to customers.</h4>
            </div>
            <div class="row construction_iner">
                <div class="col-md-6 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://image.freepik.com/free-photo/cooperation-analyst-chart-professional-paper-economics_1418-47.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-percent" aria-hidden="true"></i>
                        <a href="#">RENTAL PROPERTY MANAGEMENT</a>
                        <p>Are you a Property Manager or a Landlord looking for a good tool to manage end-to-end process of your business or property? With PaySprint, you are able to manage every aspect of the business or property ranging from managing maintenance to booking amenities or invoicing tenants.
                        Request for a Demo Today</p>
                   </div>
                </div>
                <div class="col-md-6 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://image.freepik.com/free-photo/mobile-payments-mobile-scanning-payments-face-face-payments_1359-1145.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <a href="#">PROPERTY TAX</a>
                        <p>Do you have a bill to pay, or want to check if there is any outstanding on your property tax account with government? PaySprint is all you need.  </p><br><br>
                        <span style="background-color: tomato; color: #fff; border-radius: 10px; padding: 5px">COMING SOON!!</span>
                   </div>
                </div>
            </div>
            <div class="row construction_iner">
                <div class="col-md-6 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://image.freepik.com/free-photo/hand-with-credit-card-laptop_1232-619.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-bolt" aria-hidden="true"></i>
                        <a href="#">UTILITY BILLS</a>
                        <p>Do you want to pay a utility bill to the landlord or government? Do you want to be receiving electronic copy (eCopy) of the bills, Open a Free PaySprint Account Today.   </p>
                   </div>
                </div>
                <div class="col-md-6 col-sm-6 construction">
                   <div class="cns-img">
                        <img src="https://image.freepik.com/free-photo/aerial-view-business-data-analysis-graph_53876-13390.jpg" alt="">
                   </div>
                   <div class="cns-content" style="height: 320px !important;">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <a href="#">PARKING TICKETS</a>
                        <p>You can pay the City parking tickets and most other Provincial Offences Act (POA) violations by telephone, in person or by mail. </p><br><br>
                        <span style="background-color: tomato; color: #fff; border-radius: 10px; padding: 5px">COMING SOON!!</span>
                   </div>
                </div>
                <div class="col-md-3 col-sm-6 construction disp-0">
                   <div class="cns-img">
                        <img src="https://image.freepik.com/free-photo/cooperation-analyst-chart-professional-paper-economics_1418-47.jpg" alt="">
                   </div>
                   <div class="cns-content">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <a href="#">EVENT TICKETING</a>
                        <p>You can purchase tickets for upcoming events at discounted rates. Simply login, and select the event, make payment and you receive your eTicket on your email box or simply print a copy.  </p>
                   </div>
                </div>
            </div>

                <center><a href="{{ route('about') }}" class="button_all" style="background-color: #fff !important; margin-bottom: 20px;">Read More</a></center>
        </div>
    </section>
    <!-- End What ew offer Area -->

    <!-- Our Partners Area -->
    <section class="our_partners_area disp-0">
        <div class="container">
            <div class="tittle wow fadeInUp">
                <h2>Our Partners</h2>
                <h4>&nbsp;</h4>
            </div>
            <div class="partners">
                <div class="item"><img src="images/client_logo/moneris.png" alt=""></div>
                {{-- <div class="item"><img src="images/client_logo/client_logo-2.png" alt=""></div> --}}
                {{-- <div class="item"><img src="images/client_logo/client_logo-3.png" alt=""></div> --}}
                {{-- <div class="item"><img src="images/client_logo/client_logo-4.png" alt=""></div> --}}
                {{-- <div class="item"><img src="images/client_logo/client_logo-5.png" alt=""></div> --}}
            </div>
        </div>
        <div class="book_now_aera">
            <div class="container">
                <div class="row book_now">
                    <div class="col-md-10 booking_text">
                        <h4>Booking now if you need us with all kinds of billings.</h4>
                        <p>&nbsp;</p>
                    </div>
                    <div class="col-md-2 p0 book_bottun">
                        <a href="{{ route('contact') }}" class="button_all">book now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Our Partners Area -->




@endsection
