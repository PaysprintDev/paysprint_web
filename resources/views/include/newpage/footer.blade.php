<!-- Footer section -->
<div class="footer-section bg-default-6">
    <div class="container">
        <div class="footer-top pt-15 pt-lg-25 pb-lg-19">
            <div class="row">
                <div class="col-6 col-lg-3">
                    <div class="single-footer mb-13 mb-lg-9">
                        <p class="footer-title gr-text-11 mb-7">ABOUT OUR COMPANY</p>
                        
                        <p>PaySprint is the fastest and affordable method of Sending and Receiving money, Paying Invoice and Getting Paid at anytime!</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="single-footer mb-13 mb-lg-9">
                        <p class="footer-title gr-text-11 mb-7">SERVICES</p>
                        <ul class="footer-list list-unstyled">
                        @guest
                            <li class="py-2"><a class="gr-text-9 gr-text-color" href="{{ route('my account') }}">Money Transfer</a></li>
                        @endguest

                        @auth
                            <li onclick="$('#sendMoney').click()"><a href="javascript:void()">Money Transfer</a></li>
                        @endauth

                        <li class="py-2"><a class="gr-text-9 gr-text-color" href="{{ route('invoice') }}">Pay Invoice</a></li>
                        <li class="py-2"><a class="gr-text-9 gr-text-color" href="{{ route('my account') }}">Wallet</a></li>



                        </ul>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="single-footer mb-13 mb-lg-9">
                        <p class="footer-title gr-text-11 mb-7">Quick Link</p>
                        <ul class="footer-list list-unstyled">
                            <li class="py-2"><a class="gr-text-9 gr-text-color" href="{{ route('about') }}">About us</a></li>
                            <li class="py-2"><a class="gr-text-9 gr-text-color" href="{{ route('contact') }}">Contact us</a></li>
                            <li class="py-2"><a class="gr-text-9 gr-text-color" href="{{ route('terms of use') }}">Terms of Use</a></li>
                            <li class="py-2"><a class="gr-text-9 gr-text-color" href="{{ route('privacy policy') }}">Privacy Policy</a></li>
                            @guest
                                <li class="py-2"><a class="gr-text-9 gr-text-color" href="{{ route('login') }}">Login</a></li>
                                <li class="py-2"><a class="gr-text-9 gr-text-color" href="{{ route('register') }}">Sign Up for FREE</a></li>
                            @endguest
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="single-footer mb-13 mb-lg-9">
                        <p class="footer-title gr-text-11 mb-7">Contact us</p>
                        <ul class="footer-list list-unstyled">
                            <li class="py-2"><a class="gr-text-9 text-primary font-weight-bold hover-underline active"
                                    href="mailto:info@paysprint.net"><i class="fa fa-envelope" aria-hidden="true"></i> info@paysprint.net</a></li>
                            <li class="py-2"><a class="gr-text-9 text-primary font-weight-bold hover-underline active"
                                    href="javascript:void()"><i class="fa fa-map-marker" aria-hidden="true"></i> PaySprint by Express Ca Corp,
                                    10 George St. North, Brampton. ON. L6X1R2. Canada</a></li>
                            <li class="py-2"><a class="gr-text-9 text-primary font-weight-bold hover-underline active"
                                    href="https://www.fintrac-canafe.gc.ca/intro-eng" target="_blank"><i class="fas fa-thumbtack" aria-hidden="true"></i> FINTRAC Reg No: M21469983</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-area border-top pt-9 pb-8">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <p class="copyright-text gr-text-11 mb-6 mb-lg-0 gr-text-color text-center text-lg-left">
                        © 2019 - {{ date('Y') }} Copyright, All Right Reserved
                    </p>
                </div>
                <div class="col-lg-6 text-center text-lg-right">
                    <ul class="social-icons list-unstyled mb-0 mr-n9">
                        <li class="gr-text-7"><a href="https://twitter.com/EXBC2" class="gr-text-color-opacity mr-9"><i
                                    class="icon icon-logo-twitter"></i></a></li>
                        <li class="gr-text-7"><a href="https://www.facebook.com/EXPRESSCANADA2014/?modal=admin_todo_tour" class="gr-text-color-opacity mr-9"><i
                                    class="icon icon-logo-facebook"></i></a></li>
                        <li class="gr-text-7"><a href="https://www.linkedin.com/company/exbc-canada/?viewAsMember=true" class="gr-text-color-opacity mr-9"><i
                                    class="icon icon-instant-camera-2"></i></a></li>
                        <li class="gr-text-7"><a href="https://www.linkedin.com/company/exbc-canada/?viewAsMember=true" class="gr-text-color-opacity mr-9"><i
                                    class="icon icon-logo-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>