@extends('layouts.app')

@section('content')
   
    <style>
        
    </style>
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
            <div style="text-align: center" class="subtittle">
                <h2 >WHO WE ARE</h2>
            </div>
            <div class="row about_row about_us2_pages">
                <div class="who_we_area col-md-7">
                    
                    <p>PaySprint is 100% subscription-based digital wallet that enhances payment processing among individuals and merchants. The digital wallet offers seamless, end-to-end payments at minimum costs.<br>
                    Our digital wallet enables individuals to send and receive money locally and across the border while merchants can receive payments from customers on any mobile device (for In-store sales) and on the business's website (for online sale) with no usage fees.
                    </p>
                    <a href="{{ route('contact') }}" class="button_all">Contact Now</a>
                </div>
                <div class="col-md-5 our_skill_inner">
                    <div class="single_skill">
                        <h3>Cross Border Payment Made Easy</h3>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                {{-- <div class="progress_parcent"><span class="counter2">98</span>%</div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="single_skill">
                        <h3>No-fee Peer-to-peer Digital Wallet</h3>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                {{-- <div class="progress_parcent"><span class="counter2">96</span>%</div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="single_skill">
                        <h3>Multiple Access (Mobile App & Web Application)</h3>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                {{-- <div class="progress_parcent"><span class="counter2">80</span>%</div> --}}
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
                    <img src="{{ asset('images/paysprintlogo.png') }}"alt="logo">
                </div>
                <div class="col-md-6 feature_content">
                       <h1 style="padding:1rem">PaySprint for Business</h1>
                       <h4 style=" padding:2rem">...helps merchant to keep more money in business</h4>
                       
                       
                    <div class="media" >
                        <ul>
                            <li style="font-size:2rem; color:black;font-weight:600; padding-bottom:5px">Receive Payments with PaySprint - One Platform, 3-Channels, Any Device, $0.00 Fees</li>
                              <ul>
                                <li style="font-size: 2rem">QR Code for Face-to-Face Payments</li>
                                <li style="font-size: 2rem">Payments Links for Remote Payments</li>
                                <li style="font-size: 2rem">Payments Gateway for Online Payments</li>
                              </ul>
                            <hr>
                            <li style="font-size:2rem; color:black;font-weight:600; padding-bottom:5px">Supporting Business to Grow</li>
                              <ul>
                                <li style="font-size: 2rem">Easy to Access Working Capital</li>
                                <li style="font-size: 2rem">Sell More to Customers on eStore</li>
                                <li style="font-size: 2rem">Free invoicing to Customers on any device</li>
                                <li style="font-size: 2rem">Free Cashflow Tool Kits</li>
                              </ul>
                            <hr>
                            <li style="font-size:2rem; color:black;font-weight:600; padding-bottom:5px">Target Markets</li>
                            <ul>
                                <li style="font-size: 2rem">Muilt-Vendors</li>
                                <li style="font-size: 2rem">Small and Medium Size Businesses</li>
                                <li style="font-size: 2rem">Professionals</li>
                               
                              </ul>
                        </ul>
                    </div>
                    
                    

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
