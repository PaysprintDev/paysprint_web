
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


  @if (isset($data['pauline']))
          <!-- Hero Area -->
    <div class="position-relative bg-default-2 bg-pattern pattern-2 pt-27 pt-lg-32 pb-15 pb-lg-27">
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-9 col-md-7 col-lg-5 offset-xl-1 align-self-sm-end order-lg-2">
            <div class="hero-img position-relative" data-aos="fade-left" data-aos-duration="500" data-aos-once="true">
              <img class="w-100" src="https://res.cloudinary.com/pilstech/image/upload/v1630671415/paysprint_asset/1_erelil.jpg" alt="" style="border-radius: 20% 0% 10% 0%;">
              <div class="gr-abs-tl gr-z-index-n1" data-aos="zoom-in" data-aos-delay="600" data-aos-duration="800" data-aos-once="true">
                <img src="{{ asset('newpage/image/l5/png/l5-dot-shape.png') }}" alt="">
              </div>
            </div>
          </div>
          <div class="col-11 col-md-10 col-lg-7 col-xl-6 order-lg-1" data-aos="fade-right" data-aos-duration="500" data-aos-once="true">
            <div class="hero-content mt-11 mt-lg-0">
              <h4 class="pre-title gr-text-12 text-red text-uppercase mb-7" style="font-size: 22px;">Thank you for reaching out</h4>
              <h1 class="title gr-text-2 mb-8" style="font-size:60px">One hundred percent of donations will go to the cause.</h1>

              

              <div class="hero-btn" id="donate">

                    <a href="{{ url('payment/sendmoney/'.$data['pauline']->ref_code.'?country=Canada') }}" class="btn btn-warning with-icon gr-hover-y">Donate Today<i
                        class="icon icon-tail-right font-weight-bold"></i></a>

              </div>


               
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- Content About section  -->
    <div class="content-section bg-default-4 pt-lg-10 pt-10 pb-10 pb-lg-15">
      <div class="container">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="section-title mb-13">
              <h5 style="font-weight: normal;">Hi, my name is Pauline from Toronto, Canada; On August 14th Haiti was hit by a powerful 7.2 magnitude earthquake which devastated the island causing substantial damage. The death toll has been climbing and is now over 2,000 and continuing to rise day by day with over 12,000 injured by the quake so far and many are still missing. It has been reported that an estimated 30,000 families have been left homeless.</h5>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="section-title mb-13">
              <h5 style="font-weight: normal;">Since 2012, I have been doing work with various organizations in Haiti including Ohape and Kofaviv and I was deeply touched to see the destruction caused by the earthquake and 2 days later a tropical storm bringing strong winds and torrential rain adding further distress.</h5>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="section-title mb-13">
              <h5 style="font-weight: normal;">When I visted Kofaviv back in 2013, I met Michelle, and I have been working with her in the local community of Port-au-Prince.  She reached out to me in tears and asked if I could help her family and her community who have been affected by the earthquake. She told me there were hundreds of people with no home and no food; she has been trying to assist people the best she can but with no supplies, it has been both discouraging and challenging but puts on a brave face as she helps her fellow Haitians. As I listened to her, I was compelled to do something for her and her community. So, I reached out to a group of people here in Toronto to join me in an effort to donate funds and organize barrels with much needed daily essential items. Getting the supplies to her is crucial; as she will be able to distribute them to individuals and areas who need it the most.</h5>
            </div>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="section-title mb-13">
              <h5 style="font-weight: normal;">The goal was to send 10 barrels at 200 each. However,  with the generosity of donors and the church, we exceeded our goal. Twelve (12) barrels were shipped to Haiti. So Grateful 🙏 </h5>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4">
            <div class="card" style="width: 100%;">
              <img class="card-img-top" src="https://res.cloudinary.com/pilstech/image/upload/v1630676719/paysprint_asset/7_lrcvkp.jpg" alt="Card image cap">
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card" style="width: 100%;">
              <img class="card-img-top" src="https://res.cloudinary.com/pilstech/image/upload/v1630676718/paysprint_asset/6_v8honr.jpg" alt="Card image cap">
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card" style="width: 100%;">
              <img class="card-img-top" src="https://res.cloudinary.com/pilstech/image/upload/v1630676718/paysprint_asset/4_lii9du.jpg" alt="Card image cap">
            </div>
          </div>


          <div class="col-lg-12">
            <div class="row justify-content-between align-items-center pl-lg-13">
              
              <div class="col-xl-12">
                <div class="about-content mt-3 mt-lg-10">
                  <p class="gr-text-9">However, the long term need continues. Any additional funds will be used to purchase items that was not received by donors, hire a truck and a driver to transport barrels from Port Au Prince to the affected areas upon arrival and also continued support of food and daily essential items to the victims.</p>
                </div>
                <div class="about-content mt-2">
                  <p class="gr-text-9">We will appreciate your help of any amount for this worthy cause.</p>
                </div>
                <div class="about-content mt-2">
                  <p class="gr-text-9">On behalf of everyone involved and the victims in Haiti, Thank You</p>
                </div>
                <div class="about-content mt-2">
                  <p class="gr-text-9">Pauline Martin</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fact Counter section -->

    <!-- CTA section -->
    <div class="cta-section bg-default-2">
      <div class="container">
        <div class="cta-wrapper pt-13 pb-14 py-lg-19 border-top ">
          <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
              <div class="cta-text section-title">
                <h2 class="title gr-text-5 mb-7">THANK YOU FOR REACHING OUT</h2>
                <p class="gr-text-8 mb-8 mb-lg-0">One hundred percent of donations will go to the cause.</p>
              </div>
            </div>
            <div class="col-lg-4 offset-lg-2 col-md-10">
              <div class="cta-btn text-lg-right">
                <a href="{{ url('payment/sendmoney/'.$data['pauline']->ref_code.'?country=Canada') }}" class="btn gr-hover-y btn-primary rounded-8">Donate Today</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @else
      <!-- CTA section -->
    <div class="position-relative bg-default-2 bg-pattern pattern-2 pt-27 pt-lg-32 pb-15 pb-lg-27 cta-section bg-default-2">
      <div class="container">
        <div class="cta-wrapper pt-13 pb-14 py-lg-19 border-top ">
          <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
              <div class="cta-text section-title">
                <h2 class="title gr-text-5 mb-7">THE DONATION LINK IS NOT AVAILABLE FOR YOUR COUNTRY</h2>
              </div>
            </div>
            <div class="col-lg-4 offset-lg-2 col-md-10">
              <div class="cta-btn text-lg-right">
                <a href="{{ route('home') }}" class="btn gr-hover-y btn-primary rounded-8">Goto Homepage</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  @isset($data['pauline'])
        <div class='sharethis-sticky-share-buttons' data-url='{{ url('payment/sendmoney/'.$data['pauline']->ref_code.'?country=Canada') }}'></div>
    

<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5f6b67da4174d700123667de&product=sticky-share-buttons" async="async"></script>
  @endisset





@endsection
