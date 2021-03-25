@extends('layouts.app')



@section('title', 'Home')

@show

@section('content')

    <style>
        .slider_area .slider_inner .camera_caption div{background: #141414; }

        .slider_inner.camera_wrap{
            height: 300px !important;
            display: block;
            background-color: black !important;
        }

        
    </style>


    <!-- Slider area -->
    <section class="slider_area row m0" style="background-color: #11202A">
        <div class="slider_inner">

            <div data-thumb="https://res.cloudinary.com/pilstech/image/upload/v1616688527/Send_and_Receive_q3pm2g.png" data-src="https://res.cloudinary.com/pilstech/image/upload/v1616688527/Send_and_Receive_q3pm2g.png">
                <div class="camera_caption">
                   <div class="container">
                        {{--  <h5 class=" wow fadeInUp animated">Welcome to our</h5>
                        <h3 class=" wow fadeInUp animated" data-wow-delay="0.5s">SAFE AND SECURE MONEY TRANSFER SOLUTION</h3>  --}}
                        {{-- <p class=" wow fadeInUp animated" data-wow-delay="0.8s">fastest way to collect money from customers</p> --}}
                        {{-- <a class=" wow fadeInUp animated" data-wow-delay="1s" href="#">Read More</a> --}}
                   </div>
                </div>
            </div>

            <div data-thumb="https://res.cloudinary.com/pilstech/image/upload/v1616688527/Make_Payment_v0smkl.png" data-src="https://res.cloudinary.com/pilstech/image/upload/v1616688527/Make_Payment_v0smkl.png">
                <div class="camera_caption">
                   <div class="container">
                        {{--  <h5 class=" wow fadeInUp animated">Welcome to our</h5>
                        <h3 class=" wow fadeInUp animated" data-wow-delay="0.5s">SAFE AND SECURE INVOICING AND PAYMENT SOLUTIONS</h3>  --}}
                        {{-- <p class=" wow fadeInUp animated" data-wow-delay="0.8s">fastest way to collect money from customers</p> --}}
                        {{-- <a class=" wow fadeInUp animated" data-wow-delay="1s" href="#">Read More</a> --}}
                   </div>
                </div>
            </div>

            <div data-thumb="https://res.cloudinary.com/pilstech/image/upload/v1616688527/Safe_and_Secured_wwiznn.png" data-src="https://res.cloudinary.com/pilstech/image/upload/v1616688527/Safe_and_Secured_wwiznn.png">
                <div class="camera_caption">
                   <div class="container">
                        {{--  <h5 class=" wow fadeInUp animated">Welcome to our</h5>
                        <h3 class=" wow fadeInUp animated" data-wow-delay="0.5s">BANKING MADE EASY WITH WALLET</h3>  --}}
                        {{-- <p class=" wow fadeInUp animated" data-wow-delay="0.8s">fastest way to collect money from customers</p> --}}
                        {{-- <a class=" wow fadeInUp animated" data-wow-delay="1s" href="#">Read More</a> --}}
                   </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Slider area -->

            <!-- Coming Soon to PlayStore and App Store -->
    <section class="about_us_area row">
        <div class="container">

            <div class="row about_row">
                <div class="col-md-6 col-sm-6 about_client">
                    <center>
                        <img src="https://res.cloudinary.com/pilstech/image/upload/v1616175829/google-play-soon_miudnn.png" alt="Coming Soon To Play Store" style="height: auto; width: 350px;">
                    </center>
                </div>
                <div class="col-md-6 col-sm-6 about_client">
                    <center>
                        <img src="https://res.cloudinary.com/pilstech/image/upload/v1616497940/png-clipart-apple-app-store-advertisement-iphone-app-store-android-coming-soon-electronics-text_lwp53w.png" alt="Coming Soon to App Store" style="height: auto; width: 350px;">
                    </center>
                </div>
            </div>
        </div>
    </section>
    <!-- End Coming Soon to PlayStore and App Store -->

    <!-- Professional Builde -->
    <section class="professional_builder row">
        <div class="container">
           <div class="row builder_all">
                <div class="col-md-6 col-sm-6 builder">
                    <i class="fa fa-percent" aria-hidden="true"></i>
                    <h4>Rental Property Management</h4>
                    <p>Are you a Property Manager or a Landlord looking for a good tool to manage end-to-end process of your business or property? With PaySprint, you are able to manage every aspect of the business or property ranging from managing maintenance to booking amenities or invoicing tenants.
                    Request for a Demo Today</p>
                </div>
                <div class="col-md-6 col-sm-6 builder">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <h4>Property Tax</h4>
                    <p>Do you have a bill to pay, or want to check if there is any outstanding on your property tax account with government? <br>PaySprint is all you need. <br> <span style="background-color: tomato; color: #fff; border-radius: 10px; padding: 5px">COMING SOON!!</span></p>
                </div>
           </div>
           <div class="row builder_all">
                <div class="col-md-6 col-sm-6 builder">
                    <i class="fa fa-building" aria-hidden="true"></i>
                    <h4>Utility Bill</h4>
                    <p> Do you want to pay a utility bill to the landlord or government? Do you want to be receiving electronic copy (eCopy) of the bills, Open a Free PaySprint Account Today</p>
                </div>
                <div class="col-md-6 col-sm-6 builder">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    <h4>Parking Tickets</h4>
                    <p>You can pay the City parking tickets and most other Provincial Offences Act (POA) violations by telephone, in person or by mail. <br> <span style="background-color: tomato; color: #fff; border-radius: 10px; padding: 5px">COMING SOON!!</span></p>
                </div>
                <div class="col-md-3 col-sm-6 builder disp-0">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <h4>Event Ticketing</h4>
                    <p>You can purchase tickets for upcoming events at discounted rates. Simply login, and select the event, make payment and you receive your eTicket.</p>
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





    <!-- Our Services Area -->
    {{-- <section class="our_services_area">
        <div class="container">
            <div class="tittle wow fadeInUp">
                <h2>Our Services</h2>
                <h4>A property tax or millage rate is an ad valorem tax on the value of a property</h4>
            </div>
            <div class="portfolio_inner_area">
                <div class="portfolio_filter">
                    <ul>
                        <li data-filter="*" class="active"><a href=""> All</a></li>
                        <li data-filter=".photography"><a href="">ARCHITECTURE</a></li>
                        <li data-filter=".branding"><a href="">Building</a></li>
                        <li data-filter=".webdesign"><a href="">CONSTRUCTION</a></li>
                        <li data-filter=".adversting"><a href="">DESIGN</a></li>
                        <li data-filter=".painting"><a href="">Painting</a></li>
                    </ul>
                </div>
                <div class="portfolio_item">
                   <div class="grid-sizer"></div>
                    <div class="single_facilities col-xs-4 p0 painting photography adversting">
                       <div class="single_facilities_inner">
                          	<img src="images/gallery/sv-1.jpg" alt="">
                            <div class="gallery_hover">
                                <h4>Construction</h4>
                                <ul>
                                    <li><a href="#"><i class="fa fa-link" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="single_facilities col-xs-4 p0 webdesign">
                       <div class="single_facilities_inner">
                          	<img src="images/gallery/sv-2.jpg" alt="">
                            <div class="gallery_hover">
                                <h4>Construction</h4>
                                <ul>
                                    <li><a href="#"><i class="fa fa-link" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="single_facilities col-xs-4 painting p0 photography branding">
                       <div class="single_facilities_inner">
                          	<img src="images/gallery/sv-3.jpg" alt="">
                            <div class="gallery_hover">
                                <h4>Construction</h4>
                                <ul>
                                    <li><a href="#"><i class="fa fa-link" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="single_facilities col-xs-4 p0 adversting webdesign adversting">
                       <div class="single_facilities_inner">
                          	<img src="images/gallery/sv-4.jpg" alt="">
                            <div class="gallery_hover">
                                <h4>Construction</h4>
                                <ul>
                                    <li><a href="#"><i class="fa fa-link" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="single_facilities col-xs-4 p0 painting adversting branding">
                       <div class="single_facilities_inner">
                          	<img src="images/gallery/sv-5.jpg" alt="">
                            <div class="gallery_hover">
                                <h4>Construction</h4>
                                <ul>
                                    <li><a href="#"><i class="fa fa-link" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="single_facilities col-xs-4 p0 webdesign photography magazine adversting">
                       <div class="single_facilities_inner">
                          	<img src="images/gallery/sv-6.jpg" alt="">
                            <div class="gallery_hover">
                                <h4>Construction</h4>
                                <ul>
                                    <li><a href="#"><i class="fa fa-link" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End Our Services Area -->

    <!-- Our Team Area -->
    {{-- <section class="our_team_area">
        <div class="container">
            <div class="tittle wow fadeInUp">
                <h2>Our Team</h2>
                <h4>A property tax or millage rate is an ad valorem tax on the value of a property</h4>
            </div>
            <div class="row team_row">
                <div class="col-md-3 col-sm-6 wow fadeInUp">
                   <div class="team_membar">
                        <img src="images/team/tm-1.jpg" alt="">
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
                        <img src="images/team/tm-2.jpg" alt="">
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
                <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                   <div class="team_membar">
                        <img src="images/team/tm-3.jpg" alt="">
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
                <div class="col-md-3 col-sm-6 wow fadeInUp" data-wow-delay="0.4s">
                   <div class="team_membar">
                        <img src="images/team/tm-4.jpg" alt="">
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
    </section> --}}
    <!-- End Our Team Area -->

    <!-- Our Achievments Area -->
    {{-- <section class="our_achievments_area" data-stellar-background-ratio="0.3">
        <div class="container">
            <div class="tittle wow fadeInUp">
                <h2>Our Achievments</h2>
                <h4>A property tax or millage rate is an ad valorem tax on the value of a property</h4>
            </div>
            <div class="achievments_row row">
                <div class="col-md-3 col-sm-6 p0 completed">
                    <i class="fa fa-connectdevelop" aria-hidden="true"></i>
                    <span class="counter">800</span>
                    <h6>PROJECT COMPLETED</h6>
                </div>
                <div class="col-md-3 col-sm-6 p0 completed">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <span class="counter">230</span>
                    <h6>HOUSE RENOVATIONS</h6>
                </div>
                <div class="col-md-3 col-sm-6 p0 completed">
                    <i class="fa fa-child" aria-hidden="true"></i>
                    <span class="counter">1390</span>
                    <h6>WORKERS EMPLOYED</h6>
                </div>
                <div class="col-md-3 col-sm-6 p0 completed">
                    <i class="fa fa-trophy" aria-hidden="true"></i>
                    <span class="counter">125</span>
                    <h6>AWARDS WON</h6>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End Our Achievments Area -->

    <!-- Our Testimonial Area -->
    {{-- <section class="testimonial_area row">
        <div class="container">
            <div class="tittle wow fadeInUp">
                <h2>Our TESTIMONIALS</h2>
                <h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry</h4>
            </div>
            <div class="testimonial_carosel">
                <div class="item">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="images/testimonial-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Emran Khan</h4>
                            <h6>Web Developer</h6>
                        </div>
                    </div>
                    <p><i class="fa fa-quote-right" aria-hidden="true"></i>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio<i class="fa fa-quote-left" aria-hidden="true"></i></p>
                </div>
                <div class="item">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="images/testimonial-3.jpg" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Emran Khan</h4>
                            <h6>Web Developer</h6>
                        </div>
                    </div>
                    <p><i class="fa fa-quote-right" aria-hidden="true"></i>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio<i class="fa fa-quote-left" aria-hidden="true"></i></p>
                </div>
                <div class="item">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="images/testimonial-1.jpg" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Prodip ghosht</h4>
                            <h6>Brand Manager</h6>
                        </div>
                    </div>
                    <p><i class="fa fa-quote-right" aria-hidden="true"></i>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio<i class="fa fa-quote-left" aria-hidden="true"></i></p>
                </div>
                <div class="item">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="images/testimonial-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Jakaria Khan</h4>
                            <h6>Brand Manager</h6>
                        </div>
                    </div>
                    <p><i class="fa fa-quote-right" aria-hidden="true"></i>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio<i class="fa fa-quote-left" aria-hidden="true"></i></p>
                </div>
                <div class="item">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="images/testimonial-1.jpg" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Prodip ghosht</h4>
                            <h6>Brand Manager</h6>
                        </div>
                    </div>
                    <p><i class="fa fa-quote-right" aria-hidden="true"></i>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio<i class="fa fa-quote-left" aria-hidden="true"></i></p>
                </div>
                <div class="item">
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="images/testimonial-2.jpg" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Jakaria Khan</h4>
                            <h6>Brand Manager</h6>
                        </div>
                    </div>
                    <p><i class="fa fa-quote-right" aria-hidden="true"></i>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio<i class="fa fa-quote-left" aria-hidden="true"></i></p>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End Our testimonial Area -->

    <!-- Our Featured Works Area -->
    {{-- <section class="featured_works row" data-stellar-background-ratio="0.3">
        <div class="tittle wow fadeInUp">
            <h2>Our Featured Works</h2>
            <h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry</h4>
        </div>
        <div class="featured_gallery">
            <div class="col-md-3 col-sm-4 col-xs-6 gallery_iner p0">
                <img src="images/gallery/gl-1.jpg" alt="">
                <div class="gallery_hover">
                    <h4>Bolt Apartments</h4>
                    <a href="#">VIEW PROJECT</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 gallery_iner p0">
                <img src="images/gallery/gl-2.jpg" alt="">
                <div class="gallery_hover">
                    <h4>Bolt Apartments</h4>
                    <a href="#">VIEW PROJECT</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 gallery_iner p0">
                <img src="images/gallery/gl-3.jpg" alt="">
                <div class="gallery_hover">
                    <h4>Bolt Apartments</h4>
                    <a href="#">VIEW PROJECT</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 gallery_iner p0">
                <img src="images/gallery/gl-4.jpg" alt="">
                <div class="gallery_hover">
                    <h4>Bolt Apartments</h4>
                    <a href="#">VIEW PROJECT</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 gallery_iner p0">
                <img src="images/gallery/gl-5.jpg" alt="">
                <div class="gallery_hover">
                    <h4>Bolt Apartments</h4>
                    <a href="#">VIEW PROJECT</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 gallery_iner p0">
                <img src="images/gallery/gl-6.jpg" alt="">
                <div class="gallery_hover">
                    <h4>Bolt Apartments</h4>
                    <a href="#">VIEW PROJECT</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 gallery_iner p0">
                <img src="images/gallery/gl-7.jpg" alt="">
                <div class="gallery_hover">
                    <h4>Bolt Apartments</h4>
                    <a href="#">VIEW PROJECT</a>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-6 gallery_iner p0">
                <img src="images/gallery/gl-8.jpg" alt="">
                <div class="gallery_hover">
                    <h4>Bolt Apartments</h4>
                    <a href="#">VIEW PROJECT</a>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End Our Featured Works Area -->

    <!-- Our Latest Blog Area -->
    {{-- <section class="latest_blog_area">
        <div class="container">
            <div class="tittle wow fadeInUp">
                <h2>Our Latest Blog</h2>
                <h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry</h4>
            </div>
            <div class="row latest_blog">
                <div class="col-md-4 col-sm-6 blog_content">
                    <img src="images/blog/lb-1.jpg" alt="">
                    <a href="#" class="blog_heading">Our Latest Project</a>
                    <h4><small>by  </small><a href="#">Emran Khan</a><span>/</span><small>ON </small> October 15, 2016</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sagittis iaculis velit in tristique. Curabitur ac urna urna. Sed sollicitudin at nisi sed accumsan... <a href="#">Read More</a></p>
                </div>
                <div class="col-md-4 col-sm-6 blog_content">
                    <img src="images/blog/lb-2.jpg" alt="">
                    <a href="#" class="blog_heading">Our Latest Project</a>
                    <h4><small>by  </small><a href="#">Prodip Ghosh</a><span>/</span><small>ON </small> October 15, 2016</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sagittis iaculis velit in tristique. Curabitur ac urna urna. Sed sollicitudin at nisi sed accumsan... <a href="#">Read More</a></p>
                </div>
                <div class="col-md-4 col-sm-6 blog_content">
                    <img src="images/blog/lb-3.jpg" alt="">
                    <a href="#" class="blog_heading">Our Latest Project</a>
                    <h4><small>by  </small><a href="#">Prodip Ghosh</a><span>/</span><small>ON </small> October 15, 2016</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sagittis iaculis velit in tristique. Curabitur ac urna urna. Sed sollicitudin at nisi sed accumsan... <a href="#">Read More</a></p>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End Our Latest Blog Area -->

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
