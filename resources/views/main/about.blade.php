@extends('layouts.app')

@section('content')

    <!-- Banner area -->
    <section class="banner_area" data-stellar-background-ratio="0.5">
        <h2>About Us</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('about') }}" class="active">About Us</a></li>
        </ol>
    </section>
    <!-- End Banner area -->

    <!-- About Us Area -->
    <section class="about_us_area about_us_2 row">
        <div class="container">
            <div class="row about_row about_us2_pages">
                <div class="who_we_area col-md-7">
                    <div class="subtittle">
                        <h2>WHO WE ARE</h2>
                    </div>
                    <p>PaySprint is the fastest and affordable method of Sending and Receiving money, Paying Invoice and Getting Paid at anytime!</p>
                    <a href="{{ route('contact') }}" class="button_all">Contact Now</a>
                </div>
                <div class="col-md-5 our_skill_inner">
                    <div class="single_skill">
                        <h3>Rental Property Management</h3>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                {{-- <div class="progress_parcent"><span class="counter2">98</span>%</div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="single_skill">
                        <h3>Property Tax</h3>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                {{-- <div class="progress_parcent"><span class="counter2">96</span>%</div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="single_skill">
                        <h3>Utility Bill</h3>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                {{-- <div class="progress_parcent"><span class="counter2">80</span>%</div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="single_skill">
                        <h3>Parking Tickets</h3>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                {{-- <div class="progress_parcent"><span class="counter2">78</span>%</div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="single_skill disp-0">
                        <h3>Event Ticketing</h3>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                {{-- <div class="progress_parcent"><span class="counter2">76</span>%</div> --}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End About Us Area -->

    <!-- call Area -->
    <section class="call_min_area disp-0">
        <div class="container">
            <h2>+012 345 6789</h2>
            <p>Contact With Us. We are the top Construction Company. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <div class="call_btn">
                <a href="{{ route('contact') }}" class="button_all">QUICK QUOTE</a>
            </div>
        </div>
    </section>
    <!-- End call Area -->

    <!-- Our Features Area -->
    <section class="our_feature_area">
        <div class="container">
            <div class="feature_row row">
                <div class="col-md-6 feature_img">
                    <img src="https://www.adsc.com/hs-fs/hubfs/Improved-Billing-1.png?width=750&name=Improved-Billing-1.png" alt="">
                </div>
                <div class="col-md-6 feature_content">

                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <i class="fa fa-percent" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="#">RENTAL PROPERTY MANAGEMENT</a>
                            <p>
                            Are you a Property Manager or a Landlord looking for a good tool to manage end-to-end process of your business or property? With PaySprint, you are able to manage every aspect of the business or property ranging from managing maintenance to booking amenities or invoicing tenants.
                            Request for a Demo Today  <br>
                            <a href="https://exbc.ca/login" style="font-size: 14px;">Click to login</a> to your Account NOW</p>
                        </div>
                    </div>
                    <hr>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <i class="fa fa-bolt" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="#">UTILITY BILL</a>
                            <p>Do you want to pay a utility bill to the landlord or government? Do you want to be receiving electronic copy (eCopy) of the bills, Open a Free PaySprint Account Today <a href="https://exbc.ca/login" style="font-size: 14px;">Login to your account Today</a>.</p>
                        </div>
                    </div>
                    <hr>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <i class="fa fa-home" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="#">PROPERTY TAX</a>
                            <p>
                            Do you have a bill to pay, or want to check if there is any outstanding on your property tax account with government? PaySprint is all you need. <br>
                            {{-- <a href="https://exbc.ca/login" style="font-size: 14px;">Click to login</a> to your Account NOW  --}}
                            <span style="background-color: tomato; color: #fff; border-radius: 10px; padding: 5px">COMING SOON!!</span></p>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <i class="fa fa-file" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="#">PARKING TICKETS</a>
                            <p>You can pay the City parking tickets and most other Provincial Offences Act (POA) violations by telephone, in person or by mail. <span style="background-color: tomato; color: #fff; border-radius: 10px; padding: 5px">COMING SOON!!</span></p>

                            {{-- <p>You can pay the City parking tickets and most other Provincial Offences Act (POA) violations by telephone, in person or by mail. If you wish to dispute a ticket, you have to do so in person by asking for a <a href="https://www.brampton.ca/EN/residents/Parking/Pages/Trial-Request.aspx" target="_blank">trial</a>. <br> If you have received a parking ticket or another POA violation, such as a speeding ticket, click on the appropriate button when you login to the account. However, you must also carefully read the specific details on your Parking Infraction/Offence Notice. <a href="{{ route('login') }}" style="font-size: 14px;">Login to your account Today</a>.</p> --}}
                        </div>
                    </div>
                    <hr>

                    <div class="media disp-0">
                        <div class="media-left">
                            <a href="#">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="media-body">
                            <a href="#">EVENT TICKETING</a>
                            <p>You can purchase tickets for upcoming events at discounted rates. Simply login, and select the event, make payment and you receive your eTicket on your email box or simply print a copy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Our Features Area -->

    <!-- Our Partners Area -->
    <section class="our_partners_area disp-0">
        <div class="book_now_aera">
            <div class="container">
                <div class="row book_now">
                    <div class="col-md-10 booking_text">
                        <h4>Booking now if you need us with all kinds of billings.</h4>
                    </div>
                    <div class="col-md-2 book_bottun">
                        <a href="{{ route('contact') }}" class="button_all">book now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Our Partners Area -->


    <!-- Our Team Area -->
    <section class="our_team_area disp-0">
        <div class="container">
            <div class="tittle wow fadeInUp">
                <h2>Our Team</h2>
                <h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry</h4>
            </div>
            <div class="row team_row">
                <div class="col-md-3 col-sm-6 wow fadeInUp">
                   <div class="team_membar">
                        <img src="images/team/tm-5.jpg" alt="">
                        <div class="team_content">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            </ul>
                            <a href="#" class="name">Prodip Ghosh</a>
                            <h6>Founder &amp; CEO</h6>
                        </div>
                   </div>
                </div>
                <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay="0.2s">
                   <div class="team_membar">
                        <img src="images/team/tm-6.jpg" alt="">
                        <div class="team_content">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            </ul>
                            <a href="#" class="name">Emran Khan</a>
                            <h6>Web-Developer</h6>
                        </div>
                   </div>
                </div>
                <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay="0.4s">
                   <div class="team_membar">
                        <img src="images/team/tm-7.jpg" alt="">
                        <div class="team_content">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            </ul>
                            <a href="#" class="name">Prodip Ghosh</a>
                            <h6>Founder &amp; CEO</h6>
                        </div>
                   </div>
                </div>
                <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay="0.6s">
                   <div class="team_membar">
                        <img src="images/team/tm-8.jpg" alt="">
                        <div class="team_content">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            </ul>
                            <a href="#" class="name">Jakaria Khan</a>
                            <h6>Founder &amp; CEO</h6>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Our Team Area -->

@endsection
