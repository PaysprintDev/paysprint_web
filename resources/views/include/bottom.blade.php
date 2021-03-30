<!--Footer Area -->
    <footer class="footer_area">
        <div class="container">
            <div class="footer_row row">
                <div class="col-md-3 col-sm-6 footer_about">
                    <h2>ABOUT OUR COMPANY</h2>
                    {{-- <p style="font-weight: bold; font-size: 30px;">Pay<span style="color: #f6b60b">Sprint</span></p> --}}
                    <img src="https://res.cloudinary.com/pilstech/image/upload/v1603726392/pay_sprint_white_horizotal_mb5ouw.png" style="position: relative; left: -40px;">
                    {{-- <p>Payca or electronic bill payment, is when a seller such as company, organization, or group sends its bills or invoices over the internet, and customers pay the bills electronically.</p> --}}
                    <p>PaySprint is the fastest method of Sending and Receiving money, Paying Invoice and Getting Paid at anytime!</p>
                    <ul class="socail_icon">
                        <li><a href="https://www.facebook.com/EXPRESSCANADA2014/?modal=admin_todo_tour" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="https://twitter.com/EXBC2" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>

                        <li><a href="https://instagram.com/exbc2014" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>

                        <li><a href="https://www.linkedin.com/company/exbc-canada/?viewAsMember=true" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer_about quick">
                    <h2>Services</h2>
                    <ul class="quick_link">
                        <li><a href="#"><i class="fa fa-chevron-right"></i>Money Transfer</a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i>Pay Invoice</a></li>
                        <li><a href="#"><i class="fa fa-chevron-right"></i>Wallet</a></li>
                        {{-- <li><a href="#"><i class="fa fa-chevron-right"></i>Parking Tickets</a></li> --}}
                        {{-- <li><a href="#"><i class="fa fa-chevron-right"></i>Commercial Construction</a></li> --}}
                        {{-- <li><a href="#"><i class="fa fa-chevron-right"></i>Concreate Transport</a></li> --}}
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer_about">
                    <h2>Quick link</h2>
                    <ul class="quick_link">
                        <li><a href="{{ route('about') }}"><i class="fa fa-chevron-right"></i>About Us</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fa fa-chevron-right"></i>Contact Us</a></li>
                        <li><a href="{{ route('terms of use') }}"><i class="fa fa-chevron-right"></i>Terms of Use</a></li>
                        <li><a href="{{ route('privacy policy') }}"><i class="fa fa-chevron-right"></i>Privacy Policy</a></li>
                        @guest
                            <li><a href="{{ route('login') }}"><i class="fa fa-chevron-right"></i>Login</a></li>
                        <li><a href="{{ route('register') }}"><i class="fa fa-chevron-right"></i>Sign Up for FREE</a></li>
                        @endguest
                        


                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 footer_about">
                    <h2>CONTACT US</h2>
                    <address>
                        <ul class="my_address">
                            <li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>info@paysprint.net</a></li><br>
                            <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i><span> PaySprint, by Express Ca Corp, <br> 10 George St. North, Brampton. ON. L6X1R2. Canada </span></a></li>
                        </ul>
                    </address>
                </div>
            </div>
        </div>
        <div class="copyright_area">
            Copyright 2019 All rights reserved.
        </div>
    </footer>
    <!-- End Footer Area -->
