<!--====================  mobile menu overlay ====================-->
<div class="mobile-menu-overlay" id="mobile-menu-overlay">
    <div class="mobile-menu-overlay__inner">
        <div class="mobile-menu-overlay__header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6 col-8">
                        <!-- logo -->
                        <div class="logo">
                            <a href="index.html">
                                <img src="/merchantassets/service/assets/images/logo/logo-dark.webp" class="img-fluid"
                                    alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-4">
                        <!-- mobile menu content -->
                        <div class="mobile-menu-content text-end">
                            <span class="mobile-navigation-close-icon" id="mobile-menu-close-trigger"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-menu-overlay__body">
            <nav class="offcanvas-navigation">
                <ul>
                    <li class="">
                        <a href="{{ route('merchant service now', $data['user']->businessname) }}">Home</a>

                    </li>
                    <li class="">
                        <a href="#">Our Services</a>
                    </li>
                    <li class="">
                        <a href="#">Plan & Pricing</a>

                    </li>
                    <li class="">
                        <a href="#">Order</a>

                    </li>
                    <li class="">
                        <a href="#">Check Out</a>

                    </li>

                </ul>
            </nav>
        </div>
    </div>
</div>
<!--====================  End of mobile menu overlay  ====================-->
