        <!-- Page Sidebar Start-->
        <header class="main-nav">
            <div class="sidebar-user text-center">
                <a class="setting-primary" href="javascript:void(0)"><i data-feather="settings"></i></a><img
                    class="img-90 rounded-circle" src=" {{ asset('merchantassets/assets/images/dashboard/01.jpg') }}" alt="" />
                <div class="badge-bottom"><span class="badge badge-primary"></span></div>
                <a href="{{ route('profile') }}">
                    <h6 class="mt-3 f-14 f-w-600">Double Major</h6>
                </a>
                <p class="mb-0 font-roboto">Music Producer, Web Developer</p>

                {{-- <ul>
                    <li>
                        <span><span class="counter">19.8</span>k</span>
                        <p>Follow</p>
                    </li>
                    <li>
                        <span>2 year</span>
                        <p>Experince</p>
                    </li>
                    <li>
                        <span><span class="counter">95.2</span>k</span>
                        <p>Follower</p>
                    </li>
                </ul> --}}
            </div>
            <nav>
                <div class="main-navbar">
                    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                    <div id="mainnav">
                        <ul class="nav-menu custom-scrollbar">
                            <li class="back-btn">
                                <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                        aria-hidden="true"></i></div>
                            </li>
                            <li class="sidebar-main-title">
                                <div>
                                    <h6>MAIN NAVIGATION</h6>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title active" href="javascript:void(0)"><i
                                        data-feather="home"></i><span style="color: #24695c;">Menu</span></a>
                                <ul class="nav-submenu menu-content" style="display: block;">
                                    <li><a href="{{ route('dashboard') }}" class="active">Dashboard</a></li>
                                    <li><a href="dashboard/dashboard-02.html" class="">Main Page</a></li>
                                </ul>
                            </li>



                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Billing Tools</h6>
                                </div>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="shopping-bag"></i><span>Create & Send Invoice</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li>
                                        <a class="submenu-title  " href="javascript:void(0)">
                                            Single<span class="sub-arrow"><i
                                                    class="fa fa-chevron-right"></i></span>
                                        </a>
                                        <ul class="nav-sub-childmenu submenu-content" style="display: none;">
                                            <li><a href="{{ route('invoice form') }}" class="">Customer
                                                    on PS
                                                </a></li>
                                            <li><a href="{{ route('invoice form') }}" class="">Customer
                                                    not on PS</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li onclick="comingSoon()"><a href="javascript:void()"><i
                                                class="fa fa-circle-o text-red"></i>
                                            Batch [Coming Soon]</a></li>

                                </ul>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="{{ route('invoice types') }}"><i
                                        data-feather="file-text"></i><span>Create Invoice Type</span></a>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="layers"></i><span>Payment Gateway</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li>
                                        <a class="submenu-title  " href="{{ route('payment gateway') }}">
                                            Payment Method<span class="sub-arrow"><i
                                                    class="fa fa-chevron-right"></i></span>
                                        </a>

                                    </li>



                                </ul>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="{{ route('set up tax') }}"><i
                                        data-feather="file-text"></i><span>Set Up Tax</span></a>
                            </li>

                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Payments</h6>
                                </div>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="{{ route('ordering system') }}"><i
                                        data-feather="database"></i><span>Ordering System</span></a>
                            </li>

                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Your Business</h6>
                                </div>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="clock"></i><span>Transaction History</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="{{ route('invoice statement') }}" class="">Invoice</a>
                                    </li>
                                    <li><a href="{{ route('wallet statement') }}" class="">Wallet</a>
                                    </li>

                                </ul>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="aperture"></i><span>Performance Report</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="{{ route('sent invoice') }}" class="">Sent Invoice</a>
                                    </li>
                                    <li><a href="{{ route('paid invoice') }}" class="">Paid Invoice</a>
                                    </li>
                                    <li><a href="{{ route('pending invoice') }}" class="">Unpaid
                                            Invoice</a></li>
                                    <li><a href="{{ route('balance report') }}" class="">Customer
                                            Balance Report</a></li>

                                    <li><a href="{{ route('taxes report') }}" class="">Taxes Report</a>
                                    </li>
                                    <li><a href="{{ route('invoice type report') }}" class="">Invoice
                                            Type Report</a></li>
                                    <li><a href="{{ route('recurring type') }}" class="">Recurring
                                            Invoice Report</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav "
                                    href="https://paysprint.ca/api/documentation"><i
                                        data-feather="file-text"></i><span>API Integration</span></a>
                            </li>

                            <li class="sidebar-main-title">
                                <div>
                                    <h6> </h6>
                                </div>
                            </li>

                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="server"></i><span>Settings</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="{{ route('profile') }}" class="">Profile</a></li>
                                </ul>
                            </li>








                            {{-- <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="folder-plus"></i><span>Bonus Ui</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="bonus-ui/scrollable.html" class="">Scrollable</a></li>
                                    <li><a href="bonus-ui/tree.html" class="">Tree view</a></li>
                                    <li><a href="bonus-ui/bootstrap-notify.html" class="">Bootstrap
                                            Notify</a></li>
                                    <li><a href="bonus-ui/rating.html" class="">Rating</a></li>
                                    <li><a href="bonus-ui/dropzone.html" class="">dropzone</a></li>
                                    <li><a href="bonus-ui/tour.html" class="">Tour</a></li>
                                    <li><a href="bonus-ui/sweet-alert2.html" class="">SweetAlert2</a></li>
                                    <li><a href="bonus-ui/modal-animated.html" class="">Animated Modal</a>
                                    </li>
                                    <li><a href="bonus-ui/owl-carousel.html" class="">Owl Carousel</a>
                                    </li>
                                    <li><a href="bonus-ui/ribbons.html" class="">Ribbons</a></li>
                                    <li><a href="bonus-ui/pagination.html" class="">Pagination</a></li>
                                    <li><a href="bonus-ui/steps.html" class="">Steps</a></li>
                                    <li><a href="bonus-ui/breadcrumb.html" class="">Breadcrumb</a></li>
                                    <li><a href="bonus-ui/range-slider.html" class="">Range Slider</a>
                                    </li>
                                    <li><a href="bonus-ui/image-cropper.html" class="">Image cropper</a>
                                    </li>
                                    <li><a href="bonus-ui/sticky.html" class="">Sticky </a></li>
                                    <li><a href="bonus-ui/basic-card.html" class="">Basic Card</a></li>
                                    <li><a href="bonus-ui/creative-card.html" class="">Creative Card</a>
                                    </li>
                                    <li><a href="bonus-ui/tabbed-card.html" class="">Tabbed Card</a></li>
                                    <li><a href="bonus-ui/dragable-card.html" class="">Draggable Card</a>
                                    </li>
                                    <li>
                                        <a class="submenu-title " href="javascript:void(0)">
                                            Timeline<span class="sub-arrow"><i
                                                    class="fa fa-chevron-right"></i></span>
                                        </a>
                                        <ul class="nav-sub-childmenu submenu-content" style="display: none;">
                                            <li><a href="bonus-ui/timeline-v-1.html" class="">Timeline
                                                    1</a></li>
                                            <li><a href="bonus-ui/timeline-v-2.html" class="">Timeline
                                                    2</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="edit-3"></i><span>Builders</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="builders/form-builder-1.html" class="">Form Builder 1</a>
                                    </li>
                                    <li><a href="builders/form-builder-2.html" class="">Form Builder 2</a>
                                    </li>
                                    <li><a href="builders/pagebuild.html" class="">Page Builder</a></li>
                                    <li><a href="builders/button-builder.html" class="">Button Builder</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="cloud-drizzle"></i><span>Animation</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="animation/animate.html" class="">Animate</a></li>
                                    <li><a href="animation/scroll-reval.html" class="">Scroll Reveal</a>
                                    </li>
                                    <li><a href="animation/aos.html" class="">AOS animation</a></li>
                                    <li><a href="animation/tilt.html" class="">Tilt Animation</a></li>
                                    <li><a href="animation/wow.html" class="">Wow Animation</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="command"></i><span>Icons</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="icons/flag-icon.html" class="">Flag icon</a></li>
                                    <li><a href="icons/font-awesome.html" class="">Fontawesome Icon</a>
                                    </li>
                                    <li><a href="icons/ico-icon.html" class="">Ico Icon</a></li>
                                    <li><a href="icons/themify-icon.html" class="">Thimify Icon</a></li>
                                    <li><a href="icons/feather-icon.html" class="">Feather icon</a></li>
                                    <li><a href="icons/whether-icon.html" class="">Whether Icon </a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="cloud"></i><span>Buttons</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="buttons/buttons.html" class="">Default Style</a></li>
                                    <li><a href="buttons/buttons-flat.html" class="">Flat Style</a></li>
                                    <li><a href="buttons/buttons-edge.html" class="">Edge Style</a></li>
                                    <li><a href="buttons/raised-button.html" class="">Raised Style</a>
                                    </li>
                                    <li><a href="buttons/button-group.html" class="">Button Group</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="bar-chart"></i><span>Charts</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="charts/chart-apex.html" class="">Apex Chart</a></li>
                                    <li><a href="charts/chart-google.html" class="">Google Chart</a></li>
                                    <li><a href="charts/chart-sparkline.html" class="">Sparkline
                                            chart</a></li>
                                    <li><a href="charts/chart-flot.html" class="">Flot Chart</a></li>
                                    <li><a href="charts/chart-knob.html" class="">Knob Chart</a></li>
                                    <li><a href="charts/chart-morris.html" class="">Morris Chart</a></li>
                                    <li><a href="charts/chartjs.html" class="">Chatjs Chart</a></li>
                                    <li><a href="charts/chartist.html" class="">Chartist Chart</a></li>
                                    <li><a href="charts/chart-peity.html" class="">Peity Chart</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Forms</h6>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="sliders"></i><span>Form Controls </span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="form-controls/form-validation.html" class="">Form
                                            Validation</a></li>
                                    <li><a href="form-controls/base-input.html" class="">Base Inputs</a>
                                    </li>
                                    <li><a href="form-controls/radio-checkbox-control.html"
                                            class="">Checkbox & Radio</a></li>
                                    <li><a href="form-controls/input-group.html" class="">Input
                                            Groups</a></li>
                                    <li><a href="form-controls/megaoptions.html" class="">Mega Options
                                        </a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="package"></i><span>Form Widgets</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="form-widgets/datepicker.html" class="">Datepicker</a>
                                    </li>
                                    <li><a href="form-widgets/time-picker.html" class="">Timepicker</a>
                                    </li>
                                    <li><a href="form-widgets/datetimepicker.html"
                                            class="">Datetimepicker</a></li>
                                    <li><a href="form-widgets/daterangepicker.html"
                                            class="">Daterangepicker</a></li>
                                    <li><a href="form-widgets/touchspin.html" class="">Touchspin</a></li>
                                    <li><a href="form-widgets/select2.html" class="">Select2</a></li>
                                    <li><a href="form-widgets/switch.html" class="">Switch</a></li>
                                    <li><a href="form-widgets/typeahead.html" class="">Typeahead</a></li>
                                    <li><a href="form-widgets/clipboard.html" class="">Clipboard </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="layout"></i><span>Form layout</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="form-layout/default-form.html" class="">Default
                                            Forms</a></li>
                                    <li><a href="form-layout/form-wizard.html" class="">Form Wizard 1</a>
                                    </li>
                                    <li><a href="form-layout/form-wizard-two.html" class="">Form Wizard
                                            2</a></li>
                                    <li><a href="form-layout/form-wizard-three.html" class="">Form Wizard
                                            3</a></li>
                                </ul>
                            </li>
                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Table</h6>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="server"></i><span>Bootstrap Tables </span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="bootstrap-tables/bootstrap-basic-table.html"
                                            class="">Basic Tables</a></li>
                                    <li><a href="bootstrap-tables/bootstrap-sizing-table.html"
                                            class="">Sizing Tables</a></li>
                                    <li><a href="bootstrap-tables/bootstrap-border-table.html"
                                            class="">Border Tables</a></li>
                                    <li><a href="bootstrap-tables/bootstrap-styling-table.html"
                                            class="">Styling Tables</a></li>
                                    <li><a href="bootstrap-tables/table-components.html" class="">Table
                                            components</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="database"></i><span>Data Tables </span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="data-tables/datatable-basic-init.html" class="">Basic
                                            Init</a></li>
                                    <li><a href="data-tables/datatable-advance.html" class="">Advance
                                            Init</a></li>
                                    <li><a href="data-tables/datatable-styling.html" class="">Styling</a>
                                    </li>
                                    <li><a href="data-tables/datatable-AJAX.html" class="">AJAX</a></li>
                                    <li><a href="data-tables/datatable-server-side.html" class="">Server
                                            Side</a></li>
                                    <li><a href="data-tables/datatable-plugin.html" class="">Plug-in</a>
                                    </li>
                                    <li><a href="data-tables/datatable-API.html" class="">API</a></li>
                                    <li><a href="data-tables/datatable-data-source.html" class="">Data
                                            Sources</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="hard-drive"></i><span>Ex. Data Tables </span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="ex-data-tables/datatable-ext-autofill.html"
                                            class="">Auto Fill</a></li>
                                    <li><a href="ex-data-tables/datatable-ext-basic-button.html"
                                            class="">Basic Button</a></li>
                                    <li><a href="ex-data-tables/datatable-ext-col-reorder.html"
                                            class="">Column Reorder</a></li>
                                    <li><a href="ex-data-tables/datatable-ext-fixed-header.html"
                                            class="">Fixed Header</a></li>
                                    <li><a href="ex-data-tables/datatable-ext-key-table.html"
                                            class="">Key Table</a></li>
                                    <li><a href="ex-data-tables/datatable-ext-responsive.html"
                                            class="">Responsive</a></li>
                                    <li><a href="ex-data-tables/datatable-ext-row-reorder.html"
                                            class="">Row Reorder</a></li>
                                    <li><a href="ex-data-tables/datatable-ext-scroller.html"
                                            class="">Scroller </a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="jsgrid-table.html"><i
                                        data-feather="file-text"></i><span>Js Grid Table</span></a>
                            </li>
                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Applications</h6>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="box"></i><span>Project </span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="project/projects.html" class="">Project List</a></li>
                                    <li><a href="project/projectcreate.html" class="">Create new </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="file-manager.html"><i
                                        data-feather="git-pull-request"></i><span>File manager</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="kanban.html"><i
                                        data-feather="monitor"></i><span>Kanban Board</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="shopping-bag"></i><span>Ecommerce</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="ecommerce/product.html" class="">Product</a></li>
                                    <li><a href="ecommerce/product-page.html" class="">Product page</a>
                                    </li>
                                    <li><a href="ecommerce/list-products.html" class="">Product list</a>
                                    </li>
                                    <li><a href="ecommerce/payment-details.html" class="">Payment
                                            Details</a></li>
                                    <li><a href="ecommerce/order-history.html" class="">Order History</a>
                                    </li>
                                    <li><a href="ecommerce/invoice-template.html" class="">Invoice</a>
                                    </li>
                                    <li><a href="ecommerce/cart.html" class="">Cart</a></li>
                                    <li><a href="ecommerce/list-wish.html" class="">Wishlist</a></li>
                                    <li><a href="ecommerce/checkout.html" class="">Checkout</a></li>
                                    <li><a href="ecommerce/pricing.html" class="">Pricing</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="mail"></i><span>Email</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="email/email_inbox.html" class="">Mail Inbox</a></li>
                                    <li><a href="email/email_read.html" class="">Read mail</a></li>
                                    <li><a href="email/email_compose.html" class="">Compose</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="message-circle"></i><span>Chat</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="chat/chat.html" class="">Chat App</a></li>
                                    <li><a href="chat/chat-video.html" class="">Video chat</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="users"></i><span>Users</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="users/user-profile.html" class="">Users Profile</a></li>
                                    <li><a href="users/edit-profile.html" class="">Users Edit</a></li>
                                    <li><a href="users/user-cards.html" class="">Users Cards</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="bookmark.html"><i
                                        data-feather="heart"></i><span>Bookmarks</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="contacts.html"><i
                                        data-feather="list"></i><span>Contacts</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="task.html"><i
                                        data-feather="check-square"></i><span>Tasks</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="calendar-basic.html"><i
                                        data-feather="calendar"></i><span>Calender </span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="social-app.html"><i
                                        data-feather="zap"></i><span>Social App</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="to-do.html"><i
                                        data-feather="clock"></i><span>To-Do</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="search.html"><i
                                        data-feather="search"></i><span>Search Result</span></a>
                            </li>
                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Pages</h6>
                                </div>
                            </li>
                            <li>

                            </li>
                            <li>
                                <a class="nav-link menu-title link-nav " href="sample-page.html"><i
                                        data-feather="file"></i><span>Sample page</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title link-nav " href="internationalization.html"><i
                                        data-feather="aperture"></i><span>Internationalization</span></a>
                            </li>
                            <li class="mega-menu">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="layers"></i><span>Others</span></a>
                                <div class="mega-menu-container menu-content" style="display: none;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col mega-box">
                                                <div class="link-section">
                                                    <div class="submenu-title">
                                                        <h5>Error Page</h5>
                                                    </div>
                                                    <div class="submenu-content opensubmegamenu">
                                                        <ul>
                                                            <li><a href="error-page1.html" class=""
                                                                    target="_blank">Error page 1</a></li>
                                                            <li><a href="error-page2.html" class=""
                                                                    target="_blank">Error page 2</a></li>
                                                            <li><a href="error-page3.html" class=""
                                                                    target="_blank">Error page 3</a></li>
                                                            <li><a href="error-page4.html" class=""
                                                                    target="_blank">Error page 4 </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col mega-box">
                                                <div class="link-section">
                                                    <div class="submenu-title">
                                                        <h5>Authentication</h5>
                                                    </div>
                                                    <div class="submenu-content opensubmegamenu">
                                                        <ul>
                                                            <li><a href="login.html" class=""
                                                                    target="_blank">Login Simple</a></li>
                                                            <li><a href="login_one.html" class=""
                                                                    target="_blank">Login with bg image</a></li>
                                                            <li><a href="login_two.html" class=""
                                                                    target="_blank">Login with image two </a></li>
                                                            <li><a href="login-bs-validation.html"
                                                                    class="" target="_blank">Login With
                                                                    validation</a></li>
                                                            <li><a href="login-bs-tt-validation.html"
                                                                    class="" target="_blank">Login with
                                                                    tooltip</a></li>
                                                            <li><a href="login-sa-validation.html"
                                                                    class="" target="_blank">Login with
                                                                    sweetalert</a></li>
                                                            <li><a href="sign-up.html" class=""
                                                                    target="_blank">Register Simple</a></li>
                                                            <li><a href="sign-up-one.html" class=""
                                                                    target="_blank">Register with Bg Image </a></li>
                                                            <li><a href="sign-up-two.html" class=""
                                                                    target="_blank">Register with Bg video </a></li>
                                                            <li><a href="unlock.html" class="">Unlock
                                                                    User</a></li>
                                                            <li><a href="forget-password.html"
                                                                    class="">Forget Password</a></li>
                                                            <li><a href="creat-password.html"
                                                                    class="">Creat Password</a></li>
                                                            <li><a href="maintenance.html"
                                                                    class="">Maintenance</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col mega-box">
                                                <div class="link-section">
                                                    <div class="submenu-title">
                                                        <h5>Coming Soon</h5>
                                                    </div>
                                                    <div class="submenu-content opensubmegamenu">
                                                        <ul>
                                                            <li><a href="comingsoon.html" class="">Coming
                                                                    Simple</a></li>
                                                            <li><a href="comingsoon-bg-video.html"
                                                                    class="">Coming with Bg video</a>
                                                            </li>
                                                            <li><a href="comingsoon-bg-img.html"
                                                                    class="">Coming with Bg Image</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col mega-box">
                                                <div class="link-section">
                                                    <div class="submenu-title">
                                                        <h5>Email templates</h5>
                                                    </div>
                                                    <div class="submenu-content opensubmegamenu">
                                                        <ul>
                                                            <li><a href="basic-template.html"
                                                                    class="">Basic Email</a></li>
                                                            <li><a href="email-header.html"
                                                                    class="">Basic With Header</a></li>
                                                            <li><a href="template-email.html"
                                                                    class="">Ecomerce Template</a></li>
                                                            <li><a href="template-email-2.html"
                                                                    class="">Email Template 2</a></li>
                                                            <li><a href="ecommerce-templates.html"
                                                                    class="">Ecommerce Email</a></li>
                                                            <li><a href="email-order-success.html"
                                                                    class="">Order Success </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="sidebar-main-title">
                                <div>
                                    <h6>Miscellaneous</h6>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="image"></i><span>Gallery</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="gallery.html" class="">Gallery Grid</a></li>
                                    <li><a href="gallery/gallery-with-description.html" class="">Gallery
                                            Grid Desc</a></li>
                                    <li><a href="gallery/gallery-masonry.html" class="">Masonry
                                            Gallery</a></li>
                                    <li><a href="gallery/masonry-gallery-with-disc.html" class="">Masonry
                                            with Desc</a></li>
                                    <li><a href="gallery/gallery-hover.html" class="">Hover Effects</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="edit"></i><span>Blog</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="blog.html" class="">Blog Details</a></li>
                                    <li><a href="blog/blog-single.html" class="">Blog Single</a></li>
                                    <li><a href="blog/add-post.html" class="">Add Post</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="nav-link menu-title link-nav " href="faq.html"><i
                                        data-feather="help-circle"></i><span>FAQ</span></a>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="user-check"></i><span>Job Search</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="job-search/job-cards-view.html" class="">Cards view</a>
                                    </li>
                                    <li><a href="job-search/job-list-view.html" class="">List View</a>
                                    </li>
                                    <li><a href="job-search/job-details.html" class="">Job Details</a>
                                    </li>
                                    <li><a href="job-search/job-apply.html" class="">Apply</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="layers"></i><span>Learning</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="learning/learning-list-view.html" class="">Learning
                                            List</a></li>
                                    <li><a href="learning/learning-detailed.html" class="">Detailed
                                            Course</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="map"></i><span>Maps</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="maps/map-js.html" class="">Maps JS</a></li>
                                    <li><a href="maps/vector-map.html" class="">Vector Maps</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="nav-link menu-title " href="javascript:void(0)"><i
                                        data-feather="git-pull-request"></i><span>Editors</span></a>
                                <ul class="nav-submenu menu-content" style="display: none;">
                                    <li><a href="editors/summernote.html" class="">Summer Note</a></li>
                                    <li><a href="editors/ckeditor.html" class="">CK editor</a></li>
                                    <li><a href="editors/simple-MDE.html" class="">MDE editor</a></li>
                                    <li><a href="editors/ace-code-editor.html" class="">ACE code
                                            editor</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="nav-link menu-title link-nav " href="knowledgebase.html"><i
                                        data-feather="database"></i><span>Knowledgebase</span></a>
                            </li>
                        </ul> --}}
                    </div>
                    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                </div>
            </nav>
        </header>
        <!-- Page Sidebar Ends-->
