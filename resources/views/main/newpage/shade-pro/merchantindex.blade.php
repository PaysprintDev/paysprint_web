
@extends('layouts.newpage.merchantapp')

@section('content')

<style>
  .circle-xxxl {
    max-width: 300px;
    min-width: 300px;
    max-height: 300px;
    min-height: 300px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
    
    <!-- Hero Area -->
    <div class="position-relative bg-default-2 bg-pattern pattern-2 pt-27 pt-lg-32 pb-15 pb-lg-27">
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-9 col-md-7 col-lg-5 offset-xl-1 align-self-sm-end order-lg-2">
            <div class="hero-img position-relative" data-aos="fade-left" data-aos-duration="500" data-aos-once="true">
              <img class="w-100" src="https://res.cloudinary.com/pilstech/image/upload/v1617797524/paysprint_asset/paysprint_jpeg_black_bk_ft8qly.jpg" alt="" style="border-radius: 100%;">
              <div class="gr-abs-tl gr-z-index-n1" data-aos="zoom-in" data-aos-delay="600" data-aos-duration="800" data-aos-once="true">
                <img src="{{ asset('newpage/image/l5/png/l5-dot-shape.png') }}" alt="">
              </div>
            </div>
          </div>
          <div class="col-11 col-md-10 col-lg-7 col-xl-6 order-lg-1" data-aos="fade-right" data-aos-duration="500" data-aos-once="true">
            <div class="hero-content mt-11 mt-lg-0">
              <h4 class="pre-title gr-text-12 text-red text-uppercase mb-7" style="font-size: 22px;">Let’s lift your business</h4>
              <h1 class="title gr-text-2 mb-8" style="font-size:60px">Create and Send Professional Invoices for FREE!</h1>
              <p class="gr-text-8 mb-11 pr-md-12">Create invoice at a click of a button and accept payment from customers with ease, anytime, anywhere!.</p>

              

              <div class="hero-btn">

                @guest
                    <a href="{{ route('AdminLogin') }}" class="btn btn-warning with-icon gr-hover-y">Get Started<i
                        class="icon icon-tail-right font-weight-bold"></i></a>
                @endguest


              </div>

              <a data-fancybox href="https://youtu.be/A6FGnRpcVok"
                        class="video-link gr-text-color mt-8 gr-flex-y-center justify-content-center justify-content-lg-start">
                        <span class="mr-2 gr-text-color circle-18 border border-black-dynamic">
                            <i class="icon icon-triangle-right-17-2 gr-text-14"></i>
                        </span>
                        <span class="gr-text-12 font-weight-bold text-uppercase" style="font-size: 16px;">How PaySprint
                            works</span>
                    </a>

                    <p class="gr-text-9 gr-text-color pr-md-7 font-weight-bold">
                        <br>
                        <hr>
                        <h5 class="font-weight-bold">Secure Environment</h5>
                       <i class="fas fa-circle" style="font-size: 12px; color: #f64b4b;"></i> Identity Verification  <i class="fas fa-circle" style="font-size: 12px; color: #f64b4b;"></i> Multi-level authentication <i class="fas fa-circle" style="font-size: 12px; color: #f64b4b;"></i> Full Encryption
                    </p>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Service section  -->
    <div class="service-section bg-default-4 pt-15 pb-13 py-lg-25 disp-0">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-6 col-lg-7 col-md-9">
            <div class="section-title text-center mb-11 mb-lg-19 px-lg-3">
              <h4 class="pre-title gr-text-12 text-red text-uppercase mb-7">Our services</h4>
              <h2 class="title gr-text-4">We provide great services for merchants based on needs</h2>
            </div>
          </div>
        </div>
        <div class="row justify-content-center position-relative gr-z-index-1">


          <div class="col-md-6 col-lg-4 mb-9 mb-lg-0" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
            <div class="service-card rounded-10 gr-hover-shadow-4 d-flex flex-column text-center pt-15 px-9 pb-11 dark-mode-texts bg-green h-100">
              <div class="card-img mb-11">
                <img src="{{ asset('newpage/image/l5/png/l5-service-card1.png') }}" alt="...">
              </div>
              <h3 class="card-title gr-text-6 mb-6">Professional Invoicing, Simplified!</h3>
              <p class="gr-text-9 mb-11">Create and send professional invoices with a click of a button. You can create and send a single invoice or a batch invoice including recurring payments, instalments and taxes!</p>
              <a href="{{ route('AdminLogin') }}" class="gr-text-9 btn-link with-icon text-white mt-auto">Get Started <i class="icon icon-tail-right"></i></a>
            </div>
          </div>


          <div class="col-md-6 col-lg-4 mb-9 mb-lg-0" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
            <div class="service-card rounded-10 gr-hover-shadow-4 d-flex flex-column text-center pt-15 px-9 pb-11 dark-mode-texts bg-blue h-100">
              <div class="card-img mb-11">
                <img src="{{ asset('newpage/image/l5/png/l5-service-card2.png') }}" alt="...">
              </div>
              <h3 class="card-title gr-text-6 mb-6">Accept Payments</h3>
              <p class="gr-text-9 mb-11">You have the option of selecting PaySprint, the seamless method of accepting payments, or use alternative payment gateways to accept payment to your PaySprint Wallet. Connect your bank account and have your payments ready for direct deposits. Customers can pay invoices using multiple methods: credit card, debit card, pre-paid. </p>
              <a href="{{ route('AdminLogin') }}" class="gr-text-9 btn-link with-icon text-white mt-auto">Get Started <i class="icon icon-tail-right"></i></a>
            </div>
          </div>
          
          <div class="col-md-6 col-lg-4 mb-9 mb-lg-0" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
            <div class="service-card rounded-10 gr-hover-shadow-4 d-flex flex-column text-center pt-15 px-9 pb-11 dark-mode-texts bg-red h-100">
              <div class="card-img mb-11">
                <img src="{{ asset('newpage/image/l5/png/l5-service-card3.png') }}" alt="...">
              </div>
              <h3 class="card-title gr-text-6 mb-6">Track Balances on invoice or by customer with ease</h3>
              <p class="gr-text-9 mb-11">We have made it easier for you to track balance on invoices when you enable the instalment feature on an invoice or for customer. Instalment payment help to give more choices to your customers. Generate timely statements for your business.</p>
              <a href="{{ route('AdminLogin') }}" class="gr-text-9 btn-link with-icon text-white mt-auto">Get Started <i class="icon icon-tail-right"></i></a>
            </div>
            <div class="gr-abs-br-custom gr-z-index-n1" data-aos="zoom-in-right" data-aos-delay="600" data-aos-duration="800" data-aos-once="true">
              <img src="{{ asset('newpage/image/l5/png/l5-dot-shape2.png') }}" alt="">
            </div>
          </div>
        </div>


      </div>
    </div>
    <!-- Testimonial section-1  -->
    <div class="testimonial-section1 bg-default-4 ">
      <div class="container">
          
        <div class="review-wrapper pt-9 pb-lg-25 pb-14 border-bottom">

            <div class="row justify-content-center">
          <div class="col-xl-6 col-lg-7 col-md-9">
            <div class="section-title text-center mb-11 mb-lg-19 px-lg-3">
              <h4 class="pre-title gr-text-12 text-red text-uppercase mb-7" style="font-size: 28px;"><strong>Our services</strong></h4>
              <h2 class="title gr-text-4">We provide great services for merchants based on needs</h2>
            </div>
          </div>
        </div>


          <div class="row justify-content-center align-items-center">
            
            <div class="col-xl-11 col-lg-12">
              <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">
                <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                  <img class="circle-xxxl" src="https://res.cloudinary.com/pilstech/image/upload/v1620218932/paysprint_asset/create_invoice_icljdw.png" alt="">
                </div>
                <div class="widget-text">
                  <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                  <h4 class="review-text gr-text-6 font-weight-bold mb-9">Professional Invoicing, Simplified!</h4>
                  <div class="reviewer-block d-flex flex-wrap">
                    <h5 class="name gr-text-9 mr-7 mb-md-0">Create and send professional invoices with a click of a button. You can create and send a single invoice or batch invoices and also set up recurring payments, instalments and taxes!</h5>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          
          <div class="row justify-content-center align-items-center pt-15">
            
            <div class="col-xl-11 col-lg-12">
              <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">

                <div class="widget-text">
                  <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                  <h4 class="review-text gr-text-6 font-weight-bold mb-9">Accept Payments</h4>
                  <div class="reviewer-block d-flex flex-wrap">
                    <h5 class="name gr-text-9 mr-7 mb-md-0">You have the option of selecting PaySprint, the seamless method of accepting payments, or use alternative payment gateways to accept payment to your PaySprint Wallet. Connect your bank account and have your payments ready for direct deposits. Customers can pay invoices using multiple methods: credit card, debit card, pre-paid. </h5>
                  </div>
                </div>

                <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                  <img class="circle-xxxl" src="https://res.cloudinary.com/pilstech/image/upload/v1620218932/paysprint_asset/Accept_more_payments_aao3ta.png" alt="">
                </div>
                
              </div>
            </div>
            
          </div>


          <div class="row justify-content-center align-items-center pt-15">
            
            <div class="col-xl-11 col-lg-12">
              <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">
                <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                  <img class="circle-xxxl" src="https://res.cloudinary.com/pilstech/image/upload/v1620218932/paysprint_asset/Track_balance_lnsutp.png" alt="">
                </div>
                <div class="widget-text">
                  <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                  <h4 class="review-text gr-text-6 font-weight-bold mb-9">Track Balances on invoice or by customer with ease</h4>
                  <div class="reviewer-block d-flex flex-wrap">
                    <h5 class="name gr-text-9 mr-7 mb-md-0">We have made it easier for you to track balance on invoices when you enable the instalment feature on an invoice or for customer. Instalment payment help to give more choices to your customers. Generate timely statements for your business. </h5>
                  </div>
                </div>
              </div>
            </div>
            
          </div>

          <div class="row justify-content-center align-items-center pt-15">
            
            <div class="col-xl-11 col-lg-12">
              <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">

                <div class="widget-text">
                  <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                  <h4 class="review-text gr-text-6 font-weight-bold mb-9">Business Performance Report</h4>
                  <div class="reviewer-block d-flex flex-wrap">
                    <h5 class="name gr-text-9 mr-7 mb-md-0">Reports enable you to manage and control your business activities. Have important statistics related to your business available with ease. PaySprint Merchant services provides you with robust reports including:

                        <ul style="list-style: none; text-align: left;">
                            <li>●	Sent Invoice</li>
                            <li>●	Paid Invoice</li>
                            <li>●	Unpaid (Pending) Invoice</li>
                            <li>●	Customer Balance Report</li>
                            <li>●	Taxes Report</li>
                            <li>●	Invoice Type Report</li>
                            <li>●	Recurring invoice report</li>
                            <li>●	Wallet Transaction History</li>
                        </ul>

                    </h5>

                    

                  </div>
                </div>

                <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                  <img class="circle-xxxl" src="https://res.cloudinary.com/pilstech/image/upload/v1620218932/paysprint_asset/Generate_report_txk53f.png" alt="">
                </div>
                
              </div>
            </div>
            
          </div>



          <div class="row justify-content-center align-items-center pt-15">
            
            <div class="col-xl-11 col-lg-12">
              <div class="review-widget media align-items-center px-lg-7 flex-column flex-sm-row">
                <div class="widget-image mr-12 mr-lg-19 mb-9 mb-md-0">
                  <img class="circle-xxxl" src="https://res.cloudinary.com/pilstech/image/upload/v1620219151/paysprint_asset/Additional_feature_bd4ib0.png" alt="">
                </div>
                <div class="widget-text">
                  <img class="rating mb-11" src="{{ asset('newpage/image/l5/png/5-stars.png') }}" alt="">
                  <h4 class="review-text gr-text-6 font-weight-bold mb-9">Additional Features</h4>
                  <div class="reviewer-block d-flex flex-wrap">
                    <h5 class="name gr-text-9 mr-7 mb-md-0">PaySprint Merchant Services is filled with more additional features. Get the full advantage with PaySprint. 

                        <ul style="list-style: none; text-align: left;">
                            <li>●	Manage Your Business On Any Device, (Mobile, Web etc)</li>
                            <li>●	Free Lead Generation</li>
                            <li>●	Connect Your Preferred Accounting Software.</li>
                            <li>●	Invite Your Accountant.</li>
                            <li>●	Safe and Secure Multi-Level Security and Authentication Features</li>
                        </ul>


                    </h5>
                  </div>
                </div>
              </div>
            </div>
            
          </div>



        </div>
      </div>
    </div>
    <!-- Content About section  -->
    <div class="content-section bg-default-4 pt-lg-25 pt-15 pb-10 pb-lg-15 disp-0">
      <div class="container">
        <div class="row">
          <div class="col-xl-6 col-lg-7 col-md-8">
            <div class="section-title mb-13">
              <h4 class="pre-title gr-text-12 text-red text-uppercase mb-9">Our Story</h4>
              <h2 class="title gr-text-4">We know how everything works and why your business is failing over and over again.</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-5">
            <div class="about-image img-big pt-lg-13" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
              <img class="w-100 rounded-10" src="{{ asset('') }}newpage/image/l5/jpg/l5-about-big.jpg" alt="">
            </div>
          </div>
          <div class="col-lg-7">
            <div class="row justify-content-between align-items-center pl-lg-13">
              <div class="col-md-6">
                <div class="about-image img-mid mt-9 mt-lg-0" data-aos="fade-up" data-aos-duration="900" data-aos-once="true">
                  <img class="w-100 rounded-10" src="{{ asset('') }}newpage/image/l5/jpg/l5-about-mid.jpg" alt="">
                  <div class="abs-pattern gr-abs-tr-custom" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="300" data-aos-once="true">
                    <img src="{{ asset('') }}newpage/image/l5/png/l5-about-pattern.png" alt="">
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="about-image img-sm mt-9 mt-lg-0" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
                  <img class="rounded-10" src="{{ asset('') }}newpage/image/l5/jpg/l5-about-sm.jpg" alt="">
                </div>
              </div>
              <div class="col-xl-10">
                <div class="about-content mt-12 mt-lg-23">
                  <p class="gr-text-9">We share common trends and strategies for improving your rental income and making sure you stay in high demand. With lots of unique blocks, you can easily build a page without coding. Build your next landing page.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fact Counter section -->
    <div class="fact-section bg-default-4 pt-lg-15 pb-7 pb-lg-24 disp-0">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 col-sm-6 mb-9 mb-lg-0">
            <div class="single-fact text-center px-xl-6">
              <h3 class="title mb-7 gr-text-3">1M+</h3>
              <p class="gr-text-8 mb-0">Customers visit Albino every month to get their service done.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 mb-9 mb-lg-0">
            <div class="single-fact text-center px-xl-6">
              <h3 class="title mb-7 gr-text-3"><span class="counter">92</span>%</h3>
              <p class="gr-text-8 mb-0">Satisfaction rate comes from our awesome customers.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 mb-9 mb-lg-0">
            <div class="single-fact text-center px-xl-6">
              <h3 class="title mb-7 gr-text-3"><span class="counter">4.9</span>/5.0</h3>
              <p class="gr-text-8 mb-0">Average customer ratings we have got all over internet.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Feature section -->
    <div class="feature-section pt-14 pt-lg-25 pb-7 pb-lg-11 bg-default-2 disp-0">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-6 col-lg-7 col-md-8">
            <div class="section-title text-center mb-13 mb-lg-23">
              <h4 class="pre-title gr-text-12 text-red text-uppercase mb-7">Why choose us</h4>
              <h2 class="title gr-text-4">People choose us because we serve the best for everyone</h2>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-10">
            <div class="row align-items-center justify-content-center">
              <div class="col-lg-6 col-md-10 mb-11 mb-lg-19" data-aos="fade-left" data-aos-duration="800" data-aos-delay="200" data-aos-once="true">
                <div class="feature-widget media">
                  <div class="widget-icon p-7 rounded-15 mr-9 gr-bg-blue-opacity-1">
                    <img src="{{ asset('') }}newpage/image/svg/l5-feature-icon1.svg" alt="">
                  </div>
                  <div class="widget-text">
                    <h3 class="title gr-text-7 mb-6">Dedicated project manager</h3>
                    <p class="gr-text-9 mb-0 pr-11">With lots of unique blocks, you can easily build a page without coding. Build your next landing page.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-10 mb-11 mb-lg-19" data-aos="fade-left" data-aos-duration="800" data-aos-delay="400" data-aos-once="true">
                <div class="feature-widget media">
                  <div class="widget-icon p-7 rounded-15 mr-9 gr-bg-red-opacity-1">
                    <img src="{{ asset('') }}newpage/image/svg/l5-feature-icon2.svg" alt="">
                  </div>
                  <div class="widget-text">
                    <h3 class="title gr-text-7 mb-6">Organized tasks</h3>
                    <p class="gr-text-9 mb-0 pr-11">With lots of unique blocks, you can easily build a page without coding. Build your next landing page.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-10 mb-11 mb-lg-19" data-aos="fade-right" data-aos-duration="800" data-aos-delay="600" data-aos-once="true">
                <div class="feature-widget media">
                  <div class="widget-icon p-7 rounded-15 mr-9 gr-bg-green-opacity-1">
                    <img src="{{ asset('') }}newpage/image/svg/l5-feature-icon3.svg" alt="">
                  </div>
                  <div class="widget-text">
                    <h3 class="title gr-text-7 mb-6">Easy feedback sharing</h3>
                    <p class="gr-text-9 mb-0 pr-11">With lots of unique blocks, you can easily build a page without coding. Build your next landing page.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-10 mb-11 mb-lg-19" data-aos="fade-right" data-aos-duration="800" data-aos-delay="800" data-aos-once="true">
                <div class="feature-widget media">
                  <div class="widget-icon p-7 rounded-15 mr-9 gr-bg-blackish-blue-opacity-1">
                    <img src="{{ asset('') }}newpage/image/svg/l5-feature-icon4.svg" alt="">
                  </div>
                  <div class="widget-text">
                    <h3 class="title gr-text-7 mb-6">Never miss deadline</h3>
                    <p class="gr-text-9 mb-0 pr-11">With lots of unique blocks, you can easily build a page without coding. Build your next landing page.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CTA section -->
    <div class="cta-section bg-default-2 disp-0">
      <div class="container">
        <div class="cta-wrapper pt-13 pb-14 py-lg-19 border-top ">
          <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
              <div class="cta-text section-title">
                <h2 class="title gr-text-5 mb-7">Ready to launch your next project?</h2>
                <p class="gr-text-8 mb-8 mb-lg-0">With lots of unique blocks, you can easily build a page without coding. Build your next landing page.</p>
              </div>
            </div>
            <div class="col-lg-4 offset-lg-2 col-md-10">
              <div class="cta-btn text-lg-right">
                <a href="#" class="btn gr-hover-y btn-primary rounded-8">Get started on a project</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Case Studies section  -->
    <div class="case-section pt-15 pb-14 py-lg-25 disp-0">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-6 col-lg-7 col-md-8">
            <div class="section-title text-center mb-11 mb-lg-21">
              <h3 class="sub-badge gr-text-12 text-uppercase text-red mb-7">Case studies</h3>
              <h2 class="title gr-text-4 mb-0">Our works describe why we are the best in the business</h2>
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card-columns mb-lg-9">
              <div class="single-case d-inline-block px-md-6 mb-3 mb-lg-9 gr-hover-rotate-img">
                <div class="case-img overflow-hidden">
                  <img src="{{ asset('') }}newpage/image/l5/jpg/l5-case1.jpg" alt="" class="w-100 rounded-10">
                </div>
                <div class="case-content px-5 px-md-9 py-9">
                  <span class="case-category gr-text-11 mb-2 d-inline-block gr-text-color-opacity">Graphic Design</span>
                  <h3 class="case-title gr-text-6 mb-0">Aura Branding Design</h3>
                </div>
              </div>
              <div class="single-case d-inline-block px-md-6 mb-3 mb-lg-9 gr-hover-rotate-img">
                <div class="case-img overflow-hidden">
                  <img src="{{ asset('') }}newpage/image/l5/jpg/l5-case2.jpg" alt="" class="w-100 rounded-10">
                </div>
                <div class="case-content px-5 px-md-9 py-9">
                  <span class="case-category gr-text-11 mb-2 d-inline-block gr-text-color-opacity">Web Development</span>
                  <h3 class="case-title gr-text-6 mb-0">Gradient Website Development</h3>
                </div>
              </div>
              <div class="single-case d-inline-block px-md-6 mb-3 mb-lg-9 gr-hover-rotate-img">
                <div class="case-img overflow-hidden">
                  <img src="{{ asset('') }}newpage/image/l5/jpg/l5-case3.jpg" alt="" class="w-100 rounded-10">
                </div>
                <div class="case-content px-5 px-md-9 py-9">
                  <span class="case-category gr-text-11 mb-2 d-inline-block gr-text-color-opacity">Graphic Design</span>
                  <h3 class="case-title gr-text-6 mb-0">AB.S Snack Packaging</h3>
                </div>
              </div>
              <div class="single-case d-inline-block px-md-6 mb-3 mb-lg-9 gr-hover-rotate-img">
                <div class="case-img overflow-hidden">
                  <img src="{{ asset('') }}newpage/image/l5/jpg/l5-case4.jpg" alt="" class="w-100 rounded-10">
                </div>
                <div class="case-content px-5 px-md-9 py-9">
                  <span class="case-category gr-text-11 mb-2 d-inline-block gr-text-color-opacity">Content Writing</span>
                  <h3 class="case-title gr-text-6 mb-0">Magazine Content Writing</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="more-btn case-btn text-center">
              <a href="#" class="btn-link with-icon mb-0 gr-text-7 font-weight-bold">See all works<i class="icon icon-tail-right font-weight-bold"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Testimonial section 2 -->
    <div class="testimonial-section2 position-relative bg-blue dark-mode-texts bg-pattern pattern-4 pt-14 pt-lg-26 pb-14 pb-lg-26 disp-0">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8 col-lg-7 col-xl-6">
            <div class="section-title text-center mb-9">
              <h4 class="pre-title gr-text-12 text-green text-uppercase mb-0">Testimonial</h4>
            </div>
          </div>
        </div>
        <div class="row align-items-center justify-content-around">
          <div class="col-lg-7 col-md-9">
            <div class="single-testimonial text-center">
              <h3 class="review-text gr-text-5 mb-11">“Simply the best. Better than all the rest. I’d recommend this product to beginners and advanced users.”</h3>
              <div class="reviewer-img mb-7">
                <img class="circle-lg mx-auto" src="{{ asset('') }}newpage/image/l5/jpg/l5-testimonial2.jpg" alt="">
              </div>
              <h3 class="username gr-text-9 mb-1">Ian Klein</h3>
              <span class="rank gr-text-11 gr-text-color-opacity">Digital Marketer</span>
            </div>
          </div>
        </div>
      </div>
    </div>


    
<!-- CTA section -->
<div class="cta-section pt-15 pt-lg-30 pb-5 pb-lg-5 bg-pattern pattern-7" style="background-color: #f2f2f2 !important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="text-center dark-mode-texts">
                    <h2 class="gr-text-4 mb-7" style="color: #433d3d;">DOWNLOAD OUR APP</h2>
                    
                    <a href="https://play.google.com/store/apps/details?id=com.fursee.damilare.sprint_mobile" target="_blank" class="btn text-white gr-hover-y px-lg-9">
                        <img src="https://res.cloudinary.com/pilstech/image/upload/v1620148943/paysprint_asset/l6-download-gplay_o9rcfj.png" alt="play store">
                    </a>
                    <a href="#" class="btn text-white gr-hover-y px-lg-9">
                        <img src="https://res.cloudinary.com/pilstech/image/upload/v1620148943/paysprint_asset/l6-download-appstore_odcskf.png" alt="apple store">
                    </a>
                    <p class="gr-text-11 mb-0 mt-6" style="color: #433d3d;">It takes only 2 mins!</p>
                </div>

                <div class="hero-img" data-aos="fade-left" data-aos-duration="500" data-aos-once="true">
                  <div class="hero-video-thumb position-relative gr-z-index-1">
                    <center>
<img src="https://res.cloudinary.com/pilstech/image/upload/v1617797524/paysprint_asset/paysprint_jpeg_black_bk_ft8qly.jpg" alt="" class="w-100 rounded-8" style="height: 350px !important;width: 350px !important;">
</center>
                    <a class="video-play-trigger gr-abs-center bg-white circle-xl gr-flex-all-center gr-abs-hover-y focus-reset" data-fancybox="" href="https://youtu.be/A6FGnRpcVok" tabindex="-1"><i class="icon icon-triangle-right-17-2"></i></a>
                    {{-- <div class="abs-shape gr-abs-tr-custom gr-z-index-n1">
                      <img src="{{ asset('newpage/image/l4/png/l4-hero-shape.png') }}" alt="" class="w-100" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="800" data-aos-once="true">
                    </div> --}}
                  </div>
                </div>

            </div>

            <div class="col-md-3">
                <center>
                    <img class="shadow-lg" src="https://res.cloudinary.com/pilstech/image/upload/v1621266225/paysprint_icon_opahry.webp" alt="mobile app" style="width: 80%; border-radius: 10px; position: relative; z-index: 1000;">
                </center>
            </div>

        </div>
    </div>
</div>


@endsection
