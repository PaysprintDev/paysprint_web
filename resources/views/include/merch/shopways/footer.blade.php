<!-- copyright start -->
<section class="footer-copyright">
    <div class="container">
        <div class="row">
            <div class="col">
                <ul class="f-bottom">
                    <li class="f-c f-copyright">
                        <p>Copyright <i class="fa fa-copyright"></i> 2019 - {{ date('Y') }} PaySprint</p>
                    </li>

                    @isset($data['mystore'])
                        <li class="f-c">
                            <ul class="f-bottom">
                                <li class="f-social">

                                    @if ($data['mystore']->whatsapp != null)
                                        <a href="{{ $data['mystore']->whatsapp != null ? $data['mystore']->whatsapp : 'javascript:void()' }}"
                                            target="_blank" class="f-icn-link"><i class="fa fa-whatsapp"></i></a>
                                    @endif


                                    @if ($data['mystore']->facebook != null)
                                        <a href="{{ $data['mystore']->facebook != null ? $data['mystore']->facebook : 'javascript:void()' }}"
                                            target="_blank" class="f-icn-link"><i class="fa fa-facebook-f"></i></a>
                                    @endif


                                    @if ($data['mystore']->twitter != null)
                                        <a href="{{ $data['mystore']->twitter != null ? $data['mystore']->twitter : 'javascript:void()' }}"
                                            target="_blank" class="f-icn-link"><i class="fa fa-twitter"></i></a>
                                    @endif


                                    @if ($data['mystore']->instagram != null)
                                        <a href="{{ $data['mystore']->instagram != null ? $data['mystore']->instagram : 'javascript:void()' }}"
                                            class="f-icn-link"><i class="fa fa-instagram"></i></a>
                                    @endif



                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="f-c">
                            <ul class="f-bottom">
                                <li class="f-social">
                                    <a href="javascript:void(0)" target="_blank" class="f-icn-link"><i
                                            class="fa fa-whatsapp"></i></a>
                                    <a href="javascript:void(0)" target="_blank" class="f-icn-link"><i
                                            class="fa fa-facebook-f"></i></a>
                                    <a href="javascript:void(0)" target="_blank" class="f-icn-link"><i
                                            class="fa fa-twitter"></i></a>
                                    <a href="javascript:void(0)" class="f-icn-link"><i class="fa fa-instagram"></i></a>

                                </li>
                            </ul>
                        </li>
                    @endisset




                    <li class="f-c f-payment disp-0">
                        <a href="javascript:void(0)"><img src="{{ asset('shopassets/image/payment.png') }}"
                                class="img-fluid" alt="payment image"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- copyright end -->


{{-- <!-- newsletter pop-up start -->
<div class="vegist-popup animated modal fadeIn" id="myModal1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="popup-content">
                    <!-- popup close button start -->
                    <a href="javascript:void(0)" data-bs-dismiss="modal" aria-label="Close" class="close-btn"><i
                            class="ion-close-round"></i></a>
                    <!-- popup close button end -->
                    <!-- popup content area start -->
                    <div class="pop-up-newsletter" style="background-image: url(image/news-popup.jpg);">
                        <div class="logo-content">
                            <a href="index1.html"><img src="image/logo1.png" alt="image" class="img-fluid"></a>
                            <h4>Become a subscriber</h4>
                            <span>Subscribe to get the notification of latest posts</span>
                        </div>
                        <div class="subscribe-area">
                            <input type="text" name="comment" placeholder="Your email address">
                            <a href="index1.html" class="btn btn-style1">Subscribe</a>
                        </div>
                    </div>
                    <!-- popup content area end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- newsletter pop-up end --> --}}
